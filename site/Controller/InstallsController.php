<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Install Controller
 *
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class InstallsController extends AppController {
/**
* usa modelo User para registrar administrador
*/
	public $uses = array('User');
/**
* cargar comonente de autorización
*/
	public $components = array('Auth');

    public function beforeFilter(){
    	parent::beforeFilter();
    	$this->Auth->allow(array('index', 'create'));
    }
/**
 * index method
 *
 */
	public function index() {
		$usuarioAdmin = $this->User->find('first');
		if ($usuarioAdmin) {
			$this->Session->setFlash(__('Sistema instalado, contactese con el administrador'));
			$this->redirect('/');
		}
	}

/**
 * create method
 *
 */
	public function create() {
		if ($this->request->is('post')) {
			$data = $this->request->data['Install'];
			if (!$this->User->findByUsername($data['username'])) {
				$data['password'] =  AuthComponent::password($data['password']);
				$data['role'] = 'admin';
				$data['state'] = 'activo';
				$data['first_login'] = 1;
				$this->User->create();
				if ($this->User->save($data)) {

					$Email = new CakeEmail();
					$Email->from(array('admin@mediatrends.cl' => 'Media Ads'));
					$Email->emailFormat('html');
					$Email->to($data['email']);
					$Email->subject('Acceso Mediatrends Ads');
					$Email->send('<h2>Bienvenido a Mediatrends Ads</h2><h4>Tu acceso es:</h4><p>Sitio: '.Router::url('/', true).' </br>Usuario: '.$data['username'].' </br>Contraseña: (la contraseña que ingresaste)) </br></p><p>Recuerda que la primera vez que entres te pedira cambiar tu contraseña.</p>');

					$this->Session->setFlash(__('Usuario creado correctamente.'));
					return $this->redirect(array('action' => 'congrats'));
				} else {
					$this->Session->setFlash(__('El usuario no ha sido creado, favor intentar nuevamente.'));
				}
			} else {
				$this->Session->setFlash(__('Sistema instalado, contactese con el administrador'));
				$this->redirect('/');
			}
		} else {
	        throw new BadRequestException('Petición no válida');
		}
	}
}