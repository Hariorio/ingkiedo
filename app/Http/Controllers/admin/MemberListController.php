<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class MemberListController extends Controller
{

    public function index()
    {

        if(Auth::user()->note1 != 'admin'){
            return redirect()->route('home_member');
        }
        
        return view('admin.MemberList');
    }

    public function getData(Request $request)
    {

        $result = DB::table('member_data as a')
                        ->selectRaw('a.*, b.user_pass')
                        ->join('sec_user as b', 'a.inkindo_id', '=', 'b.username')
                        ->where('b.note1', '=', 'member')
                        ->get();           

        return response()->json(['result' => $result]);
    }

    public function addNewMember(Request $request)
    {

        $id = $request->id;
        $name = $request->name;
        $address = $request->address;
        $province = $request->province;
        $city = $request->city;
        $email = $request->email;
        $type = $request->type;
        $phone = $request->phone;
        $inkindoArea = $request->inkindoArea;
        $inkidoOffice = $request->inkidoOffice;

        $randomPass = $this->generateRandomString();

        try {

            $checkID = DB::table('member_data')
                        ->select('inkindo_id')
                        ->where('inkindo_id', '=', $id)
                        ->value('inkindo_id');

            if(!$checkID)
            {

                $insertMember = DB::table('member_data')
                        ->insert([
                            'inkindo_id' => $id,
                            'member_name' => $name,
                            'member_address' => $address,
                            'member_city' => $city,
                            'member_province' => $province,
                            'member_email' => $email,
                            'member_phone' => $phone,
                            'inkindo_area' => $inkindoArea,
                            'inkindo_office' => $inkidoOffice,
                            'active_flag' => 'Y',
                            'created_by' => Auth::user()->username,
                            'member_type' => $type,
                            'penanggung_jawab' => Auth::user()->username,
                            'penanggung_jawab_hp' => Auth::user()->phone
                        ]);

                $insertUserMember = DB::table('sec_user')
                        ->insert([
                            'global_id' => $id,
                            'user_id2' => $id,
                            'username' => $id,
                            'password' => bcrypt($randomPass),
                            'user_pass' => $randomPass,
                            'name1' => $name,
                            'note1' => 'member',
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

    public function editMember(Request $request)
    {

        $id = $request->id;
        $name = $request->name;
        $address = $request->address;
        $province = $request->province;
        $city = $request->city;
        $email = $request->email;
        $type = $request->type;
        $phone = $request->phone;
        $inkindoArea = $request->inkindoArea;
        $inkidoOffice = $request->inkidoOffice;

        $update_member = DB::table('member_data')
                        ->where('inkindo_id', '=', $id)
                        ->update([
                            'member_name' => $name,
                            'member_address' => $address,
                            'member_city' => $city,
                            'member_province' => $province,
                            'member_email' => $email,
                            'member_phone' => $phone,
                            'inkindo_area' => $inkindoArea,
                            'inkindo_office' => $inkidoOffice,
                            'member_type' => $type,
                        ]);

        return response()->json(['result' => 'OK']);     

    }

    public function deActivateUser(Request $request)
    {

        $id = $request->id;

        $update_member = DB::table('member_data')
                        ->where('inkindo_id', '=', $id)
                        ->update([
                            'active_flag' => 'N',
                            'modified_date' => now(),
                            'modified_by' => Auth::user()->username,
                        ]);

        $update_sec_user = DB::table('sec_user')
                        ->where('inkindo_id', '=', $id)
                        ->update([
                            'active_flag' => 'N',
                            'dt_modified' => now(),
                        ]);

        return response()->json(['result' => 'OK']);     

    }

    public function reActivateUser(Request $request)
    {

        $id = $request->id;

        $update_member = DB::table('member_data')
                        ->where('inkindo_id', '=', $id)
                        ->update([
                            'active_flag' => 'Y',
                            'modified_date' => now(),
                            'modified_by' => Auth::user()->username,
                        ]);

        $update_sec_user = DB::table('sec_user')
                        ->where('inkindo_id', '=', $id)
                        ->update([
                            'active_flag' => 'Y',
                            'dt_modified' => now(),
                        ]);

        return response()->json(['result' => 'OK']);     

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

    public function generateRandomString() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
