<?php
/**
 * ZonaFixture
 *
 */
class ZonaFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'id_tag_template' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sites_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'crreated' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'sites_id' => array('column' => 'sites_id', 'unique' => 0),
			'sites_id_2' => array('column' => 'sites_id', 'unique' => 0)
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
			'name' => 'Lorem ipsum dolor sit amet',
			'id_tag_template' => 'Lorem ipsum dolor sit amet',
			'sites_id' => 1,
			'crreated' => '2014-05-21 16:12:47'
		),
	);

}
