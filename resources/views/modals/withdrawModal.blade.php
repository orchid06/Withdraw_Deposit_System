<link rel="stylesheet" href="{{asset('css/transactionStyle.css')}}">
<!-- Withdraw Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="user-card">
                <div class="user-info">
                    <h2 class="name">{{$user->name}}</h2>
                    <p class="email">{{$user->email}}</p>
                    <p class="balance"><strong>Balance:</strong> {{$user->balance}}</p>
                </div>

                <form action="{{route('user.withdrawRequest' , ['userId' =>$user->id])}}" method="post">
                    @csrf
                    <div class="amount">
                        <input type="number" id="amount" name="amount" placeholder="Enter withdraw amount" required>
                    </div>
                    <div class="selector">
                        <select id="withdraw-method" name="withdraw_method_id" class="custom-select" required>
                            <option value="" selected disabled>Select a method</option>
                            @foreach($withdrawMethods as $withdrawMethod)
                            <option value="{{ $withdrawMethod->id }}" data-fields="{{ $withdrawMethod->fields }}">{{ $withdrawMethod->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="additional-fields">
                        <!-- Additional fields goes here -->
                    </div>
                    <div class="submit">
                        <button type="submit">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="{{asset('/js/withdrawScript.js')}}"></script>
