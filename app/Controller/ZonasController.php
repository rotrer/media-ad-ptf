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
 * Models
 *
 * @var array
 */
	public $uses = array('Zona', 'Site', 'ZonasAdUnit', 'AdUnit', 'LineItemsAdUnit', 'LineItem');
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
		$this->set('activeZonasMenu', true);
	}

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
			#debug($this->request->data);
			
			$dataZonas = $this->request->data['Zona'];

			#Get indo site/adordres, line items
			$site = $this->Site->findById($dataZonas['site']);
			$lineItem = $this->LineItem->findByAd_orders_id($site['AdOrder'][0]['id']);

			##Guardar Zonas
			$zonaData = array(
					'name' => $dataZonas['name'],
					'id_tag_template' => $dataZonas['id_tag_template'],
					'sites_id' => $dataZonas['site']
				);
			$this->Zona->create();
			$responseZona = $this->Zona->save($zonaData);

			##Guardar AdUnit
			$name_adunit_compuesto = $dataZonas['adunit_name'];
				$name_adunit_compuesto = explode('[', str_replace("]", "", $name_adunit_compuesto));
			$adunitData = array(
					'id' => $dataZonas['adunit'],
					'name' => $name_adunit_compuesto[0],
					'status' => $name_adunit_compuesto[1],
					'created' => date('Y-m-d H:i:s')
				);
			$this->AdUnit->create();
			$responseAdUnit = $this->AdUnit->save($adunitData);

			##Guardar/Asociar ZonasAdUnit
			$zonasadunitData = array(
					'zonas_id' => $responseZona['Zona']['id'],
					'ad_units_id' => $responseAdUnit['AdUnit']['id'],
					'created' => date('Y-m-d H:i:s')
				);
			$this->ZonasAdUnit->create();
			$responseZonasAdUnit = $this->ZonasAdUnit->save($zonasadunitData);

			##Guardar/Asociar LineItemsAdUnit
			if (!$this->LineItemsAdUnit->find('count', array('LineItemsAdUnit.line_items_id' => $lineItem['LineItem']['id'], 'LineItemsAdUnit.ad_units_id' => $responseAdUnit['AdUnit']['id']))) {
				$lineitemsadunitData = array(
						'line_items_id' => $lineItem['LineItem']['id'],
						'ad_units_id' => $responseAdUnit['AdUnit']['id'],
						'created' => date('Y-m-d H:i:s')
					);
				$this->LineItemsAdUnit->create();
				$responseLineItemsAdUnit = $this->LineItemsAdUnit->save($lineitemsadunitData);
			}

			if ($responseZona && $responseAdUnit) {
				$this->Session->setFlash(__('La zona ha sido guardada.'), 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('controller' => 'zonas', 'action' => 'index', 'admin' => true));
			} else {
				$this->Session->setFlash(__('La zona no ha sido guardada.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			try {
				// Get the InventoryService.
				$inventoryService = $this->instanceDfp()->GetService('InventoryService', 'v201403');

				// Set defaults for page and statement.
				$page = new AdUnitPage();
				$filterStatement = new Statement();
				$offset = 0;
				$adunitsArr = array();

				do {
					// Create a statement to get all ad units.
					$filterStatement->query = "WHERE status = 'ACTIVE' LIMIT 500 OFFSET " . $offset;

					// Get creatives by statement.
					$page = $inventoryService->getAdUnitsByStatement($filterStatement);

					// Display results.
					if (isset($page->results)) {
						$i = $page->startIndex;
						foreach ($page->results as $adUnit) {
							if ($adUnit->status != 'ARCHIVED') {
								$adunitsArr[$adUnit->id] = $adUnit->name . '[' . $adUnit->status . ']';
								// pr( $i . ') Ad unit with ID "' . $adUnit->id
								// 	. '", name "' . $adUnit->name
								// 	. '", and status "' . $adUnit->status . "\" was found." );
								// $i++;	
							}
						}
					}

					$offset += 500;
				} while ($offset < $page->totalResultSetSize);
			} catch (OAuth2Exception $e) {
				$this->Session->write('redirect_url', $this->request->url);
				$this->redirect(array('controller' => 'users', 'action' => 'call_oauth', 'admin' => false));

			} catch (ValidationException $e) {
				#ExampleUtils::CheckForOAuth2Errors($e);
			} catch (Exception $e) {
				print $e->getMessage() . "\n";
			}



			$sites = $this->Site->find('list');
			$this->set('adunits', $adunitsArr);
		}
		
		#$adUnits = $this->Zona->AdUnit->find('list');
		$this->set(compact('sites', 'adUnits', 'cantidad_zonas'));
	}

