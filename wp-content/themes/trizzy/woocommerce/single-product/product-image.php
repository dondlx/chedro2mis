<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post, $product;
$gallerytype = ot_get_option('pp_product_default_gallery','off');



$layout         = get_post_meta($post->ID, 'pp_sidebar_layout', TRUE);
if(empty($layout)) { $layout = 'full-width'; }
$sliderstyle    = get_post_meta($post->ID, 'pp_woo_thumbnail_style', TRUE);

if($gallerytype == 'on') { ?>
<?php echo $layout != 'full-width' ? '<div class="six columns alpha">' : '<div class="eight columns">'; 

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
$image_title       = get_post_field( 'post_excerpt', $post_thumbnail_id );
$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
    'woocommerce-product-gallery',
    'woocommerce-product-gallery--' . $placeholder,
    'woocommerce-product-gallery--columns-' . absint( $columns ),
    'images',
) );
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
    <figure class="woocommerce-product-gallery__wrapper">
        <?php
        $attributes = array(
            'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
            'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
            'data-src'                => $full_size_image[0],
            'data-large_image'        => $full_size_image[0],
            'data-large_image_width'  => $full_size_image[1],
            'data-large_image_height' => $full_size_image[2],
        );

        if ( has_post_thumbnail() ) {
            $html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '">';
            $html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
            $html .= '</a></div>';
        } else {
            $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
            $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
            $html .= '</div>';
        }

        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );

        do_action( 'woocommerce_product_thumbnails' );
        ?>
    </figure>
</div>

</div>
<?php } else { ?>
<?php echo $layout != 'full-width' ? '<div class="six columns alpha">' : '<div class="eight columns">'; ?>
    <div class="slider-padding ">

        <?php
        if ( has_post_thumbnail() ) {

            $image_title        = esc_attr( get_the_title( get_post_thumbnail_id() ) );
            $image_link         = wp_get_attachment_url( get_post_thumbnail_id() );

            $image              = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'shop_single' );
            $imageRSthumb       = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'shop-small-thumb' );
            $attachment_ids     = $product->get_gallery_image_ids();
            $attachment_count   = count( $product->get_gallery_image_ids() );
            $output = '';

            if ( $attachment_count > 0 ) { // many images, use flexslider
     
            $output .='<div id="'.($sliderstyle == 'horizontal' ? 'product-slider' : 'product-slider-vertical').'" class="royalSlider rsDefault">';
                 //first, get the main thumbnail
                $output .='<a href="'.$image_link.'" itemprop="image" class="mfp-gallery" title="'.$image_title.'">
                               <img src="'.$image[0].'" class="rsImg" data-rsTmb="'.$imageRSthumb[0].'" />
                           </a><!-- Main THumbnails -->';
                //2nd, get the hover image if exists
                $hover = get_post_meta($post->ID, 'pp_featured_hover', TRUE);
                if($hover) {
                    $hoverimage = wp_get_attachment_image_src($hover, 'shop_single');
                    $image_hover_title    = esc_attr( get_the_title( $hover ) );
                    $hoverimagefull = wp_get_attachment_image_src($hover, 'full');
                    $hoverimageRSthumb = wp_get_attachment_image_src($hover, 'shop-small-thumb');
                    $output .= '<a href="'.$hoverimagefull[0].'" class="mfp-gallery" title="'.$image_hover_title.'"><img class="rsImg" src="'.$hoverimage[0].'"  data-rsTmb="'.$hoverimageRSthumb[0].'" alt="'.$image_hover_title.'"/></a><!-- hover image THumbnails -->';
                }
                //get rest of images
                foreach ( $attachment_ids as $attachment_id ) {
                    $image          = wp_get_attachment_image_src( $attachment_id, 'shop_single');
                    $imageRSthumb   = wp_get_attachment_image_src( $attachment_id, 'shop-small-thumb' );
                    $image_title    = esc_attr( get_the_title( $attachment_id ) );
                    $output .= '<a href="'.$image[0].'" class="mfp-gallery" title="'.$image_title.'"><img class="rsImg" src="'.$image[0].'" data-rsTmb="'.$imageRSthumb[0].'" /></a><!-- rest of images -->';
                }
            $output .='</div> <!-- eof royal -->';

            } else { // just one image

            $hover = get_post_meta($post->ID, 'pp_featured_hover', TRUE);
            $image_hover_title    = esc_attr( get_the_title( $hover ) );
                if($hover) {
                    $output .='<div id="'.($sliderstyle == 'horizontal' ? 'product-slider' : 'product-slider-vertical').'" class="royalSlider rsDefault images">';
                    $output .='<a href="'.$image_link.'" itemprop="image" class="mfp-gallery" title="'.$image_title.'"><img src="'.$image[0].'" class="rsImg" alt="'.$image_title.'" data-rsTmb="'.$imageRSthumb[0].'" /></a><!-- singel main THumbnails -->';
                } else {
                    $output .='<div id="product-slider-no-thumbs" class="royalSlider rsDefault">';
                    $output .='<a href="'.$image_link.'" itemprop="image" title="'.$image_title.'"><img src="'.$image[0].'" class="rsImg" alt="'.$image_title.'"  /></a>';
                }
                if($hover) {
                    $hoverimage = wp_get_attachment_image_src($hover, 'shop_single');
                    $hoverimagefull = wp_get_attachment_image_src($hover, 'full');

                    $hoverimageRSthumb = wp_get_attachment_image_src($hover, 'shop-small-thumb');
                    $output .= '<a href="'.$hoverimagefull[0].'" class="mfp-gallery" title="'.$image_hover_title.'" ><img class="rsImg" src="'.$hoverimage[0].'"  data-rsTmb="'.$hoverimageRSthumb[0].'" alt="'.$image_hover_title.'" /></a><!-- Hover single with main THumbnails -->';
                }
            $output .='</div>';
            }
        } else {
              $output .= apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="single-product-image"><img src="%s" alt="Placeholder" /></div>', woocommerce_placeholder_img_src() ), $post->ID );
        }
        echo  $output;
        //do_action('woocommerce_product_thumbnails');
        ?>


        <div class="clearfix"></div>
    </div>
</div>
<?php } //eof else standard gallery ?>