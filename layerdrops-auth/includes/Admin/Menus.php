<?php 
namespace Layerdrops\Auth\Admin;

class Menus {

    // Constructor method that runs when an instance of the Menus class is created.
    public function __construct() {
        // Hook into the 'admin_menu' action to add custom admin menu items.
        add_action('admin_menu', [ $this, 'layerdrops_auth_admin_menu' ]);
        // Hook into the 'admin_init' action to initialize settings and register options.
        add_action('admin_init', [ $this, 'layerdrops_auth_init_page' ]);
    }

    // Method to define the admin menu structure.
    public function layerdrops_auth_admin_menu() {
        $parent_slug = 'layerdrops-auth'; // Unique identifier for the parent menu.
        $capability = 'manage_options'; // Capability required to access the menu.

        // Add a top-level menu page to the WordPress admin panel.
        add_menu_page(
            __('LD Auth', 'layerdrops-auth'), // Page title
            __('LD Auth', 'layerdrops-auth'), // Menu title
            $capability, // Capability required to access the menu
            $parent_slug, // Menu slug
            [ $this, 'layerdrops_auth_plugin_page' ], // Callback function to display the page content
            'dashicons-welcome-learn-more' // Icon for the menu
        );

        // Add a submenu page for the main plugin settings.
        add_submenu_page($parent_slug, __('Layerdrops Auth', 'layerdrops-auth'), __('Layerdrops Auth', 'layerdrops-auth'), $capability, $parent_slug, [ $this, 'layerdrops_auth_plugin_page']);

        // Add another submenu page for additional plugin settings.
        add_submenu_page($parent_slug, __('Settings', 'layerdrops-auth'), __('Settings', 'layerdrops-auth'), $capability, 'layerdrop-auth-settings', [ $this, 'layerdrops_auth_settings']);
    }

    // Callback function to display the main plugin settings page.
    public function layerdrops_auth_plugin_page() {
        $this->options = get_option('layerdrops_auth_options'); // Retrieve the stored options.
        ?>
            <div class="wrap">
                <form action="options.php" method="post">
                    <?php 
                        // Render the settings fields and sections for this form.
                        settings_fields('layerdrops_auth_main_options_group');
                        do_settings_sections('wp-dark-mode-admin-section-page');
                        submit_button(); // Display the save settings button.
                    ?>
                </form>
            </div>
        <?php
    }

    // Callback function to display the settings page for plugin configurations.
    public function layerdrops_auth_settings() {
        echo "hello world"; // Temporary placeholder text for testing.
    }

    // Method to initialize the settings page and register settings.
    public function layerdrops_auth_init_page() {
        // Register the main plugin options group and set up a sanitization callback.
        register_setting(
            'layerdrops_auth_main_options_group',
            'layerdrops_auth_options',
            [ $this, 'sanitize' ] // Method to sanitize input before saving.
        );

        // Initialize the settings sections and fields.
        $this->init_settings_sections();
        $this->init_settings_fields();
    }

    // Private method to set up the settings section.
    private function init_settings_sections() {
        add_settings_section(
            'google_client_id_layerdrops_auth_section', // Unique identifier for the section.
            __( 'Google Authentication', 'wp-dark-mode' ), // Title of the section.
            [ $this, 'wp_dark_mode_print_main_section_info' ], // Callback to display additional information.
            'wp-dark-mode-admin-section-page' // Page ID where the section will appear.
        );
    }

    // Callback function to display additional information for the settings section.
    public function wp_dark_mode_print_main_section_info() {
        echo esc_html("WP Dark Mode Settings Options"); // Display a description for the section.
    }

    // Private method to set up the settings fields within the section.
    private function init_settings_fields() {

        add_settings_field(
            'google_client_name', // Unique ID for the field.
            __( 'Application Name', 'wp-dark-mode' ), // Label for the field.
            [ $this, 'wp_dark_mode_bottom_callback' ], // Callback to render the input.
            'wp-dark-mode-admin-section-page', // Page ID where the field will appear.
            'google_client_id_layerdrops_auth_section' // Section ID where the field will be added.
        );

        // Add fields for the settings page.
        add_settings_field(
            'google_client_id', // Unique ID for the field.
            __( 'Google Client ID', 'wp-dark-mode' ), // Label for the field.
            [ $this, 'wp_dark_mode_bottom_callback' ], // Callback to render the input.
            'wp-dark-mode-admin-section-page', // Page ID where the field will appear.
            'google_client_id_layerdrops_auth_section' // Section ID where the field will be added.
        );

        add_settings_field(
            'google_client_secret', // Unique ID for the field.
            __( 'Google Client Secret', 'wp-dark-mode' ), // Label for the field.
            [ $this, 'wp_dark_mode_bottom_callback' ], // Callback to render the input.
            'wp-dark-mode-admin-section-page', // Page ID where the field will appear.
            'google_client_id_layerdrops_auth_section' // Section ID where the field will be added.
        );

        add_settings_field(
            'google_redirect_url', // Unique ID for the field.
            __( 'Side Redirect Uri', 'wp-dark-mode' ), // Label for the field.
            [ $this, 'wp_dark_mode_bottom_callback' ], // Callback to render the input.
            'wp-dark-mode-admin-section-page', // Page ID where the field will appear.
            'google_client_id_layerdrops_auth_section' // Section ID where the field will be added.
        );
    }

    // Callback function for the 'Bottom Position' field.
    public function wp_dark_mode_bottom_callback() {
        $value = $this->options['wp_dark_mode_bottom'] ?? ''; // Get the stored value or default to empty.
        printf(
            '<input type="text" class="regular-text" id="wp_dark_mode_bottom" placeholder="32px" name="layerdrops_auth_options[wp_dark_mode_bottom]" value="%s" />',
            esc_attr($value) // Sanitize the value for output.
        );
    }
}