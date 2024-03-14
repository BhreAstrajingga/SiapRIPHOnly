<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

use App\Models\BroadcastMessages;

class BroadcastMessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		abort_if(Gate::denies('broadcast_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $module_name = 'Broadcasts';
		$page_title = 'Broadcasts Messages';
		$page_heading = 'Broadcasts Messages';
		$heading_class = 'fal fa-bullhorn';

		$user = Auth::user();

		$messages = BroadcastMessages::orderBy('created_at', 'asc')->get();

		return view('admin.broadcasts.index', compact('module_name', 'page_title', 'page_heading', 'heading_class', 'messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		abort_if(Gate::denies('broadcast_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $module_name = 'Broadcasts';
		$page_title = 'New Broadcasts Messages';
		$page_heading = 'New Broadcasts Messages';
		$heading_class = 'fal fa-edit';

		return view('admin.broadcasts.create', compact('module_name', 'page_title', 'page_heading', 'heading_class'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		abort_if(Gate::denies('broadcast_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		$request->validate([
			'title' => 'required|string|max:255',
			'messages' => 'required|string',
			'type' => 'required|string|max:15',
			'target' => 'required|integer',
		]);

		$userId = Auth::user()->id;
		DB::beginTransaction();
		try {
			BroadcastMessages::create(
				[
					'title' => $request->input('title'),
					'messages' => $request->input('messages'),
					'type' => $request->input('type'),
					'target' => $request->input('target'),
					'user_id' => $userId,
				]
			);
			DB::commit();
		} catch (\Throwable $th) {
			DB::rollback();
			$pesanError = 'Gagal menyimpan data. ' . $th->getMessage();
			return redirect()->back()->with('error', $pesanError);
		}
		return redirect()->route('admin.broadcasts.index')->with('success', 'Pengumuman berhasil dibuat.');
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
    public function edit($id)
    {
        abort_if(Gate::denies('broadcast_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		$message = BroadcastMessages::find($id);

        $module_name = 'Broadcasts';
		$page_title = 'New Broadcasts Messages';
		$page_heading = 'New Broadcasts Messages';
		$heading_class = 'fal fa-edit';

		return view('admin.broadcasts.edit', compact('module_name', 'page_title', 'page_heading', 'heading_class', 'message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function update(Request $request, $id)
	{
		abort_if(Gate::denies('broadcast_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		$request->validate([
			'title' => 'required|string|max:255',
			'messages' => 'required|string',
			'type' => 'required|string|max:15',
			'target' => 'required|integer',
		]);

		$userId = Auth::user()->id;

		DB::beginTransaction();

		try {
			// Temukan data yang akan diperbarui berdasarkan ID
			$broadcastMessage = BroadcastMessages::findOrFail($id);

			// Perbarui data
			$broadcastMessage->update([
				'title' => $request->input('title'),
				'messages' => $request->input('messages'),
				'type' => $request->input('type'),
				'target' => $request->input('target'),
				'user_id' => $userId,
			]);

			DB::commit();
		} catch (\Throwable $th) {
			DB::rollback();
			$pesanError = 'Gagal menyimpan data. ' . $th->getMessage();
			return redirect()->back()->with('error', $pesanError);
		}

		return redirect()->back()->with('success', 'Pengumuman berhasil diperbarui.');
	}

	public function updateStatus(Request $request, $id)
	{
		$message = BroadcastMessages::findOrFail($id);

		// Toggle the status
		$message->status = $message->status === 1 ? 0 : 1;
		$message->save();

		return response()->json(['message' => 'Status updated successfully']);
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
	{
		abort_if(Gate::denies('broadcast_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		DB::beginTransaction();

		try {
			// Temukan data yang akan dihapus berdasarkan ID
			$broadcastMessage = BroadcastMessages::findOrFail($id);

			// Hapus data
			$broadcastMessage->delete();

			DB::commit();
		} catch (\Throwable $th) {
			DB::rollback();
			$pesanError = 'Gagal menghapus data. ' . $th->getMessage();
			return redirect()->back()->with('error', $pesanError);
		}

		return redirect()->route('admin.broadcasts.index')->with('success', 'Pengumuman berhasil dibuat.');
	}
}
