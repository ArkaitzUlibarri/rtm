<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigurationController extends Controller
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
     * Show the kpi configuration view.
     *
     * @return \Illuminate\Http\Response
     */
	public function index()
	{
		return view('configuration.index');
	}
}
