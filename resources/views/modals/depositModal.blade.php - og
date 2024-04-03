
<link rel="stylesheet" href="{{asset('/css/depositModalStyle.css')}}">

<!--Deposit Modal -->
<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deposit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('user.depositRequest', ['userId'=>Auth::user()->id])}}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="row mb-3">
                        <label for="deposit_request" class="col-sm-5 col-form-label">
                            <h5>Deposit Amount:</h5>
                        </label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" id="deposit_request" name="deposit_request">
                        </div>
                        <div class="col-sm-5">
                            
                        </div>
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                            Select a method
                        </button>

                        <div class="dropdown">
                            
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                @foreach($depositMethods as $depositMethod)
                                <li><button class="dropdown-item" type="button">{{$depositMethod->name}}</button></li>
                                @endforeach
                            </ul>
                        </div>

                        <p> Mimimum Deposit : {{$depositMethod->min}}<br> Maximum Deposit : {{$depositMethod->max}}</p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Deposit</button>
                </div>
            </form>
        </div>
    </div>
</div>