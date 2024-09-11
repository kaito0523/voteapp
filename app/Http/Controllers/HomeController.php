<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function index()
    {
        $topics = Topic::where('end_date', '>', now())
                        ->orWhereNull('end_date')
                        ->orderBy('created_at', 'desc')
                        ->with('Option') //選択肢も一緒に取得
                        ->get();

        //ログイン状態に応じて、異なるビューを表示
        if(Auth::check()){
            return view('home.logged_in', compact('topics'));
        } else {
            return view('home.guest', compact('topics'));
        }
    }


}

