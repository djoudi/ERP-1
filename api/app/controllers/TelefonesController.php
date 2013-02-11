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
			$response["data"] = Contato::find($contato_id)->telefones()->skip($offset=Input::get('offset', 0))->take($limit=Input::get('limit', 10))->get()->toArray();
		}
		else
		{
			$total = Telefone::count();
			$response["data"] = Telefone::skip($offset=Input::get('offset', 0))->take($limit=Input::get('limit', 10))->get()->toArray();
		}
		$response['metadata'] = [
			"total" => $total,
			"found" => $found = count($response["data"]),
			"offset"=> intval($offset),
			"errors"=> 0
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
			return Response::json(404);		
		
		$validator = Validator::make(Input::all(),
		    [
			    'identificacao' => 'required',
		    	'telefone' => ['required', 'telefone']
		    ]);

		if ($validator->fails())
		{
			return Response::json([ "metadata" => [
				"errors"   => count($messages = $validator->messages()),
				"messages" => $validator->messages()->toArray()
			]],400);
		}

		try
		{
			$contato->telefones()->save(
				$telefone = new Telefone( Input::only('identificacao', 'telefone') )
			);	
		} catch(Exception $Exception )
		{
			$toAttach = Telefone::where('telefone',Input::get('telefone'))->first();
			$attachTo = $toAttach->contatos()->where("contato_id" ,$contato_id)->getResults();

			if ($attachTo->count())
				return Response::json([
					"metadata"=> [
						"errors"=>1,
						"messages" => [ "telefone" => "Contato já possui este e-mail" ] 
					]
				]);

			$contato->telefones()->attach($toAttach->id);			
		}

		return Response::json([
			"data" => $telefone,
			"metadata"=> [
				"errors"=>0,
				"total" => Contato::find($contato_id)->telefones()->count()
			]
		]);

	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($contato_id, $telefone_id)
	{
		if (!($contato=Contato::find($contato_id)))
			return Response::json([
				"metadata" =>
				[
					"message" => ["contato" => "Contato não foi encontrado"],
					"errors" => 1
				]
			], 404);

		$telefone = $contato->telefones()->where('telefone_id',$telefone_id)->get();
		$response = [
			'data' => $telefone->toArray(),
			'metadata' => [],
		];

		if ($telefone->count())
		{
			$response['metadata'] = [
				"errors" => 0
			];
			$code = 200;
		}
		else
		{
			$response['metadata'] = [
				"errors" => 1,
				"message" => ["telefone" => "Telefone não foi encontrado"],

			];
			$code = 404;
		}

		return Response::json($response, $code );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($contato_id, $telefone_id)
	{
		if (!($contato=Contato::find($contato_id)))
			return Response::json([
				"metadata" =>
				[
					"message" => ["contato" => "Contato não foi encontrado"],
					"errors" => 1
				]
			], 404);

		$response = [
			"metadata" =>
			[
				"modified" => $contato->telefones()->detach($telefone_id),
				"errors" => 0
			]
		];

		$telefone = Telefone::find($telefone_id);
		if (!$telefone->contatos()->count())
			$telefone->delete();

		return Response::json($response, 200);
	}


	public function contatos($telefone_id)
	{
		if (is_numeric($telefone_id))
			$telefone = Telefone::find($telefone_id);
		else
		{
			$telefone = Telefone::where("telefone",$telefone);
			if (!$telefone->count())
			{
				return Response::json([
					'metadata' => [ 
						"errors" => 1,
						"message" => ["telefone" => "Telefone não foi encontrado"],
					]
				],404);
			}
			$telefone = $telefone->first();
		}

		$total = $telefone->contatos->count();
		$response["data"] = $telefone->contatos()->skip($offset=Input::get('offset', 0))->take($limit=Input::get('limit', 10))->get()->toArray();		
		$response['metadata'] = [
			"total" => $total,
			"found" => $found = count($response["data"]),
			"offset"=> intval($offset),
			"errors"=> 0
		];

		return Response::json($response,200);

	}
}