<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // ログイン画面の表示
    public function login()
    {
        return view('auth.login');
    }

    // ユーザー認証処理
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home')); // 認証成功時にホーム画面へリダイレクト
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'), // 認証失敗時のメッセージ
        ]);
    }

    // サインアップ画面の表示
    public function register()
    {
        return view('auth.register');
    }

    // 新規ユーザーをデータベースに登録
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // パスワードの確認を含む
        ]);

        // ユーザー作成
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 自動ログインさせる
        Auth::login($user);

        return redirect()->route('home'); // サインアップ成功時にホーム画面へリダイレクト
    }
    
    // ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // ログアウト後にトップページにリダイレクト
    }
}
