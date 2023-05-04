<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class LoginController extends Controller
{
    public function index()
    {


        return view('Auth.login');
    }

    public function authenticate(Request $request)
    {

        if(Auth::attempt(['username' => $request->username, 'password' => $request->password]))
        {

            $group = DB::table('sec_user')
                            ->select('note1')
                            ->where('username', '=', Auth::user()->username)
                            ->value('note1');

            if($group == 'admin')
            {
                return redirect()->route('home_admin');
            } elseif($group == 'member')
            {
                return redirect()->route('home_member');
            } else 
            {
                return redirect()->route('login')->with('error','Sorry, your group is unknown, please call IT Administrator !');
            }

            
        } else {

            return redirect()->route('login')->with('error','Sorry, your username and password is incorrect. Please try again.');

        }

    }

    public function logout()
    {

        Auth::logout();

        return redirect()->route('login');
    }

}
