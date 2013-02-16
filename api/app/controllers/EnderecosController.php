<?php

class EnderecosController extends BaseController {

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
			$total = Contato::find($contato_id)->enderecos->count();
			$response["data"] = Contato::find($contato_id)
				->enderecos()
				->skip($offset=(Input::get('page', 1)-1)*Input::get('per_page', 10))
				->take($limit=Input::get('per_page', 10))
				->get()
				->toArray();
		}
		else
		{
			$total = Endereco::count();
			$response["data"] = Endereco::skip($offset=(Input::get('page', 1)-1)*Input::get('per_page', 10))
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
					"total"		=> Endereco::count(),
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
			    'logradouro' => 'required',
			    'bairro' => 'required',
			    'localidade' => 'required',
			    'uf' => 'required',
		    ]);

		if ($validator->fails())
		{
			return (($response = Response::json([ "metadata" => [
				"errors"	=> count($messages = $validator->messages()->toArray()),
				"found"		=> 0,
				"messages"	=> $messages,
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> $contato->enderecos()->count(),
			]],400)) && isset($inputs['callback'])?$response->setCallback($inputs['callback']):$response);
		}

		$endereco = $contato->enderecos()->where('endereco',$inputs['endereco']);
		if ($endereco->count())
			return (($response = Response::json([
				"data" => $endereco->first()->toArray(),
				"metadata"=> [
					"errors"	=> 1,
					"found"		=> 1,
					"messages"	=> [
						"endereco" => "Endereco já pertencente ao contato"
					],
					"modified"	=> 0,
					"offset"	=> 0,
					"total"		=> $contato->enderecos()->count(),
				]
			],303)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		$contato->enderecos()->save(
			$endereco = new Endereco( $inputs )
		);

		return (($response = Response::json([
			"data" => $endereco->toArray(),
			"metadata"=> [
				"errors"	=> 0,
				"found"		=> 1,
				"modified"	=> 1,
				"offset"	=> 0,
				"total"		=> $contato->enderecos()->count(),
			]
		],200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($contato_id, $endereco_id)
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
					"total"  => Endereco::count(),
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		$endereco = $contato->enderecos()->find($endereco_id);

		if ($endereco)
			return (($response = Response::json([
				'data' => $endereco->toArray(),
				'metadata' => [
					"errors" 	=> 0,
					"found"	 	=> 1,
					"offset" 	=> 0,
					"total"  	=> $contato->enderecos()->count(),
					'modified'	=> 1, 
				]
			], 200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
		else
			return (($response = Response::json([
				'metadata' => [
					"errors" 	=> 1,
					"found"	 	=> 0,
					"offset" 	=> 0,
					"total"  	=> $contato->enderecos()->count(),
					"messages" 	=> [
						"endereco" => "Endereco não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	}



	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function update($contato_id, $endereco_id)
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
					"total"  => Endereco::count(),
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);


		if (!($endereco = $contato->enderecos()->find($endereco_id)))
			return (($response = Response::json([
				'metadata' => [
					"errors" 	=> 1,
					"found"	 	=> 0,
					"offset" 	=> 0,
					"total"  	=> $contato->enderecos()->count(),
					"messages" 	=> [
						"endereco" => "Endereco não foi encontrado"
					],
					"modified" 	=> 1, 
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
		    	'logradouro' => 'min:1',
			    'bairro' => 'min:1',
			    'localidade' => 'min:1',
			    'uf' => 'min:1',
		    ]);

		if ($validator->fails())
		{
			return (($response = Response::json([ "metadata" => [
				"errors"	=> count($messages = $validator->messages()),
				"found"		=> 0,
				"messages"	=> $validator->messages()->toArray(),
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> $contato->enderecos()->count(),
			]],400)) && isset($inputs['callback'])?$response->setCallback($inputs['callback']):$response);
		}

		$endereco->fill($inputs);
		$endereco->save();

		return (($response = Response::json([
			'data' => $endereco->toArray(),
			'metadata' => [
				"errors" 	=> 0,
				"found"	 	=> 1,
				"offset" 	=> 0,
				"total"  	=> $contato->enderecos()->count(),
				'modified'	=> 1 
			]
		], 200 )) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($contato_id, $endereco_id)
	{
		if (!($contato=Contato::find($contato_id)))
			return (($response = Response::json([
				"metadata" =>
				[
					"found"		=> 0,
					"total"		=> Endereco::count(),
					"offset" 	=> 0,
					"errors"	=> 1,
					"messages"	=> [
						"contato" => "Contato não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		$endereco = $contato->enderecos()->find($endereco_id);


		if ($endereco)
			return (($response = Response::json([
				"data" => $endereco->toArray(),
				"metadata" =>
				[
					"modified"	=> $x = $endereco->delete(),
					"found"		=> $x,
					"offset"	=> 0,
					"total"		=> $contato->enderecos()->count(),
					"errors"	=> 0,
				]
			], 200)) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);

		else
			return (($response = Response::json([
				'metadata' => [
					"errors" 	=> 1,
					"found"	 	=> 0,
					"offset" 	=> 0,
					"total"  	=> $contato->enderecos()->count(),
					"messages" 	=> [
						"endereco" => "Endereco não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404 )) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
	}
}