<?php

namespace App\Http\Controllers\ViewsCentral;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('central.home');
    }

    public function loginView(){
        return view('central.login');
    }
    public function registerView(){
        return view('central.register');
    }
}
