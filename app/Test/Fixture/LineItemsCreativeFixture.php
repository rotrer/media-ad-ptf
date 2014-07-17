<?php
/**
 * LineItemsCreativeFixture
 *
 */
class LineItemsCreativeFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'line_item_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'creative_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'status' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'line_item_id' => array('column' => 'line_item_id', 'unique' => 0),
			'creative_id' => array('column' => 'creative_id', 'unique' => 0)
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
			'line_item_id' => 1,
			'creative_id' => 1,
			'status' => 'Lorem ipsum dolor sit amet',
			'created' => 1
		),
	);

}
