<?php

namespace App\Http\Controllers\Importir;

use App\Http\Controllers\Controller;
use App\Models\PullRiph;
use App\Models\PenangkarRiph;
use App\Models\Pks;

use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\MassDestroyPullriphRequest;
use App\Http\Controllers\Traits\SimeviTrait;
use App\Models\AjuVerifProduksi;
use App\Models\AjuVerifSkl;
use App\Models\AjuVerifTanam;
use App\Models\MasterAnggota;
use App\Models\Skl;
use App\Models\UserDocs;
use App\Models\Varietas;
use Symfony\Component\HttpFoundation\Response;

class CommitmentController extends Controller
{
	use SimeviTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$module_name = 'Proses RIPH';
		$page_title = 'Daftar Komitmen';
		$page_heading = 'Daftar Komitmen';
		$heading_class = 'fal fa-ballot-check';

		$npwp_company = Auth::user()->data_user->npwp_company;
		$commitments = PullRiph::where('npwp', $npwp_company)
			->with('skl')
			->select('id', 'no_ijin', 'periodetahun', 'tgl_ijin', 'volume_riph', 'luas_wajib_tanam', 'volume_produksi')
			->get();

		if ($commitments) {
			foreach ($commitments as $commitment) {
				$noIjinLink = str_replace(['/', '.'], '', $commitment->no_ijin);

				$userDocs = UserDocs::where('no_ijin', $commitment->no_ijin)
					->first();

				$ajuTanam = AjuVerifTanam::where('no_ijin', $commitment->no_ijin)->select('status')
					->first();

				$ajuProduksi = AjuVerifProduksi::where('no_ijin', $commitment->no_ijin)->select('status')
					->first();

				$ajuSkl = AjuVerifSkl::where('no_ijin', $commitment->no_ijin)->select('status')
					->first();

				$commitment->userDocs = $userDocs;
				$commitment->ajuTanam = $ajuTanam;
				$commitment->ajuProduksi = $ajuProduksi;
				$commitment->ajuSkl = $ajuSkl;
				$commitment->noIjinLink = $noIjinLink;
			}
		}

