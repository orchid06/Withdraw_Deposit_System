<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DepositMethod;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DepositRequest;
use App\Models\TransactionLog;
use App\Models\WithdrawMethod;
use App\Models\WithdrawRequest;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Support\Str;

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

    public function methods()
    {
        $users = User::select('id', 'name')->get();

        $depositMethods = DepositMethod::paginate(4);
        

        return view('dashboard.admin.methods', compact('users' , 'depositMethods'));
    }

    public function storeMethods(Request $request)
    {

        if ($request->input('transaction_type') === 'withdraw') {
            $parameters = [
                'min' => $request->input('minimum_amount'),
                'max' => $request->input('maximum_amount'),
            ];

            $jsonParameters = json_encode($parameters);

            WithdrawMethod::create([

                'user_id'   => $request->input('user_id'),
                'name'      => $request->input('method_name'),
                'parameter' => $jsonParameters,
                'min'       => $request->input('minimum_amount'),
                'max'       => $request->input('maximum_amount'),

            ]);

            return back()->with('success', 'Withdraw Method added');
        }
    }

    public function userList(): View
    {
        $users           = User::latest()->paginate(4);

        return view('dashboard.admin.users', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([

            'name'             => 'required',
            'email'            => 'required|email|unique:users,email',
            'image'            => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'         => 'required|min:5|max:30',
            'confirm_password' => 'required|min:5|max:30|same:password'

        ]);

        $imageName      = $request->hasFile('image')
            ? $this->uploadImage($request->file('image'))
            : null;

        User::create([
            'name'              => $request->input('name'),
            'email'             => $request->input('email'),
            'password'          => $request->input('password'),
            'image'             => @$imageName,
        ]);

        return back()->with('success', 'User Added');
    }

    public function edit(Request $request, int $userId): RedirectResponse
    {
        $user = User::findOrFail($userId);

        $request->validate([

            'name'              => 'sometimes|required',
            'email'             => 'sometimes|email|unique:users,email,' . $user->id,
            'image'             => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'          => 'nullable|min:5|max:30',
            'confirm_password'  => 'nullable|min:5|max:30|same:password'
        ]);




        $imageName      = $request->hasFile('image')
            ? $this->uploadImage($request->file('image'))
            : null;

        $user->update([
            'name'              => $request->input('name'),
            'email'             => $request->input('email'),
            'password'          => $request->input('password') ?? $user->password,
            'image'             => @$imageName,
        ]);

        return back()->with('success', 'User info Updated');
    }

    public function delete(int $userId)
    {
        User::findOrFail($userId)->delete();

        return back()->with('success', 'User Deleted');
    }

    public function updateActiveStatus(Request $request)
    {
        try {

            $user = User::findOrFail($request->input('user_id'));
            $user->update([
                'is_active' => $request->input('is_active')
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update user active status'], 500);
        }
    }
}
