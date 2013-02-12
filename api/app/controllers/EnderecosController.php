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
				->skip($offset=Input::get('offset', 0))
				->take($limit=Input::get('limit', 10))
				->get()
				->toArray();
		}
		else
		{
			$total = Endereco::count();
			$response["data"] = Endereco::skip($offset=Input::get('offset', 0))
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

		return Response::json($response,200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($contato_id)
	{
		if (!($contato = Contato::find($contato_id)) || func_num_args() != 1)
			return Response::json([
				"metadata"=> [
					"errors"	=> 1,
					"found"		=> 0,
					"messages"	=> [
						"contato" => "Contato não foi encontrado"
					],
					"modified"	=> 0,
					"offset"	=> 0,
					"total"		=> $contato->enderecos()->count(),
				]
			],404);
		
		$defaults = [
			'identificacao' => '',
			'numero' => '',
			'logradouro' => '',
			'bairro' => '',
			'complemento' => '',
			'localidade' => '',
			'uf' => '',
			'cep' => '',
		];

		if (!($inputs = Input::all()))
			$inputs = objectToArray(Input::json());

		$inputs = array_intersect_key($inputs, $defaults);

		$validator = Validator::make($inputs,
		    [
			    'logradouro' => 'required',
			    'bairro' => 'required',
			    'localidade' => 'required',
			    'uf' => 'required',
		    ]);

		if ($validator->fails())
		{
			return Response::json([ "metadata" => [
				"errors"	=> count($messages = $validator->messages()->toArray()),
				"found"		=> 0,
				"messages"	=> $messages,
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> $contato->enderecos()->count(),
			]],400);
		}

		$endereco = $contato->enderecos()->where('endereco',$inputs['endereco']);
		if ($endereco->count())
			return Response::json([
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
			],303);

		$contato->enderecos()->save(
			$endereco = new Endereco( $inputs )
		);

		return Response::json([
			"data" => $endereco->toArray(),
			"metadata"=> [
				"errors"	=> 0,
				"found"		=> 1,
				"modified"	=> 1,
				"offset"	=> 0,
				"total"		=> $contato->enderecos()->count(),
			]
		],200);

	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($contato_id, $endereco_id)
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
					"modified"	=> 0, 
					"offset" => 0,
					"total"  => $contato->enderecos()->count(),
				]
			], 404);

		$endereco = $contato->enderecos()->find($endereco_id);

		if ($endereco)
			return Response::json([
				'data' => $endereco->toArray(),
				'metadata' => [
					"errors" 	=> 0,
					"found"	 	=> 1,
					"offset" 	=> 0,
					"total"  	=> $contato->enderecos()->count(),
					'modified'	=> 1, 
				]
			], 200);
		else
			return Response::json([
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
			], 404);
	}



	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function update($contato_id, $endereco_id)
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
					"modified"	=> 0, 
					"offset" => 0,
					"total"  => $contato->enderecos()->count(),
				]
			], 404);


		if (!($endereco = $contato->enderecos()->find($endereco_id)))
			return Response::json([
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
			], 404 );


		$defaults = [
			'identificacao' => '',
			'numero' => '',
			'logradouro' => '',
			'bairro' => '',
			'complemento' => '',
			'localidade' => '',
			'uf' => '',
			'cep' => '',
		];

		if (!($inputs = Input::all()))
			$inputs = objectToArray(Input::json());

		$inputs = array_intersect_key($inputs, $defaults);

		$validator = Validator::make($inputs,
		    [
		    	'logradouro' => 'min:1',
			    'bairro' => 'min:1',
			    'localidade' => 'min:1',
			    'uf' => 'min:1',
		    ]);

		if ($validator->fails())
		{
			return Response::json([ "metadata" => [
				"errors"	=> count($messages = $validator->messages()),
				"found"		=> 0,
				"messages"	=> $validator->messages()->toArray(),
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> $contato->enderecos()->count(),
			]],400);
		}

		foreach($inputs as $attribute=>$value)
			$endereco->{$attribute} = $value;

		$endereco->save();

		return Response::json([
			'data' => $endereco->toArray(),
			'metadata' => [
				"errors" 	=> 0,
				"found"	 	=> 1,
				"offset" 	=> 0,
				"total"  	=> $contato->enderecos()->count(),
				'modified'	=> 1 
			]
		], 200 );
	
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($contato_id, $endereco_id)
	{
		if (!($contato=Contato::find($contato_id)))
			return Response::json([
				"metadata" =>
				[
					"found"		=> 0,
					"total"		=> $contato->enderecos()->count(),
					"offset" 	=> 0,
					"errors"	=> 1,
					"messages"	=> [
						"contato" => "Contato não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404);

		$endereco = $contato->enderecos()->find($endereco_id);


		if ($endereco)
			return Response::json([
				"data" => $endereco->toArray(),
				"metadata" =>
				[
					"modified"	=> $x = $endereco->delete(),
					"found"		=> $x,
					"offset"	=> 0,
					"total"		=> $contato->enderecos()->count(),
					"errors"	=> 0,
				]
			], 200);

		else
			return Response::json([
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
			], 404 );
	}
}