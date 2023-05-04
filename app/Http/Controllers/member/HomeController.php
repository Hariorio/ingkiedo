<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{

    public function index()
    {
        
        if(Auth::user()->note1 != 'member'){
            return redirect()->route('home_admin');
        }

        return view('member.home');
    }
}
