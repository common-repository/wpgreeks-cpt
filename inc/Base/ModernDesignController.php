<?php 

/**
 * @package  WPGreeksCPT
 */

namespace Wpgreekscpt\Base;

use Wpgreekscpt\Base\BaseController;

class ModernDesignController extends BaseController
{

	public function register()
	{
		if ( ! $this->wpgreeks_activated( 'modern_design' ) ) return;

        add_action( 'admin_enqueue_scripts', array( $this, 'wpgreeks_enqueue_modern_design' ) );

	}

    function wpgreeks_enqueue_modern_design() {

		// enqueue all our scripts
		wp_enqueue_style( 'wpgreeks-admin-menu', $this->wpgreeks_plugin_url . 'assets/css/admin-menu.css', '1.0.0', 'all' );
	}
}