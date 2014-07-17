<?php
/**
 * LineItemsAdUnitFixture
 *
 */
class LineItemsAdUnitFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'line_items_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'ad_units_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => array('line_items_id', 'ad_units_id'), 'unique' => 1),
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
			'line_items_id' => 1,
			'ad_units_id' => 1,
			'created' => '2014-05-21 19:16:49'
		),
	);

}
