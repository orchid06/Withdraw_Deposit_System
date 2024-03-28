<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DepositRequest;
use App\Models\TransactionLog;
use App\Models\WithdrawRequest;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class AdminController extends Controller
{
    public function uploadImage(mixed $file): string
    {
        $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move('uploads/user/', $imageName);
        return $imageName;
    }

    public function index(): View
    {
        $users = User::with('depositRequests')->get();

        $depositRequest  = DepositRequest::get();
        $withdrawRequest = WithdrawRequest::get();

        $totalDeposit     = $depositRequest->sum('amount');
        $totalWithdraw    = $withdrawRequest->sum('amount');
        $totalBalance     = $users->sum('balance');


        return view('dashboard.admin.home', compact(
            'users',
            'depositRequest',
            'withdrawRequest',
            'totalDeposit',
            'totalWithdraw',
            'totalBalance'
        ));
    }

    public function logs(): View
    {
        $users           = User::with('transactionLogs');
        $depositLogs  = DepositRequest::with('user')->paginate(4);
        $withdrawLogs = WithdrawRequest::with('user')->paginate(4);
        $transactionLogs   = TransactionLog::with('user')->paginate(4);

        return view('dashboard.admin.logs', compact('users', 'depositLogs', 'withdrawLogs', 'transactionLogs'));
    }

    public function methods(): View
    {
        return view('dashboard.admin.methods');
    }

    public function userList(): View
    {
        $users           = User::latest()->paginate(4);

        return view('dashboard.admin.users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'name'             => 'required',
            'email'            => 'required|email|unique:users,email',
            'image'            => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'         => 'required|min:5|max:30',
            'confirm_password' => 'required|min:5|max:30|same:password'

        ]);

        $imageName      = $request->hasFile('image') ? $this->uploadImage($request->file('image'))
                                                     : null;

        User::create([
            'name'              => $request->input('name'),
            'email'             => $request->input('email'),
            'password'          => $request->input('password'),
            'image'             => @$imageName ,
        ]);

        return back()->with('success', 'User Added');
    }
}
