<?php
App::uses('AppModel', 'Model');
/**
 * LitemsAdunit Model
 *
 * @property LineItems $LineItems
 * @property AdUnits $AdUnits
 */
class LitemsAdunit extends AppModel {

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
		'LineItems' => array(
			'className' => 'LineItems',
			'foreignKey' => 'line_items_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'AdUnits' => array(
			'className' => 'AdUnits',
			'foreignKey' => 'ad_units_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
