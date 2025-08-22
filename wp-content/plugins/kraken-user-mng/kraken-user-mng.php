<?php
/**
 * Plugin Name: Kraken UserMng
 * Plugin URI: https://example.com/
 * Description: Provides a private area for coaches with events and file sharing.
 * Version: 0.1.0
 * Author: Kraken Design
 * Text Domain: kraken-user-mng
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Kraken_UserMng {
    /**
     * Initialize hooks.
     */
    public function __construct() {
        add_action( 'init', [ $this, 'register_role' ] );
        add_action( 'init', [ $this, 'register_post_types' ] );
        add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );
    }

    /**
     * Load plugin text domain for translations.
     */
    public function load_textdomain() {
        load_plugin_textdomain( 'kraken-user-mng', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    /**
     * Register custom user role for coaches.
     */
    public function register_role() {
        if ( ! get_role( 'coach' ) ) {
            add_role( 'coach', __( 'Coach', 'kraken-user-mng' ), [
                'read'         => true,
                'upload_files' => true,
            ] );
        }
    }

    /**
     * Register custom post types for events and files.
     */
    public function register_post_types() {
        register_post_type( 'kum_event', [
            'labels' => [
                'name'          => __( 'Events', 'kraken-user-mng' ),
                'singular_name' => __( 'Event', 'kraken-user-mng' ),
            ],
            'public'      => false,
            'show_ui'     => true,
            'supports'    => [ 'title', 'editor' ],
            'show_in_menu'=> true,
            'capability_type' => 'post',
        ] );

        register_post_type( 'kum_file', [
            'labels' => [
                'name'          => __( 'Files', 'kraken-user-mng' ),
                'singular_name' => __( 'File', 'kraken-user-mng' ),
            ],
            'public'      => false,
            'show_ui'     => true,
            'supports'    => [ 'title' ],
            'show_in_menu'=> true,
            'capability_type' => 'post',
        ] );
    }
}

new Kraken_UserMng();

register_activation_hook( __FILE__, function() {
    ( new Kraken_UserMng() )->register_role();
} );
