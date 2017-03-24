<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class Test extends DuskTestCase
{
	use DatabaseMigrations;

	protected $user;

	public function setUp()
	{
		parent::setUp();
		$this->runDatabaseMigrations();

		$this->user = factory(App\User::class)->create([
			'name'  => 'John Doe',
			'email' => 'john@laravel.com'
		]);
	}
}