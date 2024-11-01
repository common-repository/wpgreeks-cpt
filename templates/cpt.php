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
		<h1 class="wrap-title">CPT Manager</h1>
	</div>

	<div class="ManagerWrapper">
		
		<div class="SettingsErrors">
			<?php settings_errors(); ?>
		</div>

		<div class="CommonTabs">
			<ul class="nav nav-tabs">
				<li class="<?php echo !isset($_POST["wpgreeks_edit_post"]) ? esc_html('active') : esc_html(''); ?>">
					<a href="#tab-1">Your Custom Post Types</a>
				</li>
				<li class="<?php echo isset($_POST["wpgreeks_edit_post"]) && isset($_POST["edit_post_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST["edit_post_wpnonce"] ) ), 'check_edit_post_nonce') ? 'active' : '' ?>">
					<a href="#tab-2">
						<?php echo isset($_POST["wpgreeks_edit_post"]) && isset($_POST["edit_post_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST["edit_post_wpnonce"] ) ) , 'check_edit_post_nonce') ? 'Edit' : 'Add' ?> Custom Post Type
					</a>
				</li>
				<li><a href="#tab-3">Export</a></li>
			</ul>
		</div>

		<div class="tab-content">
			<div id="tab-1" class="tab-pane <?php echo !isset($_POST["wpgreeks_edit_post"]) ? esc_html('active') : esc_html(''); ?>">
				<div class="CommonTable">
					<h3>Manage Your Custom Post Types</h3>

					<?php 
						$editPostNonce = wp_create_nonce('check_edit_post_nonce');
						$removePostNonce = wp_create_nonce('check_remove_post_nonce');
						$options = get_option( 'wpgreeks_plugin_cpt' ) ?: array();

						if (empty($options)) {
						    echo '<p>No custom post types found.</p>';
						} else {

						echo '<table class="cpt-table"><tr><th>Post Type Slug</th><th>Singular Name</th><th>Plural Name</th><th class="text-center">Public</th><th class="text-center">Archive</th><th class="text-center">Actions</th></tr>';

						foreach ($options as $option) {
							$public = isset($option['public']) ? "TRUE" : "FALSE";
							$archive = isset($option['has_archive']) ? "TRUE" : "FALSE";

							echo "<tr><td>" . esc_html($option['post_type']) . "</td><td>" . esc_html($option['singular_name']) . "</td><td>" . esc_html($option['plural_name']) . "</td><td class=\"text-center\">" . esc_html($public) . "</td><td class=\"text-center\">" . esc_html($archive) . "</td><td class=\"text-center\">";

							echo '<form method="post" action="" class="inline-block wpgreeks_edit_cpt_form">';
							echo '<input type="hidden" name="edit_post_wpnonce" value="' . esc_attr($editPostNonce) . '">';
							echo '<input type="hidden" name="wpgreeks_edit_post" value="' . esc_html($option['post_type']) . '">';
							submit_button( 'Edit', 'primary small', 'submit', false);
							echo '</form> ';

							echo '<form method="post" action="options.php" class="inline-block wpgreeks_remove_cpt_form">';
							settings_fields( 'wpgreeks_plugin_cpt_settings' );
							echo '<input type="hidden" name="remove_post_wpnonce" value="' . esc_attr($removePostNonce) . '">';
							echo '<input type="hidden" name="remove" value="' . esc_html($option['post_type']) . '">';
							submit_button( 'Delete', 'delete small', 'submit', false, array(
								'onclick' => 'return confirm("Are you sure you want to delete this Custom Post Type? The data associated with it will not be deleted.");'
							));
							echo '</form></td></tr>';
						}

						echo '</table>'; 
						}
					?>
				</div>
			</div>

			<div id="tab-2" class="tab-pane <?php echo isset($_POST["wpgreeks_edit_post"]) && isset($_POST["edit_post_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST["edit_post_wpnonce"] ) ), 'check_edit_post_nonce') ? 'active' : '' ?>">
				<div class="ManagerPost">
					<form method="post" action="options.php" id="<?php echo isset($_POST["wpgreeks_edit_post"]) && isset($_POST["edit_post_wpnonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST["edit_post_wpnonce"] ) ), 'check_edit_post_nonce') ? 'wpgreeks-edit-cpt-form' : 'wpgreeks-add-cpt-form' ?>">
						<?php 
							settings_fields( 'wpgreeks_plugin_cpt_settings' );
							do_settings_sections( 'wpgreeks_cpt' );
							submit_button();
						?>
					</form>
				</div>
			</div>

			<div id="tab-3" class="tab-pane">
				<div class="ExportPost">
					<h3>Export Your Custom Post Types</h3>
					<?php foreach ($options as $option) { ?>

						<h4><?php echo esc_html($option['singular_name']); ?></h4>

					<pre class="prettyprint">
						// Register Custom Post Type
						function custom_post_type() {

							$labels = array(
								'name'                  => _x( 'Post Types', 'Post Type General Name', 'text_domain' ),
								'singular_name'         => _x( '<?php echo esc_html($option['singular_name']); ?>', 'Post Type Singular Name', 'text_domain' ),
								'menu_name'             => __( '<?php echo esc_html($option['plural_name']); ?>', 'text_domain' ),
								'plural_name'             => __( '<?php echo esc_html($option['plural_name']); ?>', 'text_domain' ),
								'name_admin_bar'        => __( 'Post Type', 'text_domain' ),
								'archives'              => __( 'Item Archives', 'text_domain' ),
								'attributes'            => __( 'Item Attributes', 'text_domain' ),
								'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
								'all_items'             => __( 'All Items', 'text_domain' ),
								'add_new_item'          => __( 'Add New Item', 'text_domain' ),
								'add_new'               => __( 'Add New', 'text_domain' ),
								'new_item'              => __( 'New Item', 'text_domain' ),
								'edit_item'             => __( 'Edit Item', 'text_domain' ),
								'update_item'           => __( 'Update Item', 'text_domain' ),
								'view_item'             => __( 'View Item', 'text_domain' ),
								'view_items'            => __( 'View Items', 'text_domain' ),
								'search_items'          => __( 'Search Item', 'text_domain' ),
								'not_found'             => __( 'Not found', 'text_domain' ),
								'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
								'featured_image'        => __( 'Featured Image', 'text_domain' ),
								'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
								'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
								'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
								'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
								'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
								'items_list'            => __( 'Items list', 'text_domain' ),
								'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
								'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
							);
							$args = array(
								'label'                 => __( 'Post Type', 'text_domain' ),
								'description'           => __( 'Post Type Description', 'text_domain' ),
								'labels'                => $labels,
								'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
								'menu_icon'             => '<?php echo esc_html($option['menu_icon']); ?>',
								'taxonomies'            => array( 'category', 'post_tag' ),
								'hierarchical'          => false,
								'public'                => <?php echo esc_html( isset( $option['public'] ) ? "true" : "false" ); ?>,
								'show_ui'               => true,
								'show_in_menu'          => true,
								'menu_position'         => 5,
								'show_in_admin_bar'     => true,
								'show_in_nav_menus'     => true,
								'can_export'            => true,
								'has_archive'           => <?php echo esc_html( isset($option['has_archive'] ) ? "true" : "false" ); ?>,
								'exclude_from_search'   => false,
								'publicly_queryable'    => true,
								'capability_type'       => 'page',
							);
							register_post_type( '<?php echo esc_html($option['post_type']); ?>', $args );

						}
						add_action( 'init', 'custom_post_type', 0 );
					</pre>

					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>