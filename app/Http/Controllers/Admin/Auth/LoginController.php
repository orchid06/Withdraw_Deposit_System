<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DepositRequest;
use App\Models\TransactionLog;
use App\Models\WithdrawRequest;

class LoginController extends Controller
{
    public function check(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => 'required|email|exists:admins,email',
            'password' => 'required|min:5|max:30'
        ], [
            'email.exists' => 'This email is not exists on admin table'
        ]);


        return   Auth::guard('admin')->attempt($request->only('email', 'password'))
            ? redirect()->route('admin.index')->with('success', 'You are logged in as admin')
            : redirect()->route('admin.login')->with('fail', 'Incorrect credentials');
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
