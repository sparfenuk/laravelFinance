@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card  pre-scrollable">
                    <div class="card-header ">Wallets</div>
                    <div id="wallets" class="col-md-12 row flex-nowrap">
                            @foreach($wallets as $wallet)
                                <div  class="d-inline-block bg-dark  col-3 m-2 p-4 rounded wallet_body">
                                    <a href="{{route('wallet',['id'=>$wallet->id])}}"></a>
                                    <span class="delete_wallet_btn float-right"><img src="https://img.icons8.com/material-two-tone/40/000000/close-window.png"></span>
                                    <div hidden id="wallet_id">{{$wallet->id}}</div>
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
                        <label for="wallet_name">name</label>
                        <input id="wallet_name" class="form-control m-bot15" type="text" name="wallet_name" required/>

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
                    <button type="button" class="btn btn-primary" id="add_wallet_btn" value="Add" data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    <script>
        $(document).ready(function() {

            $('#wallets').on('click','div',function () {
                window.location = $(this).find("a").attr("href");
                return false;
            });
            // $(".wallet_body").click(function() {
            //     window.location = $(this).find("a").attr("href");
            //     return false;
            // });

            //add wallet
            $("#add_wallet_btn").click(function () {

                $.ajax({
                    data: {
                         'wallet_name': $("#wallet_name").val(),
                         'wallet_description': $("#wallet_description").val(),
                        'currency_id': $("#currency_id :selected").val()

                    },
                    success: function (data) {

                        var wallet = '<div class="d-inline-block bg-dark  col-3 m-2 p-4 rounded wallet_body">\n' +
                            '<a href="wallet/'+ data.wallet_id +'"></a>'+
                            '<span class="delete_wallet_btn float-right"><img src="https://img.icons8.com/material-two-tone/40/000000/close-window.png"></span>\n' +
                            '<div hidden id="wallet_id">'+ data.wallet_id +'</div>'+
                            '<p class="text-light">' + (data.wallet_name == null? " ":data.wallet_name) +'</p>' +
                            '<p class="text-light">' + (data.wallet_description == null? " ":data.wallet_description) +'</p>'+
                            '<span class="text-light">balance : '+data.balance+' '+data.currency+'</span>\n' +
                            '</div>';

                        $("#wallets").append(wallet);

                        console.log('success');
                    },
                    error: function (data) {
                        var errors = data.responseJSON.errors;
                        var display_error = "";
                        if(errors.hasOwnProperty("wallet_name"))
                        {
                            display_error = errors.wallet_name["0"];
                        }
                        if(errors.hasOwnProperty("wallet_description"))
                        {
                            display_error += "\n"+errors.wallet_description["0"];
                        }
                        alert(display_error);
                    }
                });
            });
            //delete wallet

            $("#wallets").on('click','.delete_wallet_btn',function () {

                var id = parseInt(this.parentNode.childNodes.item(4).innerText);
                console.log(id);
                  var node = this.parentNode.parentNode;
                  var child_to_remove = this.parentNode;



                $.ajax({
                    type:'delete',
                    method:'delete',
                    data: {
                        'wallet_id': id
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                   success: function(data) {
                        node.removeChild(child_to_remove);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }

                });
                return false;
            });
        });
</script>
@endsection