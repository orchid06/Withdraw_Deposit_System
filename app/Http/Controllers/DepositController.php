<?php

namespace App\Http\Controllers;

use App\Models\DepositRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\TransactionLog;

class DepositController extends Controller
{
    public function depositRequest(Request $request, int $userId)
    {
        DepositRequest::create([
            'user_id' => $userId,
            'amount'  => $request->input('deposit_request')
        ]);

        return back()->with('success', 'Deposit Successful');
    }

    public function updateDepositStatus(Request $request)
    {
        $depositLogId = $request->input('depositLog_id');
        $status       = $request->input('status');

        $depositLog = DepositRequest::findOrFail($depositLogId);

        $depositLog->status = $status;
        $depositLog->save();

        $userId   = $depositLog->user_id;
        $trx_code = 'Trx-' . Str::random(8);

        switch ($status) {
            case 'approved':
                TransactionLog::create([
                    'user_id'   => $userId,
                    'trx_code'  => $trx_code,
                    'amount'    => $depositLog->amount,
                    'trx_type'  => 'deposit'
                ]);
                break;
            case 'pending':

                TransactionLog::destroyLog($userId, $trx_code);
                break;
        }

        return response()->json(['message' => 'Deposit log updated successfully']);
    }
}
