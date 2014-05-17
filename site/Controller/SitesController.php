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
class SitesController extends AppController {

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

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Site->recursive = 0;
		$this->set('sites', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Site->exists($id)) {
			throw new NotFoundException(__('Invalid site'));
		}
		$options = array('conditions' => array('Site.' . $this->Site->primaryKey => $id));
		$this->set('site', $this->Site->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Site->create();
			if ($this->Site->save($this->request->data)) {
				$this->Session->setFlash(__('The site has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The site could not be saved. Please, try again.'));
			}
		}
		#Generar token
		$users = $this->Site->User->find('list');
		$public_key = String::uuid();
		$this->set(compact('users', 'public_key'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Site->exists($id)) {
			throw new NotFoundException(__('Invalid site'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Site->save($this->request->data)) {
				$this->Session->setFlash(__('The site has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The site could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Site.' . $this->Site->primaryKey => $id));
			$this->request->data = $this->Site->find('first', $options);
		}
		$users = $this->Site->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Site->id = $id;
		if (!$this->Site->exists()) {
			throw new NotFoundException(__('Invalid site'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Site->delete()) {
			$this->Session->setFlash(__('The site has been deleted.'));
		} else {
			$this->Session->setFlash(__('The site could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
