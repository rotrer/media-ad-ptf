<?php
App::uses('LineItemsCreative', 'Model');

/**
 * LineItemsCreative Test Case
 *
 */
class LineItemsCreativeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.line_items_creative',
		'app.line_item',
		'app.orders',
		'app.creative'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LineItemsCreative = ClassRegistry::init('LineItemsCreative');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LineItemsCreative);

		parent::tearDown();
	}

}
