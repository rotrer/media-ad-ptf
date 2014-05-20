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
		if (!$this->Site->exists($id_site)) {
			#throw new NotFoundException(__('Sitio no válido'));
			$this->Session->setFlash(__('Antes de seleccionar pedidos y sus lineas de pedido, debe generar un sitio.'));
			return $this->redirect(array('controller' => 'sites', 'action' => 'add'));
		}

		if ($id_site) {
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
							// pr( $i . ') Order with ID "' . $order->id
							// 		. '", name "' . $order->name
							// 		. '", and status "' . $order->status
							// 		. "\" will be approved." );

							$i++;
							$orderIds[] = $order->id;
						}
					}
				}

				$offset += 500;
			} while ($offset < $page->totalResultSetSize);

			// pr( 'Number of orders to be approved: ' . sizeof($orderIds) );

			// if (sizeof($orderIds) > 0) {
			// 	// Create action statement.
			// 	$filterStatementText =
			// 		sprintf('WHERE id IN (%s)', implode(',', $orderIds));
			// 	$filterStatement = new Statement($filterStatementText);

			// 	// Create action.
			// 	$action = new ApproveAndOverbookOrders();

			// 	// Perform action.
			// 	$result = $orderService->performOrderAction($action, $filterStatement);

			// 	// Display results.
			// 	if (isset($result) && $result->numChanges > 0) {
			// 		pr( 'Number of orders approved: ' . $result->numChanges );
			// 	} else {
			// 		pr( "No orders were approved.");
			// 	}
			// }


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
	
}