/**
 * admin_addmulti method
 *
 * @return void
 */
	public function admin_addmulti($id_site = null, $id_order = null, $id_linetiem = null, $cantidad_zonas = 3) {
		if ($this->request->is('post')) {

			if (sizeof($this->request->params['pass']) >= 3 && $this->request->data) {
				$totalZonas = (sizeof($this->request->data['Zona']) - $cantidad_zonas) / 3;
				$dataZonas = $this->request->data['Zona'];
				for ($i=0; $i < $totalZonas; $i++) {
					##Guardar Zonas
					$zonaData = array(
							'name' => $dataZonas['name'.$i],
							'id_tag_template' => $dataZonas['id_tag_template'.$i],
							'sites_id' => $id_site
						);
					$this->Zona->create();
					$responseZona = $this->Zona->save($zonaData);

					##Guardar AdUnit
					$name_adunit_compuesto = $dataZonas['adunit_name'.$i];
						$name_adunit_compuesto = explode('[', str_replace("]", "", $name_adunit_compuesto));
					$adunitData = array(
							'id' => $dataZonas['adunit'.$i],
							'name' => $name_adunit_compuesto[0],
							'status' => $name_adunit_compuesto[1],
							'created' => date('Y-m-d H:i:s')
						);
					$this->AdUnit->create();
					$responseAdUnit = $this->AdUnit->save($adunitData);

					##Guardar/Asociar ZonasAdUnit
					$zonasadunitData = array(
							'zonas_id' => $responseZona['Zona']['id'],
							'ad_units_id' => $responseAdUnit['AdUnit']['id'],
							'created' => date('Y-m-d H:i:s')
						);
					$this->ZonasAdUnit->create();
					$responseZonasAdUnit = $this->ZonasAdUnit->save($zonasadunitData);

					##Guardar/Asociar LineItemsAdUnit
					$lineitemsadunitData = array(
							'line_items_id' => $id_linetiem,
							'ad_units_id' => $responseAdUnit['AdUnit']['id'],
							'created' => date('Y-m-d H:i:s')
						);
					$this->LineItemsAdUnit->create();
					$responseLineItemsAdUnit = $this->LineItemsAdUnit->save($lineitemsadunitData);
				}

				$this->Session->setFlash(__('Proceso completado, descargue el plugin.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect($this->redirect(array(
					'controller' => 'sites',
					'action' => 'getplugin',
					'admin' => true,
					$id_site
				)));
			} else {
				$this->Session->setFlash(__('Error al guardar las zonas, favor intente nuevamente.'), 'default', array('class' => 'alert alert-warning'));
			}
		}
		if ($id_site && $id_order && $id_linetiem) {
			try {
				// Get the InventoryService.
				$inventoryService = $this->instanceDfp()->GetService('InventoryService', 'v201403');

				// Set defaults for page and statement.
				$page = new AdUnitPage();
				$filterStatement = new Statement();
				$offset = 0;
				$adunitsArr = array();

				do {
					// Create a statement to get all ad units.
					$filterStatement->query = "WHERE status = 'ACTIVE' LIMIT 500 OFFSET " . $offset;

					// Get creatives by statement.
					$page = $inventoryService->getAdUnitsByStatement($filterStatement);

					// Display results.
					if (isset($page->results)) {
						$i = $page->startIndex;
						foreach ($page->results as $adUnit) {
							if ($adUnit->status != 'ARCHIVED') {
								$adunitsArr[$adUnit->id] = $adUnit->name . '[' . $adUnit->status . ']';
								// pr( $i . ') Ad unit with ID "' . $adUnit->id
								// 	. '", name "' . $adUnit->name
								// 	. '", and status "' . $adUnit->status . "\" was found." );
								// $i++;	
							}
						}
					}

					$offset += 500;
				} while ($offset < $page->totalResultSetSize);
			} catch (OAuth2Exception $e) {
				$this->Session->write('redirect_url', $this->request->url);
				$this->redirect(array('controller' => 'users', 'action' => 'call_oauth', 'admin' => false));

			} catch (ValidationException $e) {
				#ExampleUtils::CheckForOAuth2Errors($e);
			} catch (Exception $e) {
				print $e->getMessage() . "\n";
			}



			$sites = $this->Site->find('first', array('conditions' => array('Site.id' => $id_site)));
			$this->set('adunits', $adunitsArr);
		} else {
			$this->Session->setFlash(__('Antes de crear una zona debe generar un sitio.'));
			return $this->redirect(array('controller' => 'sites', 'action' => 'add'));
		}
		
		#$adUnits = $this->Zona->AdUnit->find('list');
		$this->set(compact('sites', 'adUnits', 'cantidad_zonas'));
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
			$zonaInfo = $this->request->data = $this->Zona->find('first', $options);

			try {
				// Get the InventoryService.
				$inventoryService = $this->instanceDfp()->GetService('InventoryService', 'v201403');

				// Set defaults for page and statement.
				$page = new AdUnitPage();
				$filterStatement = new Statement();
				$offset = 0;
				$adunitsArr = array();

				do {
					// Create a statement to get all ad units.
					$filterStatement->query = "WHERE status = 'ACTIVE' LIMIT 500 OFFSET " . $offset;

					// Get creatives by statement.
					$page = $inventoryService->getAdUnitsByStatement($filterStatement);

					// Display results.
					if (isset($page->results)) {
						$i = $page->startIndex;
						foreach ($page->results as $adUnit) {
							if ($adUnit->status != 'ARCHIVED') {
								$adunitsArr[$adUnit->id] = $adUnit->name . '[' . $adUnit->status . ']';
								// pr( $i . ') Ad unit with ID "' . $adUnit->id
								// 	. '", name "' . $adUnit->name
								// 	. '", and status "' . $adUnit->status . "\" was found." );
								// $i++;	
							}
						}
					}

					$offset += 500;
				} while ($offset < $page->totalResultSetSize);
			} catch (OAuth2Exception $e) {
				$this->Session->write('redirect_url', $this->request->url);
				$this->redirect(array('controller' => 'users', 'action' => 'call_oauth', 'admin' => false));

			} catch (ValidationException $e) {
				#ExampleUtils::CheckForOAuth2Errors($e);
			} catch (Exception $e) {
				print $e->getMessage() . "\n";
			}



			$sites = $this->Site->find('list');
			$this->set('adunits', $adunitsArr);
		}
		$sites = $this->Site->find('list');
		$this->set(compact('sites', 'zonaInfo'));
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
