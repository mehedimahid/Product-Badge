<?php
class pbCustomMetaBox{
    public function __construct(){
        add_action('admin_enqueue_scripts',array($this,'pb_image_upload_box'));
        add_action('product_badge_add_form_fields',[$this, 'pb_add_badge_meta_field'],15);
        add_action('product_badge_edit_form_fields',[$this, 'pb_edit_badge_meta_field'],10);
        add_action('created_product_badge', array($this, 'pb_save_badge_meta_box'),10,2);
        add_action('edited_product_badge', array($this, 'pb_save_badge_meta_box'),10);
        //image upload
        add_action('product_badge_edit_form_fields',[$this, 'pb_image_badge_meta_field'],20, 2);
        add_action('product_badge_add_form_fields',[$this, 'pb_image_badge_add_meta_field'],20);
        add_action('created_product_badge', array($this, 'pb_save_image_badge_box'));
        add_action('edited_product_badge', array($this, 'pb_save_image_badge_box'));
        }
    //image uploads
    public function pb_image_upload_box($hook){
        if (strpos($hook, 'edit-tags.php') === false && strpos($hook, 'term.php') === false) {
            return;
        }
        wp_enqueue_style('pb_product_badge_css');
        wp_enqueue_script('pb_product_image_badge_js', pb_plugin_dir_url . 'assets/js/pb_product_image_badge.js', ['jquery'],'1.0.0',true);
        wp_enqueue_script('pbImageUploader',pb_plugin_dir_url.'assets/js/pb_image_upload.js',array('jquery'), '1.0.0', true);
        wp_enqueue_media();
    }

    //image Badge
    public function pb_save_image_badge_box($term_id)
    {
        if (isset($_POST['pb_badge_preset'])){
            update_term_meta($term_id, 'pb_badge_preset', sanitize_text_field($_POST['pb_badge_preset']));
        }
        if (isset($_POST['pb_badge_image'])){
            update_term_meta($term_id, 'pb_badge_image', sanitize_text_field($_POST['pb_badge_image']));
        }
        if (isset($_POST['pb_badge_layout'])){
            update_term_meta($term_id, 'pb_badge_layout', sanitize_text_field($_POST['pb_badge_layout']));
        }
    }
    public function pb_image_badge_add_meta_field(){
        ?>
        <div class="form-field">
            <label for="pb_badge_preset"><?php _e('Badge Preset','Product-Badge') ?></label>
            <select name="pb_badge_preset" id="pb_badge_preset">
                <option value="image">Upload Image</option>
                <option value="layout">Predefined Image</option>
            </select>
        </div>
        <div class="form-field badge-field badge-image " id="pbImageBadgeField">
            <label for="pb_badge_image">Upload Image</label>
            <div id="pb_image_badge_preview"></div>
            <input type="hidden" id="pb_badge_image" name="pb_badge_image">
            <button type="button" class="button" id="pb_image_badge_upload_btn">Upload </button>
        </div>
        <div class="form-field badge-field badge-layout" id="pbLayOutBadgeField">
            <th scope="row"><label for="pb_badge_layout"><?php _e('Badge Layout', 'Product-Badge'); ?></label></th>
            <td>
                <label style="margin-right:20px; display:inline-block;">
                    <input type="radio" name="pb_badge_layout" value="layout1" />
                    <img
                        src="<?php echo pb_plugin_dir_url . 'assets/img/pbNewProduct.jpeg'; ?>"
                        alt="Layout 1"
                        style="
                            width:80px;
                            height:auto;
                            display:block;
                            border:1px solid #ccc;
                            margin-top:5px;">
                    Layout 1
                </label>

                <label style="margin-right:20px; display:inline-block;">
                    <input type="radio"  name="pb_badge_layout" value="layout2" />
                    <img
                       src="<?php echo pb_plugin_dir_url . 'assets/img/pbOrigin.jpeg'; ?>"
                       alt="Layout 2"
                       style="
                            width:80px;
                            height:auto;
                            display:block;
                            border:1px solid #ccc;
                            margin-top:5px;">
                    Layout 2
                </label>
            </td>
        </div>
        <?php
    }
    public function pb_image_badge_meta_field($term = null , $texonomy = null){
        $term_id = $term ? $term->term_id : 0;
        $image_id = $term_id ? get_term_meta($term_id, 'pb_badge_image', true): '';
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : '';

        $display_type = $term_id ? get_term_meta($term_id, 'pb_badge_preset', true) : 'image';
        $layout = $term_id ? get_term_meta($term_id, 'pb_badge_layout', true) : '';

        ?>
        <tr class="form-field">
            <th scope="row"><label for="pb_badge_preset"><?php _e('Badge Preset') ?></label></th>
            <td>
                <select name="pb_badge_preset" id="pb_badge_preset">
                    <option value="image"<?php selected($display_type, 'image') ?>>Upload Image</option>
                    <option value="layout"<?php selected($display_type, 'layout') ?>>Predefined Image</option>
                </select>
            </td>
        </tr>
        <tr class="form-field badge-field badge-image"  style="display: <?php echo ($display_type === 'image') ? 'table-row' : 'none'; ?>">
            <th><label for="pb_badge_image">Upload Image</label></th>
            <td>
                <div id="pb_image_badge_preview"><?php if ($image_url) echo '<img src="'.esc_url($image_url).'" style="max-width:100px;" />'; ?></div>
                <input type="hidden" id="pb_badge_image" name="pb_badge_image" value="<?php echo esc_attr($image_id) ?>">
                <button type="button" class="button" id="pb_image_badge_upload_btn">Upload </button>
            </td>
        </tr>
        <tr class="form-field badge-field badge-layout"  style="display: <?php echo ($display_type === 'layout') ? 'table-row' : 'none'; ?>">
            <th scope="row"><label for="pb_badge_layout"><?php _e('Badge Layout', 'Product-Badge'); ?></label></th>
            <td>
                <label style="margin-right:20px; display:inline-block;">
                    <input type="radio" name="pb_badge_layout" value="layout1" <?php checked($layout, 'layout1'); ?> />
                    <img src="<?php echo pb_plugin_dir_url . 'assets/img/pbNewProduct.jpeg'; ?>" alt="Layout 1" style="width:80px; height:auto; display:block; border:1px solid #ccc; margin-top:5px;">
                    Layout 1
                </label>

                <label style="margin-right:20px; display:inline-block;">
                    <input type="radio" name="pb_badge_layout" value="layout2" <?php checked($layout, 'layout2'); ?> />
                    <img src="<?php echo pb_plugin_dir_url . 'assets/img/pbOrigin.jpeg'; ?>" alt="Layout 2" style="width:80px; height:auto; display:block; border:1px solid #ccc; margin-top:5px;">
                    Layout 2
                </label>
            </td>
        </tr>
        <?php
    }


