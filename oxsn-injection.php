<?php


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


/*
Plugin Name: OXSN Injection
Plugin URI: https://wordpress.org/plugins/oxsn-injection/
Description: This plugin adds helpful injectable shortcodes with quicktags!
Author: oxsn
Author URI: https://oxsn.com/
Version: 0.0.3
*/


define( 'oxsn_injection_plugin_basename', plugin_basename( __FILE__ ) );
define( 'oxsn_injection_plugin_dir_path', plugin_dir_path( __FILE__ ) );
define( 'oxsn_injection_plugin_dir_url', plugin_dir_url( __FILE__ ) );

if ( ! function_exists ( 'oxsn_injection_settings_link' ) ) {

	add_filter( 'plugin_action_links', 'oxsn_injection_settings_link', 10, 2 );
	function oxsn_injection_settings_link( $links, $file ) {

		if ( $file != oxsn_injection_plugin_basename )
		return $links;
		$settings_page = '<a href="' . menu_page_url( 'oxsn-injection', false ) . '">' . esc_html( __( 'Settings', 'oxsn-injection' ) ) . '</a>';
		array_unshift( $links, $settings_page );
		return $links;

	}

}


?><?php


/* OXSN Dashboard Tab */

if ( !function_exists('oxsn_dashboard_tab_nav_item') ) {

	add_action('admin_menu', 'oxsn_dashboard_tab_nav_item');
	function oxsn_dashboard_tab_nav_item() {

		add_menu_page('OXSN', 'OXSN', 'manage_options', 'oxsn-dashboard', 'oxsn_dashboard_tab' );

	}

}

if ( !function_exists('oxsn_dashboard_tab') ) {

	function oxsn_dashboard_tab() {

		if (!current_user_can('manage_options')) {

			wp_die( __('You do not have sufficient permissions to access this page.') );

		}

	?>

		<?php if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y') : ?>

			<div id="message" class="updated">

				<p><strong><?php _e('Settings saved.') ?></strong></p>

			</div>

		<?php endif; ?>
		
		<div class="wrap">
		
			<h2>OXSN / Digital Agency</h2>

			<div id="poststuff">

				<div id="post-body" class="metabox-holder columns-2">

					<div id="post-body-content" style="position: relative;">

						<div class="postbox">

							<h3 class="hndle cursor_initial">Information</h3>

							<div class="inside">

								<p></p>

							</div>
							
						</div>

					</div>

					<div id="postbox-container-1" class="postbox-container">

						<div class="postbox">

							<h3 class="hndle cursor_initial">Coming Soon</h3>

							<div class="inside">

								<p></p>

							</div>
							
						</div>

					</div>

				</div>

			</div>

		</div>

	<?php 

	}

}


?><?php


/* OXSN Plugin Tab */

if ( ! function_exists ( 'oxsn_injection_plugin_tab_nav_item' ) ) {

	add_action('admin_menu', 'oxsn_injection_plugin_tab_nav_item', 99);
	function oxsn_injection_plugin_tab_nav_item() {

		add_submenu_page('oxsn-dashboard', 'OXSN Injection', 'Injection', 'manage_options', 'oxsn-injection', 'oxsn_injection_plugin_tab');

	}

}

