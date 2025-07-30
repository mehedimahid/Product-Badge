
document.addEventListener('DOMContentLoaded',function (){
    const pb_image_badge_type = document.getElementById('pb_image_badge_type')
    const pbImageBadgeField = document.getElementById('pbImageBadgeField')
    const pbLayOutBadgeField = document.getElementById('pbLayOutBadgeField')
    if (!pb_image_badge_type || !pbImageBadgeField || !pbLayOutBadgeField) {
        return;
    }
     function toggle(){
        const value = pb_image_badge_type.value;
        if (value === 'image') {
            pbImageBadgeField.classList.remove('hidden');
            pbLayOutBadgeField.classList.add('hidden');
        } else if (value === 'layout') {

            pbImageBadgeField.classList.add('hidden');
            pbLayOutBadgeField.classList.remove('hidden');
        }
    }
    pb_image_badge_type.addEventListener('change',toggle)
    toggle()
})