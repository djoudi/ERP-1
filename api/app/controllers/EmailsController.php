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
			$response["data"] = Contato::find($contato_id)
				->emails()
				->skip($offset=Input::get('offset', 0))
				->take($limit=Input::get('limit', 10))
				->get()
				->toArray();
		}
		else
		{
			$total = Email::count();
			$response["data"] = Email::skip($offset=Input::get('offset', 0))
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
					"total"		=> $contato->emails()->count(),
				]
			],404);
		
		$defaults = [
			"identificacao" => "email",
			"numero" => "email@email.com",
		];

		if (!($inputs = Input::all()))
			$inputs = objectToArray(Input::json());

		$inputs = array_intersect_key($inputs, $defaults);

		$validator = Validator::make($inputs,
		    [
			    'identificacao' => 'required',
		    	'email' => ['required', 'email']
		    ]);

		if ($validator->fails())
		{
			return Response::json([ "metadata" => [
				"errors"	=> count($messages = $validator->messages()->toArray()),
				"found"		=> 0,
				"messages"	=> $messages,
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> $contato->emails()->count(),
			]],400);
		}

		$email = $contato->emails()->where('email',$inputs['email']);
		if ($email->count())
			return Response::json([
				"data" => $email->first()->toArray(),
				"metadata"=> [
					"errors"	=> 1,
					"found"		=> 1,
					"messages"	=> [
						"email" => "Email já pertencente ao contato"
					],
					"modified"	=> 0,
					"offset"	=> 0,
					"total"		=> $contato->emails()->count(),
				]
			],303);

		$contato->emails()->save(
			$email = new Email( $inputs )
		);

		return Response::json([
			"data" => $email->toArray(),
			"metadata"=> [
				"errors"	=> 0,
				"found"		=> 1,
				"modified"	=> 1,
				"offset"	=> 0,
				"total"		=> $contato->emails()->count(),
			]
		],200);

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
					"errors" => 1,
					"found"	 => 1,
					"messages" => [
						"contato" => "Contato não foi encontrado"
					],
					"modified"	=> 0, 
					"offset" => 0,
					"total"  => $contato->emails()->count(),
				]
			], 404);

		$email = $contato->emails()->find($email_id);

		if ($email)
			return Response::json([
				'data' => $email->toArray(),
				'metadata' => [
					"errors" 	=> 0,
					"found"	 	=> 1,
					"offset" 	=> 0,
					"total"  	=> $contato->emails()->count(),
					'modified'	=> 1, 
				]
			], 200);
		else
			return Response::json([
				'metadata' => [
					"errors" 	=> 1,
					"found"	 	=> 0,
					"offset" 	=> 0,
					"total"  	=> $contato->emails()->count(),
					"messages" 	=> [
						"email" => "Email não foi encontrado"
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
	public function update($contato_id, $email_id)
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
					"total"  => $contato->emails()->count(),
				]
			], 404);


		if (!($email = $contato->emails()->find($email_id)))
			return Response::json([
				'metadata' => [
					"errors" 	=> 1,
					"found"	 	=> 0,
					"offset" 	=> 0,
					"total"  	=> $contato->emails()->count(),
					"messages" 	=> [
						"email" => "Email não foi encontrado"
					],
					"modified" 	=> 1, 
				]
			], 404 );


		$defaults = [
			"identificacao" => "email",
			"numero" => "email@email.com",
		];

		if (!($inputs = Input::all()))
			$inputs = objectToArray(Input::json());

		$inputs = array_intersect_key($inputs, $defaults);

		$validator = Validator::make($inputs,
		    [
			    'identificacao' => 'required',
		    	'email' => ['required', 'email']
		    ]);

		if ($validator->fails())
		{
			return Response::json([ "metadata" => [
				"errors"	=> count($messages = $validator->messages()),
				"found"		=> 0,
				"messages"	=> $validator->messages()->toArray(),
				"modified"	=> 0,
				"offset"	=> 0,
				"total"		=> $contato->emails()->count(),
			]],400);
		}

		
		foreach($inputs as $attribute=>$value)
			$email->{$attribute} = $value;

		$email->save();

		return Response::json([
			'data' => $email->toArray(),
			'metadata' => [
				"errors" 	=> 0,
				"found"	 	=> 1,
				"offset" 	=> 0,
				"total"  	=> $contato->emails()->count(),
				'modified'	=> 1 
			]
		], 200 );
	
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
					"found"		=> 0,
					"total"		=> $contato->emails()->count(),
					"offset" 	=> 0,
					"errors"	=> 1,
					"messages"	=> [
						"contato" => "Contato não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404);

		$email = $contato->emails()->find($email_id);


		if ($email)
			return Response::json([
				"data" => $email->toArray(),
				"metadata" =>
				[
					"modified"	=> $x = $email->delete(),
					"found"		=> $x,
					"offset"	=> 0,
					"total"		=> $contato->emails()->count(),
					"errors"	=> 0,
				]
			], 200);

		else
			return Response::json([
				'metadata' => [
					"errors" 	=> 1,
					"found"	 	=> 0,
					"offset" 	=> 0,
					"total"  	=> $contato->emails()->count(),
					"messages" 	=> [
						"email" => "Email não foi encontrado"
					],
					"modified" 	=> 0, 
				]
			], 404 );
	}
}