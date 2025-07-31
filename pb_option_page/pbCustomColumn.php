<?php
class pbCustomColumn
{
    public function __construct(){
        add_filter('manage_edit-product_badge_columns', [$this, 'add_custom_columns']);
        add_filter('manage_product_badge_custom_column', [$this, 'show_badge_custom_columns'],10,3);
    }
    public function show_badge_custom_columns($output, $column_name, $item_id)
    {
        if($column_name === 'pb_badge_type'){
            $badge_type = get_term_meta($item_id, 'pb_badge_type', true);
//            error_log(print_r($badge_type, true) . "\n\n", 3, __DIR__ . '/log.txt');

                switch ($badge_type) {
                    case 'custom':
                        $output = 'Custom';
                        break;
                    case 'pb-on-sale':
                        $output = 'Product On Sale';
                        break;
                    case 'pb-featured-product':
                        $output = 'Featured Products';
                        break;
                    case 'pb-new-arrival-product':
                        $output = 'New Arrival Products';
                        break;
                    case 'pb-best-selling-product':
                        $output = 'Best Selling Products';
                        break;
                    default:
                        $output = '-';
                }
        }
        return $output;
    }
    public function add_custom_columns($columns){
        $columns['pb_badge_type'] = __('Badge Type', 'Product-Badge');
        return $columns;
    }
}
new pbCustomColumn();