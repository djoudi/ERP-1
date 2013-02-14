

<?php

class ContatosController extends BaseController {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$response = [];

		$response["data"] = Contato::with("telefones", "emails", "enderecos")
			->orderBy($order=Input::get('orderBy', "nome"),$limit=Input::get('direction', "asc"))
			->skip($offset=Input::get('offset', 0))
			->take($limit=Input::get('limit', 10))
			->get()
			->toArray();

		$response['metadata'] = [
			"errors"=> 0,
			"found" => $found = count($response["data"]),
			"modified" => 0,
			"offset"=> intval($offset),
			"total" => Contato::count(),
		];

		return (($response = Response::json($response,200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		

		if (!($inputs = Input::all()))
			if (!($inputs = objectToArray(Input::json())))
				return (($response = Response::json([
					"metadata"=> [
						"errors"	=> 1,
						"found"		=> 0,
						"modified"	=> 0,
						"offset"	=> 0,
					]
				],400)) && isset($inputs['callback'])?$response->setCallback($inputs['callback']):$response);

		

		$validator = Validator::make($inputs,
		    [
				'nome'				=>  'required',
				'pessoaJuridica'	=>  'required',
				'numeroDocumento'	=>	['unique:contatos,numeroDocumento',isset($inputs["pessoaJuridica"])&&$inputs["pessoaJuridica"]?"cnpj": "cpf"]
		    ],
		    [
		    	"cnpj" => ":attribute deve ser um CNPJ válido",
		    	"cpf" => ":attribute deve ser um CPF válido"
		    ]);

		if ($validator->fails())
		{
			return (($response = Response::json([ "metadata" => [
				"messages"	=> $messages = $validator->messages()->toArray(),
				"errors"	=> count($messages),
				"found"		=> 0,
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> Contato::count(),
			]],400)) && isset($inputs['callback'])?$response->setCallback($inputs['callback']):$response);
		}

		
		$contato = new Contato( $inputs );
		$contato->save();

		return (($response = Response::json([
			"data" => $contato->toArray(),
			"metadata"=> [
				"errors"	=> 0,
				"found"		=> 1,
				"modified"	=> 1,
				"offset"	=> 0,
				"total"		=> Contato::count(),
			]
		],200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($contato_id)
	{
		if (!($contato=Contato::with("telefones", "emails", "enderecos")->find($contato_id)))
			return (($response = Response::json([
				"metadata" =>
				[
					"errors" => 1,
					"found"	 => 1,
					"messages" => [
						"contato" => "Contato não foi encontrado"
					],
					"modified"	=> 0, 
					"offset" => 0,
					"total"  => Contato::count(),
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		return (($response = Response::json([
			'data' => $contato->toArray(),
			'metadata' => [
				"errors" 	=> 0,
				"found"	 	=> 1,
				"offset" 	=> 0,
				"total"  	=> $contato->count(),
				'modified'	=> 0, 
			]
		], 200 )) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($contato_id)
	{
		if (!($contato=Contato::with("telefones", "emails", "enderecos")->find($contato_id)))
			return (($response = Response::json([
				'metadata' => [
					"errors" 	=> 1,
					"found"	 	=> 0,
					"offset" 	=> 0,
					"total"  	=> Contato::count(),
					"messages" 	=> [
						"email" => "Contato não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		

		if (!($inputs = Input::all()))
			if (!($inputs = objectToArray(Input::json())))
				return (($response = Response::json([ "metadata" => [
					"found"		=> 1,
					"modified"	=> 0,
					"offset"	=> 0,
					"total"		=> Contato::count(),
				]],202)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);;

		
		$validator = Validator::make($inputs,
		    [
				'numeroDocumento'	=>	["unique:contatos,numeroDocumento,$contato_id",isset($inputs["pessoaJuridica"])&&$inputs["pessoaJuridica"]?"cnpj": "cpf"]
		    ],
		    [
		    	"cnpj" => ":attribute deve ser um CNPJ válido",
		    	"cpf" => ":attribute deve ser um CPF válido"
		    ]);

		if ($validator->fails())
		{
			return (($response = Response::json([ "metadata" => [
				"messages"	=> $messages = $validator->messages()->toArray(),
				"errors"	=> count($messages),
				"found"		=> 0,
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> Contato::count(),
			]],400)) && isset($inputs['callback'])?$response->setCallback($inputs['callback']):$response);
		}

		$contato->fill($inputs);
		$contato->save();

		return (($response = Response::json([
			"data" => $contato->toArray(),
			"metadata"=> [
				"errors"	=> 0,
				"found"		=> 1,
				"modified"	=> 1,
				"offset"	=> 0,
				"total"		=> Contato::count(),
			]
		],200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($contato_id)
	{
		if (!($contato=Contato::with("telefones", "emails", "enderecos")->find($contato_id)))
			return (($response = Response::json([
				"metadata" =>
				[
					"found"		=> 0,
					"total"		=> Contato::count(),
					"offset" 	=> 0,
					"errors"	=> 1,
					"messages"	=> [
						"contato" => "Contato não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		$response = [
			"data" => $contato->toArray(),
			"metadata" =>
			[
				"modified"	=> $x=$contato->delete($contato_id),
				"found"		=> $x,
				"offset"	=> 0,
				"total"		=> $contato->count(),
				"errors"	=> 0,
			]
		];

		return (($response = Response::json($response, 200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	}

}