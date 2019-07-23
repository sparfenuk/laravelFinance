@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card  pre-scrollable">
                    <div class="card-header ">Wallets</div>
                    <div id="wallets" class="col-md-12 row flex-nowrap">
                            @foreach($wallets as $wallet)
                                <div class="d-inline-block bg-dark  col-3 m-2 p-4 rounded">
                                    <p class="text-light">{{$wallet->name}}</p>
                                    <p class="text-light">{{$wallet->description}}</p>
                                <span class="text-light">balance : {{$wallet->balance.' '.$wallet->currency->currency}}</span>
                                </div>
                            @endforeach
                    </div>
                </div>
                <div class="pb-5"> </div>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Add
                </button>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new wallet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  id="createform" method="post" >
                        @csrf
                        <p id="name_error"></p>
                        <label for="wallet_name">name   <span class="text-warning">*</span></label>
                        <input id="wallet_name" class="form-control m-bot15" type="text" name="wallet_name"/>

                        <p id="description_error"></p>
                        <label for="wallet_description">description</label>
                        <input id="wallet_description" class="form-control m-bot15" type="text" name="wallet_description"/>

                        <label>{{ __('currency') }}</label>
                        <select id="currency_id" class="form-control m-bot15" name="currency_id">
                            @if($currencies->count() > 0)
                                @foreach($currencies as $currency)
                                    <option value="{{$currency->id}}">{{$currency->currency}}</option>
                                @endForeach
                            @else
                                No Record Found
                            @endif
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnconfirm" value="Add" data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    <script>
        $(document).ready(function() {

            $("#btnconfirm").click(function () {

                var error_name = $("#name_error");
                var error_description = $("#description_error");

                error_name.text('');
                error_description.text('');

                 console.log('allo');
                 console.log($("#wallet_name").val());
                 console.log($("#wallet_description").val());

                $.ajax({
                    data: {
                         'wallet_name': $("#wallet_name").val(),
                         'wallet_description': $("#wallet_description").val(),
                        'currency_id': $("#currency_id :selected").val()

                    },

                    success: function (data) {

                        var des = data.description;
                        if(des == null)
                        des = " ";

                        var wallet = '<div class="d-inline-block bg-dark  col-3 m-2 p-4 rounded">\n' +
                            '<p class="text-light">' + data.wallet_name +'</p>' +
                            '<p class="text-light">' + des +'</p>'+
                            '<span class="text-light">balance : '+data.balance+' '+data.currency+'</span>\n' +
                            '</div>';

                        $("#wallets").append(wallet);

                        console.log('success');
                    },
                    error: function (data) {
                        // var errors = data.responseJSON.errors;
                        // if(data.wallet_name !== undefined)
                        // {
                        //     alert(data.wallet_name[0]);
                        // }
                        // if(data.wallet_description !== undefined)
                        // {
                        //     alert(data.wallet_description[0]);
                        // }
                        console.error();
                    }
                });
            });
        });
</script>
@endsection