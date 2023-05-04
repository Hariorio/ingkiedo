<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class BudgetPlanController extends Controller
{
    public function index()
    {
        
        if(Auth::user()->note1 != 'admin'){
            return redirect()->route('home_member');
        }

        return view('admin.BudgetPlan');
    }

    public function getData(Request $request)
    {

        $result = DB::table('member_rab_file as a')
                        ->selectRaw('a.*, b.member_name, b.inkindo_area, b.inkindo_office, c.descr')
                        ->join('member_data as b', 'a.inkindo_id', '=', 'b.inkindo_id')
                        ->join('promo as c', 'a.promo_id', '=', 'c.id')
                        ->where('b.active_flag', '=', 'Y')
                        ->get();           

        return response()->json(['result' => $result]);

    }

    public function validateSubmit(Request $request)
    {

        $id = $request->id;
        $validateLuasModel = $request->validateLuasModel;
        $totalCouponModel = $request->totalCouponModel;

        $updateItem = DB::table('member_rab_file')
                        ->where('tr_id', '=', $id)
                        ->update([
                            'validation' => $validateLuasModel,
                            'coupon' => $totalCouponModel
                        ]);

        return response()->json(['result' => 'OK']);

    }

}
