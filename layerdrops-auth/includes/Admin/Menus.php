<?php 
namespace Layerdrops\Auth\Admin;

class Menus {

    public function __construct() {

        add_action('admin_menu', [ $this, 'layerdrops_auth_admin_menu' ] );
    }

    public function layerdrops_auth_admin_menu(){
        $parent_slug = 'layerdrops-auth';
        $capability = 'manage_options';

        add_menu_page( 
            __('Layerdrops', 'layerdrops-auth'),
         __('Layerdrops', 'layerdrops-auth'), 
         $capability , $parent_slug,
         [ $this, 'layerdrops_auth_plugin_page'],
         'dashicons-welcome-learn-more'
        );
        add_submenu_page($parent_slug, __('Layerdrops Auth', 'layerdrops-auth'), __('Layerdrops Auth', 'layerdrops-auth'),$capability, $parent_slug, [ $this, 'layerdrops_auth_plugin_page'] );
        add_submenu_page($parent_slug, __('Settings', 'layerdrops-auth'), __('Settings', 'layerdrops-auth'),$capability, 'layerdrop-auth-settings', [ $this, 'layerdrops_auth_settings'] );

    }

    public function layerdrops_auth_plugin_page(){
        echo "hello world";
    }
    public function layerdrops_auth_settings(){
        echo "hello world";
    }
}