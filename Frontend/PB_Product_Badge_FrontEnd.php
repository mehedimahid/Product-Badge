<?php
class PB_Product_Badge_FrontEnd{
    public function __construct()
    {
        add_filter('woocommerce_sale_flash',[$this,'pb_show_in_frontend'],10, 3);
        add_action('wp_enqueue_scripts',[$this, 'frontend_assets_loaded']);
        //show frontend in shop page under product desc.
        add_action('woocommerce_single_product_summary',[$this, 'pb_single_product_summary'],9);
        //show frontend in shop page under product title
        add_action('woocommerce_after_shop_loop_item_title', [$this, 'pb_single_product_summary'],5);

    }

    public function pb_show_in_frontend($html ,$post, $product)
    {
        global $product;
        if (!$product instanceof WC_Product) {
            return;
        }
        $badges = get_post_meta($product->get_id(), '_pb_custom_badges', true);
        $terms = [];
        if(!empty($badges)){
            $terms = get_terms(array(
                'taxonomy' => 'product_badge',
                'slug' => $badges,
                'hide_empty' => false,
                'fields' => 'id=>name'
            ));
        }

        if(!empty($terms) && !is_wp_error($terms)){
            $output =  '<div class="pb_badge_preset_sales">';
            foreach ($terms as $term_id => $term_name) {
                $preset_type = get_term_meta( $term_id, 'pb_badge_preset', true);
                $badge_layout_CLass = '';
                if ($preset_type === 'layout'){
                    $badge_layout = get_term_meta($term_id, 'pb_badge_layout', true);
                    if(!empty($badge_layout)){
                        $badge_layout_CLass = "pb-badge-".$badge_layout;
                    }
                    $output .=  '<div class="pb_badge_preset '.$badge_layout_CLass.'">';
                    $output .=   '<span class="pb-badge-item">' . esc_html($term_name) . '</span>';
                } elseif ($preset_type === 'image'){
                    $img_id = get_term_meta($term_id, 'pb_badge_image', true);
                    $img_url = wp_get_attachment_url($img_id);
                    $output .= '<div class="pb_badge_preset pb-badge-img-div">';
                    if($img_url){
                        $output .= '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($term_name) . '" class="pb-badge-'.($term_name).'">';
                    }
                }
                $output .=   "</div>";
            }
            $output .=  "</div>";
            return $output;
        }
        return $html;

    }
    public function pb_single_product_summary()
    {
        global $product;
        if (!$product instanceof WC_Product) {
            return;
        }
        $badges = get_post_meta($product->get_id(), '_pb_custom_badges', true);
        $terms = [];
        if(!empty($badges)){
            $terms = get_terms(array(
                'taxonomy' => 'product_badge',
                'slug' => $badges,
                'hide_empty' => false,
                'fields' => 'id=>name'
            ));
        }

        if(!empty($terms) && !is_wp_error($terms)){
            echo  '<div class="pb-product-badges">';
            foreach ($terms as $term_id => $term_name) {
                $preset_type = get_term_meta( $term_id, 'pb_badge_preset', true);
                $badge_layout_CLass = '';
                if ($preset_type === 'layout'){
                    $badge_layout = get_term_meta($term_id, 'pb_badge_layout', true);
                    if(!empty($badge_layout)){
                        $badge_layout_CLass = "pb-badge-".$badge_layout;
                    }
                    echo '<div class="pb_badge_preset '.$badge_layout_CLass.'">';
                    echo '<span class="pb-badge-item">' . esc_html($term_name) . '</span>';
                }
                if($preset_type === 'image'){
                    $img_id = get_term_meta($term_id, 'pb_badge_image', true);
                    $img_url = wp_get_attachment_url($img_id);
                    echo '<div class="pb_badge_preset '.$badge_layout_CLass.'">';
                    if($img_url){
                        echo '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($term_name) . '" class="pb-badge-'.($term_name).'">';
                    }
                }
                echo "</div>";
            }
            echo "</div>";
        }
    }


    public function frontend_assets_loaded()
    {
        wp_enqueue_style('pb-product-badge-frontend-style', pb_plugin_dir_url.'assets/css/pb_product_badge_frontend.css');
    }

}
new PB_Product_Badge_FrontEnd();