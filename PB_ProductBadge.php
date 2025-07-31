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
        require_once plugin_dir_path( __FILE__ ) . 'pb_option_page/pbCustomMetaBox.php';
        $this->init();
        add_action('init', [$this, 'register_product_badge_taxonomy']);
        add_filter('woocommerce_product_data_tabs', [$this, 'add_product_data_tabs'], 1);
        add_action('woocommerce_product_data_panels',[$this, 'add_product_data_panels']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_product_badge_assets']);
        add_action('save_post', [$this, 'save_product_badge']);
        add_action('woocommerce_after_add_attribute_fields', [$this, 'add_product_badge_attributes']);

    }
    public function init(){
        require_once plugin_dir_path(__FILE__).'Frontend/PB_Product_Badge_FrontEnd.php';
    }
    public function add_product_badge_attributes(){
        woocommerce_wp_select( array(
            'id'                => '_custom_multiselect[]',
            'label'             => __( 'Custom Multi-Select'),
            'description'       => __( 'Choose one or more options.'),
            'desc_tip'          => true,
            'class'             => 'wc-enhanced-select select',
            'options'           => array(
                'option_1' => 'Option 1',
                'option_2' => 'Option 2',
                'option_3' => 'Option 3',
            )
        ) );
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
        } else {
            delete_post_meta($post_id, '_pb_custom_badges');
        }
        if(isset($_POST['pb-dynamic-badges']) && is_array($_POST['pb-dynamic-badges'])){
            $dynamic_badges = array_map('sanitize_text_field', $_POST['pb-dynamic-badges']);
            update_post_meta($post_id, '_pb_dynamic_badges', $dynamic_badges);
        } else {
            delete_post_meta($post_id, '_pb_dynamic_badges');
        }
        // All selected badges assign to taxonomy (important!)
        $all_badges = [];
        if(!empty($custom_badges)){
            $all_badges = array_merge($all_badges, $custom_badges);
        }
        if(!empty($dynamic_badges)){
            $all_badges = array_merge($all_badges, $dynamic_badges);
        }
//        / 🔧 assign to product_badge taxonomy
        if(!empty($all_badges)){
            wp_set_object_terms($post_id, $all_badges, 'product_badge');
        }else{
            wp_set_object_terms($post_id, [], 'product_badge');

        }
    }
    public function enqueue_product_badge_assets(){
        wp_register_style('pb_product_badge_css', pb_plugin_dir_url . 'assets/css/pb_product_badge.css','', '1.0.0');
    }
    public function add_product_data_panels(){
        wp_enqueue_style('pb_product_badge_css');
        require_once plugin_dir_path( __FILE__ ) . 'pb_option_page/pb_option_page.php';
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