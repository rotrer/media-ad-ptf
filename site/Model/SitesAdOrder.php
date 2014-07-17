<?php
App::uses('AppModel', 'Model');
/**
 * SitesAdOrder Model
 *
 * @property Sites $Sites
 * @property AdOrders $AdOrders
 */
class SitesAdOrder extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'sites_id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Sites' => array(
			'className' => 'Sites',
			'foreignKey' => 'sites_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'AdOrders' => array(
			'className' => 'AdOrders',
			'foreignKey' => 'ad_orders_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
