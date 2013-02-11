<?php

class EmailsController extends BaseController {

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
			$total = Contato::find($contato_id)->emails->count();
			$response["data"] = Contato::find($contato_id)->emails()->skip($offset=Input::get('offset', 0))->take($limit=Input::get('limit', 10))->get()->toArray();
		}
		else
		{
			$total = Email::count();
			$response["data"] = Email::skip($offset=Input::get('offset', 0))->take($limit=Input::get('limit', 10))->get()->toArray();
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
		    	'email' => ['required', 'email']
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
			$contato->emails()->save(
				$email = new Email( Input::only('identificacao', 'email') )
			);	
		} catch(Exception $Exception )
		{
			$toAttach = Email::where('email',Input::get('email'))->first();
			$attachTo = $toAttach->contatos()->where("contato_id" ,$contato_id)->getResults();

			if ($attachTo->count())
				return Response::json([
					"metadata"=> [
						"errors"=>1,
						"messages" => [ "email" => "Contato já possui este e-mail" ] 
					]
				]);

			$contato->emails()->attach($toAttach->id);			
		}

		return Response::json([
			"data" => $email,
			"metadata"=> [
				"errors"=>0,
				"total" => Contato::find($contato_id)->emails()->count()
			]
		]);

	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($contato_id, $email_id)
	{
		if (!($contato=Contato::find($contato_id)))
			return Response::json([
				"metadata" =>
				[
					"message" => ["contato" => "Contato não foi encontrado"],
					"errors" => 1
				]
			], 404);

		$email = $contato->emails()->where('email_id',$email_id)->get();
		$response = [
			'data' => $email->toArray(),
			'metadata' => [],
		];

		if ($email->count())
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
				"message" => ["email" => "Email não foi encontrado"],

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
	public function destroy($contato_id, $email_id)
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
				"modified" => $contato->emails()->detach($email_id),
				"errors" => 0
			]
		];

		$email = Email::find($email_id);
		if (!$email->contatos()->count())
			$email->delete();

		return Response::json($response, 200);
	}


	public function contatos($email_id)
	{
		if (is_numeric($email_id))
			$email = Email::find($email_id);
		else
		{
			$email = Email::where("email",$email);
			if (!$email->count())
			{
				return Response::json([
					'metadata' => [ 
						"errors" => 1,
						"message" => ["email" => "Email não foi encontrado"],
					]
				],404);
			}
			$email = $email->first();
		}

		$total = $email->contatos->count();
		$response["data"] = $email->contatos()->skip($offset=Input::get('offset', 0))->take($limit=Input::get('limit', 10))->get()->toArray();		
		$response['metadata'] = [
			"total" => $total,
			"found" => $found = count($response["data"]),
			"offset"=> intval($offset),
			"errors"=> 0
		];

		return Response::json($response,200);

	}
}