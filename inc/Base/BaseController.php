<?php 

/**
 * @package  WPGreeksCPT
 */

namespace Wpgreekscpt\Base;

class BaseController
{
	public $wpgreeks_plugin_path;
	public $wpgreeks_plugin_url;
	protected $wpgreeks_plugin;
	public $wpgreeks_managers = array();

	public function __construct() {

		$this->wpgreeks_plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->wpgreeks_plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->wpgreeks_plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/wpgreeks-plugin.php';

		$this->wpgreeks_managers = array(
			'cpt_manager' => 'Activate CPT Manager',
			'modern_design'=> 'Enable Modern Design UI',
			'taxonomy_manager' => 'Activate Taxonomy Manager',
			'wpgreeks_widget' => 'Activate WPGreeks Widget'
		);
	}

	public function wpgreeks_activated( string $key )
	{
		$option = get_option( 'wpgreeks_plugin' );

		return isset( $option[ $key ] ) ? $option[ $key ] : false;
	}
}