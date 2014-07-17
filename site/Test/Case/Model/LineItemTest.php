<?php
App::uses('LineItem', 'Model');

/**
 * LineItem Test Case
 *
 */
class LineItemTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.line_item',
		'app.ad_orders',
		'app.ad_unit',
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
		$this->LineItem = ClassRegistry::init('LineItem');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LineItem);

		parent::tearDown();
	}

}
