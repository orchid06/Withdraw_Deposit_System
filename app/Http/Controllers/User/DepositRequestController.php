<?php

namespace App\Http\Controllers\User;

use App\Models\DepositMethod;
use App\Models\DepositRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\TransactionLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;


class DepositRequestController extends Controller
{
    public function depositRequest(Request $request, int $userId): RedirectResponse
    {
        $depositMethodId = $request->input('deposit_method_id');
        $depositMethod   = DepositMethod::findorfail($depositMethodId);
        $min             = $depositMethod->min;
        $max             = $depositMethod->max;

        $request->validate([

            'amount' => "required|numeric|min:$min|max:$max"
        ]);

        $fieldsJson = $depositMethod->fields;

        $fieldsArray = json_decode($fieldsJson, true);
        $inputData = $request->only(array_column($fieldsArray, 'label_name'));

        DepositRequest::create([
            'user_id'           => $userId,
            'deposit_method_id' => $depositMethodId,
            'amount'            => $request->input('amount'),
            'fields'            => json_encode($inputData),
        ]);

        return back()->with('success', 'Deposit Successful');
    }

    public function updateDepositStatus(Request $request): JsonResponse
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
