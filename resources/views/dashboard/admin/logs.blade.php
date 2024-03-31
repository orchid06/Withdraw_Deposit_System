@extends('layouts.admin')
@section('content')

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link href="{{asset('/css/tableStyle.css')}}" rel=" stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
    input {
        --s: 20px;
        /* adjust this to control the size*/

        height: calc(var(--s) + var(--s)/5);
        width: auto;
        /* some browsers need this */
        aspect-ratio: 2.25;
        border-radius: var(--s);
        margin: calc(var(--s)/2);
        display: grid;
        cursor: pointer;
        background-color: #ff7a7a;
        box-sizing: content-box;
        overflow: hidden;
        transition: .3s .1s;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    input:before {
        content: "";
        padding: calc(var(--s)/10);
        --_g: radial-gradient(circle closest-side at calc(100% - var(--s)/2) 50%, #000 96%, #0000);
        background:
            var(--_g) 0 /var(--_p, var(--s)) 100% no-repeat content-box,
            var(--_g) var(--_p, 0)/var(--s) 100% no-repeat content-box,
            #fff;
        mix-blend-mode: darken;
        filter: blur(calc(var(--s)/12)) contrast(11);
        transition: .4s, background-position .4s .1s,
            padding cubic-bezier(0, calc(var(--_i, -1)*200), 1, calc(var(--_i, -1)*200)) .25s .1s;
    }

    input:checked {
        background-color: #85ff7a;
    }

    input:checked:before {
        padding: calc(var(--s)/10 + .05px) calc(var(--s)/10);
        --_p: 100%;
        --_i: 1;
    }

    body {
        background: #15202a;
        margin: 0;
        height: 100vh;
        display: grid;
        place-content: center;
        place-items: center;
    }
</style>

<body>
    <div class="main-content">
        <div class="container mt-7">
            <!-- Transaction Log -->
            <h2 class="mb-5">Logs</h2>
            <div class="row">

                <div class="col">
                    <div class="card shadow" style="max-width: 65rem;">
                        <div class="card-header border-0">
                            <h3 class="mb-0">Transaction Log</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">User</th>
                                        <th scope="col">Transaction Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Action</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactionLogs as $transactionLog)
                                    <tr>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <a href="#" class="avatar rounded-circle mr-3">
                                                    <img alt="Image placeholder" src="https://raw.githack.com/creativetimofficial/argon-dashboard/master/assets/img/theme/bootstrap.jpg">
                                                </a>
                                                <div class="media-body">
                                                    <span class="mb-0 text-sm">{{$transactionLog->user->name}}</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td>
                                            {{$transactionLog->trx_type}}
                                        </td>
                                        <td>
                                            {{$transactionLog->amount.'$'}}
                                        </td>
                                        <td>
                                            {{$transactionLog->created_at}}
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                action
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
                                    @if ($transactionLogs->previousPageUrl())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $transactionLogs->previousPageUrl() }}" tabindex="-1">
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

                                    @foreach ($transactionLogs->getUrlRange(1, $transactionLogs->lastPage()) as $page => $url)
                                    <li class="page-item {{ ($transactionLogs->currentPage() == $page) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                    @endforeach

                                    @if ($transactionLogs->nextPageUrl())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $transactionLogs->nextPageUrl() }}">
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

            <!-- Deposit Log -->
            <div class="row mt-5">

                <div class="col">
                    <div class="card shadow" style="max-width: 65rem;">
                        <div class="card-header border-0">
                            <h3 class="mb-0">Deposit Log</h3>
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
                                    @forelse($depositLogs as $depositLog)
                                    <tr>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <a href="#" class="avatar rounded-circle mr-3">
                                                    <img alt="Image placeholder" src="https://raw.githack.com/creativetimofficial/argon-dashboard/master/assets/img/theme/bootstrap.jpg">
                                                </a>
                                                <div class="media-body">
                                                    <span class="mb-0 text-sm">{{$depositLog->user->name}}</span>
                                                </div>
                                            </div>
                                        </th>
                                        <td>
                                            {{$depositLog->amount.'$'}}
                                        </td>
                                        <td>
                                            {{$depositLog->created_at}}
                                        </td>
                                        <td>
                                            <span class="badge badge-dot mr-4" id="status-badge-{{$depositLog->id}}">
                                                <i class="{{ $depositLog->status == 'approved' ? 'bg-success' : 'bg-warning' }}"></i> {{$depositLog->status}}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">

                                                <input class="form-check-input" type="checkbox" role="switch" id="switchCheck{{ $depositLog->id }}" data-deposit-id="{{$depositLog->id }}" {{ ($depositLog->status == "approved") ? 'checked' : 'unchecked' }}>

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
                                    @if ($depositLogs->previousPageUrl())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $depositLogs->previousPageUrl() }}" tabindex="-1">
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

                                    @foreach ($depositLogs->getUrlRange(1, $depositLogs->lastPage()) as $page => $url)
                                    <li class="page-item {{ ($depositLogs->currentPage() == $page) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                    @endforeach

                                    @if ($depositLogs->nextPageUrl())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $depositLogs->nextPageUrl() }}">
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
                                            <span class="badge badge-dot mr-4" id="status-badge-withdraw{{$withdrawLog->id}}">
                                                <i class="{{ $withdrawLog->status == 'approved' ? 'bg-success' : 'bg-warning' }}"></i> {{$withdrawLog->status}}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">

                                                <input class="form-check-input-withdraw" type="checkbox" role="switch" id="switchCheck{{ $withdrawLog->id }}" data-withdraw-id="{{$withdrawLog->id }}" {{ ($withdrawLog->status == "approved") ? 'checked' : 'unchecked' }}>

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
                                        <td>
                                            No Data Found
                                        </td>
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

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.form-check-input').change(function() {
            var depositLogId = $(this).data('deposit-id');
            var currentStatus = $('#status-badge-' + depositLogId).text().trim().toLowerCase();
            var newStatus = currentStatus === 'approved' ? 'pending' : 'approved';

            $.ajax({
                url: '{{ route("admin.updateDepositStatus") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    depositLog_id: depositLogId,
                    status: newStatus
                },
                success: function(response) {

                    $('#status-badge-' + depositLogId + ' i').removeClass('bg-warning bg-success').addClass(newStatus === 'approved' ? 'bg-success' : 'bg-warning');
                    $('#status-badge-' + depositLogId).text(newStatus);
                },
                error: function(xhr, status, error) {
                    console.error('Error updating depositLog:', error);
                }
            });
        });
    });

    $(document).ready(function() {
        $('.form-check-input-withdraw').change(function() {
            var withdrawLogId = $(this).data('withdraw-id');
            var currentStatus = $('#status-badge-withdraw' + withdrawLogId).text().trim().toLowerCase();
            var newStatus = currentStatus === 'approved' ? 'pending' : 'approved';

            $.ajax({
                url: '{{ route("admin.updateWithdrawStatus") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    withdrawLog_id: withdrawLogId,
                    status: newStatus
                },
                success: function(response) {

                    $('#status-badge-withdraw' + withdrawLogId + ' i').removeClass('bg-warning bg-success').addClass(newStatus === 'approved' ? 'bg-success' : 'bg-warning');
                    $('#status-badge-withdraw' + withdrawLogId).text(newStatus);
                },
                error: function(xhr, status, error) {
                    console.error('Error updating depositLog:', error);
                }
            });
        });
    });
</script>