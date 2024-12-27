<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        if (session('user')) {
            return redirect('/');
        }
        if (Auth::check()) {
            return redirect('/');
        } else {
            return view("public.login");
        }
    }
    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect('/');
        }

        // Validate the form data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus format yang valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Jika berhasil login
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withInput()->withErrors('Email atau password salah');
    }
    public function loginAPI(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus format yang valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::where('email', $request->email)->first();
        if ($user && password_verify($request->password, $user->password)) {
            return response()->json([
                'statusCode' => 200,
                'user' => $user,
            ], 200);
        } else {
            return response()->json(['error' => 'Email atau password salah'], 500);
        }

    }
    public function logout()
    {
        Auth::logout();
        Session::forget('user');
        return redirect('/login');
    }
}
