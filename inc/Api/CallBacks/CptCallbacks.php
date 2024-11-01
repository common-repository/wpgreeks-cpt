<?php 

/**
 * @package  WPGreeksCPT
 */
namespace Wpgreekscpt\Api\CallBacks;

class CptCallbacks
{

	public function cptSectionManager()
	{
		$sectionDescription = "Create as many Custom Post Types as you want.";
		echo '<p>' . esc_html($sectionDescription) . '</p>';
	}

	public function cptSanitize( $input )
	{
		$output = get_option('wpgreeks_plugin_cpt');

		if ( isset($_POST["remove"]) && isset($_POST["remove_post_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST["remove_post_wpnonce"] ) ), 'check_remove_post_nonce') ) {
			unset($output[$_POST["remove"]]);

			return $output;
		}

		if ( ( is_countable($output) && count($output) ) == 0 ) {
			$output[$input['post_type']] = $input;

			return $output;
		}

		foreach ($output as $key => $value) {
			if ($input['post_type'] === $key) {
				$output[$key] = $input;
			} else {
				$output[$input['post_type']] = $input;
			}
		}
		
		return $output;
	}

	public function textField( $args )
	{
		$name = $args['label_for'];
		$option_name = $args['option_name'];
		$field_description = $args['field_description'];
		$value = '';

		if ( isset($_POST["wpgreeks_edit_post"]) && isset($_POST["edit_post_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST["edit_post_wpnonce"] ) ), 'check_edit_post_nonce') ) {
			    $input = get_option( $option_name );

			    $post_key = wp_unslash( $_POST["wpgreeks_edit_post"] );
			    $value = isset($input[$post_key][$name]) ? sanitize_text_field($input[$post_key][$name]) : null;
		}


		echo '<input type="text" class="regular-text" id="' . esc_attr($name) . '" name="' . esc_attr($option_name) . '[' . esc_attr($name) . ']" value="' . esc_attr($value) . '" placeholder="' . esc_attr($args['placeholder']) . '" required>';
		echo '<p class="wpgreeks-field-description">' . esc_attr($field_description) . '</p>';
	}

	public function checkboxField( $args )
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$field_description = $args['field_description'];
		$checked = false;

		if ( isset($_POST["wpgreeks_edit_post"]) && isset($_POST["edit_post_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST["edit_post_wpnonce"] ) ), 'check_edit_post_nonce') ) {
			$checkbox = get_option( $option_name );
			$checked = isset($checkbox[$_POST["wpgreeks_edit_post"]][$name]) ?: false;
		}
		
		echo '<div class="' . esc_attr($classes) . '"><input type="checkbox" id="' . esc_attr($name) . '" name="' . esc_attr($option_name) . '[' . esc_attr($name) . ']" value="1" class="" ' . checked($checked, true, false) . '><label for="' . esc_attr($name) . '"><div></div></label></div>';
		echo '<p class="wpgreeks-field-description">' . esc_attr($field_description) . '</p>';
	}
}