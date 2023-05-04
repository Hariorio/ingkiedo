<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
Use Exception;
use Image;
use Storage;


class BudgetPlanController extends Controller
{
    public function index()
    {

        if(Auth::user()->note1 != 'member'){
            return redirect()->route('home_admin');
        }
        
        return view('member.BudgetPlan');
    }

    public function getData(Request $request)
    {

        $result = DB::table('member_rab_file as a')
                        ->selectRaw('a.*, b.member_name, c.descr')
                        ->join('member_data as b', 'a.inkindo_id', '=', 'b.inkindo_id')
                        ->join('promo as c', 'a.promo_id', '=', 'c.id')
                        ->where('a.inkindo_id', '=', Auth::user()->username)
                        ->where('b.active_flag', '=', 'Y')
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

    public function budgetPlanSubmit(Request $request)
    {

        $name = $request->name;
        $province = $request->province;
        $city = $request->city;
        // $date = $request->date;
        $product = $request->product;
        $luas = $request->luas;
        $image = $request->image;

        try {

            $date = Carbon::now();
            $startSerial = '001';
            $startHeaderID = 'IKD-'.substr($date->format('Y'), -2).$date->format('m').$date->format('d');

            $checkLastID = DB::table('member_rab_file')
                            ->selectRaw('trim(max(tr_id)) as tr_id')
                            ->whereRaw("tr_id like '%$startHeaderID%'")                    
                            ->first();

            $checkRabNo = DB::table('member_rab_file')
                            ->selectRaw('trim(max(rab_no)) as rab_no')
                            ->where('inkindo_id', '=', Auth::user()->username)
                            ->whereRaw("tr_id like '%$startHeaderID%'")
                            ->first();

            if($checkRabNo){
                $rab_no = (int)$checkRabNo->rab_no + 1;
            } else {
                $rab_no = 1;
            }

            if($checkLastID){
                $lastSerial = substr($checkLastID->tr_id, -3);
                $newSerialID = str_pad((int)$lastSerial + 1, 3, '0', STR_PAD_LEFT);
                $startHeaderID .= '-'.$newSerialID;
            } else {
                $startHeaderID .= '-'.$startSerial;
            }

            if($image != '' || $image != null) {
                $imageStoreUrl = '/storage/images/uploads/' . $startHeaderID . '.jpg';
                $decodeImage = Image::make($image)->fit(1280)->encode('jpg', 75);
                $name = Storage::disk('public')->put('/images/uploads/' . $startHeaderID . '.jpg', $decodeImage->__toString());
            }

            $activePromo = DB::table('promo as a')
                            ->join('member_data as b', 'a.inkindo_area', '=', 'b.inkindo_area')
                            ->where('a.active_flag', '=', 'Y')                    
                            ->first();

            $insert = DB::table('member_rab_file')
                        ->insert([
                            'tr_id' => $startHeaderID,
                            'inkindo_id' => Auth::user()->username,
                            // 'rab_no' => $rab_no,
                            'file_name' => $startHeaderID . '.jpg',
                            'path_id' => $imageStoreUrl,
                            'created_by' => Auth::user()->username,
                            'promo_id' => $activePromo->id,
                            'luas_persegi' => $luas,
                            'project_name' => $name,
                            'product' => $product,
                            'project_province' => $province,
                            'project_city' => $city,
                        ]);

            return response()->json(['result' => 'OK']);

        } catch (Exception $e) {
            dd($e);
        }

    }

    public function deleteItem(Request $request)
    {

        $id = $request->id;

        $deleteItem = DB::table('member_rab_file')
                            ->where('inkindo_id', '=', Auth::user()->username)
                            ->where('tr_id', '=', $id)
                            ->delete();

        return response()->json(['result' => 'OK']);

    }

}
