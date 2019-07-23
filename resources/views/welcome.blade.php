<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Finances</title>
{{--C3 styles--}}
        <link href="{{ asset('c3/c3.css') }}" rel="stylesheet">
<!-- Fonts -->

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            Your Finances
        </div>
        <div id="chart" style="width: 110%"></div>
    </div>

</div>
</body>
<script src="https://d3js.org/d3.v5.min.js"></script>
<script src="{{ asset('c3/c3.js') }}"></script>
<script src="{{ asset('c3/c3.min.js') }}"></script>
<script>
    $(document).ready(function() {

        var chart = c3.generate({
            bindto: '#chart',
            data: {
                columns: [
                    ['data1', 30, 200, 100, 400, 150, 250],
                    ['data2', 50, 20, 10, 40, 15, 25]
                ],
                axes: {
                    data2: 'y2'
                }
            },
            axis: {
                y: {
                    label: { // ADD
                        text: 'Sale rate to UAH',
                        position: 'outer-middle'
                    }
                }
            }
        });
        function swap(arra) {
            [arra[0], arra[arra.length - 1]] = [arra[arra.length - 1], arra[0]];
            return arra;
        }
        $.ajax({
            url:'{{ route('getLastCurrencies') }}',
            success: function(result){
                    console.log(result);
                    var data = [];
                    $.each(result, function (i,currency) {
                        data.push(swap(currency['data'].split(';').concat(currency['currency'])));

                    });
                    setTimeout(function () {
                        chart.load({
                            columns: data,
                            unload:['data1' ,'data2']
                        });
                        console.log(data);
                    },2000);



                }
        });

    });

</script>
</html>
