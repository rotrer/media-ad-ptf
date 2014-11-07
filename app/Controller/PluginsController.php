<?php
App::uses('AppController', 'Controller');
App::uses('String', 'Utility');
/**
 * Sites Controller
 *
 * @property Site $Site
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PluginsController extends AppController {

/**
 * Models
 *
 * @var array
 */
	public $uses = array('Site', 'User', 'AdOrder', 'LineItem', 'SitesAdOrder', 'Zona');
 /**
 * Components
 *
 * @var array
 */
	public $components = array(
        'Paginator',
        'Auth' => array(
            'authenticate' => array('Form' => array('userModel' => 'User',
                                                    'fields' => array(
                                                                'username' => 'username',
                                                                'password' => 'password'
                                                                )
                                                    )
                                    ),
            'loginRedirect' => "",
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login', 'admin' => true),
            'authorize' => array('Controller')
        )
    );

	public function beforeRender(){
		parent::beforeRender();
		$this->set('activePluginsMenu', true);
	}

	public function admin_index() {

	}
}