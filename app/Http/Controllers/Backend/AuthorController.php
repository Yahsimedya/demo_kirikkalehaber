<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Authors;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Image;
//use PharIo\Manifest\Author;

class AuthorController extends Controller
{
    //

    public function index() {

        $authors= Authors::latest()->paginate();

        return view('backend.authors.listauthors',compact('authors'));

    }
    public function AddAuthors()
    {
        //$categories = Category::whereNull('parent_id')->get();

        return view('backend.authors.add_authors');
    }
    public function CreateAuthors(Request $request) {

                $notification = array(
                    'message' => 'Yazar Başarıyla Eklendi',
                    'alert-type' => 'success'
                );
                return Redirect()->route('list.authors')->with($notification);



    }
    public function EditAuthors(Authors $authors) {

        return view('backend.authors.edit_authors',compact('authors'));

    }
    public function UpdateAuthors(Request $request, Authors $authors) {

            $notification = array(
                'message' => 'Haber Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return Redirect()->route('list.authors')->with($notification);

    }
    public function DeleteAuthors(Authors $authors)
    {

        $notification = array(
            'message' => 'Yazar Başarıyla Silindi',
            'alert-type' => 'error'
        );
        return Redirect()->route('list.authors')->with($notification);
    }
    public function ActiveAuthors(Request $request, $id)
    {

        if ($request->aktif == 1) {
            $notification = array(
                'message' => 'Yazar Aktif',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Yazar Pasif',
                'alert-type' => 'warning'
            );
        }
        return Redirect()->route('list.authors')->with($notification);

    }
}
