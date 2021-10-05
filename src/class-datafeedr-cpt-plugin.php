<?php


class Datafeedr_CPT_Plugin
{
    public function __construct()
    {
        add_action( 'woocommerce_loaded', [ $this, 'load_plugin' ] );
        add_filter( 'product_type_selector', [ $this, 'add_type' ] );
        add_filter( 'woocommerce_product_data_tabs', [ $this, 'show_comparison_product_type_fields' ] );
        add_action( 'admin_footer', [ $this, 'product_page_custom_js' ] );

        add_filter( 'dfrpswc_filter_taxonomy_array', [ $this, 'modify_imported_product_taxonomy' ], 20, 5 );

        add_action('woocommerce_comparison_add_to_cart', [ $this, 'get_comparison_add_to_cart_template' ], 30);
        add_action('woocommerce_loop_add_to_cart_args', [ $this, 'loop_add_to_cart_args' ], 30, 2);

    }

    /**
     * Load Dependencies
     */
    public function load_plugin()
    {
        require_once 'class-wc-product-comparison.php';
    }

    /**
     * Add product type to select
     */
    public function add_type( $types )
    {
        $types['comparison'] = __( 'Price Comparison', 'datafeedr_cpt' );
        return $types;
    }

    /**
     * Show Comparison Product type fields
     */
    public function show_comparison_product_type_fields( $fields )
    {

        if (isset($fields['inventory']['class'])) {
            $fields['inventory']['class'][] = 'show_if_comparison';
        }

        if (isset($fields['shipping']['class'])) {
            $fields['shipping']['class'][] = 'hide_if_comparison';
        }

        return $fields;
    }

    public function product_page_custom_js()
    {
        if ( 'product' != get_post_type() ) :
            return;
        endif;
        ?><script type='text/javascript'>
            jQuery( document ).ready( function() {
                jQuery( '.options_group.show_if_external' ).addClass( 'show_if_comparison' );
                jQuery( '.options_group.hide_if_external' ).addClass( 'hide_if_comparison' );

                if (jQuery('#product-type').val() === 'comparison') {
                    jQuery( '.show_if_comparison' ).show();
                    jQuery( '.hide_if_comparison' ).hide();
                    jQuery( '.general_options' ).show();
                }
            });
        </script><?php
    }

    /**
     * Change imported product type to Price Comparison
     */
    public function modify_imported_product_taxonomy( $taxonomies, $post, $product, $set, $action )
    {
        $taxonomies['product_type'] = 'comparison';
        return $taxonomies;
    }

    public function get_comparison_add_to_cart_template()
    {
        global $product;

        $args = [
            'product_url' => $product->get_product_url(),
            'button_text' => $product->single_add_to_cart_text()
        ];

        wc_get_template( 'single-product/add-to-cart/comparison.php', $args, '', DFR_CPT_PATH . 'templates/' );
    }

    /**
     * Add target blank to custom product type
     */
    public function loop_add_to_cart_args($args, $product)
    {
        if ( 'comparison' == $product->get_type() ) {
            $args['attributes']['target'] = '_blank';
        }
        return $args;
    }

}