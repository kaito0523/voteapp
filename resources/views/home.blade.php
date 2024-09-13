@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
<<<<<<< HEAD
                <div class="card-header">Welcome</div>

                <div class="card-body">
                    @if (Auth::check())
                        You are logged in!
                    @else
                        <p>Welcome to our application. Please log in to continue.</p>
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    @endif
=======
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
>>>>>>> origin/develop
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
