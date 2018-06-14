<div style="text-align:center;"><img src ="freterapido.png" /></div>

# Desafio Back-end #1 - Frete Rápido

## Objetivo:
Desenvolver uma API Rest para consulta de CNPJ e para cotação de fretes na Frete Rápido.

#### Rota 1: [GET] .../cnpj/{cnpj}
- **Objetivo:** Consultar e retornar os dados de uma empresa através de um CNPJ informado
- **Entrada:** Receber um número de CNPJ através da rota
- **Processo:** Realizar uma consulta do CNPJ em uma API aberta (recomendações abaixo)
- **Retorno:** Retornar os seguinte dados em formato JSON, conforme estrutura abaixo:

```json
    {
        "empresa": {
            "cnpj": "17.184.406/0001-74",
            "ultima_atualizacao": "2018-05-27T23:21:27.467Z",
            "abertura": "10/08/2012",
            "nome": "ATITUDE SOLUCOES EMPRESARIAIS LTDA",
            "fantasia": "",
            "status": "OK",
            "tipo": "MATRIZ",
            "situacao": "ATIVA",
            "capital_social": "100000.00",
            "endereco": {
                "bairro": "CENTRO",
                "logradouro": "R CARLOS LUIZ FREDERICO",
                "numero": "05",
                "cep": "29.730-000",
                "municipio": "BAIXO GUANDU",
                "uf": "ES",
                "complemento": ""
            },
            "contato": {
                "telefone": "(27) 3732-4337",
                "email": "eacace@terra.com.br"
            },
            "atividade_principal": [
                {
                    "text": "Atividades de consultoria em gestão empresarial, exceto consultoria técnica específica",
                    "code": "70.20-4-00"
                }
            ]
        }
    }
```
- **Recomendações:**
    - API de consulta de CNPJ: https://receitaws.com.br/api

#### Rota 2: [POST] .../quote
- **Objetivo:** Criar uma rota para receber alguns dados e realizar uma cotação fictícia com a API da Frete Rápido (os valores e transportadoras retornadas não são reais);
- **Entrada:** Receber um JSON com os dados de volumes e destinatário, conforme exemplo abaixo:
```json
    {
        "destinatario": {
            "endereco": {
                "cep": "01311000"
            }
        },
        "volumes": [
            {
                "tipo": 7,
                "quantidade": 1,
                "peso": 5,
                "valor": 349,
                "sku": "abc-teste-123",
                "altura": 0.2,
                "largura": 0.2,
                "comprimento": 0.2
            },
            {
                "tipo": 7,
                "quantidade": 2,
                "peso": 4,
                "valor": 556,
                "sku": "abc-teste-527",
                "altura": 0.4,
                "largura": 0.6,
                "comprimento": 0.15
            }
        ]
    }
```
- **Processo:** Utilizar os dados de entrada para consumir a API da Frete Rápido no método “[Cálculo do Frete][1]”. Os dados recebidos devem complementar a estrutura padrão obrigatória para a requisição na Frete Rápido.
- **Retorno:**
```json
    {
        "transportadoras": [
            {
                "nome": "EXPRESSO FR",
                "servico": "Rodoviário",
                "prazo_entrega": "3",
                "preco_frete": 17
            },
            {
                "nome": "Correios",
                "servico": "SEDEX",
                "prazo_entrega": 1,
                "preco_frete": 20.99
            }
        ]
    }
```
- **Observação:** Para consumir a API da Frete Rápido, você vai precisar dos dados obrigatórios:
    - **URL para requisições deste desafio:** https://freterapido.com/sandbox/api/external/embarcador/v1/quote-simulator
    - **CNPJ Remetente:** 17.184.406/0001-74
    - **Token autenticação:** 2ff525e2d71540700b7949a65491121c
    - **Código Plataforma:** 588604ab3

### Sugestões:

Tecnologias que você pode utilizar (mas fique a vontade):

- Django ou Flask (Python)
- Laravel ou Lumen (PHP)

### Ganha mais pontos:

- Aplicação de TDD.
- Validação dos dados de entrada.

### Entrega:
 
- Faça um *Fork* deste repositório;
- Coloque seu projeto no seu *Fork*;
- Solicite um *Pull Request*, com **seu nome** na descrição, para nossa avaliação.
- Você tem a liberdade de realizar o desafio com a tecnologia que achar melhor. Lembre de informar quais tecnologias foram usadas, como instalar, rodar e efetuar os acessos no arquivo README.md para análise do desafio.

[1]: https://freterapido.com/dev/dist/api-ecommerce.html#/!#content_simulacao
