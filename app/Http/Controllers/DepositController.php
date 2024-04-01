<?php

namespace App\Http\Controllers;

use App\Models\DepositMethod;
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

    public function createDepositMethod()
    {
        return view('dashboard.admin.createDepositMethod');
    }

    public function storeDepositMethod(Request $request)
    {
       
        $parameters = [
            'parameter' => $request->input('parameter')
        ];

        $jsonParameters = json_encode($parameters);

        DepositMethod::create([

            'user_id'   => $request->input('user_id'),
            'name'      => $request->input('deposit_method_name'),
            'parameter' => $jsonParameters,
            'min'       => $request->input('minimum_amount'),
            'max'       => $request->input('maximum_amount'),

        ]);

        return back()->with('success', 'Deposit Method added');
    }

    public function editDepositMethod(int $id)
    {
        $depositMethod = DepositMethod::findorfail($id);

        return view('dashboard.admin.editDepositMethod', compact('depositMethod'));
    }

    public function deleteDepositMethod(int $id)
    {
        DepositMethod::findorfail($id)->delete();
        return back()->with('success', 'Method Deleted');
    }
}
