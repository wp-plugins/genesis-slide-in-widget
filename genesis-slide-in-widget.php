<?php
/*
 Plugin Name: Genesis Slide-in Widget
 Plugin URI: http://wpstud.io/plugins
 Description: Create a slide-in widget area
 Version: 1.0
 Author: Frank Schrijvers
 Author URI: http://www.wpstud.io
 Text Domain: : genesis-slide-widget
 License: GPLv2

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined( 'WPINC' ) or die;

register_activation_hook( __FILE__, 'wpstudio_gsw_activation_check' );
/**
 * This function runs on plugin activation. It checks to make sure the required
 * minimum Genesis version is installed. If not, it deactivates itself.
 */
function wpstudio_gsw_activation_check() {
	$latest = '2.0';
	$theme_info = wp_get_theme( 'genesis' );

	if ( ! function_exists('genesis_pre') ) {
		deactivate_plugins( plugin_basename( __FILE__ ) ); // Deactivate plugin
		wp_die( sprintf( __( 'Sorry, you can\'t activate %1$sGenesis Slide-in Widget unless you have installed the %3$sGenesis Framework%4$s. Go back to the %5$sPlugins Page%4$s.', 'genesis-overlay-widget' ), '<em>', '</em>', '<a href="http://www.studiopress.com/themes/genesis" target="_blank">', '</a>', '<a href="javascript:history.back()">' ) );
	}

	if ( version_compare( $theme_info['Version'], $latest, '<' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) ); // Deactivate plugin
		wp_die( sprintf( __( 'Sorry, you can\'t activate %1$sGenesis Slide-in Widget unless you have installed the %3$sGenesis %4$s%5$s. Go back to the %6$sPlugins Page%5$s.', 'genesis-overlay-widget' ), '<em>', '</em>', '<a href="http://www.studiopress.com/themes/genesis" target="_blank">', $latest, '</a>', '<a href="javascript:history.back()">' ) );
	}
}

add_action('admin_init', 'wpstudio_gsw_deactivate_check');
/**
 * This function runs on admin_init and checks to make sure Genesis is active, if not, it 
 * deactivates the plugin. This is useful for when users switch to a non-Genesis themes.
 */
function wpstudio_gsw_deactivate_check() {
    if ( ! function_exists('genesis_pre') ) {
		deactivate_plugins( plugin_basename( __FILE__ ) ); // Deactivate plugin
    }
} 

//* Enqueue scripts
add_action( 'wp_enqueue_scripts', 'wpstudio_gsw_script_managment', 99);
function wpstudio_gsw_script_managment() {
	if ( function_exists('genesis_get_option')) {
		if ( genesis_get_option( 'gsw_css', 'gsw-settings') == 1 ) {
			wp_enqueue_style( 'wpstudio-style', plugin_dir_url( __FILE__ ) . '/assets/css/wpstudio-gsw-style.css' );
		}
		wp_enqueue_script( 'main', plugin_dir_url( __FILE__ ) . '/assets/js/main.min.js', array( 'jquery' ) );	
	}
}


add_action( 'genesis_admin_init', 'wpstudio_gsw_init');
function wpstudio_gsw_init() {
require( dirname( __FILE__ )  . '/inc/gsw-admin.php');
include( dirname( __FILE__ ) . '/inc/gsw-frontend.php');
new WPSTUDIO_gsw_Settings();
}



