@extends('layouts.admin')
@section('content')

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link href="{{asset('/css/tableStyle.css')}}" rel=" stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


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
                                            <span class="badge badge-dot mr-4">
                                                <i class="bg-warning"></i> {{$depositLog->status}}
                                            </span>
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
                                            <span class="badge badge-dot mr-4">
                                                <i class="bg-warning"></i> {{$withdrawLog->status}}
                                            </span>
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