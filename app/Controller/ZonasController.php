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
	public $uses = array('Zona', 'Site', 'Plugin', 'AdUnit', 'LineItemsAdUnit', 'LineItem');
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
		$zonaInfo = $this->Zona->find('first', $options);

		$lineItemInfo = $this->LineItemsAdUnit->find('first', array('LineItemsAdUnit.ad_units_id' => $zonaInfo['AdUnits']['id']));

		$this->set('zona', $zonaInfo);
		$this->set('lineItemInfo', $lineItemInfo);
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$data = $this->request->data;

			/*
			Line Item Save
			 */
			$dataLineItem = $data['line_item'];
			$tmpArrLineItem = explode(',', $dataLineItem);
			$existsLine = $this->LineItem->find('first', array('conditions' => array('LineItem.line_id_dfp' => $tmpArrLineItem[1])));
			if (!$existsLine) {
				$toSaveLine = array(
						'name' => $tmpArrLineItem[0],
						'line_id_dfp' => $tmpArrLineItem[1]
					);
				$this->LineItem->create();
				$savedLine = $this->LineItem->save($toSaveLine);
				$idLineItem = $savedLine['LineItem']['id'];
			} else {
				$idLineItem = $existsLine['LineItem']['id'];
			}
			
			/*
			Ad Units Save
			 */
			$dataAdUnit = $data['ad_unit'];
			$tmpArrAdUnit = explode('|', $dataAdUnit);
			$existsAdUnit = $this->AdUnit->find('first', array('conditions' => array('AdUnit.adunit_id_dfp' => $tmpArrAdUnit[1])));
			if (!$existsAdUnit) {
				$toSaveAdunit = array(
						'name' => $tmpArrAdUnit[0],
						'adunit_id_dfp' => $tmpArrAdUnit[1]
					);
				$this->AdUnit->create();
				$savedAdunit = $this->AdUnit->save($toSaveAdunit);
				$idAdunit = $savedAdunit['AdUnit']['id'];
			} else {
				$idAdunit = $existsAdUnit['AdUnit']['id'];
			}

			/*
			Guardar Asociacion Adunits - LinItems
			 */
			if ($idLineItem && $idAdunit) {
				$existsLineAdUnit = $this->LineItemsAdUnit->find('first', array('conditions' => array('LineItemsAdUnit.line_items_id' => $idLineItem, 'LineItemsAdUnit.ad_units_id' => $idAdunit)));
				if (!$existsLineAdUnit) {
					$this->LineItemsAdUnit->create();
					$this->LineItemsAdUnit->save(array(
							'line_items_id' => $idLineItem,
							'ad_units_id' => $idAdunit
						));
				}
			}

			/*
			Guardar datos Zona
			 */
			if ($data['plugins_id']) {
				#Verificar id_tag_template
				$id_tag_template = (substr($data['Zona']['id_tag_template'], 0, 1) === "#")  ? $data['Zona']['id_tag_template'] : '#' . $data['Zona']['id_tag_template'];
				$toSaveZona = array(
						'name' => $data['Zona']['name'],
						'id_tag_template' => $id_tag_template,
						'plugins_id' => $data['plugins_id'],
						'ad_units_id' => $idAdunit
					);
				$this->Zona->create();
				$savedZona = $this->Zona->save($toSaveZona);
				$idZona = $savedZona['Zona']['id'];
			}

			if ($idZona) {
				$this->Session->setFlash(__('La zona ha sido guardada.'), 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('controller' => 'zonas', 'action' => 'index', 'admin' => true));
			} else {
				$this->Session->setFlash(__('La zona no ha sido guardada.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			//Line items
			// Log SOAP XML request and response.
			$this->instanceDfp()->LogDefaults();

			// Get the LineItemService.
			$lineItemService = $this->instanceDfp()->GetService('LineItemService', 'v201403');
			// Set defaults for page and statement.
			$page = new LineItemPage();
			$filterStatement = new Statement();
			$offset = 0;

			do {
				// Create a statement to get all line items.
				$filterStatement->query = "WHERE status = 'DELIVERING' OR status = 'DELIVERY_EXTENDED' OR status = 'READY' LIMIT 500 OFFSET " . $offset;
		
				// Get line items by statement.
				$page = $lineItemService->getLineItemsByStatement($filterStatement);

				// Display results.
				if (isset($page->results)) {
					foreach ($page->results as $lineItem) {
						$linesAll[$lineItem->id]['name'] = $lineItem->name;
						if (count($lineItem->targeting->inventoryTargeting->targetedAdUnits) > 0) {
							foreach ($lineItem->targeting->inventoryTargeting->targetedAdUnits as $key => $target) { 
								$linesAll[$lineItem->id]['adunits'][] = $target->adUnitId;
							}
						}
					}
				}

				$offset += 500;
			} while ($offset < $page->totalResultSetSize);
			
			if ($linesAll) {
				foreach ($linesAll as $key => $line) {
					$adunitsPieces = implode(',', $line['adunits']);
					$lineList[$line['name'] . ',' . $key . ',' . $adunitsPieces] = $line['name'];
				}
			} else {
				$lineList = array();
			}
		}
		
		$plugins_id = $this->Plugin->find('list');
		$this->set(compact('plugins_id', 'lineList'));
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
			$data = $this->request->data;

			/*
			Line Item Save
			 */
			$dataLineItem = $data['line_item'];
			$tmpArrLineItem = explode(',', $dataLineItem);
			$existsLine = $this->LineItem->find('first', array('conditions' => array('LineItem.line_id_dfp' => $tmpArrLineItem[1])));
			if (!$existsLine) {
				$toSaveLine = array(
						'name' => $tmpArrLineItem[0],
						'line_id_dfp' => $tmpArrLineItem[1]
					);
				$this->LineItem->create();
				$savedLine = $this->LineItem->save($toSaveLine);
				$idLineItem = $savedLine['LineItem']['id'];
			} else {
				$idLineItem = $existsLine['LineItem']['id'];
			}
			
			/*
			Ad Units Save
			 */
			$dataAdUnit = $data['ad_unit'];
			$tmpArrAdUnit = explode('|', $dataAdUnit);
			$existsAdUnit = $this->AdUnit->find('first', array('conditions' => array('AdUnit.adunit_id_dfp' => $tmpArrAdUnit[1])));
			if (!$existsAdUnit) {
				$toSaveAdunit = array(
						'name' => $tmpArrAdUnit[0],
						'adunit_id_dfp' => $tmpArrAdUnit[1]
					);
				$this->AdUnit->create();
				$savedAdunit = $this->AdUnit->save($toSaveAdunit);
				$idAdunit = $savedAdunit['AdUnit']['id'];
			} else {
				$idAdunit = $existsAdUnit['AdUnit']['id'];
			}

			/*
			Guardar Asociacion Adunits - LinItems
			 */
			if ($idLineItem && $idAdunit) {
				$existsLineAdUnit = $this->LineItemsAdUnit->find('first', array('conditions' => array('LineItemsAdUnit.line_items_id' => $idLineItem, 'LineItemsAdUnit.ad_units_id' => $idAdunit)));
				if (!$existsLineAdUnit) {
					$this->LineItemsAdUnit->create();
					$this->LineItemsAdUnit->save(array(
							'line_items_id' => $idLineItem,
							'ad_units_id' => $idAdunit
						));
				}
			}

			/*
			Guardar datos Zona
			 */
			if ($data['plugins_id']) {
				#Verificar id_tag_template
				$id_tag_template = (substr($data['Zona']['id_tag_template'], 0, 1) === "#")  ? $data['Zona']['id_tag_template'] : '#' . $data['Zona']['id_tag_template'];
				$toSaveZona = array(
						'name' => $data['Zona']['name'],
						'id_tag_template' => $id_tag_template,
						'plugins_id' => $data['plugins_id'],
						'ad_units_id' => $idAdunit
					);
				$this->Zona->id = $id;
				$savedZona = $this->Zona->save($toSaveZona);
			}

			if ($savedZona) {
				$this->Session->setFlash(__('La zona ha sido actualizada.'), 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('controller' => 'zonas', 'action' => 'index', 'admin' => true));
			} else {
				$this->Session->setFlash(__('La zona no ha sido actualizada.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Zona.' . $this->Zona->primaryKey => $id));
			$zonaInfo = $this->request->data = $this->Zona->find('first', $options);

			//Line items
			// Log SOAP XML request and response.
			$this->instanceDfp()->LogDefaults();

			// Get the LineItemService.
			$lineItemService = $this->instanceDfp()->GetService('LineItemService', 'v201403');
			// Set defaults for page and statement.
			$page = new LineItemPage();
			$filterStatement = new Statement();
			$offset = 0;

			do {
				// Create a statement to get all line items.
				$filterStatement->query = "WHERE status = 'DELIVERING' OR status = 'DELIVERY_EXTENDED' OR status = 'READY' LIMIT 500 OFFSET " . $offset;
		
				// Get line items by statement.
				$page = $lineItemService->getLineItemsByStatement($filterStatement);

				// Display results.
				if (isset($page->results)) {
					foreach ($page->results as $lineItem) {
						$linesAll[$lineItem->id]['name'] = $lineItem->name;
						if (count($lineItem->targeting->inventoryTargeting->targetedAdUnits) > 0) {
							foreach ($lineItem->targeting->inventoryTargeting->targetedAdUnits as $key => $target) { 
								$linesAll[$lineItem->id]['adunits'][] = $target->adUnitId;
							}
						}
					}
				}

				$offset += 500;
			} while ($offset < $page->totalResultSetSize);
			
			if ($linesAll) {
				foreach ($linesAll as $key => $line) {
					$adunitsPieces = implode(',', $line['adunits']);
					$lineList[$line['name'] . ',' . $key . ',' . $adunitsPieces] = $line['name'];
				}
			} else {
				$lineList = array();
			}
		}
		$plugins_id = $this->Plugin->find('list');
		$this->set(compact('plugins_id', 'lineList', 'zonaInfo'));
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
			$this->Session->setFlash(__('La zona ha sido eliminada.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('La zona no ha sido eliminada.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function admin_delete_async($id = null) {
		$this->layout = 'ajax';
		$this->Zona->id = $id;
		if (!$this->Zona->exists()) {
			echo json_encode(array('response' => 999));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Zona->delete()) {
			echo json_encode(array('response' => 1));
		} else {
			echo json_encode(array('response' => 0));
		}
		exit();
	}
}
