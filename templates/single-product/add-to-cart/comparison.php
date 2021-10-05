<?php
/**
 * Comparison product add to cart
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

<p class="cart">
    <a href="<?php echo esc_url( $product_url ); ?>"
       rel="nofollow"
       target="_blank"
       class="single_add_to_cart_button button alt"><?php echo esc_html( $button_text ); ?></a>
</p>

<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
