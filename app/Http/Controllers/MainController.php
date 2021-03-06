<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
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
	 * Show the filter kpis view.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('main.index');
	}
}
