<?php
App::uses('AppController', 'Controller');
/**
 * Repositories Controller
 *
 * @property Plugin $Plugin
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RepositoriesController extends AppController {

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
	public $components = array();

	public function beforeRender(){
		parent::beforeRender();
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function index() {
		$this->layout = 'ajax';
		// Pull user agent  
		$user_agent = $_SERVER['HTTP_USER_AGENT'];


		//Kill magic quotes.  Can't unserialize POST variable otherwise
		if ( get_magic_quotes_gpc() ) {
				$process = array( &$_GET, &$_POST, &$_COOKIE, &$_REQUEST );
				while ( list($key, $val) = each( $process ) ) {
						foreach ( $val as $k => $v ) {
								unset( $process[$key][$k] );
								if ( is_array( $v ) ) {
										$process[$key][stripslashes( $k )] = $v;
										$process[] = &$process[$key][stripslashes( $k )];
								} else {
										$process[$key][stripslashes( $k )] = stripslashes( $v );
								}
						}
				}
				unset( $process );
		}
		// make sure it's an array
		$packages = array();
		$packages['547f0bfd-45cc-4c96-a33b-0d06de47d803'] = array( //Replace plugin with the plugin slug that updates will be checking for
				'versions' => array(
						'1.1' => array( //Array name should be set to current version of update
								'version' => '1.1', //Current version available
								'date' => '2014-12-2', //Date version was released
								'author' => 'Author Name', //Author name - can be linked using html - <a href="http://link-to-site.com">Author Name</a>
								'requires' => '2.8', // WP version required for plugin
								'tested' => '4.0.1', // WP version tested with
								'homepage' => 'http://media-adserver.media.cl', // Site devoted to your plugin if available
								'downloaded' => '1000', // Number of times downloaded
								'external' => '', // Unused
								//plugin.zip is the same as file_name
								'package' => 'http://media-adserver.media.cl/app/webroot/api/download.php?key=' . md5('plugin.zip' . mktime(0,0,0,date("n"),date("j"),date("Y"))),
								//file_name is the name of the file in the update folder.
								'file_name' => 'plugin.zip',
								'sections' => array(
										/* Plugin Info sections tabs.  Each key will be used as the title of the tab, value is the contents of tab.
											Must be lowercase to function properly
											HTML can be used in all sections below for formating.  Must be properly escaped ie a single quote would have to be \'
											Screenshot section must use exteranl links for img tags.
										 */
										'description' => 'Description of Plugin 1.1', //Description Tab
										'installation' => 'Install Info', //Installaion Tab
										'screen shots' => 'Screen Shots', //Screen Shots
										'change log' => 'Change log', //Change Log Tab
										'faq' => '', //FAQ Tab
										'other notes' => ''    //Other Notes Tab
								)
						)
				),
				'info' => array(
						'url' => 'http://media-adserver.media.cl'  // Site devoted to your plugin if available
				)
		);

		//Create one time download link to secure zip file location
		if ( stristr( $user_agent, 'WordPress' ) == TRUE ) {
				// Process API requests
				$action = $_POST['action'];
				$args = unserialize( $_POST['request'] );
				
				if ( is_array( $args ) )
						$args = $this->array_to_object( $args );

				$latest_package = array_shift( $packages[$args->slug]['versions'] );

		// basic_check

				if ( $action == 'basic_check' ) {
						$update_info = $this->array_to_object( $latest_package );
						$update_info->slug = $args->slug;

						if ( version_compare( $args->version, $latest_package['version'], '<' ) ) {
								$update_info->new_version = $update_info->version;
								print serialize( $update_info );
						}
				}

		// plugin_information

				if ( $action == 'plugin_information' ) {
						$data = new stdClass;

						$data->slug = $args->slug;
						$data->version = $latest_package['version'];
						$data->last_updated = $latest_package['date'];
						$data->download_link = $latest_package['package'];
						$data->author = $latest_package['author'];
						$data->external = $latest_package['external'];
						$data->requires = $latest_package['requires'];
						$data->tested = $latest_package['tested'];
						$data->homepage = $latest_package['homepage'];
						$data->downloaded = $latest_package['downloaded'];
						$data->sections = $latest_package['sections'];
						print serialize( $data );
				}

		} else {
				/*
					An error message can be displayed to users who go directly to the update url
				 */

				echo 'Whoops, this page doesn\'t exist';
		}

	}

	private function array_to_object( $array = array( ) ) {
		if ( empty( $array ) || !is_array( $array ) )
				return false;

		$data = new stdClass;
		foreach ( $array as $akey => $aval )
				$data->{$akey} = $aval;
		return $data;
	}
}