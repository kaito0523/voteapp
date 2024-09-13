<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;
use App\Models\Option;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'description' => 'required|string|max:255',
            'options' => 'required|array|min:2|max:4',  // 2~4の選択肢が必須
            'options.*' => 'required|string|max:255',  // 各選択肢のバリデーション
            'ends_at' => 'nullable|date|after:now',    // 終了日時は省略可能、現在より後の日時
        ]);

        // 投稿作成
        $topic = Topic::create([
            'user_id' => Auth::id(),
            'description' => $request->input('description'),
            'ends_at' => $request->input('ends_at'),
        ]);

        // 選択肢の保存
        foreach($request->input('options') as $optionText){
            Option::create([
                'topic_id' => $topic->id,
                'text' => $optionText
            ]);
        }

        return redirect()->route('home')->with('success', '投稿が完了しました！');

    }


}


