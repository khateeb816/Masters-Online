<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    public function index()
    {
        return view('dashboard');
    }


    public function icons()
    {
        return view('icons');
    }


    public function forms()
    {
        return view('forms');
    }


    public function tables()
    {
        return view('tables');
    }



    public function profile()
    {
        return view('profile');
    }
}
