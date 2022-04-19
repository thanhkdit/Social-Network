
$(document).ready(function(){

//TODO: event in navbar
{

    const nav_right_btn = $('.nav-right__buttons-item')
    const nav_right_content = $('.nav-right__content > ul')

    nav_right_btn.mousedown(function(e){
        e.stopPropagation()
    })
    nav_right_btn.click(function(e){
        $(this).children('.new-notification').html('0')
        $(this).children('.new-notification').addClass('hide')
        e.stopPropagation()

        if (($(this).hasClass('active'))){
            un_active_all()
            }
        else{
            un_active_all()
            $(this).addClass('active')
            $(nav_right_content.get($(this).index())).addClass('display')
            
        }
    })

    
    $('.nav-notification__content').mousedown(function(e){
        e.stopPropagation()
    })
    $('.nav-notification__content').click(function(e){
        e.stopPropagation()
    })
    $('.nav-setting__content').mousedown(function(e){
        e.stopPropagation()
    })
    $('.nav-setting__content').click(function(e){
        e.stopPropagation()
    })
    $('.nav-messages__content').mousedown(function(e){
        e.stopPropagation()
    })
    $('.nav-messages__content').click(function(e){
        e.stopPropagation()
    })

    const btn_switch = $('.btn-switch')
    btn_switch.click(function() {
        $(this).toggleClass('on')
    })

    const btn_filter = $('.filter-post .filter-post__icon')
    btn_filter.click(function() {
        if (!($(this).hasClass('selected'))){
            btn_filter.removeClass('selected')
            $(this).addClass('selected')
        }
    })


    // Click search button (max-height: 1100px)

    const nav_left = $('.nav-left')
    const nav_mid = $('.nav-mid')
    const nav_right = $('.nav-right')
    const logo = $('.nav-left .logo')
    const left_btn_search = $('.nav-left .box-search')
    const mid_btn_search = $('.nav-mid .box-search')
    const input_search = $('.nav-mid .box-search input')
    const search_result = $('.box-search .box-search__result')
    const btn_back_search = $('.nav-left .back-search')
    const nav_bar = $('.nav-mid .bars')
    const filter_post = $('.nav-mid .filter-post')

    search_result.mousedown(function(e){
        e.stopPropagation()
    })
    search_result.click(function(e) {
        e.stopPropagation()
    })
    input_search.mousedown(function(e){
        e.stopPropagation()
    })
    input_search.focus(function(e){
        e.stopPropagation()
        search_result.addClass('active')
        left_btn_search.addClass('active')
        mid_btn_search.addClass('active')
    })
    left_btn_search.mousedown(function(e){
        e.stopPropagation()
    })
    left_btn_search.click(function(e){
        e.stopPropagation()
        un_active_all()
        search_result.addClass('active')
        nav_left.addClass('active')
        if (!$(this).hasClass('active')){
            $(this).addClass('active')
            logo.addClass('hide')
            btn_back_search.addClass('display')
            nav_left.addClass('active')
            nav_mid.addClass('small')
            nav_right.addClass('hide')
        }
        if (window.matchMedia('(max-width: 1100px)').matches){
            if (!$(this).hasClass('active')){
                $(this).addClass('active')
                logo.addClass('hide')
                btn_back_search.addClass('display')
                nav_left.addClass('active')
                nav_mid.addClass('small')
                nav_right.addClass('hide')
            }
        }
        
    })
    filter_post.mousedown(function(e){
        e.stopPropagation()
    })
    filter_post.click(function(e){
        e.stopPropagation()
        un_active_all()
    })

    btn_back_search.mousedown(function(e){
        e.stopPropagation()
    })
    btn_back_search.click(function(e){
        e.stopPropagation()
        search_result.removeClass('active')
        if ($(this).hasClass('display')){
            $(this).removeClass('display')
            logo.removeClass('hide')
        left_btn_search.removeClass('active')
            nav_left.removeClass('active')
            nav_mid.removeClass('small')
            nav_right.removeClass('hide')
        }
    })

    nav_bar.mousedown(function(e){
        e.stopPropagation()
    })
    nav_bar.click(function(e){
        e.stopPropagation()
        filter_post.toggleClass('display')
    })

    const nav_left_search = $('#nav-left__search:input')
    const nav_mid_search = $('#nav-mid__search')

    nav_left_search.keyup(function(){
        nav_mid_search.val($(this).val())
    })
    nav_mid_search.keyup(function(){
        nav_left_search.val($(this).val())
    })

}

    //TODO: event in notification
{
    const box_chat_list = $('.box-chat__list')
    const btn_seen = $('.nav-right .nav-notification__seen');
    
    $('.nav-messages__content-search .back-search').click(function(){
    let box_search = $(this).siblings('.box-search')
    $(this).removeClass('display')
    box_search.removeClass('active')
    box_search.children('input').val('')
    $(this).parent().siblings('.messages-content').removeClass('hide')
    $(this).parent().siblings('.search-result').removeClass('display')
    })

    $('.nav-messages__content-search .box-search input').click(function(){
        $(this).parent().addClass('active')
        $(this).parent().siblings('.back-search').addClass('display')
        $(this).parent().parent().siblings('.messages-content').addClass('hide')
        $(this).parent().parent().siblings('.search-result').addClass('display')
    })

    $('.nav-messages__content').on('click','li ul li',function(){
        $(this).closest('.nav-messages__content').removeClass('display')
        $('.nav-message.active').removeClass('active')
        
        if(box_chat_list.children().length >= TAB_CHAT_NUMS){
            box_chat_list.children(':nth-last-child(1)').remove()
        }
    })
}

    //TODO: event in calendar
{
    const main_right = $('.main-right')
    const calendar_items = $('.main-right .calendar .calendar__items')
    // let calendar_item = $('.main-right .calendar .calendar__item')
    // const calendar_item_content = $('.main-right .calendar .calendar__item__detail-content')
    const rise_calendar_detail = $('#rise .calendar')
    const rise = $('#rise')
    const rise_btn_close = $('.rise__btn-close')
    const body = $('body')
    const add_calendar = $('#rise .add_calendar')
    const delete_all_calendar = $('#rise .delete_all_calendar')
    const form_add_calendar = $('#form_add_calendar')
    const btn_submit_add_calendar = $('#form_add_calendar .btn_submit')

    const title_calendar = $('#form_add_calendar .title_calendar')
    const time_calendar = $('#form_add_calendar .time_calendar')
    const content_calendar = $('#form_add_calendar .content_calendar')

    let calendar_action = $('.calendar__item .calendar__item-action')
    let btn_minus = $('.calendar__item .btn-minus')
    
    const btn_add_calendar = $('#btn_add_calendar')
    const btn_delete_all_calendar = $('#btn_delete_all_calendar')
    const btn_delete_all = $('.delete_all_calendar .delete_all')
    const btn_cancel_delete_all = $('.delete_all_calendar .cancel_delete_all')
    
    const alert = $('#form-create-post .alert')

    main_right.mousedown(function(e){
        e.stopPropagation()
    })
    main_right.click(function(e){
        e.stopPropagation()
    })

    alert.mousedown(function(e){
        e.stopPropagation()
    })
    alert.click(function(e){
        e.stopPropagation()
    })

    //* rise action
    rise.mousedown(function(e){
        e.stopPropagation()
        alert.removeClass('display')
    })
    rise.click(function(e){
        e.stopPropagation()
        alert.removeClass('display')
    })
    rise_btn_close.mousedown(function(e){
        e.stopPropagation()
    })
    rise_btn_close.click(function(e){
        e.stopPropagation()
        rise.removeClass('display')
        rise_calendar_detail.removeClass('display')
        add_calendar.removeClass('display')
        delete_all_calendar.removeClass('display')
        body.removeClass('darken')
        $('input#post-media').val('')
    })
    
    //* Show calendar detail
    calendar_items.on('mousedown','.calendar__item__detail-content',function(e){
        e.stopPropagation()
    })
    calendar_items.on('click','.calendar__item__detail-content',function(e){
        e.stopPropagation()
        un_active_all()
        //* get infomation of calendar__item
        const title = $(this).children('b').html()
        let time = $(this).closest('.calendar__item').children('.calendar__item-time').val()
        const content = $(this).children('p').html()

        let rise_calendar_title = rise_calendar_detail.children('.calendar__header').children('p')
        let rise_calendar_time = rise_calendar_detail.children('.calendar__time').children('p')
        let rise_calendar_content = rise_calendar_detail.children('.calendar__content').children('p')

        rise_calendar_title.html(title)
        time = time.replace(/\-/g, '/')
        time = time.replace(/ /g, ' - ')
        rise_calendar_time.html(time)
        rise_calendar_content.html(content)

        rise.addClass('display')
        rise_calendar_detail.addClass('display')
        body.addClass('darken')
    })

    //* Add 1 calendar
    btn_add_calendar.mousedown(function(e){
        e.stopPropagation()
    })
    btn_add_calendar.click(function(e){
        e.stopPropagation()
        un_active_all()
        rise.addClass('display')
        add_calendar.addClass('display')
        body.addClass('darken')
        not_validate(title_calendar)
        not_validate(time_calendar)
    })
    form_add_calendar.submit(function(e){
        // e.preventDefault();
    })
    btn_submit_add_calendar.click(function(){
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "June","July", "Aug", "Sep", "Oct", "Nov", "Dec"];
        
        let date = new Date(time_calendar.val())
        if(date != 'Invalid Date' && title_calendar.val() != ''){
            let time_calendar_input = new Date(time_calendar.val())
            time_calendar_input = time_calendar_input.getFullYear() + '-'
                                + (time_calendar_input.getMonth() + 1) + '-'
                                + time_calendar_input.getDate() + ' '
                                + time_calendar_input.getHours() + ':'
                                + time_calendar_input.getMinutes() + ':'
                                + '00'
            calendar_items.prepend(
                "<li class='calendar__item'>"+
                    "<input hidden class='calendar__item-time' type='text' "+
                        "value='" + time_calendar_input +
                    "'>"+
                    "<div class='calendar__item__detail'>"+
                        "<div class='box-calendar'>"+
                            "<div class='box-calendar__day'>"+
                                date.getDate() +
                            "</div>"+
                            "<div class='box-calendar__month'>"+
                                monthNames[date.getMonth()] +
                            "</div>"+
                        "</div>"+
                        "<div class='calendar__item__detail-content'>"+
                            "<b>"+
                                title_calendar.val() +
                            "</b>"+
                            "<p>"+
                                content_calendar.val() +
                            "</p>"+
                        "</div>"+
                    "</div>"+
                    "<div class='calendar__item-action'>"+
                        "<div class='delete'>"+
                            "<i class='fas fa-trash-alt'></i>"+
                        "</div>"+
                        "<div class='cancel'>"+
                            "<i class='fas fa-times'></i>"+
                        "</div>"+
                    "</div>"+
                    "<span class='btn-minus'><i class='fas fa-minus'></i></span>"+
                "</li>"
            )

            not_validate(title_calendar)
            not_validate(time_calendar)

            is_none_calendar()

            //* Reload variable
            calendar_action = $('.calendar__item .calendar__item-action')
            btn_minus = $('.calendar__item .btn-minus')

            //* Close rise
            rise.removeClass('display')
            rise_calendar_detail.removeClass('display')
            add_calendar.removeClass('display')
            delete_all_calendar.removeClass('display')
            body.removeClass('darken')
        }else {
            validate(title_calendar)
            validate(time_calendar)
        }

    })

    //* Delete 1 calendar
    calendar_items.on('click','.btn-minus',function(){
        $(this).addClass("hide")
        $(this).parent().addClass("turn-left")
        $(calendar_action.get(btn_minus.index(this))).addClass('display')
    })
    calendar_items.on('click','.calendar__item-action .delete',function(){
        // $(this).parent().parent().remove()
        // is_none_calendar()
    })
    calendar_items.on('click','.calendar__item-action .cancel',function(){
        $(this).parent().parent().children('.btn-minus').removeClass('hide')
        $(this).parent().parent().removeClass('turn-left')
        $(this).parent().removeClass('display')
    })

    //* Delete all calendar
    btn_delete_all_calendar.mousedown(function(e){
        e.stopPropagation()
    })
    btn_delete_all_calendar.click(function(e){
        e.stopPropagation()
        rise.addClass('display')
        delete_all_calendar.addClass('display')
        body.addClass('darken')
    })
    btn_delete_all.click(function(){
        rise.removeClass('display')
        delete_all_calendar.removeClass('display')
        body.removeClass('darken')
        let calendar_item = $('.main-right .calendar .calendar__item')

        calendar_item.remove()
        is_none_calendar()
    })
    btn_cancel_delete_all.click(function(){
        rise.removeClass('display')
        delete_all_calendar.removeClass('display')
        body.removeClass('darken')
    })

}

    //TODO: event in list-stories
{
    let btn_back_left = $('.main-content__top .back-left')
    let owl_stage = $('#stories-slider .owl-stage')
    btn_back_left.click(function(){
        owl_stage.css('transform','translate3d(0px, 0px, 0px)')
    })
}

    //TODO: event in new-feed
{
    let list_news_feed = $('.list-news-feed')
    
    list_news_feed.on('click', '.btn-comment', function(){
        $(this).closest('.new-feed__bottom').find('.box-comment .emojionearea-editor').focus()
    })
    list_news_feed.on('mousedown','.new-feed__btn',function(e){
        e.stopPropagation()
    })
    list_news_feed.on('click', '.new-feed__btn', function(e){
        e.stopPropagation()
        
        if($(this).children('.functions').hasClass('display')){
            un_active_all()
        }
        else{
            un_active_all()
            $(this).children('.functions').addClass('display')
        }
        
    })

    //* read more, read less
    list_news_feed.on('click','.read-more',function(){
        $(this).siblings('p').addClass('more')
        $(this).removeClass('display-inline')
        $(this).siblings('.read-less').addClass('display-inline')
    })
    list_news_feed.on('click','.read-less',function(){
        $(this).siblings('p').removeClass('more')
        $(this).removeClass('display-inline')
        $(this).siblings('.read-more').addClass('display-inline')
    })

    //* like
    list_news_feed.on('click','.btn-like.post',function(){
        $(this).toggleClass('like')
    })
}

//TODO: event in tab-chat
{
    let box_chat_list = $('.box-chat__list')
    box_chat_list.on('click','.box-chat__list-item .btn_close',function(){
        $(this).closest('.box-chat__list-item').remove();
    })

    box_chat_list.on('mouseenter','.tab-chat__content .chat-content p',function(event){
        let time_hover = $(this).siblings('.time-hover')
        let top = event.pageY - $(this).offset().top + $(this).position().top - 20
        let left = $(this).position().left - 155;
        var timeout_hover = setTimeout(function(){
            time_hover.addClass('display')
            time_hover.css({'top':top,'left':left})
        },300)
        box_chat_list.on('mouseleave','.tab-chat__content .chat-content p',function(){
            $(this).siblings('.time-hover').removeClass('display')
            clearTimeout(timeout_hover)
        })
        box_chat_list.on('mousewheel','.tab-chat__content ul',function(){
            $('.time-hover').removeClass('display')
            clearTimeout(timeout_hover)
        })
    })

    //* Send message
    box_chat_list.on('focus', '.emojionearea .emojionearea-editor', function(e) {
        $(this).parent().addClass('focus-chat')
    })
    box_chat_list.on('blur', '.emojionearea .emojionearea-editor', function(e) {
        $(this).parent().removeClass('focus-chat')
    })
    box_chat_list.on('keypress','.input-tab-chat',function(e){
        $(this).siblings('.storage_message').html($(this).parent('form').find('.emojionearea .emojionearea-editor').html())
    })
    box_chat_list.on('keydown','.input-tab-chat',function(e){
        $(this).parents('form').find('.emojionearea').addClass('focus-chat')
        if(e.code == 'ShiftLeft' || e.code == 'ShiftRight'){
            checkShift=true
        }
        if(checkShift){
            if(e.code == 'Enter'){
                $(this).parent('form').submit()
                return false
            }
        }
    })
    box_chat_list.on('keyup','.input-tab-chat',function(e){
        if(e.code == 'ShiftLeft' || e.code == 'ShiftRight'){
            checkShift=false
        }
    })

    //* Minimize tab-chat
    box_chat_list.on('click','.btn_down',function(){
        $(this).closest('.box-chat__list-item').addClass('minimize')
    })
    box_chat_list.on('click','.btn_up',function(){
        $(this).closest('.box-chat__list-item.minimize').removeClass('minimize')
    })

    //* Cuon chuot xuong duoi cung khi gui tin nhan
    box_chat_list.on('click','.btn_submit button',function(){
        $(this).closest('.tab-chat').find('.tab-chat__content ul').scrollTop(0)
    })
    
    //* Click vào tab có tin nhắn mới
    box_chat_list.on('click','.tab-chat',function(){
        $(this).find('.tab-chat__top').removeClass('new-message')
    })
    
    //* Scroll vào tab có tin nhắn mới
    box_chat_list.on('mousewheel','.tab-chat__content ul',function(e){
        $(this).parent().siblings('.tab-chat__top').removeClass('new-message')
    })
    
    //* input vào tab có tin nhắn mới
    box_chat_list.on('keydown','.tab-chat form .input-chat',function(){
        $(this).closest('.tab-chat').children('.new-message').removeClass('new-message')
    })
    
    box_chat_list.on('click', '.label-chat-image-input', function(event){
        $(this).siblings('.chat-image-input').click()
    })
    //* preview image after selected
    box_chat_list.on('change', '.chat-image-input', function(event){
        let alert = $(this).siblings('.custom-alert')
        alert.mousedown(function(e){
            e.stopPropagation()
        })
        let preview = $(this).siblings('.preview')
        let target = event.target || event.srcElement;
        let image_preview = preview.children('.image-preview')
        // Khởi tạo masonry
        image_preview.imagesLoaded(function () {
            image_preview.masonry({
                // options...
                itemSelector: '.image-preview__one',
                columnWidth: 2
            });
        });
        let btn_image = preview.siblings('.label-chat-image-input').children('.btn-image')
        if (target.value.length == 0) {
            image_preview.removeClass('minimize')
            btn_image.removeClass('selected')
            preview.removeClass('selected')
            image_preview.html('')
        } else {
            let files = target.files
            length = files.length
            max_size_file = $('.form-input-chat .max_size_file').val()
            
            image_preview.removeClass('minimize')
            btn_image.addClass('selected')
            preview.addClass('selected')
            image_preview.html('') // xóa hết phần tử ảnh
            image_preview.masonry('layout'); // reset lại masonry vì mình vừa xóa hết phẩn tử ảnh
            for (let i = 0; i < length; i++){
                let file_size = ((files[i].size/1024)/1024).toFixed(4); //MB
                if (Number(file_size) <= Number(max_size_file)){
                    if (isImage(files[i].name)){
                        let reader = new FileReader();
                        reader.onload = function (e) {
                            let item = $("<div class='image-preview__one' file_id='" + i + "'>" +
                                            "<img src='"+ e.target.result +"' alt='aaa'>" +
                                        "</div>")
                            
                            //* append items thì phải sử dụng masonry thì masonry mới nhận
                            image_preview.imagesLoaded( function() {
                                //* Khi đã load xong ảnh thì ...
                                image_preview.append(item).masonry('appended', item)
                            })
                        };
                        reader.readAsDataURL(files[i]);
                    }
                    else if (isVideo(files[i].name)){
                        let reader = new FileReader();
                        reader.onload = function (e) {
                            let item = $("<div class='image-preview__one' file_id='" + i + "'>" +
                                            "<video controls autoplay muted>" +
                                                "<source src='"+ e.target.result +"'>" +
                                            "</video>" +
                                        "</div>")
                            
                            //* append items thì phải sử dụng masonry thì masonry mới nhận
                            image_preview.imagesLoaded( function() {
                                //* Khi đã load xong ảnh thì ...
                                image_preview.append(item).masonry('appended', item)
                            })
                        };
                        reader.readAsDataURL(files[i]);
                    }
                } else{
                    image_preview.removeClass('minimize')
                    btn_image.removeClass('selected')
                    preview.removeClass('selected')
                    alert.addClass('display')
                    alert.html("File size has exceeded 4MB")
                    image_preview.html('')
                    $(this).val('')
                    return
                }
            }
            if ($(this)[0].files.length == 1){
                preview.find('.preview-top h6').html(`<b>${$(this)[0].files.length}</b> file`)
            }
            else {
                preview.find('.preview-top h6').html(`<b>${$(this)[0].files.length}</b> files`)
            }
        }
    })

    //* remove 1 image
    box_chat_list.on('click','.image-preview__one',function(){
        let preview = $(this).closest('.preview')
        let image_preview = preview.children('.image-preview')
        let image_preview_one = preview.find('.image-preview__one')
        let btn_image = preview.siblings('.label-chat-image-input').children('.btn-image')
        let input_chat_image = preview.siblings('.chat-image-input')
        // id image muốn remove
        let id_remove = Number($(this).attr('file_id'))
        remove_file(input_chat_image, id_remove)
        
        // ẩn thẻ preview cha
        if (image_preview_one.length == 1){
            preview.removeClass('selected')
            preview.removeClass('minimize')
            btn_image.removeClass('selected')
        }
        else if (image_preview_one.length == 2){
            preview.find('.preview-top h6').html(`<b>${(image_preview_one.length - 1)}</b> file`)
        }
        else {
            preview.find('.preview-top h6').html(`<b>${(image_preview_one.length - 1)}</b> files`)
        }
        $(this).remove()
        
        image_preview.masonry('layout'); // reset lại masonry vì mình vừa xóa hết phẩn tử ảnh
        image_preview_one.each(function(index){
            let attr_file_id = Number($(this).attr('file_id'))
            if (attr_file_id > id_remove){
                $(this).attr('file_id', attr_file_id - 1)
            }
        })
    })
    
    box_chat_list.on('click','.preview-buttons__minimize .fa-chevron-down',function(){
        let preview = $(this).closest('.preview')
        preview.addClass('minimize')
        $(this).removeClass('fa-chevron-down')
        $(this).addClass('fa-chevron-up')
    })
    box_chat_list.on('click','.preview-buttons__minimize .fa-chevron-up',function(){
        let preview = $(this).closest('.preview')
        preview.removeClass('minimize')
        $(this).removeClass('fa-chevron-up')
        $(this).addClass('fa-chevron-down')
    })
    box_chat_list.on('click','.preview-buttons__close',function(){
        let preview = $(this).closest('.preview')
        let image_preview = preview.children('.image-preview')
        let btn_image = preview.siblings('.label-chat-image-input').children('.btn-image')
        let input_chat_image = preview.siblings('.chat-image-input')
        preview.removeClass('minimize')
        preview.removeClass('selected')
        btn_image.removeClass('selected')
        image_preview.html('')
        input_chat_image.val('')
    })
}


//TODO: event in up post
{
    const form_create_post = $('#form-create-post')
    let preview = $('#form-create-post .preview')
    let input_image = $('#post-media')
    let btn_image = $('.functions-buttons__one-media')
    let image = $('.functions-content__image')
    let tag = $('.functions-content__tag')
    let feeling = $('.functions-content__feeling')
    let location = $('.functions-content__location')
    let tag_box = $('.functions-content__tag-box')
    let feeling_box = $('.functions-content__feeling-box')
    let feeling_box_item = $('.functions-content__feeling-box ul li')
    let tag_input_fake = $('.functions-content__tag input.tag-fake')
    let tag_input_real = $('.functions-content__tag input.tag-real')
    let feeling_input = $('.functions-content__feeling input')
    let location_input = $('.functions-content__location input')
    let i_feeling = $('.create-post__top .post-info__poster .i-feeling')
    let i_with = $('.create-post__top .post-info__poster .i-with')
    let i_at = $('.create-post__top .post-info__poster .i-at')
    let b_feeling = $('.create-post__top .post-info__poster .b-feeling')
    let b_with = $('.create-post__top .post-info__poster .b-with')
    let b_at = $('.create-post__top .post-info__poster .b-at')
    let alert = $('.form-create-post .custom-alert')
    let create_post_btn = $('#form-create-post .create-post-button')

    $('.up-post__top-btn').click(function(){
        $('body').addClass('darken')
        $('#rise').addClass('display')
        $('#rise .create-post').addClass('display')
    })
    $('.up-post__bottom li').click(function(){
        $('body').addClass('darken')
        $('#rise').addClass('display')
        $('#rise .create-post').addClass('display')
    })

    $('.functions-buttons__one-media input').change(function(event){
        let target = event.target || event.srcElement;
        if (target.value.length == 0) {
                btn_image.removeClass('active')
                preview.removeClass('display')
                image.html('')
        } else {
            let files = target.files
            length = files.length
            max_size_file = $('.form-create-post .max_size_file').val()

            btn_image.addClass('active')
            preview.addClass('display')
            alert.removeClass('display')
            image.html('') // xóa hết phần tử ảnh
            image.masonry('layout'); // reset lại masonry vì mình vừa xóa hết phẩn tử ảnh
                
            for (let i = 0; i < length; i++){
                let file_size = ((files[i].size/1024)/1024).toFixed(4); //MB
                if (Number(file_size) <= Number(max_size_file)){
                    if (isImage(files[i].name)){
                        let reader = new FileReader();
                        reader.onload = function (e) {
                            let item = $("<div class='functions-content__image-one' file_id='"+ i +"'>" +
                                            "<img src='" + e.target.result + "' alt='aaa' />"+
                                        "</div>")
                            
                            //* append items thì phải sử dụng masonry thì masonry mới nhận
                            image.imagesLoaded( function() {
                                //* Khi đã load xong ảnh thì ...
                                image.append(item).masonry('appended', item)
                            })
                        };
                        reader.readAsDataURL(files[i]);
                    }
                    else if (isVideo(files[i].name)){
                        let reader = new FileReader();
                        reader.onload = function (e) {
                            let item = $("<div class='functions-content__image-one' file_id='"+ i +"'>" +
                                            "<video controls autoplay muted>" +
                                                "<source src='"+ e.target.result +"'>" +
                                            "</video>" +
                                        "</div>")
                            
                            //* append items thì phải sử dụng masonry thì masonry mới nhận
                            image.imagesLoaded( function() {
                                //* Khi đã load xong ảnh thì ...
                                image.append(item).masonry('appended', item)
                            })
                        };
                        reader.readAsDataURL(files[i]);
                    }
                } else{
                    btn_image.removeClass('active')
                    preview.removeClass('display')
                    alert.addClass('display')
                    alert.html("Can't choose this file! File size has exceeded 4MB")
                    image.html('')
                    $(this).val('')
                }
            }
            
            if (length == 1){
                $('#form-create-post .functions-content h6').html(`<b>${(length)}</b> file`)
            }
            else {
                $('#form-create-post .functions-content h6').html(`<b>${(length)}</b> files`)
            }
        }
    })

    //* remove 1 image
    form_create_post.on('click','.functions-content__image-one',function(){
        // id image muốn remove
        let id_remove = Number($(this).attr('file_id'))
        remove_file(input_image, id_remove)
        
        let functions_content_image_one = $('.functions-content__image-one')
        // ẩn thẻ preview cha
        if (functions_content_image_one.length == 1){
            preview.removeClass('display')
            btn_image.removeClass('active')
        }
        else if (functions_content_image_one.length == 2){
            $('#form-create-post .functions-content h6').html(`<b>${(functions_content_image_one.length - 1)}</b> file`)
        }
        else {
            $('#form-create-post .functions-content h6').html(`<b>${(functions_content_image_one.length - 1)}</b> files`)
        }
        $(this).remove()
        
        image.masonry('layout'); // reset lại masonry vì mình vừa xóa hết phẩn tử ảnh
        functions_content_image_one.each(function(index){
            let attr_file_id = Number($(this).attr('file_id'))
            if (attr_file_id > id_remove){
                $(this).attr('file_id', attr_file_id - 1)
            }
        })
    })
    form_create_post.on('click','.preview-top__buttons-close',function(){
        input_image.val('')
        preview.removeClass('display')
        btn_image.removeClass('active')
    })

    $('.functions-buttons__one-action').click(function(){
        $('#form-create-post .emojionearea-button').click()
    })
    $('.functions-buttons__one-tag').click(function(){
        if (tag.hasClass('display')){
            $(this).removeClass('active')
            tag.removeClass('display')
            tag_input_fake.val('')
            tag_input_real.val('')
            let tag_box_item = tag_box.find('ul li p')
            tag_box_item.each(function(index, item) {
                $(item).closest('.post-tag-item').removeClass('hide')
            })
            i_with.html("")
            b_with.html("")
        }
        else{
            $(this).addClass('active')
            tag.addClass('display')
            tag_input_fake.focus()
            i_with.html(" with ")
        }
    })
    $('.functions-buttons__one-feeling').click(function(){
        if (feeling.hasClass('display')){
            $(this).removeClass('active')
            feeling.removeClass('display')
            feeling_input.val('')
            i_feeling.html("")
            b_feeling.html("")
        }
        else{
            $(this).addClass('active')
            feeling.addClass('display')
            feeling_input.focus()
            i_feeling.html(" is feeling ")
        }
    })
    $('.functions-buttons__one-location').click(function(){
        if (location.hasClass('display')){
            $(this).removeClass('active')
            location.removeClass('display')
            location_input.val('')
            i_at.html("")
            b_at.html("")
        }
        else{
            $(this).addClass('active')
            location.addClass('display')
            location_input.focus()
            i_at.html(" at ")
        }
    })
    tag_input_fake.on('input', function(e){
        // if (i_with.html() == ''){
        //     i_with.html(' with ')
        // }
        let tag_box_item = tag_box.find('ul li p')
        tag_input_real.val('')
        let this_item = $(this)
        if (this_item.val().trim() != '') {
            b_with.html($(this).val())
            $(this).removeClass('invalid')
            if (tag_box_item) {
                tag_box_item.each(function(index, item) {
                    if (!$(item).html().includes(this_item.val())) {
                        $(item).closest('.post-tag-item').addClass('hide')
                    } else {
                        $(item).closest('.post-tag-item').removeClass('hide')
                    }
                })
            }
        } else {
            tag_box_item.each(function(index, item) {
                $(item).closest('.post-tag-item').removeClass('hide')
            })
        }
    })
    feeling_input.on('input', function(e){
        // if (i_feeling.html() == ''){
        //     i_feeling.html(' is feeling ')
        // }
        b_feeling.html($(this).val())
        $(this).removeClass('invalid')
    })
    location_input.on('input', function(e){
        // if (i_at.html() == ''){
        //     i_at.html(' at ')
        // }
        b_at.html($(this).val())
    })
    
    tag_input_fake.focus(function(){
        tag_box.addClass('display')
    })
    tag_input_fake.blur(function(){
        tag_box.removeClass('display')
    })
    feeling_input.focus(function(){
        feeling_box.addClass('display')
    })
    feeling_input.blur(function(){
        feeling_box.removeClass('display')
    })

    tag_box.on('mousedown', 'ul li', function(){
        var value = $(this).find('.username p').html()
        tag_input_real.val($(this).attr('user_id'))
        tag_input_fake.val(value)
        tag_input_fake.addClass('invalid')
        b_with.html(value)
    })

    feeling_box_item.mousedown(function(){
        var value = $(this).html()
        feeling_input.val(value)
        feeling_input.addClass('invalid')
        b_feeling.html(value)
    })
    
}

{
    const hightlight = $('.hightlight')

    const main_left = $('.main-left')
    const main_left_btn_open = $('.main-left__btn-open')
    const main_left_btn_close = $('.main-left__btn-close')

    const main_right = $('.main-right')
    const main_right_btn_open = $('.main-right__btn-open')
    const main_right_btn_close = $('.main-right__btn-close')

    // main-left
    main_left_btn_close.click(function(){
        main_left.addClass('minimize')
        $(this).removeClass('display')
        main_left_btn_open.addClass('display')
        $('body').removeClass('darken')
    })
    main_left_btn_open.click(function(){
        main_left.removeClass('minimize')
        $(this).removeClass('display')
        main_left_btn_close.addClass('display')
        $('body').addClass('darken')

        // close main-right
        main_right.addClass('minimize')
        main_right_btn_close.removeClass('display')
        main_right_btn_open.addClass('display')
    })
    hightlight.mousedown(function(e){
        e.stopPropagation()
    })
    hightlight.click(function(e){
        e.stopPropagation()
    })
    
    // main-right
    main_right_btn_close.click(function(){
        main_right.addClass('minimize')
        $(this).removeClass('display')
        main_right_btn_open.addClass('display')
        $('body').removeClass('darken')
    })
    main_right_btn_open.click(function(){
        main_right.removeClass('minimize')
        $(this).removeClass('display')
        main_right_btn_close.addClass('display')
        $('body').addClass('darken')

        // close main-left
        main_left.addClass('minimize')
        main_left_btn_close.removeClass('display')
        main_left_btn_open.addClass('display')
    })
    hightlight.mousedown(function(e){
        e.stopPropagation()
    })
    hightlight.click(function(e){
        e.stopPropagation()
    })
}
{
    //TODO: Zoom image
    const body = $('body')
    const zoom_layout = $('#zoom-layout')
    const zoom_layout_image = $('#zoom-layout img')
    body.on('click', '.image_zoom', function() {
        const src = $(this).attr('src')
        zoom_layout_image.attr('src', src)
        zoom_layout_image.addClass('display')
        zoom_layout.addClass('display')
        body.addClass('darken-2')
    })
    body.on('click', '.video_zoom', function() {
        zoom_layout.children('video').remove()
        const src = $(this).children('video').attr('src')
        let video_element = "<video controls class='stop'><source src='" + src + "' type='video/mp4'></video>"
        zoom_layout.append(video_element)
        zoom_layout.find('source').attr('src', src)
        zoom_layout.children('video').addClass('displayZoom')
        zoom_layout.addClass('displayZoom')
        body.addClass('darken-2')
    })
    zoom_layout.on('mousedown', 'image', function(e) {
        e.stopPropagation()
    })
    zoom_layout.on('click', 'image', function(e) {
        e.stopPropagation()
    })
    zoom_layout.on('mousedown', 'video', function(e) {
        e.stopPropagation()
    })
    zoom_layout.on('click', 'video', function(e) {
        e.stopPropagation()
    })
}
{
    $('#profile-avatar').change(function(e){
        const file = e.target.files[0]
        if (file) {
            $(this).parent().find('.form-left-avatar img').attr('src', URL.createObjectURL(file))
        }
    })
}
{
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
}

    $(document).mousedown(function(e){
        if (!$(e.target).hasClass('stop-propagation')) {
            $('.displayZoom').removeClass('displayZoom')
            $('.darken-2').removeClass('darken-2')
            // Pause video
            $('video').trigger('pause')
            un_active_all()
        }
    })
})