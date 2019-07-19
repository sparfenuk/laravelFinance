@extends('layouts.app')


@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Wallets</div>
                    <div class="card-body">
                            @foreach($wallets as $wallet)
                                <br>
                                {{$wallet}}
                                <br>
                            @endforeach
                    </div>

                </div>
                <div class="pb-5"> </div>
                <a class="btn btn-primary float-right" href="{{url('wallet/create')}}" role="button">Add wallet</a>
            </div>
        </div>
    </div>


@endsection