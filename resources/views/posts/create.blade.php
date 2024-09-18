@extends('layouts.default')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-[#0a1f1d] mb-6">新しいトピックを作成</h1>

            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-4" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('posts.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="description" class="block text-sm font-medium text-[#0a1f1d] mb-2">トピックの説明 (最大255文字):</label>
                    <textarea name="description" id="description" class="w-full px-3 py-2 text-[#0a1f1d] border border-[#ddf4f2] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#15e6d5]" maxlength="255" required></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#0a1f1d] mb-2">選択肢 (2〜4個の選択肢):</label>
                    <div id="options-wrapper" class="space-y-2">
                        <input type="text" name="options[]" class="w-full px-3 py-2 text-[#0a1f1d] border border-[#ddf4f2] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#15e6d5]" placeholder="選択肢 1" required>
                        <input type="text" name="options[]" class="w-full px-3 py-2 text-[#0a1f1d] border border-[#ddf4f2] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#15e6d5]" placeholder="選択肢 2" required>
                    </div>
                    <button type="button" id="add-option" class="mt-2 px-4 py-2 bg-[#DFEBE9] text-[#0a1f1d] rounded-xl hover:bg-[#c5d8d5] transition-colors">選択肢を追加</button>
                </div>

                <div>
                    <label for="ends_at" class="block text-sm font-medium text-[#0a1f1d] mb-2">終了日時 (任意):</label>
                    <input type="datetime-local" id="ends_at" name="ends_at" class="w-full px-3 py-2 text-[#0a1f1d] border border-[#ddf4f2] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#15e6d5]">
                </div>

                <button type="submit" class="w-full px-4 py-2 bg-[#15e6d5] text-[#0a1f1d] rounded-xl hover:bg-[#12ccc0] transition-colors font-bold">トピックを作成</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('add-option').addEventListener('click', function() {
            const wrapper = document.getElementById('options-wrapper');
            const optionsCount = wrapper.getElementsByTagName('input').length;
            if (optionsCount < 4) {
                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'options[]';
                input.className = 'w-full px-3 py-2 text-[#0a1f1d] border border-[#ddf4f2] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#15e6d5]';
                input.placeholder = '選択肢 ' + (optionsCount + 1);
                input.required = true;
                wrapper.appendChild(input);
            }
        });
    });
</script>
@endsection