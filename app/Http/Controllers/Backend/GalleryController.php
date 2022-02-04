<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Photocategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Image;
class GalleryController extends Controller
{
 public function PhotoGalery()
 {
    //  $photo = DB::table('photocategories')->get();

     $photo = DB::table('photos')
     ->orderBy('created_at', 'desc')->paginate(20);

     return view('backend.galery.photos', compact('photo'));
 }

 public function AddPhotoGalery()
 {
    $photocategory = DB::table('photocategories')->get();

     return view('backend.galery.createphoto', compact('photocategory'));
 } public function GaleryDetailAdd()
 {
    $photocategory = DB::table('photocategories')->get();

     return view('backend.galery.createphoto', compact('photocategory'));
 }

 public function CreatePhoto(Request $request)
 {



        $notification = array(
            'message' => 'Fotoğraf Başarıyla Eklendi',
            'alert-type' => 'success'
        );
        return Redirect()->route('photo.galery')->with($notification);

 }
public function GaleryUpdate(Request $request){


            $notification = array(
                'message' => 'Fotoğraf Başarıyla Eklendi',
                'alert-type' => 'success'
            );
        return Redirect()->route('photo.galery')->with($notification);

}
 public function GaleryDetail($id)
 {

     $photos= DB::table('photos')->where('photocategory_id',$id)->get();
    return view('backend.galery.galery_photo',compact('photos'));
 }
 public function AddText(Request $request , $id)
 {


    $notification = array(
        'message' => 'Fotoğraf Başarıyla Düzenlendi',
        'alert-type' => 'success'
    );
    return Redirect()->route('photo.galery')->with($notification);


}
public function ActivePhotoGalery(Request $request,$id)
{


    if ($request->aktif==1) {
        $notification = array(
            'message' => 'Foto Galeri Aktif Yapıldı',
            'alert-type' => 'success'
        );
    } else {
    $notification = array(
        'message' => 'Foto Galeri  Pasif Yapıldı',
        'alert-type' => 'warning'
    );
}
    return Redirect()->route('photo.galery')->with($notification);
    // return view('backend.subcategory.index', compact('subcategory'));

    // return view('backend.subcategory.index');
}

public function DeleteGalery($id)
{



    $notification = array(
        'message' => 'Galeri Başarıyla Silindi',
        'alert-type' => 'success'
    );
    return Redirect()->route('photo.galery')->with($notification);

}
public function EditPhotoGalery($photocategory_id)
{
    $galery = DB::table('photos')->where('id', $photocategory_id)->first();
    $photocategory = DB::table('photocategories')->get();

    return view('backend.galery.edit', compact('galery','photocategory'));
}

public function DeletePhoto($id)
{

    return Redirect()->back();

}

}
