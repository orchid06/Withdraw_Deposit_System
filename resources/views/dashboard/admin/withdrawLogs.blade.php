@extends('layouts.admin')
@section('content')
<!DOCTYPE html>
<html>

<head>
    <title>Withdraw Logs</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{asset('/css/tableStyle.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">



</head>

<body>
    <div class="main-content">
        <div class="container mt-7">
            @include('includes.alerts')

            <!-- Withdraw Log -->
            <div class="row mt-5">

                <div class="col">
                    <div class="card shadow" style="max-width: 65rem;">
                        <div class="card-header border-0">
                            <h3 class="mb-0">Withdraw Log</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">User</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($withdrawLogs as $withdrawLog)
                                    <tr>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <a href="#" class="avatar rounded-circle mr-3">
                                                    <img alt="Image placeholder" src="https://raw.githack.com/creativetimofficial/argon-dashboard/master/assets/img/theme/bootstrap.jpg">
                                                </a>
                                                <div class="media-body">
                                                    <span class="mb-0 text-sm">{{$withdrawLog->user->name}}</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td>
                                            {{$withdrawLog->amount.'$'}}
                                        </td>
                                        <td>
                                            {{$withdrawLog->created_at}}
                                        </td>

                                        <td>
                                            <span id="status-badge-withdraw{{$withdrawLog->id}}">
                                                <i class="{{ $withdrawLog->status === 'approved' ? 'bg-success' : 'bg-warning' }}"></i>
                                                {{$withdrawLog->status}}
                                            </span>

                                        </td>


                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="switchCheck{{ $withdrawLog->id }}" data-withdraw-id="{{$withdrawLog->id }}" {{ ($withdrawLog->status === 'approved') ? 'checked' : 'unchecked' }}>
                                            </div>
                                        </td>

                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                        No Data Found
                                    </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer py-4">
                            <nav aria-label="...">
                                <ul class="pagination justify-content-end mb-0">
                                    @if ($withdrawLogs->previousPageUrl())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $withdrawLogs->previousPageUrl() }}" tabindex="-1">
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

                                    @foreach ($withdrawLogs->getUrlRange(1, $withdrawLogs->lastPage()) as $page => $url)
                                    <li class="page-item {{ ($withdrawLogs->currentPage() == $page) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                    @endforeach

                                    @if ($withdrawLogs->nextPageUrl())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $withdrawLogs->nextPageUrl() }}">
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

</html>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.form-check-input').change(function() {
            var withdrawLogId = $(this).data('withdraw-id');
            var currentStatus = $('#status-badge-withdraw' + withdrawLogId).text().trim().toLowerCase();
            var newStatus = currentStatus === 'approved' ? 'pending' : 'approved';


            $('#status-badge-withdraw' + withdrawLogId + ' i').removeClass('bg-warning bg-success').addClass(newStatus === 'approved' ? 'bg-success' : 'bg-warning');
            $('#status-badge-withdraw' + withdrawLogId).text(newStatus);

            $.ajax({
                url: '{{ route("admin.updateWithdrawStatus") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    withdrawLog_id: withdrawLogId,
                    status: newStatus
                },
                success: function(response) {

                },
                error: function(xhr, status, error) {

                    $('#status-badge-withdraw' + withdrawLogId + ' i').removeClass('bg-warning bg-success').addClass(currentStatus === 'approved' ? 'bg-success' : 'bg-warning');
                    $('#status-badge-withdraw' + withdrawLogId).text(currentStatus);
                    console.error('Error updating withdrawLog:', error);
                }
            });
        });
    });
</script>