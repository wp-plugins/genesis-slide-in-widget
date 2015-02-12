<?php
/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the plugin Settings page.
 *
 * @package Genesis Slide Widget
 * @subpackage Admin
 *
 * @since 1.0.0
 */

// Exit if accessed directly
defined( 'WPINC' ) or die;
/**
 * Register a metabox and default settings for the Genesis Simple Logo.
 *
 * @package Genesis\Admin
 */


class WPSTUDIO_gsw_Settings extends Genesis_Admin_Boxes {
    /**
     * Create an archive settings admin menu item and settings page for relevant custom post types.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $settings_field = 'gsw-settings';
        $page_id = 'genesis-slide-widget';
        $menu_ops = array(
                'submenu' => array(
                'parent_slug' => 'genesis',
                'page_title'  => __( 'Genesis Slide-in Widget Settings', 'genesis-slide-widget' ),
                'menu_title'  => __( 'Slide-in Widget', 'genesis-slide-widget' )
            )
        );
        $page_ops = array(); // use defaults
        $center = current_theme_supports( 'genesis-responsive-viewport' ) ? 'mobile' : 'never';
        $default_settings = apply_filters(
            'gsw_settings_defaults',
            array(
                'gsw_background'    => '#FFFFFF',
                'gsw_button'        => 'Push me',
                'gsw_color'         => '#404040',
                'gsw_css'           => '1',
                'gsw_fixed'         => 'trigger-fixed',
                'gsw_position'      => 'trigger-left',
                'gsw_show'          => '1',
                'gsw_width'         => 'gsw-30',
                'text_color'        => '#000000',
            )
        );
        $this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );
        add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );
    }
    /**
     * Register each of the settings with a sanitization filter type.
     *
     * @since 1.0.0
     *
     * @uses genesis_add_option_filter() Assign filter to array of settings.
     *
     * @see \Genesis_Settings_Sanitizer::add_filter()
     */
    public function sanitizer_filters() {
        genesis_add_option_filter( 
            'no_html', 
            $this->settings_field,
            array(
                'gsw_background',
                'gsw_button',
                'gsw_color',
                'gsw_fixed',
                'gsw_position',
                'gsw_width',
                'text_color',
            )
        );
        genesis_add_option_filter( 
            'one_zero', 
            $this->settings_field,
            array( 
                'gsw_css',
                'gsw_show'
            ) 
        );
    }
    /**
     * Register Metabox for the Genesis Simple Logo.
     *
     * @param string $_genesis_theme_settings_pagehook
     * @uses  add_meta_box()
     * @since 1.0.0
     */
    function metaboxes() {
        add_meta_box( 'gsw-settings', __( 'Plugin Settings', 'genesis-slide-widget' ), array( $this, 'gsw_settings' ), $this->pagehook, 'main', 'high' );
    }
    /**
     * Create Metabox which links to and explains the WordPress customizer.
     *
     * @uses  wp_customize_url()
     * @since 1.0.0
     */
    function gsw_settings() {

        ?>

        <p>
            <label style="width: 180px; margin: 0 40px 0 0; display: inline-block;" for="<?php echo $this->get_field_id( 'gsw_css' ); ?>"><?php _e( 'Load plugin styling?', 'genesis-slide-widget' ); ?></label>
            <input type = "checkbox" name="<?php echo $this->get_field_name( 'gsw_css' ); ?>" id="<?php echo $this->get_field_id( 'gsw_css' ); ?>" value="1"<?php checked( $this->get_field_value( 'gsw_css' ) ); ?> />
        </p>

        <hr class="div">

        <h4><?php _e( 'Settings Button', 'genesis-slide-widget' );?></h4>

        <p>
            <label style="width: 180px; margin: 0 40px 0 0; display: inline-block;" for="<?php echo $this->get_field_id( 'gsw_show' ); ?>"><?php _e( 'Show button', 'genesis-slide-widget' ); ?></label>
            <input type = "checkbox" name="<?php echo $this->get_field_name( 'gsw_show' ); ?>" id="<?php echo $this->get_field_id( 'gsw_show' ); ?>" value="1"<?php checked( $this->get_field_value( 'gsw_show' ) ); ?> />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gsw_button' ); ?>"><?php _e( 'Button Text', 'genesis-slide-widget' ); ?></label>
            <input type="text" data-default-color="#ffffff" name="<?php echo $this->get_field_name( 'gsw_button' );?>" id="<?php echo $this->get_field_id( 'gsw_button' );?>?" value="<?php echo $this->get_field_value( 'gsw_button' ); ?>" />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 20px 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gsw_color' ); ?>"><?php _e( 'Button Color', 'genesis-slide-widget' ); ?></label>
            <input type="text" data-default-color="#ffffff" name="<?php echo $this->get_field_name( 'gsw_color' );?>" id="<?php echo $this->get_field_id( 'gsw_color' );?>?" value="<?php echo $this->get_field_value( 'gsw_color' ); ?>" />
        </p>
        <p>
            <label style="width: 180px; margin: 0 40px 0 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gsw_fixed' ); ?>"><?php _e( 'Position Fixed', 'genesis-slide-widget' ); ?></label>
            <input type="radio" name="<?php echo $this->get_field_name( 'gsw_fixed' ); ?>" value="trigger-fixed" <?php checked( $this->get_field_value( 'gsw_fixed' ), "trigger-fixed" ); ?> />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 0 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gsw_fixed' ); ?>"><?php _e( 'Position Absolute', 'genesis-slide-widget' ); ?></label>
            <input type="radio" name="<?php echo $this->get_field_name( 'gsw_fixed' ); ?>" value="trigger-absolute" <?php checked( $this->get_field_value( 'gsw_fixed' ), "trigger-absolute" ); ?> />
        </p>


         <hr class="div">

        <h4><?php _e( 'Settings panel', 'genesis-slide-widget' );?></h4>

        <p>
            <label style="width: 180px; margin: 0 40px 0 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gsw_position' ); ?>"><?php _e( 'Slide-in from the:', 'genesis-slide-widget' ); ?></label>
            <select name="<?php echo $this->get_field_name( 'gsw_position' ); ?>">
                <?php
                $positions = array(left, right);
                foreach ($positions as $position)
                {
                    echo '<option value="trigger-' . $position . '"' . selected( $this->get_field_value( 'gsw_position' ), 'trigger-' . $position ) . '>' . $position . '</option>';
                }
                ?>
            </select>
            
        </p>
        <p>
            <label style="width: 180px; margin: 0 40px 0 0; display: inline-block;" for="<?php echo $this->get_field_id( 'gsw_width' ); ?>"><?php _e( 'Width Widget', 'genesis-slide-widget' ); ?></label>
            <select name="<?php echo $this->get_field_name( 'gsw_width' ); ?>">
                <?php
                $widths = array(10, 20, 30, 40, 50, 100);
                foreach ($widths as $width)
                {
                    echo '<option value="gsw-' . $width . '"' . selected( $this->get_field_value( 'gsw_width' ), 'gsw-' . $width ) . '>' . $width . '%' . '</option>';
                }
                ?>
            </select>
        </p>

        <hr class="div">

        <h4><?php _e( 'Color settings', 'genesis-slide-widget' );?></h4>

        <p>
            <label style="width: 180px; margin: 0 40px 0 0; display: inline-block;" for="<?php echo $this->get_field_name( 'gsw_background' ); ?>"><?php _e( 'Background color', 'genesis-slide-widget' ); ?></label>
            <input type="text" data-default-color="#333333" name="<?php echo $this->get_field_name( 'gsw_background' );?>" id="<?php echo $this->get_field_id( 'gsw_background' );?>" value="<?php echo $this->get_field_value( 'gsw_background' ); ?>" />
        </p>

        <p>
            <label style="width: 180px; margin: 0 40px 0 0; display: inline-block;" for="<?php echo $this->get_field_name( 'text_color' ); ?>"><?php _e( 'Text color', 'genesis-slide-widget' ); ?></label>
            <input type="text" data-default-color="#aaaaaa" name="<?php echo $this->get_field_name( 'text_color' );?>" id="<?php echo $this->get_field_id( 'text_color' );?>"  value="<?php echo $this->get_field_value( 'text_color' ); ?>" />
        </p>

        <hr class="div">

        <?php
    }

}