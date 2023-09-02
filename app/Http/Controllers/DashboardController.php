<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            return view('admin.dashboard.index');
        } else {
            return view('pembeli.dashboard.index');
        }
    }
}
