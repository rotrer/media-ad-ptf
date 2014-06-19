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
 * Models
 *
 * @var array
 */
	public $uses = array('Site', 'User', 'AdOrder', 'LineItem', 'SitesAdOrder', 'Zona');
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
				$this->Session->setFlash(__('Sitio guardado correctament, ahora seleccione pedidos y líneas de pedidos para continuar.'));
				return $this->redirect(array('action' => 'dfporders', $this->Site->id));
			} else {
				$this->Session->setFlash(__('Sitio no ha sido guardado, favor intentar nuevamente.'));
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

/**
 * admin_addzonead method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_dfporders($id_site = null) {
		if ($this->request->is('post')) {
			##Guardar AdOrder
			$name_order_compuesto = $this->request->data['Site']['name_order'];
				$name_order_compuesto = explode('[', str_replace("]", "", $name_order_compuesto));
			$orderData = array(
					'id' => $this->request->data['Site']['order_id'],
					'name' => $name_order_compuesto[0],
					'status' => $name_order_compuesto[1],
					'created' => date('Y-m-d H:i:s')
				);
			$responseOrder = $this->AdOrder->save($orderData);
			
			##Guarar LineItem
			$name_lineitem_compuesto = $this->request->data['Site']['name_lineitem'];
				$name_lineitem_compuesto = explode('[', str_replace("]", "", $name_lineitem_compuesto));
			$lineitemData = array(
					'id' => $this->request->data['Site']['line_item_id'],
					'name' => $name_lineitem_compuesto[0],
					'status' => $name_lineitem_compuesto[1],
					'ad_orders_id' => $this->request->data['Site']['order_id'],
					'created' => date('Y-m-d H:i:s')
				);
			$responseLineItem = $this->LineItem->save($lineitemData);

			##Guardar SitesAdOrder
			$sitesadorderData = array(
					'sites_id' => $this->request->data['Site']['site_id'],
					'ad_orders_id' => $this->request->data['Site']['order_id'],
					'created' => date('Y-m-d H:i:s')
				);
			$responseSitesAdOrder = $this->SitesAdOrder->save($sitesadorderData);

			$this->redirect(array(
				'controller' => 'zonas',
				'action' => 'add',
				'admin' => true,
				$this->request->data['Site']['site_id'],
				$this->request->data['Site']['order_id'],
				$this->request->data['Site']['line_item_id']
			));
		}
		if (!$this->Site->exists($id_site)) {
			#throw new NotFoundException(__('Sitio no válido'));
			$this->Session->setFlash(__('Antes de seleccionar pedidos y sus lineas de pedido, debe generar un sitio.'));
			return $this->redirect(array('controller' => 'sites', 'action' => 'add'));
		}

		if ($id_site) {
			try {
				/*
				*DFP
				*/
				// Log SOAP XML request and response.
				$this->instanceDfp()->LogDefaults();
				// Get the OrderService.
				$orderService = $this->instanceDfp()->GetService('OrderService', 'v201403');

				// Create a datetime representing today.
				$today = date(DateTimeUtils::$DFP_DATE_TIME_STRING_FORMAT, strtotime('now'));

				// Create bind variables.
				$vars = MapUtils::GetMapEntries(array('today' => new TextValue($today)));

				// Create statement text to get all draft and pending approval orders that
				// haven't ended and aren't archived.
				$filterStatementText = "WHERE status IN ('DRAFT', 'PENDING_APPROVAL', 'APPROVED', 'PAUSED') "
					. "AND endDateTime >= :today "
					. "AND isArchived = FALSE ";

				$offset = 0;

				do {
					// Create statement to page through results.
					$filterStatement =
						new Statement($filterStatementText . " LIMIT 500 OFFSET "
						. $offset, $vars);

					// Get orders by statement.
					$page = $orderService->getOrdersByStatement($filterStatement);

					// Display results.
					$orderIds = $ordersArr = array();
					if (isset($page->results)) {
						$i = $page->startIndex;
						foreach ($page->results as $order) {
							// Archived orders cannot be approved.
							if (!$order->isArchived) {
								$ordersArr[$order->id] = $order->name . '[' . $order->status . ']';
								$i++;
								$orderIds[] = $order->id;
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


		}//End if ($id_site) {

		$options = array('conditions' => array('Site.' . $this->Site->primaryKey => $id_site));
		$this->set('site', $this->Site->find('first', $options));
		$this->set('orders', $ordersArr);
		
	}

/**
 * getlinesitems method
 * @params int $oder_id
 * @return void
 */
	public function admin_getlinesitems() {
		$this->layout = 'ajax';
		if ($this->request->is('post')) {
			if ($this->request->data['order_id']) {
				$orderId = $this->request->data['order_id'];

				$lineItemService = $this->instanceDfp()->GetService('LineItemService', 'v201403');

				// Create bind variables.
				$vars =
					MapUtils::GetMapEntries(array('orderId' => new NumberValue($orderId)));

				// Create a statement to only select line items that need creatives
				// from a given order.
				$filterStatement = new Statement("WHERE orderId = :orderId "
					. " LIMIT 500", $vars);

				// Get line items by statement.
				$page = $lineItemService->getLineItemsByStatement($filterStatement);

				// Display results.
				$optionsLines = '<option value="">Seleccione</option>';
				if (isset($page->results)) {
					$i = $page->startIndex;
					foreach ($page->results as $lineItem) {
						if (!$lineItem->isArchived) {
							$optionsLines .= '<option value="' . $lineItem->id . '">'. $lineItem->name . '[' . $lineItem->status . ']' . '</option>';
							// print $i . ') Line item with ID "'
							// 	. $lineItem->id . '", belonging to order ID "'
							// 	. $lineItem->orderId . '", and name "' . $lineItem->name . ' and status is: '
							// 	. $lineItem->status
							// 	. "\" was found.\n";
							$i++;
						}
					}
				}
				echo $optionsLines;
				#print 'Number of results found: ' . $page->totalResultSetSize . "\n";
			} else {
				echo "";
			}
			
		} else {
			echo "";
		}

		exit();
	}

/**
 * admin_getplugin method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_getplugin($id = null) {
		$this->Site->id = $id;
		if (!$this->Site->exists()) {
			throw new NotFoundException(__('Invalid site'));
		}
		// $this->request->onlyAllow('post', 'delete');
		// if ($this->Zona->delete()) {
		// 	$this->Session->setFlash(__('The zona has been deleted.'));
		// } else {
		// 	$this->Session->setFlash(__('The zona could not be deleted. Please, try again.'));
		// }
		// return $this->redirect(array('action' => 'index'));
		$this->set('site_id', $id);
	}

/**
 * admin_descarga method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_descarga($id = null) {
		$this->Site->id = $id;
		if (!$this->Site->exists()) {
			throw new NotFoundException(__('Invalid site'));
		}

		if ($id) {
			try {
				// Get adunits
				$zonasAll = $this->Zona->find('all', array('conditions' => array('Zona.sites_id' => $id)));
				if ($zonasAll) {
					foreach ($zonasAll as $key => $la_zona) {
						$infoToPlugin[$la_zona['AdUnit'][0]['id']] = array(
								'site' => array(
										'domain' => $la_zona['Sites']['domain'],
										'public_key' => $la_zona['Sites']['public_key'],
									),
								'zona' => array(
										'name' => $la_zona['Zona']['name'],
										'id_tag_template' => $la_zona['Zona']['id_tag_template'],
									),
								'adunit' => array(
									)
							);
						$adunits_ids_arr[] = $la_zona['AdUnit'][0]['id'];
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
				// $filename = 'daiwa_knot.pdf.zip';
				// $filepath = WWW_ROOT . DS;

				// header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
				// header("Content-Type: application/zip");
				// header("Content-Transfer-Encoding: Binary");
				// header("Content-Length: ".filesize($filepath.$filename));
				// header("Content-Disposition: attachment; filename=\"".$filename."\"");
				// @readfile($filepath.$filename);

			} catch (OAuth2Exception $e) {
				$this->Session->write('redirect_url', $this->request->url);
				$this->redirect(array('controller' => 'users', 'action' => 'call_oauth', 'admin' => false));

			} catch (ValidationException $e) {
				#ExampleUtils::CheckForOAuth2Errors($e);
			} catch (Exception $e) {
				print $e->getMessage() . "\n";
			}
			die();

		}//End if ($id) {
        exit;
	}

	private function createZipPlugin($info) {
		$head_ads_all = $insert_adss_all = '';
		foreach ($info as $keyad => $ad) {
			if (isset($ad['adunit'])) {
				//read head ads template
				$adunit_code = (isset($ad['adunit']['adunitcode'])) ?  : '';
				$adunit_size = (isset($ad['adunit']['sizes'][0]['width']) && isset($ad['adunit']['sizes'][0]['height'])) ? $ad['adunit']['sizes'][0]['width'] . ',' . $ad['adunit']['sizes'][0]['height'] : '';
				$head_ads = WWW_ROOT . 'template' .DS . 'head_ads.txt';
				$head_ads_content = file_get_contents($head_ads);
					$find = array('{network_code}', '{adunit_code}', '{adunit_size}', '{adunit_id}');
					$replace = array($info['networkcode'], $adunit_code, $adunit_size, $keyad);

				$head_ads_all .= str_replace($find, $replace, $head_ads_content);

				//read inserts ads template
				$insert_ads = WWW_ROOT . 'template' .DS . 'insert_ads.txt';
				$insert_ads_content = file_get_contents($insert_ads);
			}
		}
		

		// read base file plugin
		$base_plugin = WWW_ROOT . 'template' .DS . 'base.txt';
		$base_plugin_content = file_get_contents($base_plugin);
		
		// reaplace tags on base content
		$base_plugin_content = str_replace("{head_ads}", $head_ads_all, $base_plugin_content);

		echo "<pre>";
		echo $insert_ads_content;
		echo "</pre>";

		#debug($base_plugin_content);
		
		#debug($info);
	}
}
