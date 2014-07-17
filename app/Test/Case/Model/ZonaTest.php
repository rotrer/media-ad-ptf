<?php
App::uses('Zona', 'Model');

/**
 * Zona Test Case
 *
 */
class ZonaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.zona',
		'app.sites',
		'app.ad_unit',
		'app.zonas_ad_unit'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Zona = ClassRegistry::init('Zona');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Zona);

		parent::tearDown();
	}

}
