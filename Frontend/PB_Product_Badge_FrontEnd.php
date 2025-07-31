<?php
class PB_Product_Badge_FrontEnd{
    public function __construct()
    {
//        add_filter('woocommerce_sale_flash',[$this,'pb_show_in_frontend'],10, 3);
        add_action('wp_enqueue_scripts',[$this, 'frontend_assets_loaded']);
        //show frontend in shop page under product desc.
        add_action('woocommerce_single_product_summary',[$this, 'pb_single_product_summary'],9);

    }
    //show in frontend
    public function pb_single_product_summary(){
        global $product;
        if(! $product instanceof WC_Product){
            return;
        }
        $terms = get_the_terms($product->get_id(), 'product_badge');
//        error_log(print_r($product, true) . "\n\n", 3, __DIR__ . '/log.txt');

        if(!empty($terms) && !is_wp_error($terms)){
            echo  '<div class="pb-product-badges">';
            foreach ($terms as $term){
                echo '<span class="pb-badge-item">' . esc_html($term->name) . '</span><br>';
            }
            echo "</div>";
        }
        $image_id = get_term_meta($term->term_id, 'pb_badge_image', true);
        $image_url = wp_get_attachment_url($image_id);
        error_log(print_r($image_url, true) . "\n\n", 3, __DIR__ . '/log.txt');

        if ($image_url) {
            echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($term->name) . '" />';
        }

    }

    public function frontend_assets_loaded()
    {
        wp_enqueue_style('pb-product-badge-frontend-style', pb_plugin_dir_url.'assets/css/pb_product_badge_frontend.css');
    }

}
new PB_Product_Badge_FrontEnd();