<?php 

/**
 * @package  WPGreeksCPT
 */

namespace Wpgreekscpt\Api\CallBacks;

class TaxonomyCallbacks
{
	public function taxSectionManager() 
	{
		$sectionDescription = "Create custom taxonomies to classify post type content";
		echo '<p>' . esc_html($sectionDescription) . '</p>';
	}

	public function taxSanitize( $input )
	{
		$output = get_option('wpgreeks_plugin_tax');

		if ( isset($_POST["remove"]) && isset($_POST["remove_taxonomy_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST["remove_taxonomy_wpnonce"] ) ), 'check_remove_taxonomy_nonce') ) {
			unset($output[$_POST["remove"]]);

			return $output;
		}

		if ( ( is_countable($output) && count($output) ) == 0 ) {
			$output[$input['taxonomy']] = $input;

			return $output;
		}

		foreach ($output as $key => $value) {
			if ($input['taxonomy'] === $key) {
				$output[$key] = $input;
			} else {
				$output[$input['taxonomy']] = $input;
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

		if ( isset($_POST["wpgreeks_edit_taxonomy"]) && isset($_POST["edit_taxonomy_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST["edit_taxonomy_wpnonce"] ) ), 'check_edit_taxonomy_nonce') ) {
			    $input = get_option( $option_name );

			    $taxonomy_key = wp_unslash( $_POST["wpgreeks_edit_taxonomy"] );
			    $value = isset($input[$taxonomy_key][$name]) ? $input[$taxonomy_key][$name] : null;
				$value = isset($input[$taxonomy_key][$name]) ? sanitize_text_field($input[$taxonomy_key][$name]) : null;
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

		if ( isset($_POST["wpgreeks_edit_taxonomy"]) && isset($_POST["edit_taxonomy_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST["edit_taxonomy_wpnonce"] ) ), 'check_edit_taxonomy_nonce') ) {
			$checkbox = get_option( $option_name );
			$checked = isset($checkbox[$_POST["wpgreeks_edit_taxonomy"]][$name]) ?: false;
		}

		echo '<div class="' . esc_attr($classes) . '"><input type="checkbox" id="' . esc_attr($name) . '" name="' . esc_attr($option_name) . '[' . esc_attr($name) . ']" value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . esc_attr($name) . '"><div></div></label></div>';

		echo '<p class="wpgreeks-field-description">' . esc_attr($field_description) . '</p>';
	}

	public function checkboxPostTypesField( $args )
	{
		$output = '';
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$checked = false;

		if ( isset($_POST["wpgreeks_edit_taxonomy"]) && isset($_POST["edit_taxonomy_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST["edit_taxonomy_wpnonce"] ) ), 'check_edit_taxonomy_nonce') ) {
			$checkbox = get_option( $option_name );
		}

		$post_types = get_post_types( array( 'show_ui' => true ) );

		foreach ($post_types as $post) {

			if ( isset($_POST["wpgreeks_edit_taxonomy"]) && isset($_POST["edit_taxonomy_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST["edit_taxonomy_wpnonce"] ) ), 'check_edit_taxonomy_nonce') ) {
				$checked = isset($checkbox[$_POST["wpgreeks_edit_taxonomy"]][$name][$post]) ?: false;
			}

			$output .= '<div class="' . esc_attr($classes) . ' mb-10"><input type="checkbox" id="' . esc_attr($post) . '" name="' . esc_attr($option_name) . '[' . esc_attr($name) . '][' . esc_attr($post) . ']" value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . esc_attr($post) . '"><div></div></label> <strong>' . esc_html($post) . '</strong></div>';

		}

		echo $output;
	}
}