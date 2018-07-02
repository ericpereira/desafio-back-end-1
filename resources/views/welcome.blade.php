<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Quote</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>
    <body>
       
        <button id='quoteButton'>Quote</button>
         <div class='response-content' style='height: 600px; width: 800px; border: 1px solid #cecece;'>
            Console:
        </div>
        <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
        <script type="text/javascript">
            $('#quoteButton').on('click', function(){
                $('.response-content').append('<br/>atualizando...');
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
                    success:function(res) {
                        $('.response-content').append('<br/>resposta...<br/>'+res);
                        console.log(res);
                    },
                    error:function(msg){
                        $('.response-content').append(msg);
                    }
                });
            })

        </script>
    </body>
</html>
