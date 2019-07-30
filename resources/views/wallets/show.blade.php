@extends('layouts.app')

@section('content')
 <div class="container p-4" style="background-color:#e1e1e1">

     <div id="wallet_info" class="col-md-5 d-inline-block">
         <input id="wallet_id" value="{{$wallet->id}}" hidden/>
         <p  class="font-weight-bold  text-wallet-info">Id: {{$wallet->id}}</p>
         <p class="font-weight-bold  text-wallet-info">Name: {{$wallet->name}}</p>
         <p class="font-weight-bold  text-wallet-info">Description: {{$wallet->description}}</p>
         <p class="font-weight-bold  text-wallet-info">Balance: {{$wallet->balance}}</p>
     </div>
     <div id="balance_graph" class="col-md-5 d-inline-block">

         <div id="chart" style="width: 120%;max-width:1000px;margin: auto;"></div>
     </div>

     {{--incomes--}}
     <div id="incomes" class="m-md-3 p-4" style="border: 2px solid grey; background: grey">
        <h3 class="d-inline-block m-3">Incomes</h3>

         <img class="d-inline-block button"  data-toggle="modal" data-target="#incomeModal"  style="cursor: pointer" src="https://img.icons8.com/android/24/000000/plus.png">
           <table id="incomes_table" class="table-bordered table-dark w-100" >
             <tr>
                 <th>Name</th>
                 <th>Description</th>
                 <th>Frequency</th>
                 <th>Value</th>
                 <th></th>
             </tr>
             @if($incomes->count() > 0)
             @foreach($incomes as $income)
                <tr >
                    <td>{{$income->name}}</td>
                    <td>{{$income->description}}</td>
                    <td>{{$income->period->name}}</td>
                    <td>{{$income->value}}</td>
                    <td id="income_id" hidden>{{$income->id}}</td>
                    <td><span class="float-right"><img src="https://img.icons8.com/material-two-tone/40/000000/close-window.png"></span></td>
                </tr>
             @endforeach
             @endif
         </table>
     </div>

     {{--expenses--}}
      <div id="expenses" class="m-md-3 p-4" style="border: 2px solid grey; background: grey">
         <h3 class="d-inline-block m-3">Expenses</h3>
         <img class="d-inline-block button" data-toggle="modal" data-target="#expenseModal" style="cursor: pointer" src="https://img.icons8.com/android/24/000000/plus.png">
         <table id="expenses_table" class="table-bordered table-dark w-100">
             <tr>
                 <th>Name</th>
                 <th>Description</th>
                 <th>Frequency</th>
                 <th>Value</th>
                 <th></th>
             </tr>
             @if($expenses->count() > 0)
             @foreach($expenses as $expense)
                 <tr>
                     <td>{{$expense->name}}</td>
                     <td>{{$expense->description}}</td>
                     <td>{{$expense->period->name}}</td>
                     <td>{{$expense->value}}</td>
                     <td id="expense_id" hidden>{{$expense->id}}</td>
                     <td><span class="float-right"><img src="https://img.icons8.com/material-two-tone/40/000000/close-window.png"></span></td>
                 </tr>
             @endforeach
             @endif
         </table>
     </div>

 </div>

 <!-- Modal add income -->
 <div class="modal fade" id="incomeModal" tabindex="-1" role="dialog" aria-labelledby="incomeModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Add new income</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form  id="create_income" method="post" >
                     @csrf

                     <p id="name_error"></p>
                     <label for="income_name">name</label>
                     <input id="income_name" class="form-control m-bot15" type="text" name="income_name"/>

                     <p id="description_error"></p>
                     <label for="income_description">description</label>
                     <input id="income_description" class="form-control m-bot15" type="text" name="income_description"/>

                     <label for="income_value">amount of income</label>
                     <input id="income_value" class="form-control m-bot15" type="number" name="income_value"/>

                     <label>{{ __('currency') }}</label>
                     <select id="period_id_income" class="form-control m-bot15" name="period_id">
                         @if($periods->count() > 0)
                             @foreach($periods as $period)
                                 <option value="{{$period->id}}">{{$period->name}}</option>
                             @endForeach
                         @else
                             No Record Found
                         @endif
                     </select>
                 </form>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary" id="add_income_btn" value="Add" data-dismiss="modal">Save changes</button>
             </div>
         </div>
     </div>
 </div>

 <!-- Modal add expense -->
 <div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="expenseModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Add new expense</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form  id="create_expense" method="post" >
                     @csrf

                     <p id="name_error"></p>
                     <label for="expense_name">name</label>
                     <input id="expense_name" class="form-control m-bot15" type="text" name="expense_name"/>

                     <p id="description_error"></p>
                     <label for="expense_description">description</label>
                     <input id="expense_description" class="form-control m-bot15" type="text" name="expense_description"/>

                     <label for="expense_value">amount of expense</label>
                     <input id="expense_value" class="form-control m-bot15" type="number" name="expense_value"/>


                     <label>{{ __('period') }}</label>
                     <select id="period_id_expense" class="form-control m-bot15" name="period_id">
                         @if($periods->count() > 0)
                             @foreach($periods as $period)
                                 <option value="{{$period->id}}">{{$period->name}}</option>
                             @endForeach
                         @else
                             No Record Found
                         @endif
                     </select>
                 </form>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary" id="add_expense_btn" value="Add" data-dismiss="modal">Save changes</button>
             </div>
         </div>
     </div>
 </div>

