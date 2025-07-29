<?php
/*
Plugin Name: Product Badge
Plugin URI:
Description: A simple plugin that shows a welcome message to new visitors.
Version: 1.0
Author: Mehedi Hasan
Author URI: https://github.com/mehedimahid
Text Domain: Product-Badge
Domain Path: /languages/
License: GPL2
*/

define('pb_plugin_dir_url', plugin_dir_url(__FILE__));

class PB_ProductBadge{
    public function __construct(){
        $this->init();
        add_action('init', [$this, 'register_product_badge_taxonomy']);
        add_filter('woocommerce_product_data_tabs', [$this, 'add_product_data_tabs'], 1);
        add_action('woocommerce_product_data_panels',[$this, 'add_product_data_panels']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_product_badge_assets']);
        add_action('save_post', [$this, 'save_product_badge']);

    }
    public function init(){
        require_once plugin_dir_path(__FILE__).'Frontend/PB_Product_Badge_FrontEnd.php';

    }

    public function save_product_badge($post_id){
        if(get_post_type($post_id) !== 'product'){
            return;
        }
        if(isset($_POST['pb_badge_type'])){
            $badge_type = sanitize_text_field($_POST['pb_badge_type']);
            update_post_meta($post_id, '_badge_type',$badge_type);
        }
        if(isset($_POST['pb-custom-badges']) && is_array($_POST['pb-custom-badges'])){
            $custom_badges = array_map('sanitize_text_field', $_POST['pb-custom-badges']);
            update_post_meta($post_id, '_pb_custom_badges', $custom_badges);
        } //else {
         //   delete_post_meta($post_id, '_pb_custom_badges');
        //}
        if(isset($_POST['pb_badge_type_dynamic']) && is_array($_POST['pb_badge_type_dynamic'])){
            $custom_badges = array_map('sanitize_text_field', $_POST['pb_badge_type_dynamic']);
            update_post_meta($post_id, '_pb_dynamic_badges', $custom_badges);
        } //else {
//            delete_post_meta($post_id, '_pb_dynamic_badges');
//        }
    }
    public function enqueue_product_badge_assets(){
        wp_register_style('pb_product_badge_css', pb_plugin_dir_url . 'assets/css/pb_product_badge.css','', '1.0.0');
        wp_register_script('pb_product_badge_js', pb_plugin_dir_url . 'assets/js/pb_product_badge.js', ['jquery'],'1.0.0',true);
    }
    public function add_product_data_panels(){
        wp_enqueue_style('pb_product_badge_css');
        wp_enqueue_script('pb_product_badge_js');
        require_once plugin_dir_path( __FILE__ ) . 'PB_Option_Page/pb_option_page.php';
    }
    public function add_product_data_tabs($tabs){
        $tabs['pb_product_badge'] = [
          'label'=> __('Badge'),
            'target'   => 'pb_product_badge_options',
//            'class'    => [],
        ];
        return $tabs;
    }
    public function register_product_badge_taxonomy(){
        $labels = array(
            'name'              => __('Badges','Product-Badge'),
            'singular_name'     => __('Badge',  'Product-Badge'),
            'all_items'         => __('All Badges', 'Product-Badge'),
            'edit_item'         => __('Edit Badge', 'Product-Badge'),
            'update_item'       => __('Update Badge', 'Product-Badge'),
            'add_new_item'      => __('Add New Badge', 'Product-Badge'),
            'new_item_name'     => __('New Badge Name', 'Product-Badge'),
            'menu_name'         => __('Badges', 'Product-Badge'),
        );
        $args = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'query_var'         => true,
//            'rewrite'           => array('slug' => 'badge'),
        );

        register_taxonomy('product_badge', array('product'), $args);
    }


}
new PB_ProductBadge();