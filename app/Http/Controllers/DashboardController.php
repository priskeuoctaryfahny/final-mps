<?php

namespace App\Http\Controllers;

use App\Mail\TestingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Managements\Letters\IncomingLetter;
use App\Models\Managements\Letters\OutgoingLetter;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = 'Dashboard';
        return view('dashboard.index', compact('title'));
    }
}
