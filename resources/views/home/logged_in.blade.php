@extends('layout.default')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Topics</h1>

    @forelse($topics as $topic)
        <div class="bg-white shadow-md rounded-lg mb-6 p-6">
            <p class="text-lg font-semibold">{{ $topic->description }}</p>
            @if($topic->ends_at)
                <p class="text-sm text-gray-500">Ends at: {{ $topic->ends_at->format('Y-m-d H:i') }}</p>
            @else
                <p class="text-sm text-gray-500">No end date</p>
            @endif

            <form method="POST" action="{{ route('vote', $topic->id) }}" class="mt-4">
                @csrf
                @foreach($topic->options as $option)
                    <div class="flex items-center mb-2">
                        <input type="radio" name="option_id" value="{{ $option->id }}" id="option{{ $option->id }}" class="form-radio h-4 w-4 text-teal-500">
                        <label for="option{{ $option->id }}" class="ml-2 text-sm text-gray-700">{{ $option->text }}</label>
                    </div>
                @endforeach
                <button type="submit" class="bg-teal-500 text-white py-2 px-4 rounded-lg hover:bg-teal-600">Vote</button>
            </form>

            <div class="mt-4">
                <div class="vote-results" id="results-{{ $topic->id }}" style="display:none;">
                    <!-- 結果を動的に表示 -->
                </div>
            </div>
        </div>
    @empty
        <p>No topics available at the moment.</p>
    @endforelse
</div>

<script>
    document.querySelectorAll('.vote-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(form);
            const topicId = form.action.split('/').pop();

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    const resultsDiv = document.getElementById(`results-${topicId}`);
                    resultsDiv.style.display = 'block';
                    resultsDiv.innerHTML = '';

                    data.results.forEach(result => {
                        resultsDiv.innerHTML += `<p>${result.option}: ${result.votes} votes (${result.percentage.toFixed(2)}%)</p>`;
                    });
                }
            });
        });
    });
</script>
@endsection