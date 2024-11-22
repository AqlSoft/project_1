const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


// Personal Navs and Tabs

// $(document).on('click', '.navBtn', (evt) => {
//     console.log(__parent_id)
//     const __id = evt.target.getAttribute('data-target')
//     $('.tabs .tabItem').removeClass('show')
//     $(__id).addClass('show');
// })

$(document).on('click', '.navBtn', (evt) => {
    const __id = evt.target.getAttribute('data-target')
    const _btn = evt.target
    const __parent_id = $(__id).attr('data-parent')

    // If user clicked icon  nothing is depricated
    // if (_btn.classList.contains('fa')) return
    console.log(__id, __parent_id, _btn)
    $(__parent_id + ' ' + ' nav.tabsDisplay>button').removeClass('active')
    _btn.classList.add('active')

    $(__parent_id + ' .tabs .tabItem').removeClass('show')
    $(__parent_id + ' ' + __id).addClass('show');
})


//Personal Collapse

const collapseBtns = document.querySelectorAll('.collapse-btn') 
collapseBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
        const __target_id = this.getAttribute('data-target')
        const __parent_id  = this.parentElement.getAttribute('id')
        const __active_btns = document.querySelectorAll('#'+__parent_id + ' button')
        const __active_items = document.querySelectorAll('#'+__parent_id + ' .collapse-items .item')
        const __target_item = document.querySelector('#'+__parent_id + ' ' + __target_id)
        // Disable active buton 
        __active_btns.forEach(function(ab) {
            ab.classList.remove('active');
        });
        // Activate the clicked button
        this.classList.add('active');
        
        //console.log(this, __target_item)

        // Hide shown collape item
        __active_items.forEach(function(ai) {
            ai.classList.remove('show');
        });
        __target_item.classList.add('show')
    })
})
