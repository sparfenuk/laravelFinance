@extends('layouts.app')


@section('content')

    @foreach($users as $user)
        <br>
         {{$user}}
        <br>
    @endforeach

@endsection