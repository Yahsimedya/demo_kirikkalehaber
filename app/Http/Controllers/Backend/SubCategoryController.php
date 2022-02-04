<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SubCategoryController extends Controller
{
    public function index()
    {
//        $subcategory = DB::table('subcategories')
//        ->leftjoin('categories','subcategories.category_id','categories.id')
//        ->select('subcategories.*','categories.category_tr')
//        ->orderBy('created_at', 'desc')->paginate(20);
        $subcategory = Subcategory::leftjoin('categories', 'categories.id', '=', 'subcategories.category_id')
            ->select(['subcategories.*', 'categories.category_tr'])->paginate(20);
//        return $this->hasOne(User::class,'id','user_id');
        return view('backend.subcategory.index', compact('subcategory'));
    }

    public function AddSubCategory()
    {
        //$categories = DB::table('categories')->orderBy('category_tr', 'asc')->get();
        $categories = Category::latest()->orderBy('id')->latest()->get();

        return view('backend.subcategory.create', compact('categories'));
    }

    public function CreateSubCategory(Request $request)
    {




        $notification = array(
            'message' => 'Kategori Başarıyla Eklendi',
            'alert-type' => 'success'
        );
        return Redirect()->route('subcategories')->with($notification);
    }

    public function EditSubCategory(Subcategory $subcategory)
    {
        // $data =DB::table('categories')->find($id);
        $category = Category::get();
//        $data = DB::table('subcategories')->where('id', $id)->first();
//        $categories = DB::table('categories')->get();

        return view('backend.subcategory.edit', compact('subcategory','category'));
    }

    public function UpdateSubCategory(Request $request, $id)
    {

        $notification = array(
            'message' => 'Alt Kategori Başarıyla Eklendi',
            'alert-type' => 'success'
        );
        return Redirect()->route('subcategories')->with($notification);
    }

    public function ActiveSubCategory(Request $request, $id)
    {

        if ($request->aktif == 1) {
            $notification = array(
                'message' => 'Alt Kategori Aktif Yapıldı',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Alt Kategori  Pasif Yapıldı',
                'alert-type' => 'warning'
            );
        }
        return Redirect()->route('subcategories')->with($notification);

    }

    public function DeleteSubCategory(Subcategory $subcategory)
    {

        $notification = array(
            'message' => 'Alt Kategori Başarıyla Silindi',
            'alert-type' => 'error'
        );
        return Redirect()->route('subcategories')->with($notification);
    }
}
