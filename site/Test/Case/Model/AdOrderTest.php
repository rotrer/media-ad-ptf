<?php
App::uses('AdOrder', 'Model');

/**
 * AdOrder Test Case
 *
 */
class AdOrderTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ad_order',
		'app.site',
		'app.sites_ad_order',
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
		$this->AdOrder = ClassRegistry::init('AdOrder');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AdOrder);

		parent::tearDown();
	}

}
