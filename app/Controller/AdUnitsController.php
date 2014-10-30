<?php
App::uses('AppController', 'Controller');
/**
 * AdUnits Controller
 *
 * @property AdUnit $AdUnit
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AdUnitsController extends AppController {

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
		$this->set('activeAdunitsMenu', true);
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->AdUnit->recursive = 0;
		$this->set('adUnits', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->AdUnit->exists($id)) {
			throw new NotFoundException(__('Invalid ad unit'));
		}
		$options = array('conditions' => array('AdUnit.' . $this->AdUnit->primaryKey => $id));
		$adunit = $this->AdUnit->find('first', $options);

		if($adunit['Zona']) foreach ($adunit['Zona'] as $key => $zona) {
			$siteInfo = $this->AdUnit->Zona->find('first', array('conditions' => array('Zona.id' => $zona['id'])));
			$adunit['Zona'][$key]['sites_name'] = $siteInfo['Sites']['name'];
			
		}

		$this->set('adUnit', $adunit);
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->AdUnit->create();
			if ($this->AdUnit->save($this->request->data)) {
				$this->Session->setFlash(__('The ad unit has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ad unit could not be saved. Please, try again.'));
			}
		}
		$zonas = $this->AdUnit->Zona->find('list');
		$this->set(compact('zonas'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->AdUnit->id = $id;
		if (!$this->AdUnit->exists()) {
			throw new NotFoundException(__('Invalid ad unit'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->AdUnit->delete()) {
			$this->Session->setFlash(__('The ad unit has been deleted.'));
		} else {
			$this->Session->setFlash(__('The ad unit could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
