<?php
App::uses('LitemsAdunit', 'Model');

/**
 * LitemsAdunit Test Case
 *
 */
class LitemsAdunitTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.litems_adunit',
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
		$this->LitemsAdunit = ClassRegistry::init('LitemsAdunit');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LitemsAdunit);

		parent::tearDown();
	}

}
