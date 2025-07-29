<?php
global $thepostid;
$badge_type = get_post_meta($thepostid, "_badge_type", true);

?>
<div id="pb_product_badge_options" class="panel woocommerce_options_panel">
    <div class="options_group">
        <p class="form-field">
            <label for="pb_badge_type"><?php _e('Badge Type:', 'Product-Badge'); ?></label>
            <select id="pb_badge_type" class="select short" name="pb_badge_type">
                <option value="dynamic"
                    <?php if('dynamic' === $badge_type ) {
                        echo 'selected'; }
                    ?>
                > Dynamic </option>

                <option value="custom" <?php if('custom' === $badge_type ) {
                    echo 'selected'; }
                ?>  >Custom</option>
            </select>
        </p>

        <p class="form-field  <?php if('dynamic' !== $badge_type ) {
            echo 'hidden'; }
        ?> " id="pb_dynamic_badge_form_field" >
            <label for="pb_badge_type_dynamic"><?php _e('Dynamic:')?></label>
            <select id="pb_badge_type_dynamic" class="pb_badge_type_dynamic short" name="pb_badge_type_dynamic">
                <option value="pb-on-sale">Product On Sale</option>
                <option value="pb-featured-product">Featured Products</option>
                <option value="pb-new-arrival-product">New Arrival Products</option>
                <option value="pb-best-selling-product">Best Selling Products</option>
            </select>
        </p>
        <?php
            $terms = get_terms(array(
                    'taxonomy' => 'product_badge',
                    'hide_empty'=>false,
            ));
            $selected_custom_badges = get_post_meta($thepostid,'_pb_custom_badges', true);
            if(!is_array($selected_custom_badges)){
                $selected_custom_badges = array();
            }
        ?>
        <p class="form-field <?php if('custom' !== $badge_type ) {
            echo 'hidden'; }
        ?> " id="pb_custom_badge_form_field" >
            <label for="pb-custom-badges"><?php _e('Custom Badges:')?></label>
            <select
                    multiple="multiple"
                    data-placeholder="<?php esc_attr_e( 'Select Badges', 'woocommerce' ); ?>"
                    class="multiselect select short wc-enhanced-select"
                    name="pb-custom-badges[]">
                <option value="pb-on-sale"<?php selected(in_array('pb-on-sale', $selected_custom_badges)); ?>>Product On Sale</option>
                <option value="pb-featured-product"<?php selected(in_array('pb-featured-product', $selected_custom_badges)); ?>>Featured Products</option>
                <option value="pb-new-arrival-product"<?php selected(in_array('pb-new-arrival-product', $selected_custom_badges)); ?>>New Arrival Products</option>
                <option value="pb-best-selling-product"<?php selected(in_array('pb-best-selling-product', $selected_custom_badges)); ?>>Best Selling Products</option>

                <?php foreach ($terms as $term){ ?>
                    <?php if (!in_array($term->slug, ['pb-on-sale', 'pb-featured-product', 'pb-new-arrival-product', 'pb-best-selling-product'])){ ?>
                        ?>
                        <option value="<?php echo esc_attr($term->slug); ?>"
                        <?php selected(in_array($term->slug, $selected_custom_badges)); ?>>
                        <?php echo esc_html($term->name) ?>
                    </option>
                <?php }
                }
                ?>
            </select>
        </p>
    </div>
</div>

