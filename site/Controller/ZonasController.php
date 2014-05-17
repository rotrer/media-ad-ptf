<?php
App::uses('AppController', 'Controller');
/**
 * Zonas Controller
 *
 * @property Zona $Zona
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ZonasController extends AppController {

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
		$this->Zona->recursive = 0;
		$this->set('zonas', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Zona->exists($id)) {
			throw new NotFoundException(__('Invalid zona'));
		}
		$options = array('conditions' => array('Zona.' . $this->Zona->primaryKey => $id));
		$this->set('zona', $this->Zona->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Zona->create();
			if ($this->Zona->save($this->request->data)) {
				$this->Session->setFlash(__('The zona has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The zona could not be saved. Please, try again.'));
			}
		}
		$sites = $this->Zona->Site->find('list');
		$adUnits = $this->Zona->AdUnit->find('list');
		$this->set(compact('sites', 'adUnits'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Zona->exists($id)) {
			throw new NotFoundException(__('Invalid zona'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Zona->save($this->request->data)) {
				$this->Session->setFlash(__('The zona has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The zona could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Zona.' . $this->Zona->primaryKey => $id));
			$this->request->data = $this->Zona->find('first', $options);
		}
		$sites = $this->Zona->Site->find('list');
		$adUnits = $this->Zona->AdUnit->find('list');
		$this->set(compact('sites', 'adUnits'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Zona->id = $id;
		if (!$this->Zona->exists()) {
			throw new NotFoundException(__('Invalid zona'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Zona->delete()) {
			$this->Session->setFlash(__('The zona has been deleted.'));
		} else {
			$this->Session->setFlash(__('The zona could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
