<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlarmController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the alarms view.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('alarms.index');
	}
}
