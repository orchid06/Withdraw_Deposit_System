@extends('layouts.admin')
@section('content')
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link href="{{asset('/css/tableStyle.css')}}" rel=" stylesheet">
<link href=" {{asset('/css/modalStyle.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


<style>
    .card-header {
        position: relative;
    }

    .card-header .btn {
        position: absolute;
        top: 1;
        right: 20px;
    }
</style>

<body>
    <div class="main-content">
        <div class="container mt-7">
            @include('includes.alerts')
            <!-- Table -->
            <div class="row">

                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Users</h3>
                            <button class="button-1" data-bs-toggle="modal" data-bs-target="#addNewUserModal">
                                <i class='bx bx-user-plus'></i> Add New User
                            </button>
                            @include('modals.addNewUserModal')
                        </div>

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">User</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Balance</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse($users as $user)
                                    <tr>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <a href="#" class="avatar rounded-circle mr-3">
                                                    <img alt="Image placeholder" src="{{url('/uploads/user/'.$user->image)}}">
                                                </a>
                                                <div class="media-body">
                                                    <span class="mb-0 text-sm">{{$user->name}}</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td>
                                            {{$user->email}}
                                        </td>
                                        <td>
                                            {{$user->balance}}
                                        </td>
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
                                            @include('modals.editUserInfoModal')
                                            @include('modals.deleteUserModal')

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
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.form-check-input').change(function() {
            var userId = $(this).data('user-id'); 
            var isChecked = this.checked ? 1 : 0;
            var label = isChecked ? 'Active' : 'Deactive';
            $(this).siblings('.form-check-label').text(label);

            $.ajax({
                url: '{{ route("admin.updateActiveStatus") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: userId,
                    is_active: isChecked
                },
                success: function(response) {
                    console.log('User active status updated successfully.');
                },
                error: function(xhr, status, error) {
                    console.error('Error updating user active status:', error);
                }
            });
        });
    });
</script>