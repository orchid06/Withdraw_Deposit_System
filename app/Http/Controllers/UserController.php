<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function uploadImage(mixed $file): string
    {
        $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move('uploads/user/', $imageName);
        return $imageName;
    }

    public function create(Request $request): RedirectResponse
    {

        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'image'     => 'image',
            'password'  => 'required|min:5|max:30',
            'cpassword' => 'required|min:5|max:30|same:password'
        ]);

        $imageName      = $request->hasFile('image') ? $this->uploadImage($request->file('image'))
            : null;

        $user = new User();
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->image    = $imageName ?? null;
        $user->password = $request->password;
        $user->save();

        $user->sendEmailVerificationNotification();

        Auth::guard('web')->login($user);

        return redirect()->route('verification.notice')->with('success', 'Registered successfully! Please check your email to verify your account.');
    }

    public function check(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|min:5|max:30'

        ], [
            'email.exists' => 'This email is not exists on user table'
        ]);

        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            switch ($user->email_verified_at) {
                case null:
                    return redirect()->route('verification.notice')->with('fail', 'Please verify your email address.');
                default:
                    return redirect()->route('user.index')->with('success', 'You are logged in.');
            }
        } else {
            return redirect()->route('user.login')->with('fail', 'Incorrect credentials.');
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/');
    }
}
