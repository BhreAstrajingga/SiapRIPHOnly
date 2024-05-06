<?php

namespace App\Http\Controllers\Sroot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use App\Models\ForeignApi;

class ForeignApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		abort_if(Auth::user()->roles[0]->title != 'SUPERADMIN', Response::HTTP_FORBIDDEN, '403 Forbidden');
        $module_name = 'FOREIGN API';
		$page_title = 'Google Map API';
		$page_heading = 'Google Map API ';
		$heading_class = 'fal fa-google';

		$foreignApis = ForeignApi::all();

		return view('Superadmin.foreignapis.index', compact('module_name', 'page_title', 'page_heading', 'heading_class', 'foreignApis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
		abort_if(Auth::user()->roleaccess != 1, Response::HTTP_FORBIDDEN, '403 Forbidden');
		$module_name = 'FOREIGN API';
		$page_title = 'Google Map API';
		$page_heading = 'Google Map API ';
		$heading_class = 'fab fa-google-drive';

		$key = ForeignApi::findOrFail(1);

		return view('Superadmin.foreignapis.edit', compact('module_name', 'page_title', 'page_heading', 'heading_class', 'key'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        abort_if(Auth::user()->roleaccess != 1, Response::HTTP_FORBIDDEN, '403 Forbidden');
		$request->validate([
			'apikey' => 'required|string|max:255',
		]);

		try {
			DB::beginTransaction();
				$apikey = strip_tags($request->input('apikey'));
				$key = ForeignApi::findOrFail(1);
				$key->key = $apikey;
				$key->save();
			DB::commit();
		} catch (\Throwable $th) {
			DB::rollback();
			$pesanError = 'Gagal menyimpan data. ' . $th->getMessage();
			return redirect()->back()->with('error', $pesanError);
		}
		return redirect()->route('sroot.gmapapi.edit')->with('success', 'Google map API berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
