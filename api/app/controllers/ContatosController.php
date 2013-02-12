

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

		$response["data"] = Contato::skip($offset=Input::get('offset', 0))
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

		return Response::json($response,200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$defaults = [
			"nome" => "",
			"pessoaJuridica" => false,
			"numeroDocumento" => "0",
			"descricao" => 0,
		];

		if (!($inputs = Input::all()))
			$inputs = objectToArray(Input::json());

		$inputs = array_intersect_key($inputs, $defaults);

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
			return Response::json([ "metadata" => [
				"messages"	=> $messages = $validator->messages()->toArray(),
				"errors"	=> count($messages),
				"found"		=> 0,
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> Contato::count(),
			]],400);
		}

		
		$contato = new Contato( $inputs );
		$contato->save();

		return Response::json([
			"data" => $contato->toArray(),
			"metadata"=> [
				"errors"	=> 0,
				"found"		=> 1,
				"modified"	=> 1,
				"offset"	=> 0,
				"total"		=> Contato::count(),
			]
		],200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($contato_id)
	{
		if (!($contato=Contato::find($contato_id)))
			return Response::json([
				"metadata" =>
				[
					"errors" => 1,
					"found"	 => 1,
					"messages" => [
						"contato" => "Contato não foi encontrado"
					],
					"modified"	=> false, 
					"offset" => 0,
					"total"  => $contato->count(),
				]
			], 404);

		return Response::json([
			'data' => $contato->toArray(),
			'metadata' => [
				"errors" 	=> 0,
				"found"	 	=> 1,
				"offset" 	=> 0,
				"total"  	=> $contato->count(),
				'modified'	=> false, 
			]
		], 200 );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($contato_id)
	{
		if (!($contato=Contato::find($contato_id)))
			return Response::json([
				'metadata' => [
					"errors" 	=> 1,
					"found"	 	=> 0,
					"offset" 	=> 0,
					"total"  	=> $contato->count(),
					"messages" 	=> [
						"email" => "Contato não foi encontrado"
					],
					"modified" 	=> 1, 
				]
			], 404);

		$defaults = [
			"nome" => "",
			"pessoaJuridica" => false,
			"numeroDocumento" => "0",
			"descricao" => 0,
		];

		if (!($inputs = Input::all()))
			if (!($inputs = objectToArray(Input::json())))
				return Response::json([ "metadata" => [
					"found"		=> 1,
					"modified"	=> 0,
					"offset"	=> 0,
					"total"		=> Contato::count(),
				]],202);;

		$inputs = array_intersect_key($inputs, $defaults);
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
			return Response::json([ "metadata" => [
				"messages"	=> $messages = $validator->messages()->toArray(),
				"errors"	=> count($messages),
				"found"		=> 0,
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> Contato::count(),
			]],400);
		}

		
		foreach($inputs as $attribute=>$value)
			$contato->{$attribute} = $value;

		$contato->save();

		return Response::json([
			"data" => $contato->toArray(),
			"metadata"=> [
				"errors"	=> 0,
				"found"		=> 1,
				"modified"	=> 1,
				"offset"	=> 0,
				"total"		=> Contato::count(),
			]
		],200);
	
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($contato_id)
	{
		if (!($contato=Contato::find($contato_id)))
			return Response::json([
				"metadata" =>
				[
					"found"		=> 0,
					"total"		=> $contato->count(),
					"offset" 	=> 0,
					"errors"	=> 1,
					"messages"	=> [
						"contato" => "Contato não foi encontrado"
					],
					"modified" 	=> false, 
				]
			], 404);

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

		return Response::json($response, 200);
	}

}