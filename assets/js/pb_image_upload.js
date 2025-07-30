jQuery(document).ready(function ($){
    $('#pb_image_badge_type').on('change',function (){
        $('.badge-field').hide();
        $('.badge-' + $(this).val()).show();
    })
    $('#pb_image_badge_upload_btn').on('click', function(e){
        e.preventDefault();
        var frame = wp.media({ title: 'Select or Upload Image', multiple: false });
        frame.on('select', function(){
            var attachment = frame.state().get('selection').first().toJSON();
            $('#pb_badge_image').val(attachment.id);
            $('#pb_image_badge_preview').html('<img src="'+attachment.url+'" style="max-width:100px;" />');
        });
        frame.open();
    });
})