@extends('layouts\app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Create new wallet</h1>
            <form  id="createform" >
                @csrf
                <div class="pb-5"> </div>

                   <label for="currency_id" class="col-md-4 col-form-label text-md-right">{{ __('Currency') }}</label>
                    <select id="currency_id" class="form-control m-bot15" name="currency_id">
                        @if($currencies->count() > 0)
                            @foreach($currencies as $currency)
                                <option value="{{$currency->id}}">{{$currency->currency}}</option>
                            @endForeach
                        @else
                            No Record Found
                        @endif
                    </select>
                    <div class="pb-5"> </div>
                    {{--<button id="addwallet" class="btn-primary float-right" >Add</button>--}}
                    <input id="btnconfirm" type="button" value="Add"/>

            </form>
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    <script>
        $(document).ready(function() {

            $("#btnconfirm").click(function () {
                console.log('awdawdwa');
                console.log($("#currency_id :selected").val());

                $.ajax({
                    {{--type: 'POST',--}}
                    {{--url: '{{route('create_wallet')}}',--}}
                    data: {
                        'currency_id': $("#currency_id :selected").val()
                    },

                    success: function (data) {
                        console.log(data);
                        // $("#currency").html(data);
                    },
                    error: function () {
                        console.error()
                    }
                });

            });
        });
    </script>
    {{--<script>--}}
        {{--$('#sample_form').submit(function(event) {--}}

            {{--event.preventDefault();--}}

            {{--if($('#add_wallet').val()=='Add')--}}
            {{--{--}}
                {{--console.log('awdawdawda');--}}
                {{--$.ajax({--}}
                    {{--method:"POST",--}}
                    {{--url:"{{route('createWallet')}}",--}}
                    {{--data: {--}}
                        {{--'currency_id': $("#currency_id :selected").val()--}}
                    {{--},--}}
                    {{--contentType: false,--}}
                    {{--cache:false,--}}
                    {{--processData:false,--}}
                    {{--dataType:"json",--}}
                    {{--//--}}
                    {{--// success:function(data) {--}}
                    {{--//     console.log(data);--}}
                    {{--//     // $("#currency").html(data);--}}
                    {{--// },--}}
                    {{--// error:function () {--}}
                    {{--//     console.error()--}}
                    {{--// }--}}
                {{--});--}}

            {{--}--}}
        {{--});--}}
    {{--</script>--}}
@endsection