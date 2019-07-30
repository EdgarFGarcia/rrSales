<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pageController extends Controller
{
    //
    public function home(){
        return view('main');
    }

    public function updateMDC(){
    	return view('dmUpdatemdc');
    }

    public function index(){
    	return view('pages.dashboard');
    }
}
