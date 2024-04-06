<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Models\DepositRequest;
use App\Models\TransactionLog;
use App\Models\WithdrawRequest;
use Illuminate\Http\JsonResponse;

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

        $depositRequest        = DepositRequest::get();
        $withdrawRequest       = WithdrawRequest::get();
        $approvedCountDeposit  = DepositRequest::where('status', 'approved')->count();
        $approvedCountWithdraw = WithdrawRequest::where('status', 'approved')->count();

        return view('dashboard.admin.home', compact(
                    'users',
                    'depositRequest',
                    'withdrawRequest',
                    'approvedCountDeposit',
                    'approvedCountWithdraw',          
        ));
    }  

    public function userList(): View
    {
        $users           = User::latest()->paginate(4);

        return view('dashboard.admin.users', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([

            'name'             => 'required|unique',
            'email'            => 'required|email|unique:users,email',
            'image'            => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'         => 'required|min:5|max:30',
            'confirm_password' => 'required|min:5|max:30|same:password'

        ]);

  
        User::create([
            'name'              => $request->input('name'),
            'email'             => $request->input('email'),
            'password'          => $request->input('password'),
            'image'             => $request->hasFile('image')
                                        ? $this->uploadImage($request->file('image'))
                                        : null,
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



        $user->update([
            'name'              => $request->input('name'),
            'email'             => $request->input('email'),
            'password'          => $request->input('password') ?? $user->password,
            'image'             => $request->hasFile('image')
                                    ? $this->uploadImage($request->file('image'))
                                    : $user->image,
        ]);

        return back()->with('success', 'User info Updated');
    }

    public function delete(int $userId):RedirectResponse
    {
        User::findOrFail($userId)->delete();

        return back()->with('success', 'User Deleted');
    }

    public function userActiveStatus(Request $request):JsonResponse
    {
        try {

            $user = User::findOrFail($request->input('user_id'));
            $user->update([
                'is_active' => $request->input('is_active')
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => strip_tags($e->getMessage())], 500);
        }
    }

    public function transactionLog():View
    {
        $transactionLogs = TransactionLog::paginate(4);
        return view('dashboard.admin.transactionLog' , compact('transactionLogs'));
    }
}
