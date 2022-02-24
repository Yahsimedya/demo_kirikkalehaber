<?php

namespace App\Http\Controllers;
//namespace App\Http\Controllers\Backend;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\AuthorsPost;
//use CyrildeWit\EloquentViewable\View;
use CyrildeWit\EloquentViewable\Visitor;
use Analytics;
use Spatie\Analytics\Period;
//use Spatie\Analytics\AnalyticsClient;

class AdminController extends Controller
{
    public function Logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Çıkış Yapıldı');
    }
    // public function Login()
    // {
    //     Auth::login();
    //     return Redirect()->route('admin.index')->with('success' ,'Giriş Yapıldı');

    // }



    public function index(){

        return view('admin.index');

    }
}
