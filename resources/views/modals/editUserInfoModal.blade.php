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

<!--Update User Info Modal -->
<div class="modal fade" id="editUserInfoModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="container">
        <div class="modal-dialog">
            <div class="modal-content blur">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update User Info</h1>
                </div>

                <form action="{{route('admin.userEdit',['userId'=>$user->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-outline mb-3">
                            <label class="form-label faded" for="name">Name :</label>
                            <input type="name" id="name" name="name" class="form-control" placeholder="Enter Name" value="{{$user->name}}" />

                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-3">
                            <label class="form-label faded" for="email">Email :</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder=" Enter email" value="{{$user->email}}"/>

                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <label class="form-label faded" for="password">Password :</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Set a password" />

                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label faded" for="confirm_password">Confirm Password :</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm password" />

                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label faded" for="image">Photo :</label>
                            <input type="file" id="image" name="image" class="form-control" placeholder="Upload a picture" />

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>