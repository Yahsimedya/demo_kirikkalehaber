<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\District;
use App\Models\Post;
use App\Models\Subcategory;
use App\Models\Subdistrict;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Image;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function HaberAra(Request $request)
    {
//        dd($request->all());

        $text = $request->get('haber');


        $search = Post::where('title_tr', 'LIKE', '%' . $text . '%')->limit(30)->latest()->get();

        $output = '<table id="example1" class="table datatable-responsive">
            <thead>
              <tr>
                <th>No</th>
                    <th>Haber Başlığı</th>
                    <th>Kategori</th>
                    <th>Bölge</th>
                    <th>Fotoğraf</th>
                    <th>Tarih</th>
                    <th class="text-center">Actions</th>

              </tr>
            </thead>
            <tbody id="sortable">';
        $i = 0;
//        dd($search);
        foreach ($search as $row) {
            $i++;
            $baslik = $row->title_tr;
            $foto = $row->image;

            $output .= ' <tr id="">
          <td>' . $i . '</td>
           <td class="sortable text-success">' . $baslik . '</td>
          <td>' . $row->category->category_tr . '</td>
          <td>' . $row->districts->district_tr . '</td>
          <td ><img width="100" src="' . asset($row->image) . '"></td>
          <td>' . Carbon::parse($row->created_at)->diffForHumans() . '</td>
               <td> </td>
                   <td class="text-center">
                        <div class="list-icons">
                            <div class="dropdown">
                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="' . route('edit.post', $row) . '" class="dropdown-item"><i class="icon-pencil6"></i> Düzenle</a>
                                    <a href="' . route('delete.post', $row) . '"  class="dropdown-item"><i class="icon-trash"></i>Sil</a>
                                </div>
                            </div>
                        </div>
                    </td>';


        }


        return $output;

    }

    public function index()
    {
        $post = Post::leftjoin('categories', 'posts.category_id', '=', 'categories.id')
            ->leftjoin('subcategories', 'posts.subcategory_id', '=', 'subcategories.id')
            ->leftjoin('districts', 'posts.district_id', '=', 'districts.id')
            ->leftjoin('subdistricts', 'posts.subdistrict_id', 'subdistricts.id')
            ->select(['posts.*', 'categories.category_tr', 'districts.district_tr', 'subdistricts.subdistrict_tr'])
            ->latest('id')
            ->paginate(20);

        return view('backend.post.index', compact('post'));
    }

    public function AddPost()
    {

        $category = DB::table('categories')->get();
        $district = DB::table('districts')->get();
        $tags = Tag::orderBy('name', 'asc')->get();

        return view('backend.post.create', compact('category', 'district', 'tags'));
    }

    public function orderImagesPage($id)
    {
        $orderImages = DB::table('order_images')->where('haberId', '=', $id)->get();

        return view('backend.post.orderimagesPage', compact('orderImages', 'id'));
    }

    public function orderImagesUploadPage($id)
    {

        return view('backend.post.imageUpload', compact('id'));
    }

    public function CreatePosts(Request $request)
    {


            return Redirect()->route('all.post')->with([
                'message' => 'Haber Başarıyla Eklendi',
                'alert-type' => 'success'
            ]);
    }

    public function EditPosts(Post $post)
    {
//dd($post->id);

        $category = DB::table('categories')->get();
        $district = DB::table('districts')->get();
        $tags = Tag::join('post_tags', 'tags.id', '=', 'post_tags.tag_id')
            ->select(['tags.*', 'post_tags.tag_id'])
            ->where('post_tags.post_id', $post->id)
//            ->latest('created_at')
            ->get();
        $users = Auth::user()->id;
//        dd($post);
//        $tags = Tag::find($post->id);

//        $tags = Tag::orderBy('name','asc')->get();


        return view('backend.post.edit', compact('post', 'category', 'district', 'tags'));
    }

    public function UpdatePost(Request $request, Post $post)
    {


            return Redirect()->route('all.post')->with([
                'message' => 'Haber Başarıyla Güncellendi',
                'alert-type' => 'success'
            ]);
    }

    public function ActivePost(Request $request, $id)
    {




        if ($request->aktif == 1) {
            $notification = array(
                'message' => 'Haber Aktif',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Haber Pasif',
                'alert-type' => 'warning'
            );
        }
        return Redirect()->route('all.post')->with($notification);

    }

    public function DeletePost(Post $post)
    {


        $notification = array(
            'message' => 'Haber Başarıyla Silindi',
            'alert-type' => 'error'
        );
        return Redirect()->route('all.post')->with($notification);
    }


    public function GetSubCategory($category_id)
    {
        $sub = Subcategory::find($category_id)->get();
        if ($sub) {
            return response()->json($sub);
        }
    }

    public function GetSubDistrict($district_id)
    {
        $districts = Subdistrict::where('district_id', $district_id)->get();

        return response()->json($districts);
    }

    public function fetchLike(Request $request)
    {
        $post = Post::find($request->blog);
        return response()->json([
            'post' => $post,
        ]);
    }



    //  public function OrderphotoUpload(Request $request, $id)
    //  {
    //
    //      $image = $request->file('file');
    //      $year = date("Y");
    //      $benzersiz = uniqid();
    //      $month = date("m");
    //      $imageName = time() . $benzersiz . '.' . $image->extension();
    //      $image->move(public_path('image/postimg/' . $year . '/' . $month . '/'), $imageName);
    //      $url = 'image/postimg/' . $year . '/' . $month . '/' . $imageName;
    //      DB::insert('insert into order_images (haberId, image) values (?, ?)', [$id, $url]);
    //
    //
    //      return response()->json(['success' => $imageName]);
    //
    //
    //  }
    //
    //  public function Orderphotoupdate(Request $request, $update, $id)
    //  {
    //      dd("update" . $request);
    //
    //  }
    //
    //  public function Orderphotodelete(Request $request, $id)
    //  {
    //
    //      $secilenSayi = count($request->urunfotosec);
    //      $images = $request->urunfotosec;
    //
    //
    //      foreach ($images as $image) {
    //
    //          DB::table('order_images')->where('id', '=', $image)->delete();
    //
    //      }
    //      return Redirect()->route('all.orderImagesPage',$id);
    //  }


}
