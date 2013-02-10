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

		$total = Contato::count();
		$response["data"] = Contato::skip($offset=Input::get('offset', 0))->take($limit=Input::get('limit', 10))->get()->toArray();
		$response['metadata'] = [
			"total" => $total,
			"found" => count($response["data"]),
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