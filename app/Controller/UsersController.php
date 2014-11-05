<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class UsersController extends AppController {

/**
*	Url redireccion oAuth 2.0
*/
	private $redirectUri = '';
/**
 * Components
 *
 * @var array
 */
	public $components = array(
			'Paginator',
			'Password',
			// 'MathCaptcha' => array('timer' => 3, 'tabsafe' => true),
			'Auth' => array(
					'authenticate' => array('Form' => array('userModel' => 'User',
																									'fields' => array(
																															'username' => 'email',
																															'password' => 'password'
																													)
																									)
																	),
					'loginRedirect' => "",
					'logoutRedirect' => "",
					#'logoutRedirect' => array('controller' => 'users', 'action' => 'login', 'admin' => true),
					'authorize' => array('Controller')
			)
	);

	public function beforeFilter(){
		parent::beforeFilter();
		// $this->redirectUri = Router::url(array('controller' => 'users', 'action' => 'oauth2callback', 'admin' => false), true);
		// $this->Auth->allow(array('oauth2callback'));
		#$this->Auth->allow('*');
	}

	public function beforeRender(){
		parent::beforeRender();
		$this->set('activeUsersMenu', true);
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->User->create();
			#Asignar email como como username
			$this->request->data['User']['username'] = str_replace(array("@","-",".","_"), "", $this->request->data['User']['email']);
			#Generar y Encriptar password
			$new_pass = $this->Password->generatePassword();
			$this->request->data['User']['password'] = AuthComponent::password($new_pass);
			#Valores por defecto creación usuario
			$this->request->data['User']['first_login'] = 1;
			$this->request->data['User']['can_be_deleted'] = 1;
			
			if ($this->User->save($this->request->data)) {
				$Email = new CakeEmail();
				$Email->from(array('admin@mediatrends.cl' => 'Media Ads'));
				$Email->emailFormat('html');
				$Email->to($this->request->data['User']['email']);
				$Email->subject('Acceso Media Ads');
				$Email->send('<h2>Bienvenido a Mediatrends Ads</h2><h4>Tu acceso es:</h4><p>Sitio: '.Router::url('/', true).' </br>Usuario: ' . $this->request->data['User']['email'] . ' </br>Contraseña: ' . $new_pass . ' </br></p><p>Recuerda que la primera vez que entres te pedira cambiar tu contraseña.</p>');
				
				$this->Session->setFlash(__('Usuario guardado correctamente.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Usuario no guardado, favor intentar nuevamente.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ( empty($this->request->data['User']['password']) ) {
				unset($this->request->data['User']['password']);
			}
			if (isset($this->request->data['enviar'])) unset($this->request->data['enviar']);

			$saveState = $this->User->save($this->request->data);
			// $log = $this->User->getDataSource()->getLog(false, false);
			// debug($log); die();
			if ($saveState) {
				$this->Session->setFlash(__('Usuario editado correctamente.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Usuario no editado, favor intentar nuevamente.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('Usuario eliminado correctamente.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('Usuario no eliminado, favor intentar nuevamente.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin login method
 *
 * @throws NotFoundException
 * @param none
 * @return void
 */
	public function admin_login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$userData = $this->User->find('first', 
					array(
						'conditions' => array('User.id' => $this->Auth->user('id')),
						'fields' => array('first_login')
					)
				);
				
				if ($userData['User']['first_login'] == true) {
					$this->redirect(array('action' => 'changepassword'));
				}

				if ($this->Auth->user('role') == 'admin' || $this->Auth->user('role') == 'user') {
					$this->redirect(array('controller' => 'users', 'action' => 'network', 'admin' => true));
				} else {
					$this->Session->setFlash(__('Acceso denegado.'), 'default', array('class' => 'alert alert-danger'));
					$this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => true));
				}
			} else {
					$this->Session->setFlash(__('Usuario o contraseña inválido, favor intentar nuevamente.'), 'default', array('class' => 'alert alert-danger'));
			}
		}

		if ($this->Auth->login()) {
			$this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
		}
		// $this->set('captcha', $this->MathCaptcha->getCaptcha());
		// $this->set('captcha_result', $this->MathCaptcha->getResult());
	}

/**
 * admin_changepassword method
 *
 * @throws NotFoundException
 * @param none
 * @return void
 */
	public function admin_changepassword() {
		if ($this->request->is('post')) {
			if ($this->request->data['User']['nueva_pass'] == $this->request->data['User']['nueva_pass_r']) {
				$this->User->id = $this->Auth->user('id');
				$dataPass = array('password' => AuthComponent::password($this->request->data['User']['nueva_pass']), 'first_login' => 0);
				if ($this->User->save($dataPass, false)) {
					$this->Session->setFlash(__('Contraseña actualizada correctamente.'), 'default', array('class' => 'alert alert-success'));
					$this->Auth->logout();
					$this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => true));
				} else {
					$this->Session->setFlash(__('La contraseña no ha sido actualizada, favor intentar nuevamente.'), 'default', array('class' => 'alert alert-danger'));
				}
			} else {
				$this->Session->setFlash(__('Las contraseñas no coinciden, favor intentar nuevamente.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
	}

/**
 * admin logout method
 *
 * @throws none
 * @param none
 * @return void
 */
	public function admin_logout() {
			$this->Auth->logout();
			$this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => true));
	}

	/**
 * admin logout method
 *
 * @throws none
 * @param none
 * @return void
 */
	public function admin_network() {
		/*
		*
		* Obtener networks de cliente logeado
		*/
		/*
		*DFP
		*/
		// Log SOAP XML request and response.
		$this->instanceDfp()->LogDefaults();

		// Get the NetworkService.
		$networkService = $this->instanceDfp()->GetService('NetworkService', 'v201403');

		// Get all networks that you have access to with the current login
		// credentials.
		$networks = $networkService->getAllNetworks();
		if (isset($networks)) {
				$networksArr = array();
				foreach ($networks as $network) {
					$networksArr[$network->networkCode] = $network->displayName;
				}
		}
		$this->Session->write('networksAds', $networksArr);
		$this->set('networks', $networks);
	}


/**
 * login method
 *
 * @throws NotFoundException
 * @param none
 * @return void
 */
	public function login() {
		if ($this->request->is('post')) {
			// var_dump(AuthComponent::password("media_2014")); die();
			if ($this->Auth->login()) {
				$userData = $this->User->find('first', 
					array(
						'conditions' => array('User.id' => $this->Auth->user('id')),
						'fields' => array('first_login')
				));

				if ($userData['User']['first_login'] == true) {
					$this->redirect(array('action' => 'changepassword'));
				}

				/*
				*
				* Obtener networks de cliente logeado
				*/
				/*
				*DFP
				*/
				// Log SOAP XML request and response.
				$this->instanceDfp()->LogDefaults();

				// Get the NetworkService.
				$networkService = $this->instanceDfp()->GetService('NetworkService', 'v201403');

				// Get all networks that you have access to with the current login
				// credentials.
				$networks = $networkService->getAllNetworks();
				if (isset($networks)) {
						$networksArr = array();
						foreach ($networks as $network) {
							$networksArr[$network->networkCode] = $network->displayName;
						}
				}
				$this->Session->write('networksAds', $networksArr);

				if ($this->Auth->user('role') == 'admin' || $this->Auth->user('role') == 'user') {
					$this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
				} else {
					$this->redirect('/dashboard');
				}
			} else {
				$this->Session->setFlash(__('Usuario o contraseña inválido, favor intentar nuevamente.'), 'default', array('class' => 'alert alert-danger'));
				$this->redirect('/');
			}
		} else {
			throw new BadRequestException('Petición no válida');
		}
	}

/**
 * changepassword method
 *
 * @throws NotFoundException
 * @param none
 * @return void
 */
		public function changepassword() {
			if ($this->request->is('post')) {
				if ($this->request->data['User']['nueva_pass'] == $this->request->data['User']['nueva_pass_r']) {
					$this->User->id = $this->Auth->user('id');
				$dataPass = array('password' => AuthComponent::password($this->request->data['User']['nueva_pass']), 'first_login' => 0);
				if ($this->User->save($dataPass, false)) {
					$this->Session->setFlash(__('Contraseña actualizada correctamente.'), 'default', array('class' => 'alert alert-success'));
					$this->Auth->logout();
							$this->redirect('/');
				} else {
					$this->Session->setFlash(__('La contraseña no ha sido actualizada, favor intentar nuevamente.'), 'default', array('class' => 'alert alert-danger'));
				}
				
				} else {
					$this->Session->setFlash(__('Las contraseñas no coinciden, favor intentar nuevamente.'), 'default', array('class' => 'alert alert-danger'));
				}
			}
	}

/**
 * call_oauth method [DEPRECATED], se reemplaza metodo de autenticacion
 *
 * @throws NotFoundException
 * @param none
 * @return void
 */
	// public function call_oauth(){
	// 	/*
	// 	*DFP
	// 	*/
	// 	$user = new DfpUser(Configure::read('pathAuthIni'));
	// 		$offline = TRUE;
	// 	$OAuth2Handler = $user->GetOAuth2Handler();
	// 	$authorizationUrl = $OAuth2Handler->GetAuthorizationUrl(
	// 		$user->GetOAuth2Info(), $this->redirectUri, $offline);
	// 	header("Location: $authorizationUrl");
	// 	exit();
	// }

/**
 * auth callback method [DEPRECATED], se reemplaza metodo de autenticacion
 *
 * @throws ForbiddenException
 * @param none
 * @return void
 */
	// public function oauth2callback() {
	// 	$this->layout = 'ajax';
	// 	if ($this->params->query['code']) {
	// 		$code = $this->params->query['code'];
	// 		/*
	// 		*DFP
	// 		*/
	// 		$user = new DfpUser(Configure::read('pathAuthIni'));
	// 		$OAuth2Handler = $user->GetOAuth2Handler();
	// 		$user->SetOAuth2Info( $OAuth2Handler->GetAccessToken($user->GetOAuth2Info(), $code, $this->redirectUri) );
	// 		$dataUser = array(
	// 				'google' => $user->GetOAuth2Info(),
	// 				'id' => $this->Auth->user('id')
	// 			);
	// 		$this->Session->write('dataUser', $dataUser);
	// 		if ($this->Session->check('redirect_url')) {
	// 			$redirect_url = $this->Session->read('redirect_url');
	// 			$this->Session->write('redirect_url', '');
	// 			$this->redirect($redirect_url);
	// 			exit();
	// 		}

	// 		/*
	// 		*
	// 		* Obtener networks de cliente logeado
	// 		*/
	// 		/*
	// 		*DFP
	// 		*/
	// 		// Log SOAP XML request and response.
	// 		$this->instanceDfp()->LogDefaults();

	// 		// Get the NetworkService.
	// 		$networkService = $this->instanceDfp()->GetService('NetworkService', 'v201403');

	// 		// Get all networks that you have access to with the current login
	// 		// credentials.
	// 		$networks = $networkService->getAllNetworks();
	// 		if (isset($networks)) {
	// 				$networksArr = array();
	// 				foreach ($networks as $network) {
	// 					$networksArr[$network->networkCode] = $network->displayName;
	// 				}
	// 		}
	// 		$this->Session->write('networksAds', $networksArr);

	// 		if ($this->Auth->user('role') == 'admin' || $this->Auth->user('role') == 'user') {
	// 			$this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
	// 		} else {
	// 			$this->redirect('/dashboard');
	// 		}
	// 	} else {
	// 		throw new ForbiddenException(__('Sin código autorización'));
	// 	}
		
	// }

/**
 * admin_checkemail method
 *
 * @throws NotFoundException
 * @param throw POST request
 * @return void
 */
	public function admin_checkemail(){
		$this->layout = 'ajax';
		$response = 999;
		if ($this->request->is('post')) {
			$countEmail =  $this->User->find('count', array('conditions' => array('User.email' => $this->request->data['email'])));
			if (!$countEmail) {
				$response = 1;
			}
		}
		echo $response;
	}
}
