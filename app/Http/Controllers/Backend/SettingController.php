<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Seos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SettingController extends Controller
{
    //
    public function SocialSetting()
    {
       $social =DB::table('socials')->first();
       return view('backend.setting.social',compact('social'));

    }
    public function UpdateSocial(Request $request, $id)
    {

        $notification = array(
            'message' => 'Sosyal Medya Linkleri Başarıyla Güncellendi',
            'alert-type' => 'info'
        );
        return redirect()->route('social.setting')->with($notification);
    }
    public function SeoSetting()
    {
        $seos =DB::table('seos')->first();

        return view('backend.setting.seo',compact('seos'));


    }
    public function UpdateSeo(Request $request, Seos $seos)
    {

        $notification = array(
            'message' => 'SEO Ayarları Başarıyla Kaydedildi',
            'alert-type' => 'success'
        );
        return redirect()->route('seo.setting')->with($notification);
    }
}
