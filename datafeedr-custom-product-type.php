<?php
/**
 * Plugin Name: Datafeedr Custom Product type
 * Description: Move Datafeedr Importer Products to Custom Product type
 * Author: Daria Levchenko
 * Version: 1.0.0
 * Text Domain: datafeedr_cpt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'DFR_CPT_PATH', plugin_dir_path( __FILE__ ) );

require_once( DFR_CPT_PATH . 'src/class-datafeedr-cpt-plugin.php' );

register_activation_hook( __FILE__, 'datafeedr_cpt_plugin_install' );

function datafeedr_cpt_plugin_install()
{
    if ( ! get_term_by( 'slug', 'comparison', 'product_type' ) ) {
        wp_insert_term( 'comparison', 'product_type' );
    }
}

new Datafeedr_CPT_Plugin();
