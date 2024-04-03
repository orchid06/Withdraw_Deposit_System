@extends('layouts.admin')
@section('content')
<!DOCTYPE html>
<html>

<head>
    <title>Dynamic Fields</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{asset('/css/methodStyle.css')}}">
    <link rel="stylesheet" href="{{asset('/css/tableStyle.css')}}">
    


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
                            <h3 class="mb-0">Withdraw Methods</h3>
                            <a href="{{route('admin.withdrawMethod.create')}}" class="button-1" style="color: black;">
                                <i class='bx bx-user-plus'></i> Add New Method
                            </a>

                        </div>

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse($withdrawMethods as $withdrawMethod)
                                    <tr>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <span class="mb-0 text-sm">{{$withdrawMethod->name}}</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td>

                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="switchCheck{{ $withdrawMethod->id }}" data-withdraw-method-id="{{ $withdrawMethod->id }}" {{ ($withdrawMethod->is_active == true) ? 'checked' : 'unchecked' }}>
                                                <label class="form-check-label" for="switchCheck{{ $withdrawMethod->id }}">{{ ($withdrawMethod->is_active == true) ? "Active" : "Deactive" }}</label>
                                            </div>

                                        </td>

                                        <td>

                                            <div class="d-flex align-items-center">
                                                <a href="{{route('admin.withdrawMethod.edit' , ['id' => $withdrawMethod->id])}}" button class="btn btn-primary-sm" style="color: black;">
                                                    <i class="bx bx-edit-alt"></i>
                                                    </button></a>

                                                <button class="btn btn-primary-sm" data-bs-toggle="modal" data-bs-target="#deletewithdrawMethodModal{{$withdrawMethod->id}}">
                                                    <i class='bx bx-trash-alt'></i>
                                                </button>
                                                @include('modals.deletewithdrawMethodModal')
                                            </div>

                                        </td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <p>No withdrawMethod Data Found</p>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer py-4">
                            <nav aria-label="...">
                                <ul class="pagination justify-content-end mb-0">
                                    @if ($withdrawMethods->previousPageUrl())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $withdrawMethods->previousPageUrl() }}" tabindex="-1">
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

                                    @foreach ($withdrawMethods->getUrlRange(1, $withdrawMethods->lastPage()) as $page => $url)
                                    <li class="page-item {{ ($withdrawMethods->currentPage() == $page) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                    @endforeach

                                    @if ($withdrawMethods->nextPageUrl())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $withdrawMethods->nextPageUrl() }}">
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

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.form-check-input').change(function() {
            var withdrawMethodId = $(this).data('withdraw-method-id');
            var isChecked = this.checked ? 1 : 0;
            var label = isChecked ? 'Active' : 'Deactive';
            $(this).siblings('.form-check-label').text(label);

            $.ajax({
                url: '{{ route("admin.withdrawMethod.updateActiveStatus") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    withdrawMethod_id: withdrawMethodId,
                    is_active: isChecked,
                    
                },
                
                success: function(response) {
                    console.log('withdrawMethod active status updated successfully.');
                },
                error: function(xhr, status, error) {
                    console.error('Error updating withdrawMethod active status:', error);
                }
            });
        });
    });
</script>