if ( !function_exists('oxsn_injection_plugin_tab') ) {

	function oxsn_injection_plugin_tab() {

		if (!current_user_can('manage_options')) {

			wp_die( __('You do not have sufficient permissions to access this page.') );

		}

	?>

		<?php if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y') : ?>

			<div id="message" class="updated">

				<p><strong><?php _e('Settings saved.') ?></strong></p>

			</div>

		<?php endif; ?>
		
		<div class="wrap oxsn_settings_page">
		
			<h2>OXSN / Injection Plugin</h2>

			<div id="poststuff">

				<div id="post-body" class="metabox-holder columns-2">

					<div id="post-body-content" style="position: relative;">

						<div class="postbox">

							<h3 class="hndle cursor_initial">Information</h3>

							<div class="inside">

								<p>Coming soon.</p>

							</div>
							
						</div>

					</div>

					<div id="postbox-container-1" class="postbox-container">

						<div class="postbox">

							<h3 class="hndle cursor_initial">Custom Project</h3>

							<div class="inside">

								<p>Want us to build you a custom project?</p>

								<p><a href="mailto:brief@oxsn.com?Subject=Custom%20Project%20Request%21&Body=Please%20answer%20the%20following%20questions%20to%20help%20us%20better%20understand%20your%20needs..%0A%0A1.%20What%20is%20the%20name%20of%20your%20company%3F%0A%0A2.%20What%20are%20the%20concepts%20and%20goals%20of%20your%20project%3F%0A%0A3.%20What%20is%20the%20proposed%20budget%20of%20this%20project%3F" class="button button-primary button-large">Email Us</a></p>

							</div>
							
						</div>

						<div class="postbox">

							<h3 class="hndle cursor_initial">Support</h3>

							<div class="inside">

								<p>Need help with this plugin? Visit the Wordpress plugin page for support..</p>

								<p><a href="https://wordpress.org/support/plugin/oxsn-injection" target="_blank" class="button button-primary button-large">Support</a></p>

							</div>
							
						</div>

					</div>

				</div>

			</div>

		</div>

	<?php 

	}

}


?><?php


/* OXSN Shortcodes */

//[oxsn_injection injection_filter="" injection_id="" exclude="" class=""]
if ( ! function_exists ( 'oxsn_injection_shortcode' ) ) {

	add_shortcode('oxsn_injection', 'oxsn_injection_shortcode');
	function oxsn_injection_shortcode( $atts, $content = null ) {
		$a = shortcode_atts( array(
			'injection_id' => '',
			'injection_filter' => '',
			'exclude' => array( '' ),
		), $atts );

		$oxsn_injection_id = esc_attr($a['injection_id']);

		$oxsn_injection_filter = esc_attr($a['injection_filter']);
		$oxsn_injection_filter = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $oxsn_injection_filter)));;

		$oxsn_injection_exclude = esc_attr($a['exclude']);
		$oxsn_injection_exclude = explode( ',', $oxsn_injection_exclude );

		if ($oxsn_injection_ad_filter != '') :

			$args = array(
				'posts_per_page' => 1,
				'post_type' => 'injection',
				'page_id' => $oxsn_injection_id,
				'orderby'    => 'rand',
				'hide_empty' => 0,
				'post__not_in' => $oxsn_injection_exclude,
				'tax_query' => array(
					array(
						'taxonomy' => 'ad_filter',
						'field'    => 'slug',
						'terms'    => $oxsn_injection_filter,
					),
				),
			);

		else :

			$args = array(
				'posts_per_page' => 1,
				'post_type' => 'injection',
				'page_id' => $oxsn_injection_id,
				'hide_empty' => 0,
				'post__not_in' => $oxsn_injection_exclude,
			);

		endif;
		
		$query = new WP_Query( $args );

		while ( $query->have_posts() ) : $query->the_post();

			$output = get_the_content();

		endwhile;

		wp_reset_postdata();

		return $output;

	}

}


?><?php


/* OXSN Quicktags */

if ( ! function_exists ( 'oxsn_injection_quicktags' ) ) {

	add_action( 'admin_print_footer_scripts', 'oxsn_injection_quicktags' );
	function oxsn_injection_quicktags() {

		if ( wp_script_is( 'quicktags' ) ) {

		?>

			<script type="text/javascript">

				QTags.addButton( 'oxsn_injection_quicktag', '[oxsn_injection]', '[oxsn_injection injection_filter="" injection_id="" exclude=""]', '', 'oxsn_injection', 'Quicktags INJECTION', 301 );

			</script>

		<?php

		}

	}

}


