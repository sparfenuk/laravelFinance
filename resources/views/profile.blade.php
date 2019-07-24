@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <img src="/uploads/avatars/{{ $user->avatar }}" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
                <h2>{{ $user->name }} Profile</h2>
                <form enctype="multipart/form-data" action="/profile" method="POST">
                    <label>Profile Image</label><br>
                    <input type="file" name="avatar"><br>
                    @csrf
                    <br>
                    <input type="submit" class="pull-right btn btn-sm btn-primary">
                </form>
            </div>
        </div>
    </div>
@endsection