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
		'app.orders',
		'app.creative',
		'app.line_items_creative'
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
