<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminLoginController extends Controller
{

    public function showLoginForm()
    {
        if (Auth::guard('super_admin')->check()) {
            return redirect()->intended(route('super_admin.dashboard'));
        } elseif (Auth::guard('user')->check()) {
            return redirect()->intended(route('super_admin.dashboard'));
        }

        return view('admin.auth.login');
    }


    public function loginFormSubmit(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        // Attempt to log the user in
        if (Auth::guard('super_admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended(route('super_admin.dashboard'));
        } elseif (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended(route('super_admin.dashboard'));
        }

        // if unsuccessful
        $errors = [
            'email' => 'Email or password is incorrect',
        ];
        return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors($errors);
    }


    public function logout()
    {
        if (Auth::guard('super_admin')->check()) {
            auth()->guard('super_admin')->logout();
        } elseif (Auth::guard('user')->check()) {
            auth()->guard('user')->logout();
        }

        return redirect('/');
    }
}
