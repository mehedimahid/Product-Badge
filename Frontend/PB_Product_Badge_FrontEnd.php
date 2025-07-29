<?php
class PB_Product_Badge_FrontEnd{
    public function __construct()
    {
        add_filter('woocommerce_sale_flash',[$this,'pb_show_in_frontend'],10, 3);
        add_action('wp_enqueue_scripts',[$this, 'frontend_assets_loaded']);
    }
    public function frontend_assets_loaded()
    {
        wp_enqueue_style('pb-product-badge-frontend-style', pb_plugin_dir_url.'assets/css/pb_product_badge_frontend.css');
    }
    function pb_show_in_frontend($html,$post, $product){
        $html = '<span class="pb_badge">Hello</span>';
        return $html;
    }
}
new PB_Product_Badge_FrontEnd();