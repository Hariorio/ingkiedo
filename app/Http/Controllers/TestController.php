<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {


        return view('test');
    }

    public function test2()
    {


        return view('test2');
    }

}
