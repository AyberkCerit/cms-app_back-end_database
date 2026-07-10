@extends('layouts.app.app')
@section('content')
<h4>Users</h4>
<hr>
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{ $user == null ? 'Yeni Kullanıcı Ekle' : 'Kullanıcıyı Düzenle' }}</h5>
        <div>
            <a href="{{route('users')}}"><button class="btn btn-secondary min-btn me-2" type="button">Back</button></a>
            <button class="btn btn-success min-btn saveUserBtn" type="button">
                <span class="spinner-border spinner-border-sm d-none me-1" id="saveSpinner" role="status" aria-hidden="true"></span>
                Save
            </button>
        </div>
    </div>
    <div class="card-body">
        <form id="usersForm">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="form-floating">
                        <input type="text" name="name" id="name" class="form-control name_surname" placeholder="Name LastName"  value="{{($user==null ? null : $user->name)}}">
                        <label for="name">Name LastName*</label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="form-floating">
                        <input type="email" name="email" id="email" class="form-control email" placeholder="Email" value="{{($user==null ? null : $user->email)}}">
                        <label for="email">Email*</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="form-floating">
                        <input type="text" name="phone" id="phone" class="form-control phone" placeholder="Phone" value="{{($user==null ? null : $user->phone)}}">
                        <label for="phone">Phone</label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="form-floating">
                        <select name="status" id="status" class="form-control status" required>
                            <option value="">Select Status</option>
                            <option value="active" {{($user==null ? 'selected':($user->status==1 ?'selected':'   '))}}>Active</option>
                            <option value="inactive" {{($user==null ? 'selected':($user->status==0 ?'selected':'   '))}}>Passive</option>
                        </select>
                        <label for="status">Status</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="form-floating">
                        <input type="password" name="password" id="password" class="form-control password" placeholder="Password" autocomplete="new-password">
                        <label for="password">Password{{ $user == null ? '*' : '' }}</label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="form-floating">
                        <input type="password" name="r_password" id="r_password" class="form-control password_rep" placeholder="Repeat Password" autocomplete="new-password">
                        <label for="r_password">Repeat Password{{ $user == null ? '*' : '' }}</label>
                        <div class="invalid-feedback">Passwords do not match!</div>
                    </div>
                </div>
            </div>

            <input type="hidden" value="{{($user==null ? null: $user->id)}}" class="user_id"/>
        </form>
    </div>
</div>

@endsection


@section('js')
<script type="text/javascript">
    var checkInterval=setInterval(() => {
        if (app.loader!==undefined&&app.loader!==null){
            app.loader.setModule('Users');
            clearInterval(checkInterval);
        }
    }, 500);
</script>
@endsection