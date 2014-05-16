<?php
App::uses('AppModel', 'Model');
/**
 * LineItem Model
 *
 * @property Orders $Orders
 * @property Creative $Creative
 */
class LineItem extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Orders' => array(
			'className' => 'Orders',
			'foreignKey' => 'orders_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Creative' => array(
			'className' => 'Creative',
			'joinTable' => 'line_items_creatives',
			'foreignKey' => 'line_item_id',
			'associationForeignKey' => 'creative_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
