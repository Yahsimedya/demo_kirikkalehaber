<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use phpDocumentor\Reflection\DocBlock\Tag;
use function PHPUnit\Framework\assertEmpty;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest('created_at')
            ->paginate(20);
        return view('backend.user.userList', compact('users'));

    }

    public function editPage(Request $request, $id)
    {
        $users = User::where('id', '=', $request->id)->get();


        return view('backend.user.editUser', compact('users'));
    }

    public function edit(Request $request, $id)
    {


        return Redirect()->route('user.index')->with([
            'message' => 'Kullanıcı Başarıyla Güncellendi',
            'alert-type' => 'success'
        ]);


    }

    public function create()
    {
        return view('backend.user.createUser');
    }

    public function insert(Request $request)
    {


            $notification = array(
                'message' => 'Kullanıcı Başarıyla Eklendi',
                'alert-type' => 'success'
            );
            return Redirect()->route('user.index')->with($notification);

    }

    public function delete($id)
    {
        $notification = array(
            'message' => 'Kullanıcı Başarıyla Kaldırıldı',
            'alert-type' => 'success'
        );
        return Redirect()->route('user.index')->with($notification);


    }
}
