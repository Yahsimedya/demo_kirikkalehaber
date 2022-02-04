<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect;

class CommentsController extends Controller
{
    public function adminCommentsindex()
    {
        $comments = \DB::table('comments')->orderByDesc("id")->get();
        return view('backend.Comments.index', compact('comments'));
    }

    public function ActiveComments(Request $request, $id)
    {

        $update['status'] = $request->aktif;


        if ($request->aktif == 1) {
            $notification = array(
                'message' => 'Yorum Aktif',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Yorum Pasif',
                'alert-type' => 'warning'
            );
        }
        return Redirect()->route('comments.index')->with($notification);
    }

    public function DeleteComments(Request $request, $id)
    {
//        dd($id);
        $notification = array(
            'message' => 'Yorum Silindi',
            'alert-type' => 'warning'
        );
        return Redirect()->route('comments.index')->with($notification);
    }

    public function OpenComments(Request $request, $id)
    {
        $posts = DB::table('posts')->where('id', '=', $id)->get();
        $url = "/" . str_slug($posts[0]->title_tr) . "/" . $id . "/haberi";
        return Redirect::to($url);
    }

    public function AddComments(Request $request, $id)
    {


            return Redirect()->route('open.comments', $id)->with($notification);

    }
}
