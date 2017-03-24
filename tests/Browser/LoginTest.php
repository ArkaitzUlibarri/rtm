<?php

namespace Tests\Browser;

use Tests\Browser\Test;

class LoginTest extends Test
{
	/**
	 * Login failed
	 *
	 * @return void
	 */ 
	public function test_login_fail()
	{
		$user = $this->user;

		$this->browse(function ($browser) use ($user) {
			$browser->visit('/login')
					->assertSee('Login')
					->type('email', $user->email)
					->type('password', 'incorrect passwod')
					->press('Login')
					->assertPathIs('/login')
					->assertSee('These credentials do not match our records.');
		});
	}

	/**
	 * Login successful
	 *
	 * @return void
	 */
	public function test_login_success()
	{
		$user = $this->user;

		$this->browse(function ($browser) use ($user) {
			$browser->visit('/login')
					->assertSee('Login')
					->type('email', $user->email)
					->type('password', 'secret')
					->press('Login')
					->assertPathIs('/')
					->assertSee($user->name);
		});
	}

	/**
	 * Authenticated user cant sign in again
	 *
	 * @return void
	 */ 
	public function test_authenticated_user_doesnt_see_login()
	{
		$this->browse(function ($browser) {
			$browser->assertDontSee('Login')
					->visit('/login')
					->assertPathIs('/');
		});
	}

	/**
	 * Logout
	 *
	 * @return void
	 */ 
	public function test_logout()
	{
		$user = $this->user;

		$this->browse(function ($browser) use ($user) {
			$browser->clickLink($user->name)
					->clickLink('Logout')
					->assertPathIs('/')
					->assertSee('Login');
		});
	}
}
