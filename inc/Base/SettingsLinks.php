<?php

/**
 * @package  WPGreeksCPT
 */

namespace Wpgreekscpt\Base;

class SettingsLinks
{
	public function register() 
	{
		add_filter( "plugin_action_links_" . WPGREEKS_PLUGIN, array( $this, 'settings_link' ) );
	}

	public function settings_link( $links ) 
	{
		$settings_link = '<a href="admin.php?page=wpgreeks_plugin">Go To Settings</a>';
		array_push( $links, $settings_link );
		return $links;
	}
}