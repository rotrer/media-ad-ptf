<?php
App::uses('AppModel', 'Model');
/**
 * UsersSite Model
 *
 * @property Users $Users
 * @property Sites $Sites
 */
class UsersSite extends AppModel {

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
		'Users' => array(
			'className' => 'Users',
			'foreignKey' => 'users_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Sites' => array(
			'className' => 'Sites',
			'foreignKey' => 'sites_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
