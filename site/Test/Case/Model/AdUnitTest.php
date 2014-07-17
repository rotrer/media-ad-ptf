<?php
App::uses('AdUnit', 'Model');

/**
 * AdUnit Test Case
 *
 */
class AdUnitTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ad_unit',
		'app.line_item',
		'app.line_items_ad_unit',
		'app.zona',
		'app.sites',
		'app.zonas_ad_unit'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AdUnit = ClassRegistry::init('AdUnit');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AdUnit);

		parent::tearDown();
	}

}
