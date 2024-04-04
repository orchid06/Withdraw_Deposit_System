@extends('layouts.admin')
@section('content')
<!DOCTYPE html>
<html>

<head>
    <title>Transaction Logs</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{asset('/css/tableStyle.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">



</head>

<body>
    <div class="main-content">
        <div class="container mt-7">
            @include('includes.alerts')

            <!-- Transaction Log -->
            <div class="row mt-5">

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
                                        <th scope="col">Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Trx_Code</th>
                                        <th scope="col">Time</th>

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
                                            {{$transactionLog->trx_code}}
                                        </td>

                                        <td>
                                            {{$transactionLog->created_at}}
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
        </div>
    </div>
</body>

</html>
@endsection