    //Custom/ Dynamic  Badge
    public function pb_save_badge_meta_box($term_id){
        if(isset($_POST['pb_badge_type'])){
            update_term_meta($term_id, 'pb_badge_type', sanitize_text_field($_POST['pb_badge_type']));
        }
    }
    public function pb_edit_badge_meta_field($term){
        $badge_type = get_term_meta($term->term_id, 'pb_badge_type', true);
        ?>
        <tr class="form-field term-description-wrap">
            <th scope="row"><label for="description"><?php _e( 'Badge Type:', 'Product-Badge' ); ?></label></th>
            <td>
                <div class="form-field">
                    <select id="pb_badge_type" class="select short" name="pb_badge_type">
                        <option value="custom" <?php selected($badge_type, 'custom') ?>>Custom</option>
                        <option value="pb-on-sale"  <?php selected($badge_type, 'pb-on-sale') ?> >Product On Sale</option>
                        <option value="pb-featured-product"<?php selected($badge_type, 'pb-featured-product') ?> >Featured Products</option>
                        <option value="pb-new-arrival-product"<?php selected($badge_type, 'pb-new-arrival-product') ?>>New Arrival Products</option>
                        <option value="pb-best-selling-product"<?php selected($badge_type, 'pb-best-selling-product') ?>>Best Selling Products</option>
                    </select>
                </div>
                <p class="description" id="description-description">Create your custom badge or Choose Dynamic</p>
            </td>
        </tr>
        <?php
    }
    public function pb_add_badge_meta_field()
    {
    ?>
        <p class="form-field">
            <label for="pb_badge_type"><?php _e('Badge Type:', 'Product-Badge'); ?></label>
            <select id="pb_badge_type" class="select short" name="pb_badge_type">
                <option value="custom">Custom</option>
                <option value="pb-on-sale" >Product On Sale</option>
                <option value="pb-featured-product" >Featured Products</option>
                <option value="pb-new-arrival-product">New Arrival Products</option>
                <option value="pb-best-selling-product">Best Selling Products</option>
            </select>
        </p>
    <?php
    }
}
new pbCustomMetaBox();