<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Image;

class WebsiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $websetting =WebsiteSetting::first();
        return view('backend.setting.webisitesetting',compact('websetting'));
    }


    public function update(Request $request, WebsiteSetting $websetting)
    {

        $notification = array(
            'message' => 'Reklam Başarıyla Düzenlendi',
            'alert-type' => 'success'
        );
        return redirect()->back();

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
