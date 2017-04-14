<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
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
	 * Show the user.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$users = User::orderBy('name', 'asc')->paginate(10);

		return view('users.index', compact('users'));
	}

	public function edit(User $user)
	{
		return view('users.edit', compact('user'));
	}

	public function update(Request $request, $id)
	{
		$user = User::findOrFail($id);

		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users,email,' . $id,
			'role' => 'required',
		]);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator);
		}

		$user->fill($request->all());
		$user->save();

		return redirect('users')
			->with('message', 'User is successfully Updated!')
			->withInput();
	}

}
