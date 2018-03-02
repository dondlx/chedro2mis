<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

 $shop_layout = ot_get_option('pp_woo_layout','right-sidebar');

// Extra post classes
$classes = array();
if($shop_layout != 'full-width') {
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'alpha first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'omega last';
}

$shop_columns = ot_get_option('pp_woocolumns','four');

if($shop_layout == 'full-width') {
	$classes[] = 'full-shop columns masonry-shop-item';
} else {
	$classes[] = 'shop columns masonry-shop-item';
}
if($shop_layout == 'full-width') {

	if(is_shop() || is_product_category()){

		$shop_columns = ot_get_option('pp_woocolumns','four');
		switch ($shop_columns) {
			case 'six': // 2columns
				$classes[] = 'eight';
				break;			
			case 'four':// 3columns
				$classes[] = 'one-third';
				break;			
			case 'three':// 4columns
				$classes[] = 'four';
				break;
			
			default:
				$classes[] = 'four';
				break;
		}
	} else {
		$classes[] = 'six';
	}
} else {
	if(is_shop() || is_product_category()){
		$classes[] = $shop_columns;
	} else {
		$classes[] = 'six';
	}
}
$classes[] = 'products-categories';

?>
<div <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

	<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>" class="img-caption">
		<figure>
			<?php
				/**
				 * woocommerce_before_subcategory_title hook
				 *
				 * @hooked woocommerce_subcategory_thumbnail - 10
				 */
				do_action( 'woocommerce_before_subcategory_title', $category );

			?>
			<figcaption>
				<h3>
					<?php
						echo $category->name;

						if ( $category->count > 0 )
							echo apply_filters( 'woocommerce_subcategory_count_html', ' (' . $category->count . ')', $category );
					?>
				</h3>
				<span><?php _e('Browse Products','trizzy') ?></span>
			<?php
				/**
				 * woocommerce_after_subcategory_title hook
				 */
				do_action( 'woocommerce_after_subcategory_title', $category );
			?>
			</figcaption>
		</figure>
	</a>

	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

</div>