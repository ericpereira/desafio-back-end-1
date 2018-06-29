Depois de clonar a aplicação, basta abrir a pasta e executar os comandos:

composer dump-autoload

composer install

Para rodar o site, executar o comando:

php artisan serve

Rota 1:
Para realizar a consulta do cnpj, abrir a rota http://localhost:8000/cnpj/{cnpj}
onde em {cnpj} deve ir o valor numérico de um cnpj válido

Rota 2:
A cotação pode ser feita de duas formas
Forma 1: Passando um json como request para a rota http://localhost:8000/quote, lembrando de passar um token na variavel _token, ex: _token: "{{ csrf_token() }}" caso a requisição seja feita por ajax.

Forma 2: É possível ver o json de retorno da cotação clicando no botão "quote" no link http://localhost:8000/quote

