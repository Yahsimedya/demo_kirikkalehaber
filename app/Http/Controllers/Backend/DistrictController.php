<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\District;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistrictController extends Controller
{
    //
    public function index()
    {
$district = DB::table('districts')->latest('id')->get();
        return view('backend.district.index', compact('district'));
    }
    public function AddDistrict()
    {
        return view('backend.district.create');
    }
    public function CreateDistrict(Request $request)
    {

        $notification = array(
            'message' => 'Bölge Başarıyla Eklendi',
            'alert-type' => 'success'
        );
        return redirect()->route('district')->with($notification);
    }
    public function ActiveDistrict(Request $request, $id)
    {

        if ($request->aktif == 1) {
            $notification = array(
                'message' => 'Bölge Aktif Yapıldı',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Bölge  Pasif Yapıldı',
                'alert-type' => 'warning'
            );
        }
        return Redirect()->route('district')->with($notification);

    }
    public function Editdistrict(District $district)
    {


        return view('backend.district.edit', compact('district'));
    }
    public function UpdateDistrict(Request $request,District $district)
    {



        $notification = array(
            'message' => 'Bölge Başarıyla Güncellendi',
            'alert-type' => 'success'
        );
        return Redirect()->route('district')->with($notification);
    }
    public function DeleteDistrict(District $district)
    {
        $notification = array(
            'message' => 'Bölge Başarıyla Silindi',
            'alert-type' => 'success'
        );
        return Redirect()->route('district')->with($notification);

    }
}
