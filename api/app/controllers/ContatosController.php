<?php

class ContatosController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		var_export(func_get_args());
		return;
		$total = Contato::count();
		$contatos = Contato::skip($offset=Input::get('offset', 0))->take($limit=Input::get('limit', 10))->get();



		if (($found = count($contatos)) < $total)
		{
			header(sprintf("Content-Range: token %d-%d/%d",$offset, $offset+$found, $total));
			$code = 206;
		}
		else
			$code = 200;


		return Response::json([
			'errors' => 0,
			'data' => $contatos->toArray()
		],$code);




$response->headers->set('Content-Type', $value);

return $response;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(
		    array('name' => 'Dayle'),
		    array('name' => array('required', 'min:5'))
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($id)
	{
		return Contato::find($id);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}