?><?php


/* OXSN Include CSS */

if ( ! function_exists ( 'oxsn_injection_inc_css' ) ) {

	add_action( 'wp_enqueue_scripts', 'oxsn_injection_inc_css' );
	function oxsn_injection_inc_css() {

		wp_enqueue_style( 'oxsn_injection_css', oxsn_injection_plugin_dir_url . 'inc/css/carousel.min.css', array(), '1.0.0', 'all' ); 

	}

}


?><?php


/* OXSN Include JS */

if ( ! function_exists ( 'oxsn_injection_inc_js' ) ) {

	add_action( 'wp_enqueue_scripts', 'oxsn_injection_inc_js' );
	function oxsn_injection_inc_js() {

		wp_enqueue_style( 'oxsn_injection_sudoslider_js', oxsn_injection_plugin_dir_url . 'inc/js/jquery.sudoSlider.min.js', array('jquery'), '1.0.0', true ); 
		wp_enqueue_style( 'oxsn_injection_js', oxsn_injection_plugin_dir_url . 'inc/js/carousel.js', array('jquery'), '1.0.0', true ); 

	}

}


?><?php


/* OXSN Include Post Type */

if ( ! function_exists('oxsn_injection') ) {

	function oxsn_injection() {

		$labels = array(
			'name'                  => _x( 'Injections', 'Post Type General Name', 'oxsn_injection' ),
			'singular_name'         => _x( 'Injection', 'Post Type Singular Name', 'oxsn_injection' ),
			'menu_name'             => __( 'Injections', 'oxsn_injection' ),
			'name_admin_bar'        => __( 'Injection', 'oxsn_injection' ),
			'archives'              => __( 'Injection Archives', 'oxsn_injection' ),
			'parent_item_colon'     => __( 'Parent Injection:', 'oxsn_injection' ),
			'all_items'             => __( 'All Injections', 'oxsn_injection' ),
			'add_new_item'          => __( 'Add New Injection', 'oxsn_injection' ),
			'add_new'               => __( 'Add New', 'oxsn_injection' ),
			'new_item'              => __( 'New Injection', 'oxsn_injection' ),
			'edit_item'             => __( 'Edit Injection', 'oxsn_injection' ),
			'update_item'           => __( 'Update Injection', 'oxsn_injection' ),
			'view_item'             => __( 'View Injection', 'oxsn_injection' ),
			'search_items'          => __( 'Search Injections', 'oxsn_injection' ),
			'not_found'             => __( 'Not found', 'oxsn_injection' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'oxsn_injection' ),
			'featured_image'        => __( 'Featured Image', 'oxsn_injection' ),
			'set_featured_image'    => __( 'Set featured image', 'oxsn_injection' ),
			'remove_featured_image' => __( 'Remove featured image', 'oxsn_injection' ),
			'use_featured_image'    => __( 'Use as featured image', 'oxsn_injection' ),
			'insert_into_item'      => __( 'Insert into injection', 'oxsn_injection' ),
			'uploaded_to_this_item' => __( 'Uploaded to this injection', 'oxsn_injection' ),
			'items_list'            => __( 'Injections list', 'oxsn_injection' ),
			'items_list_navigation' => __( 'Injections list navigation', 'oxsn_injection' ),
			'filter_items_list'     => __( 'Filter injections list', 'oxsn_injection' ),
		);
		$rewrite = array(
			'slug'                  => 'injection',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Injection', 'oxsn_injection' ),
			'description'           => __( 'Injection', 'oxsn_injection' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'author', 'revisions', ),
			'taxonomies'            => array( 'injection_filter' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'page',
			'capabilities' => array(
				'publish_posts' => 'manage_options',
				'edit_posts' => 'manage_options',
				'edit_others_posts' => 'manage_options',
				'delete_posts' => 'manage_options',
				'delete_others_posts' => 'manage_options',
				'read_private_posts' => 'manage_options',
				'edit_post' => 'manage_options',
				'delete_post' => 'manage_options',
				'read_post' => 'manage_options',
			),
		);
		register_post_type( 'injection', $args );

	}
	add_action( 'init', 'oxsn_injection', 0 );

}

?><?php


/* OXSN Include Meta Box */

class oxsn_injection_default_location {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	public function init_metabox() {

		add_action( 'add_meta_boxes',        array( $this, 'add_metabox' )         );
		add_action( 'save_post',             array( $this, 'save_metabox' ), 10, 2 );

	}

	public function add_metabox() {

		add_meta_box(
			'',
			__( 'Default Location', 'text_domain' ),
			array( $this, 'render_metabox' ),
			'injection',
			'normal',
			'default'
		);

	}

	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'oxsn_injection_default_location_nonce_action', 'oxsn_injection_default_location_nonce' );

		// Retrieve an existing value from the database.
		$oxsn_injection_default_location_ = get_post_meta( $post->ID, 'oxsn_injection_default_location_', true );

		// Set default values.
		if( empty( $oxsn_injection_default_location_ ) ) $oxsn_injection_default_location_ = '';

		// Form fields.
		echo '<p class="description">' . __( 'Please select whether you would like this content to be injected into the header, footer, or neither.', 'text_domain' ) . '</p>';
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<td>';
		echo '			<label><input type="radio" name="oxsn_injection_default_location_" class="oxsn_injection_default_location__field" value="oxsn_injection_default_location_header" ' . checked( $oxsn_injection_default_location_, 'oxsn_injection_default_location_header', false ) . '> ' . __( 'Header', 'text_domain' ) . '</label><br>';
		echo '			<label><input type="radio" name="oxsn_injection_default_location_" class="oxsn_injection_default_location__field" value="oxsn_injection_default_location_footer" ' . checked( $oxsn_injection_default_location_, 'oxsn_injection_default_location_footer', false ) . '> ' . __( 'Footer', 'text_domain' ) . '</label><br>';
		echo '			<label><input type="radio" name="oxsn_injection_default_location_" class="oxsn_injection_default_location__field" value="oxsn_injection_default_location_none" ' . checked( $oxsn_injection_default_location_, 'oxsn_injection_default_location_none', false ) . '> ' . __( 'None', 'text_domain' ) . '</label><br>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['oxsn_injection_default_location_nonce'] ) ? $_POST['oxsn_injection_default_location_nonce'] : '';
		$nonce_action = 'oxsn_injection_default_location_nonce_action';

		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Sanitize user input.
		$oxsn_injection_default_location_new_ = isset( $_POST[ 'oxsn_injection_default_location_' ] ) ? $_POST[ 'oxsn_injection_default_location_' ] : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'oxsn_injection_default_location_', $oxsn_injection_default_location_new_ );

	}

}

