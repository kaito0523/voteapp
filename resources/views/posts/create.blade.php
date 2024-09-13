@extends('layouts.default')

@section('content')
<div class="container">
    <h1>Create New Topic</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="description">Topic Description (max 255 characters):</label>
            <textarea name="description" id="description" class="form-control" maxlength="255" required></textarea>
        </div>

        <div class="form-group">
            <label for="options">Options (2 to 4 options):</label>
            <div id="options-wrapper">
                <input type="text" name="options[]" class="form-control" placeholder="Option 1" required>
                <input type="text" name="options[]" class="form-control" placeholder="Option 2" required>
            </div>
            <button type="button" id="add-option" class="btn btn-secondary">Add Option</button>
        </div>

        <div class="form-group">
            <label for="ends_at">End Date (optional):</label>
            <input type="datetime-local" name="ends_at" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Create Topic</button>
    </form>
</div>

<script>
    document.getElementById('add-option').addEventListener('click', function() {
        const wrapper = document.getElementById('options-wrapper');
        const optionsCount = wrapper.getElementsByTagName('input').length;
        if (optionsCount < 4) {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'options[]';
            input.className = 'form-control';
            input.placeholder = 'Option ' + (optionsCount + 1);
            input.required = true;
            wrapper.appendChild(input);
        }
    });
</script>
@endsection