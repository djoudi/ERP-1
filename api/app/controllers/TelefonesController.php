<?php

class TelefonesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($contato_id = null)
	{
		$response = [];

		if ($contato_id)
		{
			$total = Contato::find($contato_id)->telefones->count();
			$response["data"] = Contato::find($contato_id)
				->telefones()
				->skip($offset=Input::get('offset', 0))
				->take($limit=Input::get('limit', 10))
				->get()
				->toArray();
		}
		else
		{
			$total = Telefone::count();
			$response["data"] = Telefone::skip($offset=Input::get('offset', 0))
				->take($limit=Input::get('limit', 10))
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
	public function store($contato_id)
	{
		if (!($contato = Contato::find($contato_id)) || func_num_args() != 1)
			return (($response = Response::json([
				"metadata"=> [
					"errors"	=> 1,
					"found"		=> 0,
					"messages"	=> [
						"contato" => "Contato não foi encontrado"
					],
					"modified"	=> 0,
					"offset"	=> 0,
					"total"		=> Telefone::count(),
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
			    'identificacao' => 'required',
		    	'numero' => ['required', 'numeric']
		    ]);

		if ($validator->fails())
		{
			return (($response = Response::json([ "metadata" => [
				"errors"	=> count($messages = $validator->messages()->toArray()),
				"found"		=> 0,
				"messages"	=> $messages,
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> $contato->telefones()->count(),
			]],400)) && isset($inputs['callback'])?$response->setCallback($inputs['callback']):$response);
		}

		$telefone = $contato->telefones()->where('numero',$inputs['numero']);
		if ($telefone->count())
			return (($response = Response::json([
				"data" => $telefone->first()->toArray(),
				"metadata"=> [
					"errors"	=> 1,
					"found"		=> 1,
					"messages"	=> [
						"numero" => "Telefone já pertencente ao contato"
					],
					"modified"	=> 0,
					"offset"	=> 0,
					"total"		=> $contato->telefones()->count(),
				]
			],303)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		$contato->telefones()->save(
			$telefone = new Telefone( $inputs )
		);

		return (($response = Response::json([
			"data" => $telefone->toArray(),
			"metadata"=> [
				"errors"	=> 0,
				"found"		=> 1,
				"modified"	=> 1,
				"offset"	=> 0,
				"total"		=> $contato->telefones()->count(),
			]
		],200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($contato_id, $telefone_id)
	{
		if (!($contato=Contato::find($contato_id)))
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
					"total"  => Telefone::count(),
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		$telefone = $contato->telefones()->find($telefone_id);

		if ($telefone)
			return (($response = Response::json([
				'data' => $telefone->toArray(),
				'metadata' => [
					"errors" 	=> 0,
					"found"	 	=> 1,
					"offset" 	=> 0,
					"total"  	=> $contato->telefones()->count(),
					'modified'	=> 0, 
				]
			], 200 )) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
		else
			return (($response = Response::json([
				'metadata' => [
					"errors" 	=> 1,
					"found"	 	=> 0,
					"offset" 	=> 0,
					"total"  	=> $contato->telefones()->count(),
					"messages" 	=> [
						"telefone" => "Telefone não foi encontrado"
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
	public function update($contato_id, $telefone_id)
	{
		if (!($contato=Contato::find($contato_id)))
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
					"total"  => Telefone::count(),
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		if (!($telefone = $contato->telefones()->find($telefone_id)))
			return (($response = Response::json([
				'metadata' => [
					"errors" 	=> 1,
					"found"	 	=> 0,
					"offset" 	=> 0,
					"total"  	=> $contato->telefones()->count(),
					"messages" 	=> [
						"telefone" => "Telefone não foi encontrado"
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
			    'identificacao' => 'required',
		    	'numero' => ['required', 'numeric']
		    ]);

		if ($validator->fails())
		{
			return (($response = Response::json([ "metadata" => [
				"errors"	=> count($messages = $validator->messages()),
				"found"		=> 0,
				"messages"	=> $validator->messages()->toArray(),
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> $contato->telefones()->count(),
			]],400)) && isset($inputs['callback'])?$response->setCallback($inputs['callback']):$response);
		}

		$telefone->fill($inputs);
		$telefone->save();

		return (($response = Response::json([
			'data' => $telefone->toArray(),
			'metadata' => [
				"errors" 	=> 0,
				"found"	 	=> 1,
				"offset" 	=> 0,
				"total"  	=> $contato->telefones()->count(),
				'modified'	=> 1, 
			]
		], 200 )) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($contato_id, $telefone_id)
	{
		if (!($contato=Contato::find($contato_id)))
			return (($response = Response::json([
				"metadata" =>
				[
					"found"		=> 0,
					"total"		=> Telefone::count(),
					"offset" 	=> 0,
					"errors"	=> 1,
					"messages"	=> [
						"contato" => "Contato não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		$telefone = $contato->telefones()->find($telefone_id);


		if ($telefone)
			return (($response = Response::json([
				"data" => $telefone->toArray(),
				"metadata" =>
				[
					"modified"	=> $x = $telefone->delete(),
					"found"		=> $x,
					"offset"	=> 0,
					"total"		=> $contato->telefones()->count(),
					"errors"	=> 0,
				]
			], 200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		else
			return (($response = Response::json([
				'metadata' => [
					"errors" 	=> 1,
					"found"	 	=> 0,
					"offset" 	=> 0,
					"total"  	=> $contato->telefones()->count(),
					"messages" 	=> [
						"telefone" => "Telefone não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404 )) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	}
}