<?php
/**
 * 'park_list' Shortcode
 * 
 * @package Parks Directory
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function pd_get_parklist( $atts){
	ob_start();
    $content2 = '';
    ?>
    <div class="container">
        <div class="row">
            <div class="parks-filter col-md-12 col-sm-12">
                <div id="facilities_filter">                
                    <button class="fac_btn" id="all">ALL</button>
                    <?php
                    $facilities = get_terms(array(
                        'taxonomy' => 'facilities', // Custom taxonomy
                        'orderby' => 'name',
                        'order' => 'ASC',
                        'hide_empty' => true 
                    ));
                    foreach ($facilities as $facility) {
                        echo '<button class="fac_btn" id="'. esc_attr($facility->slug) . '">'.          esc_html($facility->name) . '</button>';               
                    }
                    ?>
                    <input type="hidden" name="curr_facility" id="curr_facility" value="all" />
                </div> 
                
                <div id="parks-list-container" class="col-md-12">
                <?php
                $content = '';
                $args = array(
                    'post_type'      => PD_POST_TYPE,
                    'posts_per_page' => 3,
                    'orderby'		=> 'date', 
		            'order'			=> 'ASC',
                    'paged'          => 1,
                );
                        
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
                                <div class="col-md-8 col-sm-6">
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
                                <div class="col-md-4 col-sm-6 pdimg-sec">
                                    <img src="'.$feat_image.'" />
                                </div>
                            </div>               
                            </div>
                        </div>';
                    } }
                    echo $content;
                    ?>
                </div>
                <button id="load-more-parks" data-page="1">Load More</button>   
            </div>
        </div>        
    </div>
    <?php	
	$content2 .= ob_get_clean();
	return $content2;
}

// Blog Shortcode
add_shortcode( 'park_list', 'pd_get_parklist' );