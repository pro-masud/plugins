<?php 
/**
 * Plugin Name: Layerdrops Auth
 * Version: 1.0.0
 * Description: A simple WordPress plugin for managing custom authentication features with extensible options for frontend and backend interactions.
 * Author: Masud Rana
 * Author URI: https://promasudbd.com
 * Text Domain: layerdrops-auth
 * Domain Path: /language
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

final class LAYERDROPS_AUTH {

    const version = '1.0';

    /**
     * Constructor to initialize the class
     */
    function __construct() {
        $this->define_constants();

        // Hook for plugin activation
        register_activation_hook(__FILE__, [ $this, 'plugin_activate' ]);
        
        // Initialize the plugin once all plugins are loaded
        add_action('plugins_loaded', [ $this, 'layerdrops_auth_init_plugin' ]);
    }

    /**
     * Singleton instance for the plugin
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define essential constants for the plugin
     */
    public function define_constants() {
        define('LAYERDROPS_AUTH_VERSION', self::version);
        define('LAYERDROPS_AUTH_FILE', __FILE__);
        define('LAYERDROPS_AUTH_PATH', __DIR__);
        define('LAYERDROPS_AUTH_URL', plugins_url('', LAYERDROPS_AUTH_FILE));
        define('LAYERDROPS_AUTH_ASSETS', LAYERDROPS_AUTH_URL . '/assets');
    }

    /**
     * Initialize plugin functionalities
     */ 
    public function layerdrops_auth_init_plugin() {

        // Assets can be initialized here
        // Example: new Promasud\MR_9\Assets();

        // Handle AJAX requests if applicable
        // Example: if (defined('DOING_AJAX') && DOING_AJAX) { new Promasud\MR_9\Ajax(); }
        
        // Separate admin and frontend functionalities
        if (is_admin()) {
            // Admin-specific logic can be loaded here
            // Example: new Promasud\MR_9\Admin();
        } else {
            // Frontend-specific logic can be loaded here
            // Example: new Promasud\MR_9\Frontend();
        }

        // Additional API functionalities can be added
        // Example: new Promasud\MR_9\APIs();
    }

    /**
     * Plugin activation logic
     */
    public function plugin_activate() {
        // Run necessary installation tasks on plugin activation
        // Example: $installers = new Promasud\MR_9\Installers(); $installers->run();
    }
}

/**
 * Initialize the main plugin instance
 */
function Layerdrops_Auth() {
    return LAYERDROPS_AUTH::init();
}

// Start the plugin
Layerdrops_Auth();