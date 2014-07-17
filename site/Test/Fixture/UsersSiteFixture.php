<?php
/**
 * UsersSiteFixture
 *
 */
class UsersSiteFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'users_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'sites_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'sites_id' => array('column' => 'sites_id', 'unique' => 0),
			'users_id' => array('column' => 'users_id', 'unique' => 0)
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
			'users_id' => 1,
			'sites_id' => 1,
			'created' => '2014-05-16 09:50:37'
		),
	);

}
