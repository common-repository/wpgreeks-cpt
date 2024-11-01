<?php 
/**
 * @package  WPGreeksCPT
 */

namespace Wpgreekscpt\Api\CallBacks;

use Wpgreekscpt\Base\BaseController;

class ManagerCallbacks extends BaseController
{
	public function checkboxSanitize( $input )
	{
		$output = array();

		foreach ( $this->wpgreeks_managers as $key => $value ) {
			$output[$key] = isset( $input[$key] ) ? true : false;
		}

		return $output;
	}

	public function adminSectionManager()
	{
		$tabDescription = "Manage the Sections and Features of this Plugin by activating the toggle from the following list. Rest of features are coming soon.";
		echo '<p>' . esc_html($tabDescription) . '</p>';
	}

	public function checkboxField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$checkbox = get_option( $option_name );
		$checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;

		echo '<div class="' . esc_attr($classes) . '"><input type="checkbox" id="' . esc_attr($name) . '" name="' . esc_attr($option_name) . '[' . esc_attr($name) . ']" value="1" class="" ' . checked($checked, true, false) . '><label for="' . esc_attr($name) . '"><div></div></label></div>';
	}
}