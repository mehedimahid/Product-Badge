
document.addEventListener('DOMContentLoaded',function (){
    const pb_badge_preset = document.getElementById('pb_badge_preset')
    const pbImageBadgeField = document.getElementById('pbImageBadgeField')
    const pbLayOutBadgeField = document.getElementById('pbLayOutBadgeField')
    if (!pb_badge_preset || !pbImageBadgeField || !pbLayOutBadgeField) {
        return;
    }
     function toggle(){
        const value = pb_badge_preset.value;
        if (value === 'image') {
            pbImageBadgeField.classList.remove('hidden');
            pbLayOutBadgeField.classList.add('hidden');
        } else if (value === 'layout') {

            pbImageBadgeField.classList.add('hidden');
            pbLayOutBadgeField.classList.remove('hidden');
        }
    }
    pb_badge_preset.addEventListener('change',toggle)
    toggle()
})