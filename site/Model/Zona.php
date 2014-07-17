<?php
App::uses('AppModel', 'Model');
/**
 * Zona Model
 *
 * @property Sites $Sites
 * @property AdUnit $AdUnit
 */
class Zona extends AppModel {

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
		'Sites' => array(
			'className' => 'Sites',
			'foreignKey' => 'sites_id',
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
		'AdUnit' => array(
			'className' => 'AdUnit',
			'joinTable' => 'zonas_ad_units',
			'foreignKey' => 'zonas_id',
			'associationForeignKey' => 'ad_units_id',
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
