<?php

namespace App\Http\Controllers;

use App\User;
use App\Group;
use App\Store;
use App\Attendance;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::get();


        return view(
            'home',
            array(
                'users' => $users,
            )
        );
    }
}