		return view('importir.commitment.index', compact('module_name', 'page_title', 'page_heading', 'heading_class', 'npwp_company', 'commitments'));
	}

	public function show($no_ijin)
	{
		$npwp_company = Auth::user()->data_user->npwp_company;
		$formattedNoIjin = substr_replace($no_ijin, '/', 4, 0); // Memasukkan '/' setelah 4 karakter pertama
		$formattedNoIjin = substr_replace($formattedNoIjin, '.', 7, 0); // Memasukkan '.' setelah karakter ke-7
		$formattedNoIjin = substr_replace($formattedNoIjin, '/', 11, 0); // Memasukkan '/' setelah karakter ke-10
		$formattedNoIjin = substr_replace($formattedNoIjin, '/', 13, 0);
		$formattedNoIjin = substr_replace($formattedNoIjin, '/', 16, 0);
		// dd($formattedNoIjin);
		$commitment = PullRiph::where('npwp', $npwp_company)
			->where('no_ijin', $formattedNoIjin)->firstOrFail();

		$module_name = 'Komitmen';
		$page_title = 'Data Komitmen';
		$page_heading = 'Data Komitmen: ' . $commitment->no_ijin;
		$heading_class = 'fal fa-file-edit';

		return view('importir.commitment.show', compact('module_name', 'page_title', 'page_heading', 'heading_class', 'npwp_company', 'commitment'));
	}

	public function realisasi($no_ijin)
	{
		$module_name = 'Komitmen';
		$page_title = 'Data Realisasi';
		$page_heading = 'Realisasi Komitmen';
		$heading_class = 'fal fa-file-edit';
		$formattedNoIjin = substr_replace($no_ijin, '/', 4, 0); // Memasukkan '/' setelah 4 karakter pertama
		$formattedNoIjin = substr_replace($formattedNoIjin, '.', 7, 0); // Memasukkan '.' setelah karakter ke-7
		$formattedNoIjin = substr_replace($formattedNoIjin, '/', 11, 0); // Memasukkan '/' setelah karakter ke-10
		$formattedNoIjin = substr_replace($formattedNoIjin, '/', 13, 0);
		$formattedNoIjin = substr_replace($formattedNoIjin, '/', 16, 0);
		$npwp = Auth::user()->data_user->npwp_company;
		$commitment = PullRiph::where('npwp', $npwp)
			->where('no_ijin', $formattedNoIjin)->firstOrFail();
		$pkss = Pks::where('npwp', $npwp)
			->where('no_ijin', $commitment->no_ijin)
			->withCount(['lokasi' => function ($query) use ($npwp, $commitment) {
				$query->where('npwp', $npwp)
					->where('no_ijin', $commitment->no_ijin);
			}])
			->withSum(['lokasi' => function ($query) use ($npwp, $commitment) {
				$query->where('npwp', $npwp)->where('no_ijin', $commitment->no_ijin);
			}], 'luas_lahan')
			->get();

		// dd($pkss);

		foreach ($pkss as $pks) {
			// Calculate the sum of luas_lahan for this Pks record
			$luasLahanSum = $pks->masterpoktan->anggota->sum('luas_lahan');

			// Assign the sum to the Pks object
			$pks->sum_luaslahan = $luasLahanSum;
		}

		$docs = UserDocs::where('commitment_id', $commitment->id)->first();
		$penangkars = PenangkarRiph::where('npwp', $npwp)
			->when(isset($commitment->no_ijin), function ($query) use ($commitment) {
				return $query->where('no_ijin', $commitment->no_ijin);
			}, function ($query) use ($commitment) {
				return $query->where('commitment_id', $commitment->id);
			})
			->get();
		$varietass = Varietas::all();
		$commitmentStatus = $commitment->status;
		if (empty($commitmentStatus) || $commitmentStatus == 3 || $commitmentStatus == 5) {
			$disabled = false; // input di-enable
		} else {
			$disabled = true; // input di-disable
		}
		return view('importir.commitment.realisasi', compact('module_name', 'page_title', 'page_heading', 'heading_class', 'commitment', 'pkss', 'penangkars', 'docs', 'npwp', 'varietass', 'disabled'));
	}

	public function storeUserDocs(Request $request, $id)
	{
		$commitment = PullRiph::find($id);
		$realnpwp = $commitment->npwp;
		$npwp = str_replace(['.', '-'], '', $commitment->npwp);
		$realNoIjin = $commitment->no_ijin;
		$noIjin = str_replace(['/', '.'], '', $realNoIjin);
		$userFiles = [];
		try {
			DB::beginTransaction();

			$fileFields = [
				'sptjmtanam',
				'sptjmproduksi',
				'spvt',
				'rta',
				'sphtanam',
				'logbooktanam',
				'spvp',
				'rpo',
				'formLa',
				'sphproduksi',
				'logbookproduksi',
				'spskl'
				// Tambahkan field-file lainnya di sini
			];

			foreach ($fileFields as $field) {
				if ($request->hasFile($field)) {
					$file = $request->file($field);

					// Validasi ekstensi file
					$allowedExtensions = ['pdf']; // Ekstensi yang diperbolehkan
					$fileExtension = $file->getClientOriginalExtension();
					$clientFile = $file->getClientOriginalName();
					if (!in_array($fileExtension, $allowedExtensions)) {
						// File memiliki ekstensi yang tidak diizinkan
						DB::rollBack(); // Rollback transaksi
						return redirect()->back()->with('error', 'Berkas ' . $clientFile . ' harus memiliki ekstensi .pdf.');
					}

					$file_name = $field . '_' . $noIjin . '_' . time() . '.' . $fileExtension;
					$file_path = $file->storeAs('uploads/' . $npwp . '/' . $commitment->periodetahun, $file_name, 'public');
					$userFiles[$field] = $file_name;
				}
			}

			$data = UserDocs::updateOrCreate(
				[
					'npwp' => $realnpwp,
					'commitment_id' => $id,
					'no_ijin' => $realNoIjin
				],
				array_merge($request->all(), $userFiles) // Menggabungkan data form dan file dalam satu array
			);
			DB::commit();

			// Flash message sukses
			return redirect()->back()->with('success', 'Berkas berhasil diunggah.');
		} catch (\Exception $e) {
			// Rollback transaksi jika ada kesalahan
			DB::rollBack();

			// Flash message kesalahan
			return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunggh berkas: ' . $e->getMessage());
		}
	}

	public function submission($id)
	{
		$module_name = 'Komitmen';
		$page_title = 'Pengajuan Verifikasi';
		$page_heading = 'Data Pengajuan';
		$heading_class = 'fal fa-file-invoice';

		$npwp_company = Auth::user()->data_user->npwp_company;
		$commitment = PullRiph::where('npwp', $npwp_company)
			->findOrFail($id);

		$total_luastanam = $commitment->datarealisasi->sum('luas_lahan');
		$total_volume = $commitment->datarealisasi->sum('volume');
		// dd($total_volume);
		return view('importir.commitment.realisasi', compact('module_name', 'page_title', 'page_heading', 'heading_class'));
	}


	public function destroy($id)
	{
		abort_if(Gate::denies('commitment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		$pullRiph = PullRiph::find($id);
		$pullRiph->delete();

		return back();
	}

	public function massDestroy(MassDestroyPullriphRequest $request)
	{
		PullRiph::whereIn('id', request('ids'))->delete();
		return response(null, Response::HTTP_NO_CONTENT);
	}
}
