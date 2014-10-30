<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');
App::import('Vendor', 'DfpUser', array('file' => 'googleads-lib'.DS.'src'.DS.'Google'.DS.'Api'.DS.'Ads'.DS.'Dfp'.DS.'Lib'.DS.'DfpUser.php'));
App::import('Vendor', 'DateTimeUtils', array('file' => 'googleads-lib'.DS.'src'.DS.'Google'.DS.'Api'.DS.'Ads'.DS.'Dfp'.DS.'Util'.DS.'DateTimeUtils.php'));
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package     app.Controller
 * @link        http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $uses = array('Sessions');

		public function beforeFilter() {
				if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
						$this->layout = 'admin';
				} 
		}
		public function beforeRender() {
			if ($this->request->params['controller'] != 'installs') {
					$this->loadModel('User');
					$usuarioAdmin = $this->User->find('first', array(
									'conditions' => array('User.role = ' => 'admin')
							));
					if (!$usuarioAdmin) {
							$this->redirect(array('controller' => 'installs', 'action' => 'index', 'admin' => false));
					}
			}
			$this->set('networksAds', $this->Session->read('networksAds'));
			$this->set('networksAdsSelected', $this->Session->read('networksAdsSelected'));
		}

	public function isAuthorized($user) {
				if ($user['state'] === 'activo') {
						if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
								switch ($user['role']) {
										case 'user':
												$menuAdminAccess = array(
																'users' => 0,
																'sites' => 1,
																'zonas' => 1,
																'adunits' => 1
														);
												break;
										// case 'client':
										// 		$menuAdminAccess = array();
										// 		break;
										default:
												// Admin can access every action
												$menuAdminAccess = array(
																'users' => 1,
																'sites' => 1,
																'zonas' => 1,
																'adunits' => 1
														);
												break;
								}
								$this->set('menuAdminAccess',$menuAdminAccess);
						}
						return true;
				}

				// Default deny
				$this->Session->setFlash(__('Acceso no autorizado'));
				$this->Auth->logout();
				if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
						$this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => true));
				} else {
						$this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
				}
				return false;
		}

		public function instanceDfp() {
				// if ($this->Session->check('dataUser')) {
				// 		$dataUser = $this->Session->read('dataUser');
				// 		$dataUser = $dataUser['google'];
				// } else {
				// 		$dataUser = NULL;
				// }

				$networksSelected =  ($this->Session->check('networksAdsSelected')) ? $this->Session->read('networksAdsSelected') : NULL;
				return new DfpUser(Configure::read('pathAuthIni'), NULL, NULL, NULL, $networksSelected, NULL, NULL, NULL);
		}
}
