<?php
App::uses('LineItemsAdUnit', 'Model');

/**
 * LineItemsAdUnit Test Case
 *
 */
class LineItemsAdUnitTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.line_items_ad_unit',
		'app.line_items',
		'app.ad_units'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LineItemsAdUnit = ClassRegistry::init('LineItemsAdUnit');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LineItemsAdUnit);

		parent::tearDown();
	}

}
