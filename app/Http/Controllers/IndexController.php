<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
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
			$res = $client->request('GET', 'https://www.receitaws.com.br/v1/cnpj/27865757000102', [
			    'auth' => ['user', 'pass']
			]);

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
