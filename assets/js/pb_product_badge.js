document.addEventListener('DOMContentLoaded',function (){
    const pb_badge_type = document.getElementById('pb_badge_type')
    const pb_dynamic_badge_form_field = document.getElementById('pb_dynamic_badge_form_field')
    const pb_custom_badge_form_field = document.getElementById('pb_custom_badge_form_field')
    pb_badge_type.addEventListener('change', ()=>{
        const value = pb_badge_type.value;
        // pb_badge_popular_type.style.display = (value === 'dynamic') ? 'block' : 'none';
        // pb_badge_best_type.style.display = (value === 'custom') ? 'block' : 'none';
        if (value === 'dynamic') {
            pb_dynamic_badge_form_field.classList.remove('hidden');
            pb_custom_badge_form_field.classList.add('hidden');
        } else if (value === 'custom') {
            pb_dynamic_badge_form_field.classList.add('hidden');
            pb_custom_badge_form_field.classList.remove('hidden');
        }
    })
})