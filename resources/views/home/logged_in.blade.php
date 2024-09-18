@extends('layouts.default')

@section('content')
<div class="container mx-auto px-4 py-8">
    @foreach($topics as $topic)
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <div class="p-6">
            <!-- プロフィールアイコンとユーザー名 -->
            <div class="flex items-center mb-4">
                <img src="{{ $topic->user->profile_image }}" alt="Profile" class="w-10 h-10 rounded-full mr-3">
                <div>
                    <h6 class="font-semibold text-[#0a1f1d]">{{ $topic->user->name }}</h6>
                    <p class="text-sm text-gray-500">{{ $topic->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <h5 class="text-xl font-bold text-[#0a1f1d] mb-2">{{ $topic->title }}</h5>
            <p class="text-gray-600 mb-4">{{ $topic->description }}</p>
            
            @php
                $hasVoted = $topic->votes->where('user_id', Auth::id())->count() > 0;
            @endphp

            <!-- もし投票済みなら結果を表示 -->
            @if($hasVoted)
                <div class="space-y-2 results-{{ $topic->id }}">
                    @foreach($topic->options as $option)
                    @php
                        $voteCount = $option->votes->count();
                        $totalVotes = $topic->votes->count();
                        $percentage = $totalVotes > 0 ? ($voteCount / $totalVotes) * 100 : 0;
                    @endphp
                    <div class="bg-gray-200 rounded-full overflow-hidden">
                        <div class="bg-[#15e6d5] text-[#0a1f1d] text-sm font-semibold py-2 px-3 flex justify-between" style="width: {{ $percentage }}%">
                            <span>{{ $option->text }}</span>
                            <span>{{ number_format($percentage, 0) }}%</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
            <!-- もし未投票なら投票オプションを表示 -->
            <div class="space-y-2 mb-4 options-{{ $topic->id }}">
                @foreach($topic->options as $option)
                <button 
                    class="w-full text-left px-4 py-2 bg-[#DFEBE9] text-[#0a1f1d] rounded-xl hover:bg-[#15e6d5] transition duration-300 option-button"
                    data-option-id="{{ $option->id }}" 
                    data-topic-id="{{ $topic->id }}"
                >
                    {{ $option->text }}
                </button>
                @endforeach
            </div>
            @endif

            <p class="text-sm text-gray-500">
                @if($topic->ends_at)
                    終了まで{{ $topic->ends_at->diffForHumans() }}
                @else
                    投票期限なし
                @endif
                • <span class="vote-count-{{ $topic->id }}">{{ $topic->votes_count }}</span>票
            </p>
        </div>
    </div>
    @endforeach
</div>

<script>
// ... (既存のJSコードも変更なしで使えます)
</script>
@endsection