new oxsn_injection_default_location;


?><?php


/* OXSN Include Taxonomy */

if ( ! function_exists( 'oxsn_injection_filter' ) ) {

	function oxsn_injection_filter() {

		$labels = array(
			'name'                       => _x( 'Injection Filters', 'Taxonomy General Name', 'injection_filter' ),
			'singular_name'              => _x( 'Injection Filter', 'Taxonomy Singular Name', 'injection_filter' ),
			'menu_name'                  => __( 'Injection Filter', 'injection_filter' ),
			'all_items'                  => __( 'All Injection Filters', 'injection_filter' ),
			'parent_item'                => __( 'Parent Injection Filter', 'injection_filter' ),
			'parent_item_colon'          => __( 'Parent Injection Filter:', 'injection_filter' ),
			'new_item_name'              => __( 'New Injection Filter Name', 'injection_filter' ),
			'add_new_item'               => __( 'Add New Injection Filter', 'injection_filter' ),
			'edit_item'                  => __( 'Edit Injection Filter', 'injection_filter' ),
			'update_item'                => __( 'Update Injection Filter', 'injection_filter' ),
			'view_item'                  => __( 'View Injection Filter', 'injection_filter' ),
			'separate_items_with_commas' => __( 'Separate injection filters with commas', 'injection_filter' ),
			'add_or_remove_items'        => __( 'Add or remove injection filters', 'injection_filter' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'injection_filter' ),
			'popular_items'              => __( 'Popular Injection Filters', 'injection_filter' ),
			'search_items'               => __( 'Search Injection Filters', 'injection_filter' ),
			'not_found'                  => __( 'Not Found', 'injection_filter' ),
			'no_terms'                   => __( 'No injection filters', 'injection_filter' ),
			'items_list'                 => __( 'Injection Filters list', 'injection_filter' ),
			'items_list_navigation'      => __( 'Injection Filters list navigation', 'injection_filter' ),
		);
		$rewrite = array(
			'slug'                       => 'injection-filter',
			'with_front'                 => true,
			'hierarchical'               => false,
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'rewrite'                    => $rewrite,
		);
		register_taxonomy( 'injection_filter', array( 'injection' ), $args );

	}
	add_action( 'init', 'oxsn_injection_filter', 0 );

}


