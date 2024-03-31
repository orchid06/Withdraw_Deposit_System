<?php

namespace App\Http\Controllers;

use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use App\Models\TransactionLog;
use Illuminate\Support\Str;

class WithdrawController extends Controller
{
    public function withdrawRequest(Request $request, int $userId)
    {
        WithdrawRequest::create([
            'user_id' => $userId,
            'amount'  => $request->input('withdraw_request')
        ]);

        return back()->with('success', 'Withdraw Successful');
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
