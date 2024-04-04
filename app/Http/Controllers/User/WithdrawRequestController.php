<?php

namespace App\Http\Controllers\User;

use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use App\Models\TransactionLog;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\WithdrawMethod;
use Illuminate\Http\RedirectResponse;

class WithdrawRequestController extends Controller
{
    public function withdrawRequest(Request $request, int $userId): RedirectResponse
    {
        $withdrawMethodId = $request->input('withdraw_method_id');
        $withdrawMethod   = WithdrawMethod::findorfail($withdrawMethodId);
        $min              = $withdrawMethod->min;
        $max              = $withdrawMethod->max;

        $request->validate([

            'amount' => "required|numeric|min:$min|max:$max"
        ]);

        $fieldsJson = $withdrawMethod->fields;

        $fieldsArray = json_decode($fieldsJson, true);
        $inputData = $request->only(array_column($fieldsArray, 'label_name'));

        WithdrawRequest::create([
            'user_id'           => $userId,
            'withdraw_method_id' => $withdrawMethodId,
            'amount'            => $request->input('amount'),
            'fields'            => json_encode($inputData),
        ]);

        return back()->with('success', 'withdraw Successful');
    }


    public function updateWithdrawStatus(Request $request)
    {
        $withdrawLogId = $request->input('withdrawLog_id');
        $status        = $request->input('status');

        $withdrawLog = WithdrawRequest::findOrFail($withdrawLogId);

        $withdrawLog->status = $status;
        $withdrawLog->save();

        $userId   = $withdrawLog->user_id;
        $trx_code = 'Trx-' . Str::random(8);

        switch ($status) {
            case 'approved':
                TransactionLog::create([
                    'user_id'   => $userId,
                    'trx_code'  => $trx_code,
                    'amount'    => $withdrawLog->amount,
                    'trx_type'  => 'withdraw'
                ]);
                break;
            case 'pending':

                TransactionLog::destroyLog($userId, $trx_code);
                break;
        }


        return response()->json(['message' => 'Withdraw log updated successfully']);
    }
}
