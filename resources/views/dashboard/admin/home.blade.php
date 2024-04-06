@extends('layouts.admin')
@section('content')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('/css/adminHomeStyle.css')}}">

<div class="container">
    <div class="card-container">
        <div class="card bg-c-blue order-card">
            <div class="card-block">
                <h6 class="m-b-20">Total User</h6>
                <h2 class="text-right"><i class="fa fa-user f-left"></i><span>{{count($users)}}</span></h2>
            </div>
        </div>

        <div class="card bg-c-green order-card">
            <div class="card-block">
                <h6 class="m-b-20">Deposit Request</h6>
                <h2 class="text-right"><i class="fa fa-money f-left"></i><span>{{count($depositRequest)}}</span></h2>
                <p class="m-b-0">Approved requests : <span class="f-right">{{$approvedCountDeposit}}</span></p>
            </div>
        </div>

        <div class="card bg-c-yellow order-card">
            <div class="card-block">
                <h6 class="m-b-20">Withdraw Request</h6>
                <h2 class="text-right"><i class="fa fa-money f-left"></i><span>{{count($withdrawRequest)}}</span></h2>
                <p class="m-b-0">Approved requests : <span class="f-right">{{$approvedCountWithdraw}}</span></p>
            </div>
        </div>

        <div class="card bg-c-pink order-card">
            <div class="card-block">
                <h6 class="m-b-20">Total Deposit</h6>
                <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span>{{$depositRequest->sum('amount')}}</span></h2>
                <p class="m-b-0">Total Withdraw :<span class="f-right">{{$withdrawRequest->sum('amount')}}</span></p>
            </div>
        </div>

        <div class="card bg-c-green order-card">
            <div class="card-block">
                <h6 class="m-b-20">Current Balance</h6>
                <h2 class="text-right"><i class="fa fa-dollar f-left"></i><span>{{$users->sum('balance')}}</span></h2>
            </div>
        </div>
    </div>
</div>

@endsection