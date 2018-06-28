<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
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
                font-size: 12px;
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

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <button id='quoteButton' >Quote</button>
                    <a href="#">asdasdasdadas</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
        <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
        <script type="text/javascript">
            $('#quoteButton').on('click', function(){
                $.ajax({
                    type: "POST",
                    url: "{{ route('quote') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        destinatario: {
                            endereco: {
                                cep: "01311000"
                            }
                        },
                        volumes: [
                            {
                                tipo: 9,
                                quantidade: 1,
                                peso: 5,
                                valor: 349,
                                sku: "abc-teste-123",
                                altura: 0.2,
                                largura: 0.2,
                                comprimento: 0.2
                            },
                            {
                                tipo: 7,
                                quantidade: 2,
                                peso: 4,
                                valor: 556,
                                sku: "abc-teste-527",
                                altura: 0.4,
                                largura: 0.6,
                                comprimento: 0.15
                            }
                        ]},
                    dataType: 'json',
                    success:function(res) {
                        $('.title').html(res.status);
                    } 
                });
            })

        </script>
    </body>
</html>
