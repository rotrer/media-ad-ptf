<?php
/**
 * LitemsAdunitFixture
 *
 */
class LitemsAdunitFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'line_items_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'ad_units_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'line_items_id' => array('column' => 'line_items_id', 'unique' => 0),
			'ad_units_id' => array('column' => 'ad_units_id', 'unique' => 0)
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
			'line_items_id' => 1,
			'ad_units_id' => 1,
			'created' => '2014-05-16 10:01:20'
		),
	);

}
