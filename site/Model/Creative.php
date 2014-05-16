<?php
App::uses('AppModel', 'Model');
/**
 * Creative Model
 *
 * @property LineItem $LineItem
 */
class Creative extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'LineItem' => array(
			'className' => 'LineItem',
			'joinTable' => 'line_items_creatives',
			'foreignKey' => 'creative_id',
			'associationForeignKey' => 'line_item_id',
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
