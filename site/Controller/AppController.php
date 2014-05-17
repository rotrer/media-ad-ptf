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
App::import('Vendor', 'DfpUser', array('file' => 'googleads-php-lib'.DS.'src'.DS.'Google'.DS.'Api'.DS.'Ads'.DS.'Dfp'.DS.'Lib'.DS.'DfpUser.php'));
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
    }

	public function isAuthorized($user) {
        // Admin can access every action
        if ($user['state'] === 'activo') {
            return true;
        }

        // Default deny
        $this->Session->setFlash(__('Acceso no autorizado'));
        $this->Session->destroy();
        if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
            $this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => true));
        } else {
            $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
        }
        return false;
    }

    public function instanceDfp() {
        if ($this->Session->check('dataUser')) {
            $dataUser = $this->Session->read('dataUser');
            $dataUser = $dataUser['google'];
        } else {
            $dataUser = NULL;
        }
        return new DfpUser(NULL, NULL, NULL, NULL, NULL, NULL, NULL, $dataUser);
    }
}
