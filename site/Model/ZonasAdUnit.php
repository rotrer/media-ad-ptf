<?php
App::uses('AppModel', 'Model');
/**
 * ZonasAdUnit Model
 *
 * @property Zonas $Zonas
 * @property AdUnits $AdUnits
 */
class ZonasAdUnit extends AppModel {

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
		'Zonas' => array(
			'className' => 'Zonas',
			'foreignKey' => 'zonas_id',
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
