<link rel="stylesheet" href="{{asset('css/depositStyle.css')}}">
<!-- Deposit Modal -->
<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="user-card">
                <div class="user-info">
                    <h2 class="name">{{$user->name}}</h2>
                    <p class="email">{{$user->email}}</p>
                    <p class="balance"><strong>Balance:</strong> {{$user->balance}}</p>
                </div>

                <form action="{{route('user.depositRequest' , ['userId' =>$user->id])}}" method="post">
                    @csrf
                    <div class="deposit">
                        <input type="number" id="deposit_amount" name="deposit_amount" placeholder="Enter deposit amount">
                    </div>
                    <div class="selector">
                        <select id="method" name="method" class="custom-select">
                            @foreach($depositMethods as $depositMethod)
                            <option value="{{$depositMethod->id}}" data-fields="{{ json_encode($depositMethod->fields)}}">{{$depositMethod->name}}</option>
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

<script src="{{asset('/js/depositScript.js')}}"></script>