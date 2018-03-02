<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) : ?>

<?php
global $post;
$layout         = get_post_meta($post->ID, 'pp_sidebar_layout', TRUE);
 echo $layout != 'full-width' ? '<div class="twelve columns alpha omega">' : '<div class="sixteen alpha columns">'; ?>

	<h3 class="headline"><?php _e( 'You may also like&hellip;', 'trizzy' ) ?></h3>
	<span class="line margin-bottom-0"></span>
</div>
<div class="clearfix"></div>

<div class="upsells products  margin-bottom-30">

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $upsells as $upsell ) : ?>

				<?php
				 	$post_object = get_post( $upsell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'productcross' ); ?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

</div>



<?php endif;

wp_reset_postdata();
