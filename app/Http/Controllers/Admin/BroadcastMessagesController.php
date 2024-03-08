<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

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
        $module_name = 'Broadcasts';
		$page_title = 'Broadcasts Messages';
		$page_heading = 'Broadcasts Messages';
		$heading_class = 'fal fa-speaker';

		$user = Auth::user();

		$messages = BroadcastMessages::all();

		return view('admin.broadcasts.index', compact('module_name', 'page_title', 'page_heading', 'heading_class', 'messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		abort_if(Auth::user()->roleaccess != 1, Response::HTTP_FORBIDDEN, '403 Forbidden');

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
    public function edit($id)
    {
        // abort_if(Auth::user()->roleaccess != 1, Response::HTTP_FORBIDDEN, '403 Forbidden');
		// abort_if(Auth::user()->id != $message->user_id, Response::HTTP_FORBIDDEN, '403 Forbidden');
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
        //
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
