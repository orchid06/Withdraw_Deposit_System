<style>
    .modal.show {
        backdrop-filter: blur(8px);
    }

    .blur {
        backdrop-filter: blur(18px);
        background: hsla(0, 0%, 100%, 0.66);
        padding: 20px;
        border-radius: 10px;

    }

    .modal-body {
        background: hsla(0, 0%, 100%, 0.66);
        backdrop-filter: blur(10px);
        padding: 20px;
        border-radius: 10px;
    }

    .faded {
        opacity: 0.8;

    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<!--Update depositMethod Info Modal -->
<div class="modal fade" id="deleteDepositMethodModal{{$depositMethod->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="container">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content blur">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete depositMethod Info</h1>
                </div>
                <h7>Are you sure you wnat to delete <strong>{{$depositMethod->name}}'s</strong> info ?</h7>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{route('admin.deleteDepositMethod' , ['id' => $depositMethod->id])}}" button type="submit" class="btn btn-danger">Delete</button></a>
                </div>
            </div>
        </div>
    </div>
</div>