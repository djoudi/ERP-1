<?php

class ContratosController extends BaseController {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$response = [];
		$response["data"] = Contrato::with("historicos")->skip($offset=(Input::get('page', 1)-1)*Input::get('per_page', 10))
			->take($limit=Input::get('per_page', 10))
			->get()
			->toArray();

		$response['metadata'] = [
			"errors"=> 0,
			"found" => $found = count($response["data"]),
			"modified" => 0,
			"offset"=> intval($offset),
			"total" => Contrato::count(),
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
				'empresa' => ["required","exists:contatos,id", "unique:contratos,empresa"],
				'consultor' => ["required","exists:contatos,id"],
				'administrador' => ["required","exists:contatos,id"],
				'numeroCliente' => "numeric",
				'usuarioAtendimento' => "required",
				'senhaAtendimento' => ["required","min:0","max:9999"],
				'inicioContrato' => ["required","date"],
				'periodo' => "numeric",
		    ]);

		if ($validator->fails())
		{
			return (($response = Response::json([ "metadata" => [
				"messages"	=> $messages = $validator->messages()->toArray(),
				"errors"	=> count($messages),
				"found"		=> 0,
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> Contrato::count(),
			]],400)) && isset($inputs['callback'])?$response->setCallback($inputs['callback']):$response);
		}
		
		$contrato = new Contrato( $inputs );
		$contrato->save();

		return (($response = Response::json([
			"data" => $contrato->toArray(),
			"metadata"=> [
				"errors"	=> 0,
				"found"		=> 1,
				"modified"	=> 1,
				"offset"	=> 0,
				"total"		=> Contrato::count(),
			]
		],200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($contrato_id)
	{
		if (!($contrato=Contrato::with("historicos")->find($contrato_id)))
			return (($response = Response::json([
				"metadata" =>
				[
					"errors" => 1,
					"found"	 => 1,
					"messages" => [
						"contrato" => "Contrato não foi encontrado"
					],
					"modified"	=> 0, 
					"offset" => 0,
					"total"  => $contrato->count(),
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		return (($response = Response::json([
			'data' => $contrato->toArray(),
			'metadata' => [
				"errors" 	=> 0,
				"found"	 	=> 1,
				"offset" 	=> 0,
				"total"  	=> $contrato->count(),
				'modified'	=> 0, 
			]
		], 200 )) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($contrato_id)
	{

		if (!($contrato=Contrato::with("historicos")->find($contrato_id)))
			return (($response = Response::json([
				"metadata" =>
				[
					"errors" => 1,
					"found"	 => 1,
					"messages" => [
						"contrato" => "Contrato não foi encontrado"
					],
					"modified"	=> 0, 
					"offset" => 0,
					"total"  => Contrato::count(),
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		

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
				'empresa' => ["exists:contatos,id", "unique:contratos,empresa,".$contrato->empresa],
				'consultor' => ["exists:contatos,id"],
				'administrador' => ["exists:contatos,id"],
				'numeroContrato' => "numeric",
				'senhaAtendimento' => ["min:0","max:9999"],
				'inicioContrato' => ["date"],
				'periodo' => "numeric",
		    ]);

		if ($validator->fails())
			return (($response = Response::json([ "metadata" => [
				"messages"	=> $messages = $validator->messages()->toArray(),
				"errors"	=> count($messages),
				"found"		=> 0,
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> Contrato::count(),
			]],400)) && isset($inputs['callback'])?$response->setCallback($inputs['callback']):$response);
		
		$contrato->fill($inputs);
		$contrato->save();

		return (($response = Response::json([
			"data" => $contrato->toArray(),
			"metadata"=> [
				"errors"	=> 0,
				"found"		=> 1,
				"modified"	=> 1,
				"offset"	=> 0,
				"total"		=> Contrato::count(),
			]
		],200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($contrato_id)
	{
		if (!($contrato=Contrato::with("historicos")->find($contrato_id)))
			return (($response = Response::json([
				"metadata" =>
				[
					"found"		=> 0,
					"total"		=> Contrato::count(),
					"offset" 	=> 0,
					"errors"	=> 1,
					"messages"	=> [
						"contrato" => "Contrato não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		$response = [
			"data" => $contrato->toArray(),
			"metadata" =>
			[
				"modified"	=> $x=$contrato->delete($contrato_id),
				"found"		=> $x,
				"offset"	=> 0,
				"total"		=> $contrato->count(),
				"errors"	=> 0,
			]
		];

		return (($response = Response::json($response, 200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	}

}