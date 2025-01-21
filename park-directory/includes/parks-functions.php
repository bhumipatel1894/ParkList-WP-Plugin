<?php
/**
 * Plugin generic functions file
 *
 * @package Parks Directory
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action('wp_enqueue_scripts', 'enqueue_frontend_script');
function enqueue_frontend_script() {

     // Register Style
     wp_register_style( 'pd-public-style', PD_URL.'assets/css/parks-public.css', array(), PD_VERSION );
     wp_register_style( 'pd-bootstrap-css', PD_URL.'assets/css/bootstrap.min.css', array(), PD_VERSION );
     wp_register_style( 'pd-bootstrap-grid-css', PD_URL.'assets/css/bootstrap-grid.min.css', array(), PD_VERSION );
     
     wp_enqueue_style( 'pd-bootstrap-css' );
     wp_enqueue_style( 'pd-bootstrap-grid-css' );
     wp_enqueue_style( 'pd-public-style' );

    // Ensure jQuery is loaded properly
    if (!wp_script_is('jquery', 'registered')) {
        wp_register_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', false, '3.6.0', true);
    }
    wp_enqueue_script('jquery');

    // Register and enqueue your custom script
    wp_register_script('park-public-js', PD_URL . 'assets/js/parks-public.js', array('jquery'), '1.0.2', true);
    wp_localize_script('park-public-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_enqueue_script('park-public-js'); // Corrected script handle
}

add_action('wp_ajax_load_parks', 'parks_list_fetch_parks');
add_action('wp_ajax_nopriv_load_parks', 'parks_list_fetch_parks');
function parks_list_fetch_parks() {

    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $facility = isset($_POST['facility']) ? sanitize_text_field($_POST['facility']) : '';
    $facility = ($facility == 'all') ? '' : $facility ;
    $content = '';
        
    $args = array(
        'post_type'      => PD_POST_TYPE,
        'posts_per_page' => 3,
        'orderby'		=> 'date', 
		'order'			=> 'ASC',
        'paged'         => $page,
    );

    if ($facility) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => PD_CAT,
                'field'    => 'slug',
                'terms'    => $facility,
            ),
        );
    }

    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $location = get_post_meta(get_the_ID(), 'location', true);
            $weekday_hours = get_post_meta(get_the_ID(), 'weekday_hours', true);
            $weekend_hours = get_post_meta(get_the_ID(), 'weekend_hours', true);
            $short_description = wp_trim_words(get_the_content(), 20, '...');
            $feat_image = pd_featured_image( get_the_ID(), 'medium' );
            
           
            $content .= '<div class="park-item" >
                <div clas="content-cover">
                <div class="row">  
                    <div class="col-md-6 col-sm-6">
                    
                        <h3>' . get_the_title() . '</h3>';
            if($location){
                $content .= '<p><strong>Location: </strong>' . esc_html($location) . '</p>';
            }
            $content .= '<div class="row">';
            if($weekday_hours){
                $content .= '<div class="col-md-12 col-sm-12"><strong>Weekday: </strong>' . esc_html($weekday_hours) . '</div>';
            }
            if($weekend_hours){
                $content .= '<div class="col-md-6 col-sm-6"><strong>Weekend: </strong>' . esc_html($weekend_hours) . '</div>';
            }
            if($short_description){
                $content .= '<div class="col-md-12 col-sm-12"><p>' . esc_html($short_description) . '</p></div>';
            }
            $content .= '</div> </div>
                    <div class="col-md-6 col-sm-6 pdimg-sec">
                        <img src="'.$feat_image.'" />
                    </div>
                </div>               
                </div>
            </div>';
        }

        echo $content;
    } else {

        echo $content = '';
    }    
    wp_reset_postdata();
    die();
}

/**
 * Function to get post featured image
 * 
 * @since 1.1.7
 */
function pd_featured_image( $post_id = '', $size = 'full' ) {

	global $post;

	if( empty( $post_id ) ) {
		$post_id = isset( $post->ID ) ? $post->ID : $post_id;
	}

	$size   = ! empty( $size ) ? $size : 'full';
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

	if( ! empty( $image ) ) {
		$image = isset( $image[0] ) ? $image[0] : '';
	}

	return $image;

}