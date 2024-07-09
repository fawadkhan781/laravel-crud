<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        return view('backend.dashboard.index');
    }

    public function changePassword()
    {
        return view('backend.dashboard.change-password');
    }

    
}
