<?php
App::uses('AppModel', 'Model');
/**
 * PluginsAdOrder Model
 *
 * @property Plugins $Plugins
 * @property AdOrders $AdOrders
 */
class PluginsAdOrder extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Plugins' => array(
			'className' => 'Plugins',
			'foreignKey' => 'plugins_id',
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