?><?php


/* OXSN Modify Admin */

if ( ! function_exists ( 'oxsn_injection_hide_default_meta_boxes' ) ) {

	add_action('default_hidden_meta_boxes', 'oxsn_injection_hide_default_meta_boxes', 10, 2);
	function oxsn_injection_hide_default_meta_boxes($hidden, $screen) {
		
		$post_type = $screen->post_type;

		if ( $post_type == 'injection' ) :
			
			$hidden = array('slugdiv', 'authordiv');

			return $hidden;
		
		endif;

		return $hidden;

	}

}

if ( ! function_exists ( 'oxsn_injection_disable_wyswyg' ) ) {

	add_filter( 'wp_editor_settings', 'oxsn_injection_disable_wyswyg', 10, 2 );
	function oxsn_injection_disable_wyswyg( $settings, $editor_id ) {

		if ( $editor_id === 'content' && get_current_screen()->post_type === 'injection' ) {
			$settings['tinymce']   = false;
			$settings['quicktags'] = false;
			$settings['media_buttons'] = false;
		}

		return $settings;

	}

}


?><?php


/* OXSN Include in Footer */

if ( ! function_exists ( 'oxsn_injection_footer_inc' ) ) {

	add_action( 'wp_footer', 'oxsn_injection_footer_inc');
	function oxsn_injection_footer_inc() { 

		$args = array(
		    'posts_per_page' => -1,
		    'post_type' => 'injection',
		    'meta_query'=> array(
		        array(
		            'key' => 'oxsn_injection_default_location_',
		            'compare' => '=',
		            'value' => 'oxsn_injection_default_location_footer',
		        )
		    ),
		);

		$oxsn_injection_query = new WP_Query( $args );

		while ( $oxsn_injection_query->have_posts() ) : $oxsn_injection_query->the_post();

		    echo get_the_content();

		endwhile;

		wp_reset_postdata();

	}	

}


?><?php


/* OXSN Include in Header */


if ( ! function_exists ( 'oxsn_injection_header_inc' ) ) {

	add_action( 'wp_head', 'oxsn_injection_header_inc');
	function oxsn_injection_header_inc() { 

		$args = array(
		    'posts_per_page' => -1,
		    'post_type' => 'injection',
		    'meta_query'=> array(
		        array(
		            'key' => 'oxsn_injection_default_location_',
		            'compare' => '=',
		            'value' => 'oxsn_injection_default_location_header',
		        )
		    ),
		);

		$oxsn_injection_query = new WP_Query( $args );

		while ( $oxsn_injection_query->have_posts() ) : $oxsn_injection_query->the_post();

		    echo get_the_content();

		endwhile;

		wp_reset_postdata();

	}	

}


?>