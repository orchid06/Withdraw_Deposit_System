@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="{{asset('/css/createMethodStyle.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<div class="container mt-5">
    <form>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="deposit_method_name" class="form-label">Deposit Method Name :</label>
                <input type="text" class="form-control" id="deposit_method_name" name="deposit_method_name" value="{{ $depositMethod->name }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="minimum_amount" class="form-label">Minimum Amount :</label>
                <input type="number" class="form-control" id="minimum_amount" name="minimum_amount" value="{{ $depositMethod->min }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="maximum_amount" class="form-label">Maximum Amount :</label>
                <input type="number" class="form-control" id="maximum_amount" name="maximum_amount" value="{{ $depositMethod->max }}">
            </div>
        </div>

        <div id="formfield">
            <input type="text" name="text" class="text" size="50" placeholder="Custom Field">
        </div>
        <div class="row justify-content-center">
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <button class="button-1" onclick="add()"><i class="fa fa-plus"></i>Add Custom Field+</button>
    <button class="button-2" onclick="remove()"><i class="fa fa-minus"></i>Remove</button>


</div>

<script src="{{asset('/js/methodScript.js')}}"></script>
@endsection