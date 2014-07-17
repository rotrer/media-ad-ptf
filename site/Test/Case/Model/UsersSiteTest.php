<?php
App::uses('UsersSite', 'Model');

/**
 * UsersSite Test Case
 *
 */
class UsersSiteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.users_site',
		'app.users',
		'app.sites'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UsersSite = ClassRegistry::init('UsersSite');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UsersSite);

		parent::tearDown();
	}

}
