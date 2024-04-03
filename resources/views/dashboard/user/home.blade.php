@extends('layouts.user')

@section('content')
<section class="vh-100" style="background: url('/images/bg.jpg');">
    <div class="container py-5 h-100 " style="margin-left: 50px;">
        @include('includes.alerts')
        <div class="row d-flex justify-content-left align-items-center h-50">
            <div class="col-md-12 col-xl-4">

                <div class="card" style="border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="mt-3 mb-4">
                            <img src="{{url('/uploads/user/'.$user->image)}}" class="rounded-circle img-fluid" style="width: 100px;" />
                        </div>
                        <h4 class="mb-2">{{$user->name}}</h4>
                        <p class="text-muted mb-4">{{$user->email}}</p>
                        <a href="{{route('user.transactionLog')}}" button type="button" class="btn btn-primary btn-rounded btn-lg">
                            Transactions Log
                        </button></a>
                        <div class="d-flex justify-content-between text-center mt-5 mb-2">
                            <div>
                                <p class="mb-2 h5">$ 8471</p>
                                <p class="text-muted mb-0">Total Deposit</p>
                            </div>
                            <div class="px-3">
                                <p class="mb-2 h5">$ 8512 </p>
                                <p class="text-muted mb-0">Total Withdraw</p>
                            </div>
                            <div>
                                <p class="mb-2 h5">4751</p>
                                <p class="text-muted mb-0">Total Transactions</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col col-md-12 col-lg-8 col-xl-6">
                <div class="card" style="border-radius: 15px; background-color: #ffff; margin-left: 100px; margin-top: -200px;">
                    <div class="card-body p-4 text-black">
                        <div class="flex-grow-1 ms-3">
                            <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                <h4 class="mb-0">Current Balance:</h4>
                                <h5 class="mb-0 fw-bold">{{$user->balance}}</h5>
                            </div>

                        </div>
                        <hr>
                        <div class="flex-grow-1 ms-3 text-end">
                            <div class="d-flex flex-row align-items-center mb-2">
                                <ul class="mb-0 list-unstyled d-flex flex-row" style="color: #1B7B2C;">
                                    <li>
                                        <i class="fas fa-star fa-xs"></i>
                                    </li>
                                    <li>
                                        <i class="fas fa-star fa-xs"></i>
                                    </li>
                                </ul>
                            </div>
                            <div>

                                <button type="button" class="btn btn-outline-dark btn-rounded btn-sm" data-mdb-ripple-color="dark" data-bs-toggle="modal" data-bs-target="#depositModal">+ Deposit</button>
                                <button type="button" class="btn btn-outline-dark btn-rounded btn-sm" data-mdb-ripple-color="dark" data-bs-toggle="modal" data-bs-target="#withdrawModal"> Withdraw</button>

                            </div>

                        </div>
                        @include('modals.withdrawModal')
                        @include('modals.depositModal')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection