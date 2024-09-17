<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold mb-6">Login</h1>

            @if (session('error'))
                <div class="mb-4 text-red-500">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600" required>
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-between items-center mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="form-checkbox">
                        <span class="ml-2">Remember Me</span>
                    </label>

                    <a href="#" class="text-sm text-indigo-600 hover:underline">Forgot Password?</a>
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700">Login</button>
            </form>

            <p class="mt-4 text-sm text-center">Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Sign Up</a></p>
        </div>
    </div>
</body>
</html>