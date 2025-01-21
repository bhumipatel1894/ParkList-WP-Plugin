<?php
/**
 * Admin Class
 *
 * Handles the admin functionality of the plugin
 *
 * @package Parks Directory
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class PD_Admin {

	function __construct() {

		// Action to add metabox
		add_action( 'add_meta_boxes', array( $this, 'pd_post_sett_metabox' ) );

		// Action to save the metabox data
		add_action( 'save_post', array( $this, 'parks_list_save_meta_box' ) );
	}

	/**
	 * Post Settings Metabox
	 * 
	 * @since 2.1
	 */
	function pd_post_sett_metabox() {
		add_meta_box( 'pd_details_meta_box', __('Park Details', 'parks-directory'), array($this, 'pd_render_meta_box'), PD_POST_TYPE, 'normal', 'high' );
	}

	/**
	 * Function to handle 'premium' metabox HTML
	 * 
	 * @since 2.1
	 */
	function pd_render_meta_box( $post ) {

		// Get existing values
		$location = get_post_meta($post->ID, 'location', true);
		$weekday_hours = get_post_meta($post->ID, 'weekday_hours', true);
		$weekend_hours = get_post_meta($post->ID, 'weekend_hours', true);
		 
		// Security nonce
		wp_nonce_field('parks_list_save_meta_box', 'parks_list_meta_box_nonce');
	
		?>
		<p>
			<label for="location"><strong>Location:</strong></label><br>
			<input type="text" id="location" name="location" value="<?php echo esc_attr($location); ?>" size="50">
		</p>
		<p>
			<label for="weekday_hours"><strong>Weekday Hours:</strong></label><br>
			<input type="text" id="weekday_hours" name="weekday_hours" value="<?php echo esc_attr($weekday_hours); ?>" size="50">
		</p>
		<p>
			<label for="weekend_hours"><strong>Weekend Hours:</strong></label><br>
			<input type="text" id="weekend_hours" name="weekend_hours" value="<?php echo esc_attr($weekend_hours); ?>" size="50">
		</p>
		<?php
	}

	// Save meta box data when the post is saved
	function parks_list_save_meta_box($post_id) {
		// Verify nonce
		if (!isset($_POST['parks_list_meta_box_nonce']) || 
			!wp_verify_nonce($_POST['parks_list_meta_box_nonce'], 'parks_list_save_meta_box')) {
			return;
		}

		// Check for autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		// Check user permission
		if (!current_user_can('edit_post', $post_id)) {
			return;
		}

		// Save data
		if (isset($_POST['location'])) {
			update_post_meta($post_id, 'location', sanitize_text_field($_POST['location']));
		}
		if (isset($_POST['weekday_hours'])) {
			update_post_meta($post_id, 'weekday_hours', sanitize_text_field($_POST['weekday_hours']));
		}
		if (isset($_POST['weekend_hours'])) {
			update_post_meta($post_id, 'weekend_hours', sanitize_text_field($_POST['weekend_hours']));
		}
	}
}

// Initialize the admin class
$PD_Admin = new PD_Admin();