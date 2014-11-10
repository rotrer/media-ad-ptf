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
	public $uses = array('Plugin', 'Site', 'User', 'AdOrder', 'LineItem', 'Zona');
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
		$this->set('plugin', $this->Plugin->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Plugin->create();
			if ($this->Plugin->save($this->request->data)) {
				$this->Session->setFlash(__('The plugin has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The plugin could not be saved. Please, try again.'));
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
				$adunitsPieces = implode(',', $line['adunits']);
				$lineList[$key . ',' . $adunitsPieces] = $line['name'];
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
			if ($this->Plugin->save($this->request->data)) {
				$this->Session->setFlash(__('The plugin has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The plugin could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Plugin.' . $this->Plugin->primaryKey => $id));
			$this->request->data = $this->Plugin->find('first', $options);
		}
		$sites = $this->Plugin->Site->find('list');
		$adOrders = $this->Plugin->AdOrder->find('list');
		$this->set(compact('sites', 'adOrders'));
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
				$adunitsLine = array();
				foreach ($page->results as $lineItem) {
					if (count($lineItem->targeting->inventoryTargeting->targetedAdUnits) > 0) {
						foreach ($lineItem->targeting->inventoryTargeting->targetedAdUnits as $key => $target) { 
							$adunitsLine[] = $target->adUnitId;
						}

						$adunitsPieces = implode(',', $adunitsLine);
					}
					$listLines .= '<option value="' . $lineItem->id . ',' . $adunitsPieces . '">' . $lineItem->name . '</option>';
				}
			}

			$offset += 500;
		} while ($offset < $page->totalResultSetSize);

		$html = '<div class="row rowZonas">
					<div class="col-md-3">
						<div class="form-group">

  						<select name="line_item[]" class="form-control selectedLine" required="required" id="PluginSitesId">
<option value="">Seleccione</option>' . $listLines . '
</select>						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
  						<select name="ad_unit[]" class="form-control" required="required" id="PluginSitesId">
<option value="">Seleccione</option>
</select>						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
  						<input name="zona_name[]" class="form-control" required="required" type="text" id="PluginSitesId">						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
  						<input name="id_tag_template[]" class="form-control" required="required" type="text" id="PluginSitesId">						</div>
						<button type="button" class="btn btn-danger  pull-right">
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
			// $adunitsArr = '92828173,92827693,92827933,92827813';
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
							$adunitsList .= '<option value="'. $adUnit->id .'">' . $adUnit->name . '[' . $adUnit->status . ']' . '</option>';
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
}
