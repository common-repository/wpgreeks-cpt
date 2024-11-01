<?php 

/**
 * @package  WPGreeksCPT
 */

namespace Wpgreekscpt\Base;

use \Wpgreekscpt\Base\BaseController;

class Enqueue extends BaseController
{
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'wpgreeks_enqueue' ) );
	}
	
	function wpgreeks_enqueue() {
		
		wp_enqueue_style( 'wpgreeks-main-style', $this->wpgreeks_plugin_url . 'assets/css/wpgreeks-main.css', '1.0.0', 'all' );
		wp_enqueue_script( 'wpgreeks-main-script', $this->wpgreeks_plugin_url . 'assets/js/wpgreeks-main.js', array(), '1.0.0', true );
		wp_enqueue_script( 'wpgreeks-code-prettify', $this->wpgreeks_plugin_url . 'assets/js/run_prettify.js', array(), '1.0.0', true );
	}
}