@endsection
@section('javascripts')
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="{{ asset('c3/c3.js') }}"></script>
    <script src="{{ asset('c3/c3.min.js') }}"></script>
    <script>

        $(document).ready(function () {
            //adding incomes
            $("#add_income_btn").click(function () {
                $.ajax({

                    data: {
                        'type':"income",
                        'income_name': $("#income_name").val(),
                        'income_description':$("#income_description").val(),
                        'income_value':$("#income_value").val(),
                        'period_id':$("#period_id_income").val(),
                        'wallet_id':$("#wallet_id").val(),
                    },
                    success: function (data) {

                        var income = '<tr>\n' +
                            '<td>'+(data.income_name == null ? " ":data.income_name)+'</td>\n' +
                            '<td>'+(data.income_description == null? " ":data.income_description)+'</td>\n' +
                            '<td>'+(data.income_period == null ? " ":data.income_period)+'</td>\n' +
                            '<td>'+(data.income_value == null ? " ":data.income_value)+'</td>\n' +
                            '<td id="income_id" hidden>'+ data.income_id +'</td>'+
                            '<td><span class="delete_wallet_btn float-right"><img src="https://img.icons8.com/material-two-tone/40/000000/close-window.png"></span></td>' +
                            '</tr>';

                        var table = $("#incomes_table").append(income);
                        console.log('success');

                    },
                    error:function (data) {

                        var errors = data.responseJSON.errors;
                        var display_error = "";
                        if(errors.hasOwnProperty("income_name"))
                        {
                            display_error = errors.income_name["0"];
                        }
                        if(errors.hasOwnProperty("income_description"))
                        {
                            display_error += "\n"+errors.income_description["0"];
                        }

                        alert(display_error);
                    }
                });
         });
            //delete income
            $("#incomes_table").on('click','span',function () {
                //this.parentNode.parentNode.childNodes.item(8).val()
               var id =$(this.parentNode.parentNode).find("#income_id").html();
               var node = this.parentNode.parentNode.parentNode;
               var child_to_remove = this.parentNode.parentNode;

                //console.log(id);
        
                $.ajax({
                    'type':'delete_income',
                    method:'delete',
                    data:{
                        'income_id':id
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    success:function (data) {
                        node.removeChild(child_to_remove);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
                

            });

        //adding expenses
        $("#add_expense_btn").click(function () {
                $.ajax({

                    data: {
                        'type':"expense",
                        'expense_name': $("#expense_name").val(),
                        'expense_description':$("#expense_description").val(),
                        'expense_value':$("#expense_value").val(),
                        'period_id':$("#period_id_income").val(),
                        'wallet_id':$("#wallet_id").val(),
                    },
                    success: function (data) {
                        var expense = '<tr>\n' +
                            '<td>'+(data.expense_name == null ? " ":data.expense_name)+'</td>\n' +
                            '<td>'+(data.expense_description == null? " ":data.expense_description)+'</td>\n' +
                            '<td>'+(data.expense_period == null ? " ":data.expense_period)+'</td>\n' +
                            '<td>'+(data.expense_value == null ? " ":data.expense_value)+'</td>\n' +
                            '<td id="expense_id" hidden>'+ data.expense_id +'</td>' +
                            '<td><span class="float-right"><img src="https://img.icons8.com/material-two-tone/40/000000/close-window.png"></span></td>' +
                            '</tr>';

                        var table = $("#expenses_table").append(expense);
                        console.log('success');

                    },
                    error:function (data) {
                        var errors = data.responseJSON.errors;
                        var display_error = "";
                        if(errors.hasOwnProperty("expense_name"))
                        {
                            display_error = errors.expense_name["0"];
                        }
                        if(errors.hasOwnProperty("expense_description"))
                        {
                            display_error += "\n"+errors.expense_description["0"];
                        }

                        alert(display_error);

                    }
                });
            });
            //delete expense
            $("#expenses_table").on('click','span',function () {
                //this.parentNode.parentNode.childNodes.item(8).val()
                var id =$(this.parentNode.parentNode).find("#expense_id").html();
                var node = this.parentNode.parentNode.parentNode;
                var child_to_remove = this.parentNode.parentNode;

                //console.log(id);

                $.ajax({
                    'type':'delete_expense',
                    method:'delete',
                    data:{
                        'expense_id':id
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    success:function (data) {
                        node.removeChild(child_to_remove);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });


            });
        });
        function formatDate(date) {
            return  date.getDate() + '-' + date.getMonth() + '-' + date.getFullYear();
        }

        var data = [];
        var dates = [];

        for(var i = 0 ; i <= 12 ; i++) {
            dates[i] = new Date();
            dates[i].setMonth(dates[i].getMonth() + i);
            dates[i] = formatDate(dates[i]);
        }


        dates.unshift("x");
        data.unshift(dates);
        console.log(dates);
        var chart = c3.generate({
            data: {
                x: 'x',
                columns: data,
                type: 'line'
            },
            zoom: {
                enabled: true
            },
            axis: {
                x: {
                    type: 'timeseries', 
                    tick: {
                        format: '%Y-%m-%d',
                        rotate: -50,
                        multiline: false,
                    }
                },
                y: {
                    label: { // ADD
                        text: 'Amount',
                        position: 'outer-middle'
                    }
                }
            }
        });

    </script>
@endsection