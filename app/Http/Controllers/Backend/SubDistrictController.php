<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Subdistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SubDistrictController extends Controller
{
    //
    public function index()
    {
        $subdistrict = Subdistrict::leftjoin('districts', 'subdistricts.district_id', '=', 'districts.id')
            ->select(['subdistricts.*', 'districts.district_tr'])->latest('district_tr')->paginate(20);


        return view('backend.subdistrict.index', compact('subdistrict'));
    }
    public function AddSubDistrict()
    {
        $districts =District::latest('')->get();
        return view('backend.subdistrict.create',compact('districts'));
    }
    public function CreateSubDistrict(Request $request)
    {
        $validatedData = $request->validate(
            [
                'subdistrict_tr' => 'required|unique:subdistricts|max:255',
                'subdistrict_en' => 'required|unique:subdistricts|max:255',
                'subdistrict_keywords' => 'required|max:255',
                'subdistrict_description' => 'required|max:255',
            ],
            [
                'subdistrict_tr.required' => 'Türkçe kategori ismi boş olamaz lütfen doldurunuz',
                'subdistrict_tr.unique' => 'Bu isimle daha önce kayıt yapılmış',
                'subdistrict_tr.max' => 'İsim 255 karakterden büyük olamaz',
                'subdistrict_en.required' => 'İngilizce kategori ismi boş olamaz lütfen doldurunuz',
                'subdistrict_en.unique' => 'Bu isimle daha önce kayıt yapılmış',
                'subdistrict_en.max' => 'İsim 255 karakterden büyük olamaz',
                'subdistrict_keywords.required' => 'Alan boş olamaz lütfen doldurunuz',
                'subdistrict_keywords.max' => '255 karakterden büyük olamaz',
                'subdistrict_description.required' => 'Alan boş olamaz lütfen doldurunuz',
                'subdistrict_description' => '255 karakterden büyük olamaz',
            ]
        );

        Subdistrict::create($request->all());
        $notification = array(
            'message' => 'Kategori Başarıyla Eklendi',
            'alert-type' => 'success'
        );
        return redirect()->route('subdistrict')->with($notification);
    }
    public function EditSubDistrict(Subdistrict $subdistrict)
    {
        $districts= DB::table('districts')->get();

        return view('backend.subdistrict.edit', compact('subdistrict','districts'));
    }
    public function UpdateSubDistrict(Request $request,Subdistrict $subdistrict)
    {

        $notification = array(
            'message' => 'Alt Kategori Başarıyla Eklendi',
            'alert-type' => 'success'
        );
        return Redirect()->route('subdistrict')->with($notification);
    }
    public function ActiveSubDistrict(Request $request,$id)
    {

        $update['subdistrict_status'] = $request->aktif;

         DB::table('subdistricts')->where('id',$id)->update($update);


        if ($request->aktif==1) {
            $notification = array(
                'message' => 'Alt Bölge Aktif Yapıldı',
                'alert-type' => 'success'
            );
        } else {
        $notification = array(
            'message' => 'Alt Bölge  Pasif Yapıldı',
            'alert-type' => 'warning'
        );
    }
        return Redirect()->route('subdistrict')->with($notification);

    }
    public function DeleteSubDistrict(Subdistrict $subdistrict)
    {
        $subdistrict->delete();
        $notification = array(
            'message' => 'Alt Bölge Başarıyla Silindi',
            'alert-type' => 'error'
        );
        return Redirect()->route('subdistrict')->with($notification);
    }
}
