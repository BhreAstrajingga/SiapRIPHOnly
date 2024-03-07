<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Inspiring;
use Carbon\Carbon;

use App\Models\Post;
use App\Models\User;
use App\Models\BroadcastMessages;
use App\Models\DataAdministrator;

class HomeController extends Controller
{
	public function index()
	{
		$module_name = 'Beranda';
		$page_title = 'Beranda';
		$page_heading = 'Welcome';
		$heading_class = 'fal fa-ballot-check';
		$quote = Inspiring::quote();

		$roleaccess = Auth::user()->roles[0]->title;
		$message = BroadcastMessages::where('status', 1)->latest()->first();

		return view('admin.landing.index', compact('module_name', 'page_title', 'page_heading', 'heading_class', 'quote', 'roleaccess', 'message'));
	}
}
