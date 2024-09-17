<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Topic;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    
    public function index()
    {
        $topics = Topic::where('ends_at', '>', now())
                        ->orWhereNull('ends_at')
                        ->orderBy('created_at', 'desc')
                        ->with('options') //選択肢も一緒に取得
                        ->get();

        //ログイン状態に応じて、異なるビューを表示
        if(Auth::check()){
            return view('home.logged_in', compact('topics'));
        } else {
            return view('home.guest', compact('topics'));
        }
    }

    public function vote(Request $request, $topicId)
{
    // バリデーション
    $request->validate([
        'option_id' => 'required|exists:options,id',
    ]);

    $userId = Auth::id() ?? null;

    // ユーザーが既に投票しているか確認
    $existingVote = Vote::where('topic_id', $topicId)
                        ->where(function ($query) use ($userId, $request) {
                            if ($userId) {
                                $query->where('userId', $userId);
                            } else {
                                $query->where('ip_Address', $request->ip());
                            }
                        })
                        ->first();

    if ($existingVote) {
        return response()->json(['error' => 'You have already voted on this topic.'], 403);
    }

    // 投票を保存
    Vote::create([
        'topic_id' => $topicId,
        'option_id' => $request->input('option_id'),
        'userId' => $userId,
        'ip_Address' => $request->ip(),
    ]);

    // 結果を計算
    $topic = Topic::with('options.votes')->find($topicId);
    $results = $this->calculateResults($topic);

    // 投票成功と結果を返す
    return response()->json(['message' => 'Vote successful', 'results' => $results], 200);
}

    private function calculateResults(Topic $topic)
    {
        $results = [];
        $totalVotes = $topic->votes->count();

        foreach($topic->options as $option){
            $voteCount = $option->votes->count();
            $percentage = $totalVotes > 0 ? ($voteCount / $totalVotes) * 100 : 0;
            $results[] =[
                'option' => $option->text,
                'votes' => $voteCount,
                'percentage' => $percentage,
            ];
        }

        return $results;
    }

}

