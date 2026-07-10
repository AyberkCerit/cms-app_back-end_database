@extends('layouts.app.app')
@section('content')
<h4>Users</h4>
<hr>
<div class="card">
    <div class="card-header">
<a href="{{route('users/new')}}"><button type="button" class="btn btn-success min-btn">New</button></a>
<button type="button" class="btn btn-primary min-btn editUserBtn">Edit</button>
<button type="button" class="btn btn-danger min-btn deleteUserBtn">Delete</button>





    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered" id="usersTable">
        <thead>
            <tr>
                <th>name</th>
                <th>email</th>
                <th>phone</th>
                <th>status</th>
                <th width="135">action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        </table>
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