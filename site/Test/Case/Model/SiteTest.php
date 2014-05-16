<?php
App::uses('Site', 'Model');

/**
 * Site Test Case
 *
 */
class SiteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.site',
		'app.user',
		'app.users_site'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Site = ClassRegistry::init('Site');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Site);

		parent::tearDown();
	}

}
