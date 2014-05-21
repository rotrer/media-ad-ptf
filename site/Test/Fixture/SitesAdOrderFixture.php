<?php
/**
 * SitesAdOrderFixture
 *
 */
class SitesAdOrderFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'sites_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'ad_orders_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => array('sites_id', 'ad_orders_id'), 'unique' => 1),
			'fk_sites_id_idx' => array('column' => 'sites_id', 'unique' => 0),
			'fk_orders_id_idx' => array('column' => 'ad_orders_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'sites_id' => 1,
			'ad_orders_id' => 1,
			'created' => '2014-05-21 18:07:35'
		),
	);

}
