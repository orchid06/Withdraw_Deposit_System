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

    public function index(): View
    {
        $users = User::with('depositRequests')->get();

        $depositRequest  = DepositRequest::get();
        $withdrawRequest = WithdrawRequest::get();

        $totalDeposit     = $depositRequest->sum('amount');
        $totalWithdraw    = $withdrawRequest->sum('amount');
        $totalBalance     = $users->sum('balance');


        return view('dashboard.admin.home', compact('users', 'depositRequest',
                                                    'withdrawRequest', 'totalDeposit',
                                                        'totalWithdraw', 'totalBalance'));
    }

    public function logs()
    {
        $users           = User::with('transactionLogs');
        $depositRequest  = DepositRequest::get();
        $withdrawRequest = WithdrawRequest::get();
        $tranactionLog   = TransactionLog::get();

        return view('dashboard.admin.logs', compact('users', 'depositRequest' , 'withdrawRequest', 'tranactionLog' ));

    }

    public function methods()
    {
        return view('dashboard.admin.methods');
    }
}
