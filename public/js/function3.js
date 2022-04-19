function reset(){
    
    // let nav_left = $('.nav-left')
    // let nav_mid = $('.nav-mid')
    // let nav_right = $('.nav-right')
    // let logo = $('.nav-left .logo')
    // let btn_search = $('.nav-left .box-search')
    // let btn_back_search = $('.nav-left .back-search')
    
    // btn_back_search.removeClass('display')
    // logo.removeClass('hide')
    // btn_search.removeClass('active')
    // nav_left.removeClass('active')
    // nav_mid.removeClass('small')
    // nav_right.removeClass('hide')

}

function is_none_calendar(){
    let calendar_items = $('.main-right .calendar__items')
    let calendar_not_have = $('.main-right .calendar__items .not-have')
    let condition = calendar_items.children().not('.hide')
    if(condition.length == 1){
        calendar_not_have.addClass('display')
    }
    else {
        calendar_not_have.removeClass('display')
    }
}

function validate(selector){
    let element = $(selector)
    let value = element.val()
    if (value == ""){
        element.addClass('required')
        element.parent().children('.alert-required').addClass('display');
    }
    else {
        element.removeClass('required')
        element.parent().children('.alert-required').removeClass('display');
    }
}
function not_validate(selector){
    let element = $(selector)
    element.removeClass('required')
    element.parent().children('.alert-required').removeClass('display');
    
}

function un_active_all(){

    $('.new-feed__btn .functions').removeClass('display')
    
    // remove class: div.#rise
    const rise = $('#rise')
    const rise_calendar_detail = $('#rise .calendar')
    const add_calendar = $('#rise .add_calendar')
    const delete_all_calendar = $('#rise .delete_all_calendar')
    const body = $('body')

    rise.removeClass('display')
    rise_calendar_detail.removeClass('display')
    add_calendar.removeClass('display')
    delete_all_calendar.removeClass('display')
    body.removeClass('darken')
    
    // remove ORTHER CLASS
    const nav_right_btn = $('.nav-right__buttons-item')
    const nav_right_content = $('.nav-right__content ul')

    const nav_left = $('.nav-left')
    const nav_mid = $('.nav-mid')
    const nav_right = $('.nav-right')
    const logo = $('.nav-left .logo')
    const btn_search = $('.nav-left .box-search')
    const btn_back_search = $('.nav-left .back-search')
    const filter_status = $('.nav-mid .filter-status')

    nav_right_btn.removeClass('active')
    nav_right_content.removeClass('display')
    filter_status.removeClass('display')
    if (btn_back_search.hasClass('display')){
        btn_back_search.removeClass('display')
        logo.removeClass('hide')
        btn_search.removeClass('active')
        nav_left.removeClass('active')
        nav_mid.removeClass('small')
        nav_right.removeClass('hide')
    }

    $('.nav-messages__content-search .back-search').removeClass('display')
    $('.nav-messages__content-search .box-search').removeClass('active')
    $('.nav-messages__content-search .box-search input').val('')
    $('.nav-messages__content .messages-content').removeClass('hide')
    $('.nav-messages__content .search-result').removeClass('display')
    
}

jQuery.fn.hasScrollBar = function(direction)
{
  if (direction == 'vertical')
  {
    return this.get(0).scrollHeight > this.innerHeight();
  }
  else if (direction == 'horizontal')
  {
    return this.get(0).scrollWidth > this.innerWidth();
  }
  return false;

}