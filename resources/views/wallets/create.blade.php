@extends('layouts\app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Create new wallet</h1>
            <form method="post" action="create">
                @csrf
                <div class="pb-5"> </div>
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Currency') }}</label>
                <div class="form-group">
                    <select class="form-control m-bot15" name="currency_id">
                        @if($currencies->count() > 0)
                            @foreach($currencies as $currency)
                                <option value="{{$currency->id}}">{{$currency->currency}}</option>
                            @endForeach
                        @else
                            No Record Found
                        @endif
                    </select>
                    <div class="pb-5"> </div>
                    <button class="btn-primary float-right" type="submit">Create</button>
                    {{--<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

                    {{--<div class="col-md-6">--}}
                        {{--<input  type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

                        {{--@error('email')--}}
                        {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                        {{--@enderror--}}
                    {{--</div>--}}
                </div>

            </form>
            </div>
        </div>
    </div>
@endsection