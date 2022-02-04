<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Authors;
use App\Models\AuthorsPost;
use Illuminate\Http\Request;
class CornerPostsController extends Controller
{
    //
    public function index() {
        $AuthPosts = AuthorsPost::leftjoin('authors', 'authors.id', '=', 'authors_posts.authors_id')

            ->select(['authors_posts.*', 'authors.name'])
            ->latest('created_at')
            ->paginate(20);
//        $AuthPosts=AuthorsPost::latest()->paginate(10);
        return view('backend.authorsposts.list',compact('AuthPosts'));
    }
    public function AddAuthorsPosts() {
        $authors=Authors::get();
        return view('backend.authorsposts.add',compact('authors'));

    }
    public function CreateAuthorsPosts(Request $request) {


        return redirect('/authors/posts');

    }

    public function EditAuthorsPosts(AuthorsPost $cornerposts) {
        $authors=Authors::get();

        return view('backend.authorsposts.edit',compact('cornerposts','authors'));

    }
    public function UpdateAuthorsPosts(Request $request,AuthorsPost $cornerposts) {

            $notification = array(
                'message' => 'Yazı Güncellendi',
                'alert-type' => 'success'
            );

        return Redirect()->route('list.authorsposts')->with($notification);
    }
    public function ActiveAuthors(Request $request, $id)
    {

        if ($request->aktif == 1) {
            $notification = array(
                'message' => 'Yazı Aktif',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Yazı Pasif',
                'alert-type' => 'warning'
            );
        }
        return Redirect()->route('list.authorsposts')->with($notification);

    }
    public function DeleteAuthorsPosts(AuthorsPost $cornerposts) {

        $notification = array(
            'message' => 'Köşe Yaızısı Başarıyla Silindi',
            'alert-type' => 'success'
        );

        return redirect()->route('list.authorsposts')->with($notification);
    }
}
