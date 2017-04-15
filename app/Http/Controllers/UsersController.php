<?php

namespace App\Http\Controllers;

use App\User;
use App\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
	protected $userRepository;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(UserRepository $userRepository)
	{
		$this->middleware('auth');

		$this->userRepository = $userRepository;
	}

	/**
	 * Show the user.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$users = $this->userRepository->search($request->all(), true);

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
