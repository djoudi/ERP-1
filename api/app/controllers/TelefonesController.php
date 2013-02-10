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
			"found" => count($response["data"]),
			"offset"=> intval($offset),
			"errors"=> 0
		];
		return Response::json($response,200);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($contato_id, $id)
	{
		return Telefone::find($id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		//
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