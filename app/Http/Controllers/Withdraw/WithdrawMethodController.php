<?php

namespace App\Http\Controllers\Withdraw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WithdrawMethod;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WithdrawMethodController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name')->get();

        $withdrawMethods = WithdrawMethod::paginate(4);

        
        return view('dashboard.admin.WithdrawMethods', compact('users', 'withdrawMethods'));
    }

    public function create(): View
    {
        return view('dashboard.admin.createWithdrawMethod');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'withdraw_method_name' => 'required',
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

        WithdrawMethod::create([

            'name'      => $request->input('withdraw_method_name'),
            'fields'    => $jsonFields,
            'min'       => $request->input('minimum_amount'),
            'max'       => $request->input('maximum_amount'),

        ]);

        return back()->with('success', 'Deposit Method added');
    }

    public function edit(int $id): View
    {
        $withdrawMethod = WithdrawMethod::findorfail($id);
        $existingFieldsCount = count(json_decode($withdrawMethod->fields));

        return view('dashboard.admin.editWithdrawMethod', compact('withdrawMethod', 'existingFieldsCount'));
    }

    public function delete(int $id): RedirectResponse
    {
        WithdrawMethod::findorfail($id)->delete();
        return back()->with('success', 'Method Deleted');
    }

    public function update(Request $request, int $id)
    {

        $WithdrawMethod = WithdrawMethod::findorfail($id);

        $data = $request->all();

        $fields = [];
        for ($i = 0; isset($data["label_name_$i"]); $i++) {
            $fields[] = [
                'label_name' => $data["label_name_$i"],
                'input_type' => $data["input_type_$i"],
                'condition'  => $data["condition_$i"]
            ];
        }

        $jsonFields = json_encode($fields);

        $WithdrawMethod->update([

            
            'name'      => $request->input('withdraw_method_name'),
            'fields'    => $jsonFields,
            'min'       => $request->input('minimum_amount'),
            'max'       => $request->input('maximum_amount'),
        ]);

        return back()->with('success', 'Deposit Method updated');
    }

    public function updateActiveStatus(Request $request)
    {
        try {

            $withdrawMethod = WithdrawMethod::findOrFail($request->input('withdrawMethod_id'));
            $withdrawMethod->update([
                'is_active' => $request->input('is_active')
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update Method active status'], 500);
        }
    }
}
