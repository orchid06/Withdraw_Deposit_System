@extends('layouts.admin')
@section('content')
<!DOCTYPE html>
<html>

<head>
    <title>Dynamic Fields</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{asset('/css/methodStyle.css')}}">

</head>

<body>
    @include('includes.alerts')

    <div class="main-content">
        <div class="container mt-7">
            @include('includes.alerts')
            <!-- Table -->
            <div class="row">

                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Deposit Methods</h3>
                            <button class="btn btn-primary-sm" data-bs-toggle="modal" data-bs-target="#addNewUserModal">
                                <i class='bx bx-user-plus'></i> Add New Method
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse($depositMethods as $depositMethod)
                                    <tr>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <span class="mb-0 text-sm">{{$depositMethod->name}}</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="switchCheck{{ $user->id }}" data-user-id="{{ $user->id }}" {{ ($user->is_active == true) ? 'checked' : 'unchecked' }}>
                                                <label class="form-check-label" for="switchCheck{{ $user->id }}">{{ ($user->is_active == true) ? "Active" : "Deactive" }}</label>
                                            </div>

                                        </td>

                                        <td>

                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-primary-sm" data-bs-toggle="modal" data-bs-target="#editUserInfoModal{{$user->id}}">
                                                    <i class="bx bx-edit-alt"></i>
                                                </button>

                                                <button class="btn btn-primary-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{$user->id}}">
                                                    <i class='bx bx-trash-alt'></i>
                                                </button>
                                            </div>

                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <p>No user Data Found</p>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer py-4">
                            <nav aria-label="...">
                                <ul class="pagination justify-content-end mb-0">
                                    @if ($users->previousPageUrl())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->previousPageUrl() }}" tabindex="-1">
                                            <i class="fa fa-angle-left"></i>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    @else
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                            <i class="fa fa-angle-left"></i>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    @endif

                                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                    <li class="page-item {{ ($users->currentPage() == $page) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                    @endforeach

                                    @if ($users->nextPageUrl())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->nextPageUrl() }}">
                                            <i class="fa fa-angle-right"></i>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                    @else
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-disabled="true">
                                            <i class="fa fa-angle-right"></i>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('/js/methodScript.js')}}"></script>
</body>

</html>
@endsection