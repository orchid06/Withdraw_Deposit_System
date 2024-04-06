@extends('layouts.profile')
@section('content')
<div class="content__title">
    <h1>{{$user->name}}</h1><span>{{$user->email}}</span>
</div>
<div class="content__description">
    <p>Description</p>
    <p>Columbia University - New York</p>
</div>
<ul class="content__list">
    <li><span>{{$user->balance}}</span>Balance</li>
    <li><span>$ {{ $user->depositRequests()->sum('amount') }}</span>Total Deposit</li>
    <li><span>$ {{ $user->withdrawRequests()->sum('amount') }}</span>Total Withdraw</li>
</ul>
<!-- <div class="content__button"><a class="button" href="#">
        <div class="button__border"></div>
        <div class="button__bg"></div>
        <p class="button__text">Show more</p>
    </a></div> -->
</div>
@endsection