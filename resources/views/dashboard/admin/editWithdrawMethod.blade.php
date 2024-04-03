@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="{{asset('/css/createMethodStyle.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<div class="container mt-5">
    @include('includes.alerts')
    <form action="{{route('admin.withdrawMethod.update' , ['id' => $withdrawMethod->id])}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="withdraw_method_name" class="form-label">Withdraw Method Name :</label>
                <input type="text" class="form-control" id="withdraw_method_name" name="withdraw_method_name" value="{{$withdrawMethod->name}}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="minimum_amount" class="form-label">Minimum Amount :</label>
                <input type="number" class="form-control" id="minimum_amount" name="minimum_amount" value="{{$withdrawMethod->min}}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="maximum_amount" class="form-label">Maximum Amount :</label>
                <input type="number" class="form-control" id="maximum_amount" name="maximum_amount" value="{{$withdrawMethod->max}}">
            </div>
        </div>

        <div class="row mt-5 mb-4" id="fieldsContainer">

            @foreach(json_decode($withdrawMethod->fields) as $index => $field)
            <div class="row mt-4">
                <div class="col">
                    <input type="text" class="form-control" name="label_name_{{ $index }}" value="{{ $field->label_name }}" placeholder="Label name">
                </div>
                <div class="col">
                    <select class="form-select" name="input_type_{{ $index }}" aria-label="Default select example">
                        <option>Select Input Type</option>
                        <option value="text" {{ $field->input_type == 'text' ? 'selected' : '' }}>Text</option>
                        <option value="email" {{ $field->input_type == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="number" {{ $field->input_type == 'number' ? 'selected' : '' }}>Number</option>
                        <option value="textarea" {{ $field->input_type == 'textarea' ? 'selected' : '' }}>Description</option>
                    </select>
                </div>
                <div class="col">
                    <select class="form-select" name="condition_{{ $index }}" aria-label="Default select example">
                        <option>Select Condition</option>
                        <option value="0" {{ $field->condition == '0' ? 'selected' : '' }}>Optional</option>
                        <option value="1" {{ $field->condition == '1' ? 'selected' : '' }}>Required</option>
                    </select>
                </div>
                <div class="col">
                    <button class="button-2 removeButton" onclick="removeRow(this)">Remove</button>
                </div>
            </div>
            @endforeach

        </div>

        <div class="row justify-content-center">
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <button class="button-1" onclick="add()"><i class="fa fa-plus"></i>Add Custom Field+</button>
    <!-- <button class="button-2" onclick="remove()"><i class="fa fa-minus"></i>Remove</button> -->


</div>
<div id="existingFieldsCount" data-count="{{ $existingFieldsCount }}"></div>
<script src="{{asset('/js/updateMethodScript.js')}}"></script>
@endsection