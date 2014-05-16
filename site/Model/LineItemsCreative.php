<?php
App::uses('AppModel', 'Model');
/**
 * LineItemsCreative Model
 *
 * @property LineItem $LineItem
 * @property Creative $Creative
 */
class LineItemsCreative extends AppModel {

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
		'LineItem' => array(
			'className' => 'LineItem',
			'foreignKey' => 'line_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creative' => array(
			'className' => 'Creative',
			'foreignKey' => 'creative_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
