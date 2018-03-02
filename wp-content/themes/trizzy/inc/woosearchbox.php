<?php
global $wpdb, $woocommerce, $wp_query, $wp, $wp_the_query;
$min = $max = 0;
 
$background = ot_get_option('pp_shop_search_bg');  ?>
<section class="woo-search">
    <form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
        <div class="woo-search-main">
            <label for="s"><?php echo ot_get_option('pp_woosearch_label') ?></label>
            <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php echo esc_attr( ot_get_option('pp_woosearch_placehodler')); ?>">
            <button><i class="fa fa-search"></i></button>
            <input type="hidden" name="post_type" value="product">
            <input type="hidden" name="trizzy_search" value="advanced">
        </div>
        <?php if(ot_get_option('pp_woosearch_adv_on')== 'on') { ?>
        <a href="#" class="advanced-search-btn button"><?php _e('Advanced Search','trizzy'); ?> <i class="fa fa-caret-down"></i></a>
        <div class="woo-search-elements clearfix">
            <?php $woo_search_attributes = ot_get_option('pp_woosearch_attr',array()); ?>
            <ul class="clearfix">
                <?php if(ot_get_option('pp_woosearch_cats_on','off') == 'on') { ?>
                <li>
                    <select class="" data-holder="<?php _e('Categories','trizzy'); ?>" name="trizzy_product_cat[]" multiple="multiple">
                        <?php
                        $theterms = get_terms('product_cat',array('hide_empty' => false));
                         if ( !empty( $theterms ) && !is_wp_error( $theterms ) ){
                            foreach ($theterms as $term) :
                                echo "<option value='".$term->slug."'";
                                    if(isset($_GET['trizzy_product_cat'])) {
                                        if(is_array($_GET['trizzy_product_cat'])) {
                                            if(in_array($term->slug, $_GET['trizzy_product_cat'])) { echo 'selected="selected"'; }
                                        } else {
                                            $_GET['trizzy_product_cat'] == $term->slug ? ' selected="selected"' : '';
                                        }
                                    }
                                echo ">".$term->name."</option>\n";
                            endforeach;
                        } 
                        ?>
                    </select>
                </li>
                <?php } ?>

                <?php foreach ($woo_search_attributes as $attr) : ?>
                <li>
                    <select class="" data-holder="<?php echo wc_attribute_label($attr); ?>" name="trizzy_<?php echo $attr; ?>[]" multiple="multiple">
                    <?php
                    $terms = get_terms($attr, array('hide_empty' => false));
                    if(!empty($terms)) {
                        foreach ($terms as $term) {
                            echo "<option value='".$term->slug."'";
                                if(isset($_GET['trizzy_'.$attr])) {
                                    if(is_array($_GET['trizzy_'.$attr])) {
                                        if(in_array($term->slug, $_GET['trizzy_'.$attr])) { echo 'selected="selected"'; }
                                    } else {
                                        $_GET['trizzy_'.$attr] == $term->slug ? ' selected="selected"' : '';
                                    }
                                }
                            echo ">".$term->name."</option>\n";
                        }
                    }
                    $terms = ''; ?>
                    </select>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php
                $min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
                $max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';
                // Find min and max price in current result set
                $trizzy_class = new Trizzy_Filtered_Navigation;
                $prices = $trizzy_class->get_prices();
                $min    = floor( $prices->min_price );
                $max    = ceil( $prices->max_price );


             ?>
            <?php if(ot_get_option('pp_woosearch_price_on','off') == 'on') { ?>
            <div class=" clearfix">
                <div class="price_slider_wrapper widget_price_filter">
                    <div class="price_slider_amount">
                        <input type="text" id="min_price" name="min_price" value="<?php echo esc_attr( $min_price ) ?>" data-min="<?php echo esc_attr( apply_filters( 'woocommerce_price_filter_widget_amount', $min ) ); ?>" placeholder="<?php _e('Min price','trizzy'); ?>" >
                        <input type="text" id="max_price" name="max_price" value="<?php echo esc_attr( $max_price ) ?>" data-max="<?php echo esc_attr( apply_filters( 'woocommerce_price_filter_widget_amount', $max ) ); ?>" placeholder="<?php _e('Max price','trizzy'); ?>" >
                        <label for=""><?php _e('Price Range','trizzy') ?></label>
                        <div class="price_slider" style="display:none;"></div>
                        <div class="price_amount"><span class="from"></span> &mdash; <span class="to"></span></div>
                       
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
           
            <?php } ?>
        </div>
        <?php } //eof if pp_woosearch_adv_on  ?>
    </form>
</section>

