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
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'zonas_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'ad_units_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
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
			'id' => 1,
			'zonas_id' => 1,
			'ad_units_id' => 1,
			'created' => '2014-05-16 09:56:09'
		),
	);

}
