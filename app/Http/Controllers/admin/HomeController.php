<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{

    public function index()
    {

        if(Auth::user()->note1 != 'admin'){
            return redirect()->route('home_member');
        }
        
        return view('admin.home');
    }
    
}