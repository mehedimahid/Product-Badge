<div id="pb_product_badge_options" class="panel woocommerce_options_panel">
    <div class="options_group">
        <p class="form-field">
            <label for="pb_badge_type"><?php _e('Badge Type:', 'Product-Badge'); ?></label>
            <select id="pb_badge_type" class="select short" name="pb_badge_type">
                <option value="dynamic" selected>Dynamic</option>
                <option value="custom">Custom</option>
            </select>
        </p>
        <p class="form-field " id="pb_dynamic_form_field" >
            <label for="pb_dynamic_badge_type"><?php _e('Dynamic:')?></label>
            <select id="pb_dynamic_badge_type" class=" short" name="pb_dynamic_badge_type">
                <option value="pb-on-sale">Product On Sale</option>
                <option value="pb-featured-product">Featured Products</option>
                <option value="pb-new-arrival-product">New Arrival Products</option>
                <option value="pb-best-selling-product">Best Selling Products</option>
            </select>
        </p>
        <p class="form-field hidden" id="pb_custom_badge_form_field" >
            <label for="pb_custom_badge"><?php _e('Custom Badge:')?></label>
            <input type="text" id="pb_custom_badge" name="pb_custom_badge" value="">
        </p>
    </div>
</div>

