<?php
App::uses('SitesAdOrder', 'Model');

/**
 * SitesAdOrder Test Case
 *
 */
class SitesAdOrderTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sites_ad_order',
		'app.sites',
		'app.ad_orders'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SitesAdOrder = ClassRegistry::init('SitesAdOrder');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SitesAdOrder);

		parent::tearDown();
	}

}
