<?php
App::uses('Creative', 'Model');

/**
 * Creative Test Case
 *
 */
class CreativeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.creative',
		'app.line_item',
		'app.orders',
		'app.line_items_creative'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Creative = ClassRegistry::init('Creative');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Creative);

		parent::tearDown();
	}

}
