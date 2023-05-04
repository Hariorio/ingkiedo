<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class ListPromoController extends Controller
{
    
    public function index()
    {

        if(Auth::user()->note1 != 'admin'){
            return redirect()->route('home_member');
        }

        return view('admin.ListPromo');
    }

    public function getData(Request $request)
    {

        $result = DB::table('promo')
                        ->selectRaw("id, descr, inkindo_area, inkindo_office, format(dt_start, 'yyyy-MM-dd') as dt_start, format(dt_end, 'yyyy-MM-dd') as dt_end, 
                        format(created_date, 'yyyy-MM-dd') as created_date, created_by, active_flag")
                        ->get();           

        return response()->json(['result' => $result]);
        
    }

    public function getProvinceAndCity(Request $request)
    {

        $province = DB::table('province')
                        ->whereIn('province', ['Jawa Barat', 'Jawa Tengah', 'Jawa Timur'])
                        ->get();

        $city = DB::table('city')
                        ->get();

        return response()->json(['province' => $province, 'city' => $city]);
    }

    public function getCity(Request $request)
    {

        $province = $request->province;

        if($province == 'all')
        {
            $city = DB::table('city')
                        ->get();

            return response()->json(['city' => $city]);

        } else {

            $city = DB::table('city')
                        ->where('province', '=', $province)
                        ->get();

            return response()->json(['city' => $city]);

        }

    }

    public function newPromoSubmit(Request $request)
    {

        $promoDesc = $request->promoDesc;
        $inkindoArea = $request->inkindoArea;
        $inkindoOffice = $request->inkindoOffice;
        $startPromo = $request->startPromo;
        $endPromo = $request->endPromo;

        try {

            $getId = DB::table('promo')
                        ->selectRaw('max(id) as id')
                        ->value('id');

            if($getId)
            {

                $insertMember = DB::table('promo')
                        ->insert([
                            'id' => $getId + 1,
                            'descr' => $promoDesc,
                            'inkindo_area' => $inkindoArea,
                            'inkindo_office' => $inkindoOffice,
                            'dt_start' => $startPromo,
                            'dt_end' => $endPromo,
                            'created_by' => Auth::user()->username,
                            'active_flag' => 'Y'
                        ]);

                return response()->json(['result' => 'OK']);

            } else {

                return response()->json(['result' => 'EXISTS']);

            }

        } catch (Exception $e) {
            dd($e);
        }

    }

    public function editPromoSubmit(Request $request)
    {

        $id = $request->id;
        $promoDesc = $request->promoDesc;
        $inkindoArea = $request->inkindoArea;
        $inkindoOffice = $request->inkindoOffice;
        $startPromo = $request->startPromo;
        $endPromo = $request->endPromo;

        try {

            $insertMember = DB::table('promo')
                    ->where('id', '=', $id)
                    ->update([
                        'descr' => $promoDesc,
                        'inkindo_area' => $inkindoArea,
                        'inkindo_office' => $inkindoOffice,
                        'dt_start' => $startPromo,
                        'dt_end' => $endPromo
                    ]);

            return response()->json(['result' => 'OK']);

        } catch (Exception $e) {
            dd($e);
        }

    }

    public function deactivatePromo(Request $request)
    {

        $id = $request->id;

        $update_promo = DB::table('promo')
                        ->where('id', '=', $id)
                        ->update([
                            'active_flag' => 'N',
                        ]);

        return response()->json(['result' => 'OK']);     

    }

    public function reactivatePromo(Request $request)
    {

        $id = $request->id;

        $update_promo = DB::table('promo')
                        ->where('id', '=', $id)
                        ->update([
                            'active_flag' => 'Y',
                        ]);

        return response()->json(['result' => 'OK']);     

    }

}
