<?php 
namespace Layerdrops\Auth\Admin;

class Menus {

    public function __construct() {

        add_action('admin_menu', [ $this, 'layerdrops_auth_admin_menu' ] );
        add_action('admin_init', [ $this, 'layerdrops_auth_init_page' ] );
    }

    public function layerdrops_auth_admin_menu(){
        $parent_slug = 'layerdrops-auth';
        $capability = 'manage_options';

        add_menu_page( 
            __('LDA', 'layerdrops-auth'),
         __('LDA', 'layerdrops-auth'), 
         $capability , $parent_slug,
         [ $this, 'layerdrops_auth_plugin_page'],
         'dashicons-welcome-learn-more'
        );
        add_submenu_page($parent_slug, __('Layerdrops Auth', 'layerdrops-auth'), __('Layerdrops Auth', 'layerdrops-auth'),$capability, $parent_slug, [ $this, 'layerdrops_auth_plugin_page'] );
        add_submenu_page($parent_slug, __('Settings', 'layerdrops-auth'), __('Settings', 'layerdrops-auth'),$capability, 'layerdrop-auth-settings', [ $this, 'layerdrops_auth_settings'] );

    }

    public function layerdrops_auth_plugin_page(){
        $this->options = get_option('layerdrops_auth_options');
        ?>
            <div class="wrap">
                <form action="options.php" method="post">
                    <?php 
                        settings_fields( 'layerdrops_auth_main_options_group' );
                        do_settings_sections( 'wp-dark-mode-admin-section-page' );
                        submit_button();
                    ?>
                </form>
            </div>
        <?php
    }

    public function layerdrops_auth_settings(){
        echo "hello world";
    }

    public function layerdrops_auth_init_page() {
        
        register_setting(
            'layerdrops_auth_main_options_group',
            'layerdrops_auth_options',
            [ $this, 'sanitize' ]
        );

        $this->init_settings_sections();
        $this->init_settings_fields();
    }

    private function init_settings_sections() {
        add_settings_section(
            'wp_dark_mode_main_section',
            __( 'Custom Position', 'wp-dark-mode' ),
            [ $this, 'wp_dark_mode_print_main_section_info' ],
            'wp-dark-mode-admin-section-page'
        );
    }

    public function wp_dark_mode_print_main_section_info() {
        echo esc_html("WP Dark Mode Settings Options");
    }

    private function init_settings_fields() {
        add_settings_field(
            'wp_dark_mode_bottom',
            __( 'Bottom Position', 'wp-dark-mode' ),
            [ $this, 'wp_dark_mode_bottom_callback' ],
            'wp-dark-mode-admin-section-page',
            'wp_dark_mode_main_section'
        );

        add_settings_field(
            'wp_dark_mode_left',
            __( 'Left Position', 'wp-dark-mode' ),
            [ $this, 'wp_dark_mode_left_callback' ],
            'wp-dark-mode-admin-section-page',
            'wp_dark_mode_main_section'
        );

        add_settings_field(
            'wp_dark_mode_right',
            __( 'Right Position', 'wp-dark-mode' ),
            [ $this, 'wp_dark_mode_right_callback' ],
            'wp-dark-mode-admin-section-page',
            'wp_dark_mode_main_section'
        );

        add_settings_field(
            'wp_dark_mode_sipo_section',
            __( 'Show in Posts Only', 'wp-dark-mode' ),
            [ $this, 'wp_dark_mode_sipo_callback' ],
            'wp-dark-mode-admin-section-page',
            'wp_dark_mode_main_section'
        );

    }

    public function wp_dark_mode_print_default_postion_info() {
        echo esc_html("Choose the position that you prefer:");
    }

    public function wp_dark_mode_print_widget_settings_section_info() {
        echo esc_html("Enter Your Widget Settings Options:");
    }

    public function wp_dark_mode_print_extra_section_info() {
        echo esc_html("Additional settings and options for dark mode behavior.");
    }

    public function wp_dark_mode_bottom_callback() {
        $value = $this->options['wp_dark_mode_bottom'] ?? '';
        printf(
            '<input type="text" id="wp_dark_mode_bottom" placeholder="32px" name="layerdrops_auth_options[wp_dark_mode_bottom]" value="%s" />',
            esc_attr($value)
        );
    }

    public function wp_dark_mode_left_callback() {
        $value = $this->options['wp_dark_mode_left'] ?? '';
        printf(
            '<input type="text" id="wp_dark_mode_left" placeholder="32px" name="layerdrops_auth_options[wp_dark_mode_left]" value="%s" />',
            esc_attr($value)
        );
    }

    public function wp_dark_mode_right_callback() {
        $value = $this->options['wp_dark_mode_right'] ?? '';
        printf(
            '<input type="text" id="wp_dark_mode_right" placeholder="32px" name="layerdrops_auth_options[wp_dark_mode_right]" value="%s" />',
            esc_attr($value)
        );
    }

    public function wp_dark_mode_sipo_callback() {
        $checked = $this->options['wp_dark_mode_sipo_section'] ?? 0;
        printf(
            '<input type="checkbox" id="wp_dark_mode_sipo_section" name="layerdrops_auth_options[wp_dark_mode_sipo_section]" value="1" %s />',
            checked(1, $checked, false)
        );
    }
}