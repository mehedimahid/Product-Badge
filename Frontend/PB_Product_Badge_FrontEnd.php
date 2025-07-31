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
                'taxonomy' => 'product_badge', // তোমার ট্যাক্সোনোমির নাম
                'slug' => $badges,         // slug-এর অ্যারে
                'hide_empty' => false,         // প্রয়োজনে true/false
                'fields' => 'id=>name'
            ));
        }
        error_log(print_r($terms, true) . "\n\n", 3, __DIR__ . '/log.txt');

        if(!empty($terms) && !is_wp_error($terms)){
            echo  '<div class="pb-product-badges">';
            foreach ($terms as $term){
                echo '<span class="pb-badge-item">' . esc_html($term) . '</span><br>';
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