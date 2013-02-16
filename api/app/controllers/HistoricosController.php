<?php

class HistoricosController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($contrato_id = null)
	{
		$response = [];

		if ($contrato_id)
		{
			$total = Contrato::find($contrato_id)->historicos->count();
			$response["data"] = Contrato::find($contrato_id)
				->historicos()
				->skip($offset=(Input::get('page', 1)-1)*Input::get('per_page', 10))
				->take($limit=Input::get('per_page', 10))
				->get()
				->toArray();
		}
		else
		{
			$total = Historico::count();
			$response["data"] = Historico::skip($offset=(Input::get('page', 1)-1)*Input::get('per_page', 10))
				->take($limit=Input::get('per_page', 10))
				->get()
				->toArray();
		}
		$response['metadata'] = [
			"errors"=> 0,
			"found" => $found = count($response["data"]),
			"modified" => 0,
			"offset"=> intval($offset),
			"total" => $total,
		];

		return (($response = Response::json($response,200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($contrato_id)
	{
		if (!($contrato = Contrato::find($contrato_id)) || func_num_args() != 1)
			return (($response = Response::json([
				"metadata"=> [
					"errors"	=> 1,
					"found"		=> 0,
					"messages"	=> [
						"contrato" => "Contrato não foi encontrado"
					],
					"modified"	=> 0,
					"offset"	=> 0,
					"total"		=> Historico::count(),
				]
			],404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);		
		
		

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
			    'autor' 	=> ['required','exists:contatos,id'],
		    ]);

		if ($validator->fails())
		{
			return (($response = Response::json([ "metadata" => [
				"errors"	=> count($messages = $validator->messages()->toArray()),
				"found"		=> 0,
				"messages"	=> $messages,
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> $contrato->historicos()->count(),
			]],400)) && isset($inputs['callback'])?$response->setCallback($inputs['callback']):$response);
		}

		$contrato->historicos()->save(
			$historico = new Historico( $inputs )
		);

		return (($response = Response::json([
			"data" => $historico->toArray(),
			"metadata"=> [
				"errors"	=> 0,
				"found"		=> 1,
				"modified"	=> 1,
				"offset"	=> 0,
				"total"		=> $contrato->historicos()->count(),
			]
		],200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($contrato_id, $historico_id)
	{
		if (!($contrato=Contrato::find($contrato_id)))
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
					"total"  => Historico::count(),
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		$historico = $contrato->historicos()->find($historico_id);

		if ($historico)
			return (($response = Response::json([
				'data' => $historico->toArray(),
				'metadata' => [
					"errors" 	=> 0,
					"found"	 	=> 1,
					"offset" 	=> 0,
					"total"  	=> $contrato->historicos()->count(),
					'modified'	=> 0, 
				]
			], 200 )) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
		else
			return (($response = Response::json([
				'metadata' => [
					"errors" 	=> 1,
					"found"	 	=> 0,
					"offset" 	=> 0,
					"total"  	=> $contrato->historicos()->count(),
					"messages" 	=> [
						"historico" => "Historico não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404 )) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	}



	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function update($contrato_id, $historico_id)
	{
		if (!($contrato=Contrato::find($contrato_id)))
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
					"total"  => Historico::count(),
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		if (!($historico = $contrato->historicos()->find($historico_id)))
			return (($response = Response::json([
				'metadata' => [
					"errors" 	=> 1,
					"found"	 	=> 0,
					"offset" 	=> 0,
					"total"  	=> $contrato->historicos()->count(),
					"messages" 	=> [
						"historico" => "Historico não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404 )) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		

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
			    'autor' 	=> 'exists:contatos',
			    'contrato' 	=> 'exists:contratos',
		    ]);

		if ($validator->fails())
		{
			return (($response = Response::json([ "metadata" => [
				"errors"	=> count($messages = $validator->messages()),
				"found"		=> 0,
				"messages"	=> $validator->messages()->toArray(),
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> $contrato->historicos()->count(),
			]],400)) && isset($inputs['callback'])?$response->setCallback($inputs['callback']):$response);
		}

		$historico->fill($inputs);
		$historico->save();

		return (($response = Response::json([
			'data' => $historico->toArray(),
			'metadata' => [
				"errors" 	=> 0,
				"found"	 	=> 1,
				"offset" 	=> 0,
				"total"  	=> $contrato->historicos()->count(),
				'modified'	=> 1, 
			]
		], 200 )) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($contrato_id, $historico_id)
	{
		if (!($contrato=Contrato::find($contrato_id)))
			return (($response = Response::json([
				"metadata" =>
				[
					"found"		=> 0,
					"total"		=> Historico::count(),
					"offset" 	=> 0,
					"errors"	=> 1,
					"messages"	=> [
						"contrato" => "Contrato não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		$historico = $contrato->historicos()->find($historico_id);


		if ($historico)
			return (($response = Response::json([
				"data" => $historico->toArray(),
				"metadata" =>
				[
					"modified"	=> $x = $historico->delete(),
					"found"		=> $x,
					"offset"	=> 0,
					"total"		=> $contrato->historicos()->count(),
					"errors"	=> 0,
				]
			], 200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		else
			return (($response = Response::json([
				'metadata' => [
					"errors" 	=> 1,
					"found"	 	=> 0,
					"offset" 	=> 0,
					"total"  	=> $contrato->historicos()->count(),
					"messages" 	=> [
						"historico" => "Historico não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404 )) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	}
}