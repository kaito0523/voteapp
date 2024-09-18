<?php

namespace App\Http\Controllers;

use DB;
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
                    ->withCount('votes')
                    ->with(['options', 'votes']) // optionsとvotesを一緒に取得
                    ->get();

    // ユーザーがログインしているかどうかで投票済み確認
    if (Auth::check()) {
        $userId = Auth::id();
        foreach ($topics as $topic) {
            // ログインユーザーの場合、user_idで投票済みか確認
            $topic->has_voted = $topic->votes->where('user_id', $userId)->count() > 0;
        }
    } else {
        $userIp = request()->ip();
        foreach ($topics as $topic) {
            // ゲストユーザーの場合、IPアドレスで投票済みか確認
            $topic->has_voted = $topic->votes->where('ip_address', $userIp)->count() > 0;
        }
    }

    // ログイン状態に応じてビューを表示
    if (Auth::check()) {
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

    $userId = Auth::id();
    $ipAddress = $request->ip();

    DB::beginTransaction();
    try {
        // トピックが存在し、まだ終了していないか確認
        $topic = Topic::where('id', $topicId)
            ->where(function ($query) {
                $query->where('ends_at', '>', now())
                    ->orWhereNull('ends_at');
            })
            ->lockForUpdate()
            ->first();

        if (!$topic) {
            DB::rollBack();
            return response()->json(['error' => 'This topic does not exist or has ended.'], 404);
        }

        // ユーザーが既に投票しているか確認
        $existingVote = Vote::where('topic_id', $topicId)
            ->where(function ($query) use ($userId, $ipAddress) {
                $query->where('ip_address', $ipAddress)
                    ->when($userId, function ($query) use ($userId) {
                        $query->orWhere('user_id', $userId);
                    });
            })
            ->first();

        if ($existingVote) {
            DB::rollBack();
            return response()->json(['error' => 'You have already voted on this topic.'], 403);
        }

        // 投票を保存
        Vote::create([
            'topic_id' => $topicId,
            'option_id' => $request->input('option_id'),
            'user_id' => $userId,
            'ip_address' => $ipAddress,
        ]);

        DB::commit();

        // 結果を計算
        $topic = Topic::with('options.votes')->find($topicId);
        $results = $this->calculateResults($topic);

        return response()->json(['message' => 'Vote successful', 'results' => $results], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'An error occurred while processing your vote.'], 500);
    }
}

private function calculateResults(Topic $topic)
{
    $results = [];
    $totalVotes = $topic->votes->count();

    foreach ($topic->options as $option) {
        $voteCount = $option->votes->count();
        $percentage = $totalVotes > 0 ? ($voteCount / $totalVotes) * 100 : 0;
        $results[] = [
            'option' => $option->text,
            'votes' => $voteCount,
            'percentage' => number_format($percentage, 2), // 小数点2桁で表示
        ];
    }

    return $results;
}

}

