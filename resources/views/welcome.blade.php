@extends('layouts.app')
@section('stylesheets')
{{--C3 styles--}}
    <link href="{{ asset('c3/c3.css') }}" rel="stylesheet">
<!-- Fonts -->

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
@endsection
@section('content')
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title m-b-md">
            Your Finances
        </div>
        <div id="chart" style="width: 120%;max-width:1000px;margin: auto;"></div>
    </div>
</div>
@endsection
@section('javascripts')
<script src="https://d3js.org/d3.v5.min.js"></script>
<script src="{{ asset('c3/c3.js') }}"></script>
<script src="{{ asset('c3/c3.min.js') }}"></script>
<script>
    $(document).ready(function() {


        var dates = [];
        var data = [];

        $.each({!! json_encode($dates) !!},function (i,date) {
            dates.push(date['created_at'].toString());
        });

        $.each({!! $currencies !!}, function (i,currency){
                var tempData = (currency['data'].split(';').concat(currency['currency']));
                tempData.unshift(tempData.pop());
                data.push(tempData);
        });
        dates.unshift("x");
        data.unshift(dates);
        var chart = c3.generate({
            data: {
                x : 'x',
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
                        text: 'Sale rate to UAH',
                        position: 'outer-middle'
                    }
                }
            }
        });
        {{--$.ajax({--}}
        {{--    url:'{{ route('getLastCurrencies') }}',--}}
        {{--    success: function(result){--}}

        {{--            var data = [];--}}

        {{--            $.each(result, function (i,currency) {--}}
        {{--                var tempData = (currency['data'].split(';').concat(currency['currency']));--}}
        {{--                tempData.unshift(tempData.pop());--}}
        {{--                data.push(tempData);--}}
        {{--            });--}}
        {{--            //data.unshift(dates);--}}
        {{--            console.log(data);--}}
        {{--            setTimeout(function () {--}}
        {{--                chart.load({--}}
        {{--                    columns: [--}}
        {{--                        //dates,--}}
        {{--                        data,--}}
        {{--                    ]--}}
        {{--                });--}}
        {{--            },5000);--}}


        {{--        }--}}
        {{--});--}}

    });

</script>
@endsection
