<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DepositMethod;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\DepositRequest;

class DepositMethodController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name')->get();

        $depositMethods = DepositMethod::paginate(4);


        return view('dashboard.admin.depositMethods', compact('users', 'depositMethods'));
    }

    public function create(): View
    {
        return view('dashboard.admin.createDepositMethod');
    }

    public function store(Request $request): RedirectResponse
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
                'condition'  => $data["condition_$i"]
            ];
        }


        DepositMethod::create([

            'name'      => $request->input('deposit_method_name'),
            'fields'    => json_encode($fields),
            'min'       => $request->input('minimum_amount'),
            'max'       => $request->input('maximum_amount'),

        ]);

        return back()->with('success', 'Deposit Method added');
    }

    public function edit(int $id): View
    {
        $depositMethod = DepositMethod::findorfail($id);
        $existingFieldsCount = count(json_decode($depositMethod->fields));

        return view('dashboard.admin.editDepositMethod', compact('depositMethod', 'existingFieldsCount'));
    }

    public function delete(int $id): RedirectResponse
    {
        DepositMethod::findorfail($id)->delete();
        return back()->with('success', 'Method Deleted');
    }

    public function update(Request $request, int $id)
    {

        $depositMethod = DepositMethod::findorfail($id);

        $data = $request->all();

        $fields = [];
        for ($i = 0; isset($data["label_name_$i"]); $i++) {
            $fields[] = [
                'label_name' => $data["label_name_$i"],
                'input_type' => $data["input_type_$i"],
                'condition'  => $data["condition_$i"]
            ];
        }

        $depositMethod->update([

            'name'      => $request->input('deposit_method_name'),
            'fields'    => json_encode($fields),
            'min'       => $request->input('minimum_amount'),
            'max'       => $request->input('maximum_amount'),
        ]);

        return back()->with('success', 'Deposit Method updated');
    }

    public function updateActiveStatus(Request $request)
    {
        try {

            $depositMethod = DepositMethod::findOrFail($request->input('depositMethod_id'));
            $depositMethod->update([
                'is_active' => $request->input('is_active')
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => strip_tags($e->getMessage())], 500);
        }
    }

    public function logs(): View
    {
        $users           = User::with('transactionLogs');
        $depositLogs     = DepositRequest::with('user')->paginate(4);

        return view('dashboard.admin.depositLogs', compact('users', 'depositLogs'));
    }
}
