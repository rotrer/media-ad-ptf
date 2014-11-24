<?php
App::uses('AppController', 'Controller');
/**
 * Plugins Controller
 *
 * @property Plugin $Plugin
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PluginsController extends AppController {

/**
 * Models
 *
 * @var array
 */
	public $uses = array('Plugin', 'Site', 'User', 'LineItem', 'LineItemsAdUnit', 'AdUnit', 'Zona');
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
		$this->set('activePluginsMenu', true);
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Plugin->recursive = 0;
		$this->set('plugins', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Plugin->exists($id)) {
			throw new NotFoundException(__('Invalid plugin'));
		}
		$options = array('conditions' => array('Plugin.' . $this->Plugin->primaryKey => $id));
		$plugin = $this->Plugin->find('first', $options);

		$zonasInfo = $this->Zona->find('all', array('conditions' => array('Zona.plugins_id' => $id)));

		if($zonasInfo) foreach ($zonasInfo as $key => $zona) {
			$lineItemInfo = $this->LineItemsAdUnit->find('first', array('conditions' => array('LineItemsAdUnit.ad_units_id' => $zona['AdUnits']['id'])));
			$zonasLineInfo[] = array_merge($zona, $lineItemInfo);
		}

		$this->set(compact('plugin', 'zonasLineInfo'));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Plugin->create();
			$savedPlugin = $this->Plugin->save($this->request->data);
			if ($savedPlugin) {
				$idPlugin = $savedPlugin['Plugin']['id'];
				$data = $this->request->data;
				for ($i=0; $i < count($data['line_item']); $i++) { 
					/*
					Line Item Save
					 */
					$dataLineItem = $data['line_item'][$i];
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
					$dataAdUnit = $data['ad_unit'][$i];
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
					if ($idPlugin) {
						#Verificar id_tag_template
						$id_tag_template = (substr($data['id_tag_template'][$i], 0, 1) === "#")  ? $data['id_tag_template'][$i] : '#' . $data['id_tag_template'][$i];
						$toSaveZona = array(
								'name' => $data['zona_name'][$i],
								'id_tag_template' => $id_tag_template,
								'out_of_page' => (isset($data['style'][$i]) && trim($data['style'][$i])) ? 1 : 0,
								'style' => trim($data['style'][$i]),
								'plugins_id' => $idPlugin,
								'ad_units_id' => $idAdunit
							);
						$this->Zona->create();
						$savedZona = $this->Zona->save($toSaveZona);
						$idZona = $savedZona['Zona']['id'];
					}

				}
				$this->Session->setFlash(__('Plugin ha sido guardado correctamente.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Plugin no ha sido guardado, favor intentar nuevamente.'), 'default', array('class' => 'alert alert-danger'));
			}
		}

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
				if (!empty($line) && is_array($line) && isset($line['adunits'])) {
					$adunitsPieces = implode(',', $line['adunits']);
					$lineList[$line['name'] . ',' . $key . ',' . $adunitsPieces] = $line['name'];
				}
			}
		} else {
			$lineList = array();
		}

		$sites = $this->Site->find('list');
		$this->set(compact('sites', 'lineList'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Plugin->exists($id)) {
			throw new NotFoundException(__('Invalid plugin'));
		}
		if ($this->request->is(array('post', 'put'))) {
			
			$this->Plugin->id = $id;
			$savedPlugin = $this->Plugin->save($this->request->data);
			if ($savedPlugin) {
				$idPlugin = $id;
				$data = $this->request->data;
				for ($i=0; $i < count($data['line_item']); $i++) { 
					/*
					Line Item Save
					 */
					$dataLineItem = $data['line_item'][$i];
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
					$dataAdUnit = $data['ad_unit'][$i];
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
					if ($idPlugin) {
						#Verificar id_tag_template
						$id_tag_template = (substr($data['id_tag_template'][$i], 0, 1) === "#")  ? $data['id_tag_template'][$i] : '#' . $data['id_tag_template'][$i];
						$toSaveZona = array(
								'name' => $data['zona_name'][$i],
								'id_tag_template' => $id_tag_template,
								'out_of_page' => (isset($data['style'][$i]) && trim($data['style'][$i])) ? 1 : 0,
								'style' => trim($data['style'][$i]),
								'plugins_id' => $idPlugin,
								'ad_units_id' => $idAdunit
							);
						if (isset($data['zona_id'][$i]) && !empty($data['zona_id'][$i])) {
							$this->Zona->id = $data['zona_id'][$i];
						} else {
							$this->Zona->create();
						}
						$savedZona = $this->Zona->save($toSaveZona);
					}

				}
				$this->Session->setFlash(__('Plugin ha sido actualizado correctamente.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Plugin no ha sido actualizado, favor intentar nuevamente.'), 'default', array('class' => 'alert alert-danger'));
			}
		}

		$options = array('conditions' => array('Plugin.' . $this->Plugin->primaryKey => $id));
		$plugin = $this->Plugin->find('first', $options);

		$zonasInfo = $this->Zona->find('all', array('conditions' => array('Zona.plugins_id' => $id)));

		if($zonasInfo) foreach ($zonasInfo as $key => $zona) {
			$lineItemInfo = $this->LineItemsAdUnit->find('first', array('conditions' => array('LineItemsAdUnit.ad_units_id' => $zona['AdUnits']['id'])));
			$zonasLineInfo[] = array_merge($zona, $lineItemInfo);
		}

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
				if (!empty($line) && is_array($line) && isset($line['adunits'])) {
					$adunitsPieces = implode(',', $line['adunits']);
					$lineList[$line['name'] . ',' . $key . ',' . $adunitsPieces] = $line['name'];
				}
			}
		} else {
			$lineList = array();
		}

		$sites = $this->Site->find('list');

		$this->set(compact('plugin', 'zonasLineInfo', 'sites', 'lineList'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Plugin->id = $id;
		if (!$this->Plugin->exists()) {
			throw new NotFoundException(__('Invalid plugin'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Plugin->delete()) {
			$this->Session->setFlash(__('The plugin has been deleted.'));
		} else {
			$this->Session->setFlash(__('The plugin could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function admin_addzona(){
		$this->layout = 'ajax';

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
				$listLines = '';
				foreach ($page->results as $lineItem) {
					$adunitsLine = array();
					if (count($lineItem->targeting->inventoryTargeting->targetedAdUnits) > 0) {
						foreach ($lineItem->targeting->inventoryTargeting->targetedAdUnits as $key => $target) { 
							$adunitsLine[] = $target->adUnitId;
						}

						$adunitsPieces = implode(',', $adunitsLine);
					}
					$listLines .= '<option value="' . $lineItem->name . ',' . $lineItem->id . ',' . $adunitsPieces . '">' . $lineItem->name . '</option>';
				}
			}

			$offset += 500;
		} while ($offset < $page->totalResultSetSize);

		$html = '<div class="row rowZonas">
					<div class="col-md-2">
						<div class="form-group">

  						<select name="line_item[]" class="form-control selectedLine" required="required" id="PluginSitesId">
								<option value="">Seleccione</option>' . $listLines . '
							</select>						</div>
					</div>
					<div class="col-md-2">
						<div class="wait-select" style="float: left; display: none;">
				  		<img src="/img/spinner.gif" alt="Wait">
			  		</div>
						<div class="form-group">
  						<select name="ad_unit[]" class="form-control" required="required" id="PluginSitesId">
								<option value="">Seleccione</option>
							</select>						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
  						<input name="zona_name[]" class="form-control" required="required" type="text" id="PluginSitesId">						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
  						<input name="id_tag_template[]" class="form-control" required="required" type="text" id="PluginSitesId">						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
  						<textarea name="style[]" class="form-control" cols="30" rows="6" id="PluginSitesId"></textarea>						</div>
						<button type="button" class="btn btn-danger pull-right removeRow">
							<span class="glyphicon glyphicon-remove"></span>
						</button>
					</div>
				</div>';
		echo $html;
		exit();
	}

	public function admin_getadunits(){
		$this->layout = 'ajax';
		if ($this->request->is(array('post', 'get'))) {
			$adunitsArr = $this->request->data['adunits']; 
			$tmpAdUnits = explode(',', $adunitsArr);
			#Remover Nombre y ID Line Item, solo dejar adunits
			unset($tmpAdUnits[0]);
			unset($tmpAdUnits[1]);
			$adunitsArr = (count($tmpAdUnits) > 0) ? implode(',', $tmpAdUnits) : '';
			if (!empty($adunitsArr)) {
				// Log SOAP XML request and response.
				$this->instanceDfp()->LogDefaults();

				// Get the InventoryService.
				$inventoryService = $this->instanceDfp()->GetService('InventoryService', 'v201403');

				// Get the NetworkService.
				$networkService = $this->instanceDfp()->GetService('NetworkService', 'v201403');

				// Get the effective root ad unit's ID.
				$network = $networkService->getCurrentNetwork();
				$effectiveRootAdUnitId = $network->effectiveRootAdUnitId;

				// Create a statement to select the children of the effective root ad unit.
				$filterStatementText =
        	sprintf('WHERE id IN (%s)', $adunitsArr);
    		$filterStatement = new Statement($filterStatementText);

				// Get ad units by statement.
				$page = $inventoryService->getAdUnitsByStatement($filterStatement);

				// Display results.
				$adunitsList = '<option value="">Seleccione</option>';
				if (isset($page->results)) {
					foreach ($page->results as $adUnit) {
						if ($adUnit->status != 'ARCHIVED') {
							$adunitsList .= '<option value="'. $adUnit->name . '|' . $adUnit->id .'">' . $adUnit->name . '[' . $adUnit->status . ']' . '</option>';
						}
					}
				}

				echo $adunitsList;
			} else {
				echo '<option value="">AdUnits no Disponibles</option>';
			}
		}

		exit();
	}

	public function admin_download($id = null){
		if (!$this->Plugin->exists($id)) {
			throw new NotFoundException(__('Invalid plugin'));
		}

		if ($this->request->is('post')) {
			$infoToPlugin = array();
			$infoToPlugin['id'] 	= $id;
			$infoToPlugin['unq'] 	= $this->request->data['Plugin']['unq'];
			$infoToPlugin['sync'] = $this->request->data['Plugin']['sync'];

			if ($infoToPlugin) {
				try {
					// Get adunits
					$zonasAll = $this->Zona->find('all', array('conditions' => array('Zona.plugins_id' => $id)));
					$plugin = $this->Plugin->find('first', array('conditions' => array('Plugin.' . $this->Plugin->primaryKey => $id))); 
					// debug($plugin);
					// debug($zonasAll);
					// die();
					if ($zonasAll) {
						foreach ($zonasAll as $key => $la_zona) {
							$infoToPlugin[$la_zona['AdUnits']['adunit_id_dfp']] = array(
									'site' => array(
											'domain' => $plugin['Sites']['domain'],
											'public_key' => $plugin['Sites']['public_key'],
										),
									'zona' => array(
											'name' => $la_zona['Zona']['name'],
											'id_tag_template' => $la_zona['Zona']['id_tag_template'],
											'out_of_page' => $la_zona['Zona']['out_of_page'],
											'style' => $la_zona['Zona']['style'],
										),
									'adunit' => array(
										)
								);
							$adunits_ids_arr[] = $la_zona['AdUnits']['adunit_id_dfp'];
						}
					} else {
						//Sin zonas...
					}
					$adunits_ids = implode(",", $adunits_ids_arr);
					/*
					*DFP
					*/
					// Log SOAP XML request and response.
					$this->instanceDfp()->LogDefaults();
					// Get the InventoryService.
					$inventoryService = $this->instanceDfp()->GetService('InventoryService', 'v201403');

					// Get the NetworkService.
	  				$networkService = $this->instanceDfp()->GetService('NetworkService', 'v201403');

					// Get the effective root ad unit's ID.
					$network = $networkService->getCurrentNetwork();
					$effectiveRootAdUnitId = $network->effectiveRootAdUnitId;

					//Save network code for plugin WP
					$infoToPlugin['networkcode'] = $network->networkCode;

					// Create a statement to select the children of the effective root ad unit.
					$filterStatement =
						new Statement("WHERE parentId = :id AND status = 'ACTIVE' AND id  IN ($adunits_ids) LIMIT 500",
										MapUtils::GetMapEntries(array(
																		'id' => new NumberValue($effectiveRootAdUnitId)
																	)
																)
									);

					// Get ad units by statement.
					$page = $inventoryService->getAdUnitsByStatement($filterStatement);

					// Display results.
					if (isset($page->results)) {
						$i = $page->startIndex;
						foreach ($page->results as $adUnit) {
							$sizes_to_unit = array();
							foreach ($adUnit->adUnitSizes as $key => $sizes) {
								$sizes_to_unit[] = array(
										'width' => $sizes->size->width,
										'height' => $sizes->size->height,
									);
							}
							// Get unit code and unit size
							$infoToPlugin[$adUnit->id]['adunit'] = array(
									'adunitcode' => $adUnit->adUnitCode,
									'sizes' => $sizes_to_unit,
								);
						}
					}
					
					//All ok to create zip plugin
					$fileInfo = $this->createZipPlugin($infoToPlugin);
					if ($fileInfo) {
						$filename = basename($fileInfo);
						header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
						header("Content-Type: application/zip");
						header("Content-Transfer-Encoding: Binary");
						header("Content-Length: ".filesize($fileInfo));
						header("Content-Disposition: attachment; filename=\"".$filename."\"");
						@readfile($fileInfo);
					}

				} catch (OAuth2Exception $e) {
					$this->Session->write('redirect_url', $this->request->url);
					$this->redirect(array('controller' => 'users', 'action' => 'call_oauth', 'admin' => false));

				} catch (ValidationException $e) {
					#ExampleUtils::CheckForOAuth2Errors($e);
				} catch (Exception $e) {
					print $e->getMessage() . "\n";
				}
				die();

			}//End if ($infoToPlugin) {
		}

		$options = array('conditions' => array('Plugin.' . $this->Plugin->primaryKey => $id));
		$plugin = $this->Plugin->find('first', $options);

		$zonasInfo = $this->Zona->find('all', array('conditions' => array('Zona.plugins_id' => $id)));

		$hasOop =  false;
		if($zonasInfo) foreach ($zonasInfo as $key => $zona) {
			if (!empty($zona['Zona']['style']))
				$hasOop =  true;

			$lineItemInfo = $this->LineItemsAdUnit->find('first', array('conditions' => array('LineItemsAdUnit.ad_units_id' => $zona['AdUnits']['id'])));
			$zonasLineInfo[] = array_merge($zona, $lineItemInfo);
		}

		$this->set(compact('plugin', 'zonasLineInfo', 'hasOop'));
	}

	private function createZipPlugin($info) {
		// debug($info);
		if ($info) {
			$head_ads_all = $insert_ads_all = $styles_oop = '';
			foreach ($info as $keyad => $ad) {
				if (isset($ad['adunit']) && is_array($ad['adunit']) && !empty($ad['adunit'])) {
					$adunit_code = $ad['adunit']['adunitcode'];
					if ($ad['zona']['out_of_page'] == 0) {
						$width =  $ad['adunit']['sizes'][0]['width'];
						$height =  $ad['adunit']['sizes'][0]['height'];

						//read head ads template
						$adunit_size = $width . ',' . $height;
						$head_ads = WWW_ROOT . 'template' .DS . 'head_ads.txt';
						$head_ads_content = file_get_contents($head_ads);
							$findHead 		= array('{network_code}', '{adunit_code}', '{adunit_size}', '{adunit_id}');
							$replaceHead 	= array($info['networkcode'], $adunit_code, $adunit_size, $keyad);

						//read inserts ads template
						$adunit_tag_id = $ad['zona']['id_tag_template'];
						$insert_ads = WWW_ROOT . 'template' .DS . 'insert_ads.txt';
						$insert_ads_content = file_get_contents($insert_ads);
							$find 		= array('{adunit_id}', '{width}', '{height}', '{adunit_tag_id}');
							$replace 	= array($keyad, $width, $height, $adunit_tag_id);

						$insert_ads_all .= str_replace($find, $replace, $insert_ads_content);	
					} else {
						//read head ads template
						$head_ads = WWW_ROOT . 'template' .DS . 'head_ads_oop.txt';
						$head_ads_content = file_get_contents($head_ads);

							$findHead 		= array('{network_code}', '{adunit_code}', '{adunit_id}');
							$replaceHead 	= array($info['networkcode'], $adunit_code, $keyad);

						//read inserts ads template
						$adunit_tag_id = $ad['zona']['id_tag_template'];
						$insert_ads = WWW_ROOT . 'template' .DS . 'insert_ads_oop.txt';
						$insert_ads_content = file_get_contents($insert_ads);
							$find 		= array('{adunit_id}', '{adunit_tag_id}');
							$replace 	= array($keyad, $adunit_tag_id);

						$insert_ads_all .= str_replace($find, $replace, $insert_ads_content);	

						$styles_oop .= $ad['zona']['id_tag_template'] . '{' . $ad['zona']['style'] . '};';
					}
					$head_ads_all .= str_replace($findHead, $replaceHead, $head_ads_content);
					//domain plugin
					$domain_plugin = $ad['site']['domain'];
				}
			}

			// read sync or async option
			$sync_request = ($info['sync'] == 1) ? 'sync.txt' : 'async.txt';
			$sync_file = WWW_ROOT . 'template' .DS . $sync_request;
			$sync_file_content = file_get_contents($sync_file);

			// replace adunits
			$sync_file_content = str_replace("{head_ads}", $head_ads_all, $sync_file_content);
			// replace single request option googletag.pubads().enableSingleRequest();
			$single_request = ($info['unq'] == 1) ? 'googletag.pubads().enableSingleRequest();' : '';
			$sync_file_content = str_replace("{single_request}", $single_request, $sync_file_content);

			// read base file plugin
			$base_plugin = WWW_ROOT . 'template' .DS . 'base.txt';
			$base_plugin_content = file_get_contents($base_plugin);
			
			// reaplace tags on base content
			$base_plugin_content = str_replace("{domain}", $domain_plugin, $base_plugin_content);
			$base_plugin_content = str_replace("{insert_ads}", $insert_ads_all, $base_plugin_content);
			// replace sync and single request options
			$base_plugin_content = str_replace("{sync_request}", $sync_file_content, $base_plugin_content);
			// replace styles oop
			$base_plugin_content = str_replace("{styles_oop}", $styles_oop, $base_plugin_content);

			// create dir plugin
			$base_path = WWW_ROOT . "plugins";
			$path_plugin = $base_path . DS . 'mt-' . $domain_plugin;

			// check if dir exists
			if (!is_dir($path_plugin)) {
				mkdir($path_plugin);
			}

			// create file index.php plugin
			$index_plugin = $path_plugin . DS . $domain_plugin . '.php';
			if (file_exists($index_plugin)) {
				unlink($index_plugin);
			}
			file_put_contents($index_plugin, $base_plugin_content);

			$zipFile = $base_path . DS . 'mt-' . $domain_plugin . '.zip';
			$endZip = $this->Zip($path_plugin, $zipFile);
			if ($endZip) {
				return $zipFile;
			} else {
				return false;
			}
			
		}
	}

	public function Zip($source, $destination) {
	    if (!extension_loaded('zip') || !file_exists($source)) {
	        return false;
	    }

	    $zip = new ZipArchive();
	    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
	        return false;
	    }

	    $source = str_replace('\\', '/', realpath($source));

	    if (is_dir($source) === true)
	    {
	        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

	        foreach ($files as $file)
	        {
	            $file = str_replace('\\', '/', $file);

	            // Ignore "." and ".." folders
	            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
	                continue;

	            $file = realpath($file);

	            if (is_dir($file) === true)
	            {
	                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
	            }
	            else if (is_file($file) === true)
	            {
	                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
	            }
	        }
	    }
	    else if (is_file($source) === true)
	    {
	        $zip->addFromString(basename($source), file_get_contents($source));
	    }

	    return $zip->close();
	}
}
