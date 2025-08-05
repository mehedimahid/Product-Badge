<?php
global $thepostid;
$badge_type = get_post_meta($thepostid, "_badge_type", true);

?>
<div id="pb_product_badge_options" class="panel woocommerce_options_panel">
    <div class="options_group">
        <?php
            $terms = get_terms(array(
                    'taxonomy' => 'product_badge',
                    'hide_empty'=>false,
                    'meta_query' => [
                        [
                            'key'     => 'pb_badge_type',
//                            'value'   => 'custom',
                            'compare' => 'EXISTS'
                        ]
                    ]
            ));
            $selected_custom_badges = get_post_meta($thepostid,'_pb_custom_badges', true);
            if(!is_array($selected_custom_badges)){
                $selected_custom_badges = array();
            }
        ?>
        <p class="form-field" id="pb_custom_badge_form_field" >
            <label id="pb_badge_type"><?php _e('Custom Badge', 'Product-Badge'); ?></label>
            <select
                multiple="multiple"
                data-placeholder="<?php esc_attr_e( 'Select Badges', 'woocommerce' ); ?>"
                class="multiselect select short wc-enhanced-select"
                name="pb-custom-badges[]">
                <?php foreach ($terms as $term){ ?>
                        <option value="<?php echo esc_attr($term->slug); ?>"
                        <?php selected(in_array($term->slug, $selected_custom_badges)); ?>>
                        <?php echo esc_html($term->name) ?>
                    </option>
                <?php
                }
                ?>
            </select>
        </p>
    </div>
</div>

