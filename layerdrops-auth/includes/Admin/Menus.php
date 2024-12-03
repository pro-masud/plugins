<?php 
namespace Layerdrops\Auth\Admin; // Defines the namespace for organizing the Admin class within Layerdrops\Auth.

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
            __('LDA', 'layerdrops-auth'), // Page title
            __('LDA', 'layerdrops-auth'), // Menu title
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
            'wp_dark_mode_main_section', // Unique identifier for the section.
            __( 'Custom Position', 'wp-dark-mode' ), // Title of the section.
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
        // Add fields for the settings page.
        add_settings_field(
            'wp_dark_mode_bottom', // Unique ID for the field.
            __( 'Bottom Position', 'wp-dark-mode' ), // Label for the field.
            [ $this, 'wp_dark_mode_bottom_callback' ], // Callback to render the input.
            'wp-dark-mode-admin-section-page', // Page ID where the field will appear.
            'wp_dark_mode_main_section' // Section ID where the field will be added.
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

    // Callback function for the 'Bottom Position' field.
    public function wp_dark_mode_bottom_callback() {
        $value = $this->options['wp_dark_mode_bottom'] ?? ''; // Get the stored value or default to empty.
        printf(
            '<input type="text" id="wp_dark_mode_bottom" placeholder="32px" name="layerdrops_auth_options[wp_dark_mode_bottom]" value="%s" />',
            esc_attr($value) // Sanitize the value for output.
        );
    }

    // Callback function for the 'Left Position' field.
    public function wp_dark_mode_left_callback() {
        $value = $this->options['wp_dark_mode_left'] ?? ''; 
        printf(
            '<input type="text" id="wp_dark_mode_left" placeholder="32px" name="layerdrops_auth_options[wp_dark_mode_left]" value="%s" />',
            esc_attr($value)
        );
    }

    // Callback function for the 'Right Position' field.
    public function wp_dark_mode_right_callback() {
        $value = $this->options['wp_dark_mode_right'] ?? '';
        printf(
            '<input type="text" id="wp_dark_mode_right" placeholder="32px" name="layerdrops_auth_options[wp_dark_mode_right]" value="%s" />',
            esc_attr($value)
        );
    }

    // Callback function for the 'Show in Posts Only' checkbox.
    public function wp_dark_mode_sipo_callback() {
        $checked = $this->options['wp_dark_mode_sipo_section'] ?? 0; // Check the stored value or default to 0 (unchecked).
        printf(
            '<input type="checkbox" id="wp_dark_mode_sipo_section" name="layerdrops_auth_options[wp_dark_mode_sipo_section]" value="1" %s />',
            checked(1, $checked, false)
        );
    }
}
