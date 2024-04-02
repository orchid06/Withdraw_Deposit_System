<?php

namespace App\Http\Controllers;

use App\Models\DepositMethod;
use App\Models\DepositRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\TransactionLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DepositController extends Controller
{
    public function depositRequest(Request $request, int $userId): RedirectResponse
    {
        DepositRequest::create([
            'user_id' => $userId,
            'amount'  => $request->input('deposit_request')
        ]);

        return back()->with('success', 'Deposit Successful');
    }

    public function updateDepositStatus(Request $request): RedirectResponse
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

    public function createDepositMethod(): View
    {
        return view('dashboard.admin.createDepositMethod');
    }

    public function storeDepositMethod(Request $request): RedirectResponse
    {
        $request->validate([
            'deposit_method_name'  => 'required',
            'minimum_amount'       => 'required|numeric|gt:0',
            'maximum_amount'       => 'required|numeric|gt:minimum_amount'
        ]);

        $data = $request->all();

        $fields = [];

        for ($i = 0; isset($data["label_name_$i"]); $i++) {
            $fields[] = [
                'label_name' => $data["label_name_$i"],
                'input_type' => $data["input_type_$i"],
                'condition' => $data["condition_$i"]
            ];
        }

       
        $jsonFields = json_encode($fields);

        DepositMethod::create([

            'user_id'   => $request->input('user_id'),
            'name'      => $request->input('deposit_method_name'),
            'fields' => $jsonFields,
            'min'       => $request->input('minimum_amount'),
            'max'       => $request->input('maximum_amount'),

        ]);

        return back()->with('success', 'Deposit Method added');
    }

    public function editDepositMethod(int $id): View
    {
        $depositMethod = DepositMethod::findorfail($id);
        $existingFieldsCount = count(json_decode($depositMethod->fields));

        return view('dashboard.admin.editDepositMethod', compact('depositMethod', 'existingFieldsCount'));
    }

    public function deleteDepositMethod(int $id): RedirectResponse
    {
        DepositMethod::findorfail($id)->delete();
        return back()->with('success', 'Method Deleted');
    }

    public function updateDepositMethod(Request $request, int $id)
    {
        dd($request);
        $depositMethod = DepositMethod::findorfail($id);

        $data = $request->all();

        $fields = [];
        
        for ($i = 0; isset($data["label_name_$i"]); $i++) {
            $fields[] = [
                'label_name' => $data["label_name_$i"],
                'input_type' => $data["input_type_$i"],
                'condition' => $data["condition_$i"]
            ];
        }

        $jsonFields = json_encode($fields);

        $depositMethod->update([

            'user_id'   => $request->input('user_id'),
            'name'      => $request->input('deposit_method_name'),
            'fields' => $jsonFields,
            'min'       => $request->input('minimum_amount'),
            'max'       => $request->input('maximum_amount'),
        ]);

        return back()->with('success', 'Deposit Method updated');
    }
}
