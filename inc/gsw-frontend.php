<?php

defined( 'WPINC' ) or die;


function wpstudio_gsw_add_widget_area() {
	genesis_register_sidebar( array(
		'id'            => 'slide-in-widget',
		'name'          => __( 'Slide-in Widget', 'genesis-slide-widget' ),
		'description'   => __( 'This is the slide-in widget area', 'genesis-slide-widget' ),
	) );
}

add_action( 'widgets_init', 'wpstudio_gsw_add_widget_area');


function wpstudio_gsw_add_widget() {
	if (is_active_sidebar( 'slide-in-widget' )) {

		if ( genesis_get_option( 'gsw_position', 'gsw-settings') === 'trigger-left' ) {
			echo '<div class="wpstudio-panel from-left">';
		}
		if ( genesis_get_option( 'gsw_position', 'gsw-settings') === 'trigger-right' ) {
			echo '<div class="wpstudio-panel from-right">';
		}
		echo '<header class="wpstudio-panel-header' . ' ' . genesis_get_option( 'gsw_width', 'gsw-settings' ) .'">';
		echo '<a href="#0" class="wpstudio-panel-close">Close</a>';
		echo '</header>';
		if ( genesis_get_option( 'gsw_background', 'gsw-settings' ) ) { 
			echo '<div class="wpstudio-panel-container' . ' ' . genesis_get_option( 'gsw_width', 'gsw-settings' ) . '"';
			echo 'style="background-color: '. genesis_get_option( 'gsw_background' , 'gsw-settings') .';';
			echo 'color: '. genesis_get_option( 'text_color' , 'gsw-settings') .';">';
		}
			genesis_widget_area( 'creative_headerwidget', array());
		echo '</div></div>';
		

		echo '</div>';

	}

}

add_action( 'genesis_after_footer', 'wpstudio_gsw_add_widget' );


// Add fire button 
add_filter( 'genesis_before', 'wpstudio_gsw_fire' );
function wpstudio_gsw_fire() {
	if (is_active_sidebar( 'slide-in-widget' )) {
		if ( genesis_get_option( 'gsw_show', 'gsw-settings') == 1 ) {

			$classes = array(
			genesis_get_option( 'gsw_position' , 'gsw-settings' ),
			genesis_get_option( 'gsw_fixed' , 'gsw-settings' )
			);

			$classes = implode(' ', $classes);

			echo '<a href="#" style="background-color:'. genesis_get_option( 'gsw_color' , 'gsw-settings')  .'" id="wpstudio-panel-open" class="' . $classes . '">' . genesis_get_option( 'gsw_button', 'gsw-settings' ) . '</a>';
		}
	}
}

//Shortcode
function wpstudio_add_shortcode( $atts, $content = "" ) {
	return '<a href="#" class="wpstudio-shortcode">' . $content . '</a>';
}

add_shortcode('slide-widget', 'wpstudio_add_shortcode');


