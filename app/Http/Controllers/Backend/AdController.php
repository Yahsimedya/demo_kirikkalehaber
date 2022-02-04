<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class AdController extends Controller
{
    //
    public function Listads()
    {
//$ads= Ad::paginate(20);
//$ads=DB::table('ads')->get();
        $ads = Ad::leftjoin('ad_categories', 'ad_categories.id', '=', 'ads.category_id')
            ->select(['ads.*', 'ad_categories.title'])
            ->latest('created_at')
            ->paginate(5);
        return view('backend.ads.listads', compact('ads'));
    }

    public function AddAds()
    {
        $category = AdCategory::orderBy('title', 'asc')->get();
        return view('backend.ads.add_ads', compact('category'));
    }

    public function CreateAds(Request $request)
    {


            $notification = array(
                'message' => 'Reklam Başarıyla Eklendi',
                'alert-type' => 'success'
            );
            return Redirect()->route('list.add')->with($notification);


    }

    public function EditAds(Ad $ads)
    {
        $category = AdCategory::get();
        return view('backend.ads.edit_ads', compact('ads', 'category'));
    }


    public function UpdateAds(Request $request, Ad $ad)
    {

                $notification = array(
                    'message' => 'Reklam Başarıyla Düzenlendi',
                    'alert-type' => 'success'
                );
                return Redirect()->route('list.add')->with($notification);



    }

    public function DeleteAds(Ad $ad)
    {


        $notification = array(
            'message' => 'Reklam Başarıyla Silindi',
            'alert-type' => 'error'
        );
        return redirect()->route('list.add')->with($notification);
    }

    public function adsStatus(Ad $ad, Request $request)
    {


        if ($request->aktif == 1) {
            $notification = array(
                'message' => 'Reklam Aktif Yapıldı',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Reklam  Pasif Yapıldı',
                'alert-type' => 'warning'
            );
        }


        return redirect()->route('list.add')->with($notification);
    }
}
