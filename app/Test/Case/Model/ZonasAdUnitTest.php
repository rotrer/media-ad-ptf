<?php
App::uses('ZonasAdUnit', 'Model');

/**
 * ZonasAdUnit Test Case
 *
 */
class ZonasAdUnitTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.zonas_ad_unit',
		'app.zonas',
		'app.ad_units'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ZonasAdUnit = ClassRegistry::init('ZonasAdUnit');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ZonasAdUnit);

		parent::tearDown();
	}

}
