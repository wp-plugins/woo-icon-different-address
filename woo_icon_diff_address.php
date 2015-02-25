<?php
/*
Plugin Name: Woo icon different address
Plugin URI: http://www.best-of-site.fr/plugin
Description: Le pluginWoo icon different address affiche une icône visible pour avoir un apperçue rapide des adresses de livraison différentes.
Version: 1
Author: Best Of Site
Author URI: http://best-of-site.fr
*/

/*  Copyright 2014  Agence Best Of Site  (email : contact@bestofsite.fr) */


// ajout de la colone avec icône pour adresse différente
add_action('woocommerce_checkout_update_order_meta', 'woo_icon_diff_address');
function woo_icon_diff_address( $order_id ) {
global $woocommerce;
$diffaddress = $_POST['ship_to_different_address'];
update_post_meta( $order_id, '_diff_address', $_POST['ship_to_different_address'] );
}

add_filter( 'manage_edit-shop_order_columns', 'woo_icon_column_address_diff', 20 );
function woo_icon_column_address_diff( $columns ) {
$offset = 9;
$updated_columns = array_slice( $columns, 0, $offset, true) +
array( 'shipping_adress_differente' => esc_html__( 'Adresse différente', 'woocommerce' ) ) +
array_slice($columns, $offset, NULL, true);
return $updated_columns;
}
// Populate weight column
add_action( 'manage_shop_order_posts_custom_column', 'woo_custom_column_adress_diff', 2 );
function woo_custom_column_adress_diff( $column ) {
global $post, $woocommerce, $the_order;
if ( $column == 'shipping_adress_differente' ) {
$diff_address = get_post_meta( $post->ID, '_diff_address', true );
 if(!empty ($diff_address)) 
echo '<span data-tip="'.esc_html__( 'ATTENTION <br /> Adresse de livraison différente !', 'woocommerce' ).'" style="color:#E9B10B;font-size:28px;" class="dashicons tips dashicons-info"></span>';
else echo'';
}
}