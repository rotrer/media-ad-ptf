<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));

	Router::connect('/admin', array('controller' => 'users', 'action' => 'login', 'admin' => true));#Route admin login
	Router::connect('/oauth2callback', array('controller' => 'users', 'action' => 'oauth2callback'));
	Router::connect('/dashboard', array('controller' => 'pages', 'action' => 'dashboard'));
	Router::connect('/{$prefix}/zonas/add/:site_id/:order_id/:line_item_id', 
					array('controller' => 'zonas', 'action' => 'add', 'admin' => true),
					array(
							'site_id' => '[0-9]+',
							'order_id' => '[0-9]+',
							'line_item_id' => '[0-9]+'
						));

	#Router::connect('/admin', array('controller' => 'users', 'action' => 'login'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
