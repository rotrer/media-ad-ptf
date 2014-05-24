<?php
App::uses('AppController', 'Controller');
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
        'Auth' => array(
            'authenticate' => array('Form' => array('userModel' => 'User',
                                                    'fields' => array(
                                                                'username' => 'username',
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
    	$this->redirectUri = Configure::read('redirectUri');
    	$this->Auth->allow(array('oauth2callback'));
    	#$this->Auth->allow('*');
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
			#Encriptar pass
			$this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
			#Valores por defecto creación usuario
			$this->request->data['User']['first_login'] = 1;
			$this->request->data['User']['can_be_deleted'] = 1;

			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('Usuario guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Usuario no guardado, favor intentar nuevamente.'));
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

			$saveState = $this->User->save($this->request->data);
			#debug($saveState, $showHtml = null, $showFrom = true); die();
			if ($saveState) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
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
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
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
        			));
            	
            	if ($userData['User']['first_login'] == true) {
            		$this->redirect(array('action' => 'changepassword'));
            	}
                $this->call_oauth();
            } else {
                $this->Session->setFlash(__('Usuario o contraseña inválido, favor intentar nuevamente.'));
            }
        }

        if ($this->Auth->login()) {
        	$this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
        }
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
					$this->Session->setFlash(__('Contraseña actualizada correctamente..'));
					$this->Auth->logout();
        			$this->redirect(array('controller' => 'users', 'action' => 'login', 'admin' => true));
				} else {
					$this->Session->setFlash(__('La contraseña no ha sido actualizada, favor intentar nuevamente.'));
				}
				
    		} else {
    			$this->Session->setFlash(__('Las contraseñas no coinciden, favor intentar nuevamente.'));
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
 * auth callback method
 *
 * @throws ForbiddenException
 * @param none
 * @return void
 */
	public function oauth2callback() {
		$this->layout = 'ajax';
		if ($this->params->query['code']) {
			$code = $this->params->query['code'];
			/*
			*DFP
			*/
			$user = new DfpUser();
			$OAuth2Handler = $user->GetOAuth2Handler();
			$user->SetOAuth2Info( $OAuth2Handler->GetAccessToken($user->GetOAuth2Info(), $code, $this->redirectUri) );
			$dataUser = array(
					'google' => $user->GetOAuth2Info(),
					'id' => $this->Auth->user('id')
				);
			$this->Session->write('dataUser', $dataUser);
			if ($this->Session->check('redirect_url')) {
				$redirect_url = $this->Session->read('redirect_url');
				$this->Session->write('redirect_url', '');
				$this->redirect($redirect_url);
				exit();
			}

			if ($this->Auth->user('role') == 'admin' || $this->Auth->user('role') == 'user') {
        		$this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
        	} else {
        		$this->redirect('/dashboard');
        	}
		} else {
			throw new ForbiddenException(__('Sin código autorización'));
		}
		
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
			if ($this->Auth->login()) {
				$userData = $this->User->find('first', 
            		array(
            			'conditions' => array('User.id' => $this->Auth->user('id')),
            			'fields' => array('first_login')
        			));
            	
            	if ($userData['User']['first_login'] == true) {
            		$this->redirect(array('action' => 'changepassword'));
            	}
                $this->call_oauth();
            } else {
            	$this->Session->setFlash(__('Usuario o contraseña inválido, favor intentar nuevamente.'));
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
					$this->Session->setFlash(__('Contraseña actualizada correctamente..'));
					$this->Auth->logout();
        			$this->redirect('/');
				} else {
					$this->Session->setFlash(__('La contraseña no ha sido actualizada, favor intentar nuevamente.'));
				}
				
    		} else {
    			$this->Session->setFlash(__('Las contraseñas no coinciden, favor intentar nuevamente.'));
    		}
    	}
	}

/**
 * call_oauth method
 *
 * @throws NotFoundException
 * @param none
 * @return void
 */
	public function call_oauth(){
		/*
		*DFP
		*/
		$user = new DfpUser();
  		$offline = TRUE;
		$OAuth2Handler = $user->GetOAuth2Handler();
		$authorizationUrl = $OAuth2Handler->GetAuthorizationUrl(
			$user->GetOAuth2Info(), $this->redirectUri, $offline);
		header("Location: $authorizationUrl");
		exit();
	}
}
