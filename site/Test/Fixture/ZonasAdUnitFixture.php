<?php
/**
 * ZonasAdUnitFixture
 *
 */
class ZonasAdUnitFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'zonas_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'ad_units_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => array('zonas_id', 'ad_units_id'), 'unique' => 1),
			'index2' => array('column' => 'zonas_id', 'unique' => 0),
			'index3' => array('column' => 'ad_units_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'zonas_id' => 1,
			'ad_units_id' => 1,
			'created' => '2014-05-21 19:16:05'
		),
	);

}
