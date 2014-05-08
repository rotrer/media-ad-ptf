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

	public function isAuthorized($user) {
        // Admin can access every action
        if ($user['state'] === 'activo') {
            return true;
        }

        // Default deny
        $this->Session->setFlash(__('Acceso no autorizado'));
        $this->Session->destroy();
        $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
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
