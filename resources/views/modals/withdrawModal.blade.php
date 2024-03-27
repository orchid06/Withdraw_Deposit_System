<!--Withdraw Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Withdraw</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('user.withdrawRequest', ['userId'=>Auth::user()->id])}}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="row mb-3">
                        <label for="withdraw_request" class="col-sm-5 col-form-label">
                            <h5>Deposit Amount:</h5>
                        </label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" id="withdraw_request" name="withdraw_request">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Withdraw</button>
                </div>
            </form>
        </div>
    </div>
</div>