@extends('layouts.guestlayout')

@section('content')
<div class="container mx-auto px-4 py-8">
    @forelse($topics as $topic)
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
            <p class="text-gray-600 mb-4">{{ $topic->description }}</p>
            
            <!-- 投票済みかどうかで条件分岐 -->
            @if($topic->has_voted)
                <!-- 投票結果を表示 -->
                <div class="space-y-2 mb-4 results-{{ $topic->id }}">
                    @foreach($topic->options as $option)
                        @php
                            $totalVotes = $topic->votes->count();
                            $optionVotes = $option->votes->count();
                            $percentage = $totalVotes > 0 ? ($optionVotes / $totalVotes) * 100 : 0;
                        @endphp
                        <div class="bg-gray-200 rounded-full overflow-hidden">
                            <div class="text-[#0a1f1d] text-sm font-semibold py-2 px-3 flex justify-between items-center w-full" style="background: linear-gradient(to right, #15e6d5 {{ $percentage }}%, transparent {{ $percentage }}%);">
                                <span class="truncate flex-grow">{{ $option->text }}</span>
                                <span class="ml-2 flex-shrink-0">{{ number_format($percentage, 0) }}%</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- 投票ボタンを表示 -->
                <div class="space-y-2 mb-4 options-{{ $topic->id }}">
                    @foreach($topic->options as $option)
                    <button
                        class="w-full text-left px-4 py-2 bg-[#DFEBE9] text-[#0a1f1d] rounded-xl hover:bg-[#15e6d5] transition duration-300 option-button flex justify-between items-center"
                        data-option-id="{{ $option->id }}"
                        data-topic-id="{{ $topic->id }}"
                    >
                        <span class="truncate flex-grow">{{ $option->text }}</span>
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

            <!-- 結果表示領域 -->
            <div class="mt-4 space-y-2 results-{{ $topic->id }}" style="display: none;"></div>
        </div>
    </div>
    @empty
    <p>現在投稿されているトピックはありません。</p>
    @endforelse
</div>

<script>
    document.querySelectorAll('.option-button').forEach(button => {
        button.addEventListener('click', async function() {
            const optionId = this.getAttribute('data-option-id');
            const topicId = this.getAttribute('data-topic-id');
            const optionsDiv = document.querySelector(`.options-${topicId}`);
            const resultsDiv = document.querySelector(`.results-${topicId}`);
    
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                const headers = {
                    'Content-Type': 'application/json',
                };
                
                if (csrfToken) {
                    headers['X-CSRF-TOKEN'] = csrfToken;
                }
    
                const response = await fetch(`/topics/${topicId}/vote`, {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify({ option_id: optionId })
                });
    
                let data;
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    data = await response.json();
                } else {
                    const text = await response.text();
                    console.error('Received non-JSON response:', text);
                    throw new Error('サーバーから予期しない応答がありました。');
                }
    
                if (!response.ok) {
                    throw new Error(data.error || '投票中にエラーが発生しました。');
                }
    
                // 結果を表示
                resultsDiv.innerHTML = data.results.map(result => `
                <div class="bg-gray-200 rounded-full overflow-hidden mb-2">
                    <div class="text-[#0a1f1d] text-sm font-semibold py-2 px-3 flex justify-between items-center w-full" style="background: linear-gradient(to right, #15e6d5 ${parseFloat(result.percentage).toFixed(0)}%, transparent ${parseFloat(result.percentage).toFixed(0)}%);">
                        <span class="truncate flex-grow">${result.option}</span>
                        <span class="ml-2 flex-shrink-0">${parseFloat(result.percentage).toFixed(0)}%</span>
                    </div>
                </div>
                `).join('');
    
                // 選択肢を非表示にし、結果を表示
                optionsDiv.style.display = 'none';
                resultsDiv.style.display = 'block';
    
                const voteCountElem = document.querySelector(`.vote-count-${topicId}`);
                voteCountElem.textContent = parseInt(voteCountElem.textContent) + 1;
    
            } catch (error) {
                console.error('Error:', error);
                alert(error.message); 
            }
        });
    });
    </script>
@endsection