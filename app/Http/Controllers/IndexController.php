<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
	/*
		Realiza uma cotação ficticia na api de teste da frete rápido
	*/
	public function getQuote(Request $request){

		/*
			Verifica se é um cnpj válido
    	*/
		$request->cnpj = (isset($request->cnpj) ? $request->cnpj : 17184406000174);
		if($this->validarCnpj($request->cnpj) && is_numeric($request->destinatario['endereco']['cep'])){

			$client = new \GuzzleHttp\Client();
			
			/*
				Monta o vetor associativo com as informações passadas via post em formato json para realizar a requisição e consumir a api da frete rápido
			*/
			$json['remetente']['cnpj'] = $request->cnpj;
			$json['destinatario']['tipo_pessoa'] = 1;
			$json['destinatario']['endereco']['cep'] = $request->destinatario['endereco']['cep'];


			/*
				Adiciona todos os volumes ao vetor associativo
			*/
			for($i = 0; $i < count($request->volumes); $i++){
				$json['volumes'][$i]['tipo'] = $request->volumes[$i]['tipo'];
				$json['volumes'][$i]['quantidade'] = $request->volumes[$i]['quantidade'];
				$json['volumes'][$i]['peso'] = $request->volumes[$i]['peso'];
				$json['volumes'][$i]['valor'] = $request->volumes[$i]['valor'];
				$json['volumes'][$i]['sku'] = $request->volumes[$i]['sku'];
				$json['volumes'][$i]['altura'] = $request->volumes[$i]['altura'];
				$json['volumes'][$i]['largura'] = $request->volumes[$i]['largura'];
				$json['volumes'][$i]['comprimento'] = $request->volumes[$i]['comprimento'];
			}

			/*
				Informações necessárias para o teste
			*/
			$json['codigo_plataforma'] = '588604ab3';
			$json['token'] = '2ff525e2d71540700b7949a65491121c';
			

			/*
				Realiza a requisição ao link de testes da api passando o vetor associativo json
				com os dados necessários para realizar a cotação
			*/	
			$resApiExterna = $client->request('POST',
				'https://freterapido.com/sandbox/api/external/embarcador/v1/quote-simulator',
				[
					'json' => $json
				]);
			
			/*
				Pega os dados de retorno em json e decodifica para a variável data
			*/
			$data = json_decode($resApiExterna->getBody());


			/*
				Monta o vetor de retorno com as transportadoras cotadas
			*/
			$transportadoras = NULL; 
			for($i = 0; $i < count($data->transportadoras); $i++){
				$transportadoras[$i]['nome'] = $data->transportadoras[$i]->nome;
				$transportadoras[$i]['servico'] = $data->transportadoras[$i]->servico;
				$transportadoras[$i]['prazo_entrega'] = $data->transportadoras[$i]->prazo_entrega;
				$transportadoras[$i]['preco_frete'] = $data->transportadoras[$i]->preco_frete;
			}

			/*
				Codifica os dados de retorno em json
			*/

			return response()->json([
	    		'transportadoras' => $transportadoras,
	    		'status' => '200 OK'
	    	], 200, [], JSON_UNESCAPED_UNICODE);

		} 

		/*
			Retorna o json com o erro
		*/

		$errorString = '';
		if(!$this->validarCnpj($request->cnpj)){ $errorString .= "CNPJ inválido"; }
		if(!is_numeric($request->destinatario['endereco']['cep'])){ $errorString .= " CEP inválido"; }

		return response()->json([
	    		'status' => '400 Bad Request',
	    		'error' => $errorString
	    	], 400, [], JSON_UNESCAPED_UNICODE);
	}

	/*
		Função utilizada para validar o cnpj
	*/
	public function validarCnpj($cnpj){
		

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


	/*
		Função que realiza a consulta de um cnpj na api da receita e retorna
		o json no formato especificado no desafio
	*/
    public function getJson(Request $request){
    	
    	/*
			Verifica se é um cnpj válido
    	*/

		$jsonData = new \stdClass();

    	if($this->validarCnpj($request->cnpj)){
    		$client = new \GuzzleHttp\Client();

    		/*
				Realiza a requisição do cnpj no link da api
    		*/
			$res = $client->request('GET', 'https://www.receitaws.com.br/v1/cnpj/'.$request->cnpj);

			/*
				Decodifica a resposta em json para utilizar os dados
			*/
			$response = json_decode($res->getBody());

			/*
				Monta o json de retorno, como pedido no desafio
			*/
			$atividadesEmpresa = NULL;
			for($i = 0; $i < count($response->atividade_principal); $i++){
				$atividadesEmpresa[$i]['text'] = $response->atividade_principal[$i]->text;
				$atividadesEmpresa[$i]['code'] = $response->atividade_principal[$i]->code;
			}


			/*
				Retorna o json
			*/
			return response()->json([
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
	    			'atividade_principal' => $atividadesEmpresa
	    		],
	    		'status' => '200 OK'
	    	], 200, [], JSON_UNESCAPED_UNICODE);
    	}

    	/*
			Caso o cnpj seja inválido, retorna a string
		*/
		return response()->json([
	    		'status' => '400 Bad Request',
	    		'error' => 'CNPJ inválido'
	    	], 400, [], JSON_UNESCAPED_UNICODE);
    }
}
