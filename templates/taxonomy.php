<?php
/**
 * @package WPGreeksCPT
 * @author Prashant Agarwal
 * @license GPL-2.0-or-later
 */

// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

?>

<div class="WrapperArea">

	<div class="Title">
		<h1 class="wrap-title">Custom Taxonomy Manager</h1>
	</div>

	<div class="ManagerWrapper">
		
		<div class="SettingsErrors">
			<?php settings_errors(); ?>
		</div>

		<div class="CommonTabs">
			<ul class="nav nav-tabs">
				<li class="<?php echo !isset($_POST["wpgreeks_edit_taxonomy"]) ? 'active' : '' ?>"><a href="#tab-1">Your Taxonomies</a></li>
				<li class="<?php echo isset($_POST["wpgreeks_edit_taxonomy"]) && isset($_POST["edit_taxonomy_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST["edit_taxonomy_wpnonce"] ) ), 'check_edit_taxonomy_nonce') ? 'active' : '' ?>">
					<a href="#tab-2">
						<?php echo isset($_POST["wpgreeks_edit_taxonomy"]) && isset($_POST["edit_taxonomy_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST["edit_taxonomy_wpnonce"] ) ), 'check_edit_taxonomy_nonce') ? 'Edit' : 'Add' ?> Taxonomy
					</a>
				</li>
			</ul>
		</div>

		<div class="tab-content">
			<div id="tab-1" class="tab-pane <?php echo !isset($_POST["wpgreeks_edit_taxonomy"]) ? 'active' : '' ?>">
				<div class="CommonTable">
					<h3>Manage Your Custom Taxonomies</h3>
					<?php
						$editTaxonomyNonce = wp_create_nonce('check_edit_taxonomy_nonce');
						$removeTaxonomyNonce = wp_create_nonce('check_remove_taxonomy_nonce');
						$options = get_option( 'wpgreeks_plugin_tax' ) ?: array();

						if (empty($options)) {
						    echo '<p>No custom taxonomies found.</p>';
						} else {
						    echo '<table class="cpt-table"><tr><th>ID</th><th>Singular Name</th><th>Show Admin Column</th><th>Hierarchical</th><th class="text-center">Actions</th></tr>';

						    foreach ($options as $option) {
						        $hierarchical = isset($option['hierarchical']) ? "TRUE" : "FALSE";
						        $show_admin_column = isset($option['show_admin_column']) ? "TRUE" : "FALSE";

						        echo "<tr><td>" . esc_html($option['taxonomy']) . "</td><td>" . esc_html($option['singular_name']) . "</td><td>" . esc_html($show_admin_column) . "</td><td>" . esc_html($hierarchical) . "</td><td class=\"text-center\">";

						        echo '<form method="post" action="" class="inline-block wpgreeks_edit_taxonomy_form">';
						        echo '<input type="hidden" name="wpgreeks_edit_taxonomy" value="' . esc_html($option['taxonomy']) . '">';
						        echo '<input type="hidden" name="edit_taxonomy_wpnonce" value="' . esc_attr($editTaxonomyNonce) . '">';
						        submit_button( 'Edit', 'primary small', 'submit', false);
						        echo '</form> ';

						        echo '<form method="post" action="options.php" class="inline-block wpgreeks_edit_taxonomy_form">';
						        settings_fields( 'wpgreeks_plugin_tax_settings' );
						        echo '<input type="hidden" name="remove_taxonomy_wpnonce" value="' . esc_attr($removeTaxonomyNonce) . '">';
						        echo '<input type="hidden" name="remove" value="' . esc_html($option['taxonomy']) . '">';
						        submit_button( 'Delete', 'delete small', 'submit', false, array(
						            'onclick' => 'return confirm("Are you sure you want to delete this Custom Taxonomy? The data associated with it will not be deleted.");'
						        ));
						        echo '</form></td></tr>';
						    }

						    echo '</table>';
						}
						?>

				</div>
			</div>

			<div id="tab-2" class="tab-pane <?php echo isset($_POST["wpgreeks_edit_taxonomy"]) && isset($_POST["edit_taxonomy_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST["edit_taxonomy_wpnonce"] ) ), 'check_edit_taxonomy_nonce') ? 'active' : '' ?>">
				<div class="ManagerPost">
					<form method="post" action="options.php" id="<?php echo isset($_POST["wpgreeks_edit_taxonomy"]) && isset($_POST["edit_taxonomy_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST["edit_taxonomy_wpnonce"] ) ), 'check_edit_taxonomy_nonce') ? 'wpgreeks-edit-tax-form' : 'wpgreeks-add-tax-form' ?>">
						<?php 
							settings_fields( 'wpgreeks_plugin_tax_settings' );
							do_settings_sections( 'wpgreeks_taxonomy' );
							submit_button();
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>