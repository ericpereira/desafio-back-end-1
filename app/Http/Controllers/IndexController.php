<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
	
	public function testApi(Request $request){
		$client = new \GuzzleHttp\Client();
		$resApi = $client->request('POST',
			'https://freterapido.com/sandbox/api/external/embarcador/v1/quote-simulator',
			[
				'json' => 
				[
					'remetente' => [
						'cnpj' => 17184406000174
					],
					'destinatario' => [
						'tipo_pessoa' => 1,
						'endereco' => [
							'cep' => '29932520'
						]
					],
					'volumes' => [
						[
							'tipo' => 7,
			                'quantidade' => 1,
			                'peso' => 5,
			                'valor' => 349,
			                'sku' => "abc-teste-123",
			                'altura' => 0.2,
			                'largura' => 0.2,
			                'comprimento' => 0.2
						],
						[
							'tipo' => 7,
			                'quantidade' => 1,
			                'peso' => 5,
			                'valor' => 349,
			                'sku' => "abc-teste-123",
			                'altura' => 0.2,
			                'largura' => 0.2,
			                'comprimento' => 0.2
						],
					],
					'codigo_plataforma' => '588604ab3',
					'token' => '2ff525e2d71540700b7949a65491121c'
				]
			]);

		//$dataResApi = json_decode($resApi->getBody());
		return $resApi->getBody();
	}


	public function getQuote(Request $request){

		$response = response()->json([
    		'transportadoras' => [
    			[
    				'nome' => 'nome 1',
					'servico' => 'lul11',
    			    'prazo_entraga' => 3,
    			    'prazo_frete' => 99
    			],
    			[
    				'nome' => 'nooome2',
					'servico' => 'lul222',
    			    'prazo_entraga' => 1,
    			    'prazo_frete' => 17
    			],
    		],
    		'status' => $request->volumes[0]['tipo']
    	], 200, [], JSON_UNESCAPED_UNICODE);
		$response->header('Content-Type', 'application/json');
		$response->header('charset', 'utf-8');

    	return $response;
    	//return $dataResApi;
	}

	public function validar_cnpj($cnpj){
		$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
		// Valida tamanho
		if (strlen($cnpj) != 14)
			return false;
		// Valida primeiro dígito verificador
		for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
		{
			$soma += $cnpj{$i} * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = $soma % 11;
		if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
			return false;
		// Valida segundo dígito verificador
		for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
		{
			$soma += $cnpj{$i} * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = $soma % 11;
		return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
	}

    public function getJson(Request $request){
    	if($this->validar_cnpj($request->cnpj)){
    		$client = new \GuzzleHttp\Client();
			$res = $client->request('GET', 'https://www.receitaws.com.br/v1/cnpj/'.$request->cnpj);

			$response = json_decode($res->getBody());

			$response = response()->json([
	    		'empresa' => [
	    			'cnpj' => $response->cnpj,
	    			'ultima_atualizacao' => $response->data_situacao,
	    			'abertura' => $response->abertura,
	    			'nome' => $response->nome,
	    			'fantasia' => $response->fantasia,
	    			'status' => $response->status,
	    			'tipo' => $response->tipo,
	    			'situacao' => $response->situacao,
	    			'capital_social' => $response->capital_social,
	    			'endereco' => [
	    				'bairro' => $response->bairro,
	    				'logradouro' => $response->logradouro,
	    				'numero' => $response->numero,
	    				'cep' => $response->cep,
	    				'municipio' => $response->municipio,
	    				'uf' => $response->uf,
	    				'complemento' => $response->complemento
	    			],
	    			'contato' => [
	    				'telefone' => $response->telefone,
	    				'email' => $response->email,
	    			],
	    			'atividade_principal' => [
	    				'text' => $response->atividade_principal[0]->text,
	    				'code' => $response->atividade_principal[0]->code,	
	    			]
	    		]
	    	], 200, [], JSON_UNESCAPED_UNICODE);
			$response->header('Content-Type', 'application/json');
			$response->header('charset', 'utf-8');

	    	return $response;
    	}else{
    		return "CNPJ inválido";
    	}
    }
}
