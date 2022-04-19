
$(document).ready(function(){

    //TODO: event in navbar
    {
    
        const nav_right_btn = $('.nav-right__buttons-item')
        const nav_right_content = $('.nav-right__content > ul')
    
        nav_right_btn.mousedown(function(e){
            e.stopPropagation()
        })
        nav_right_btn.click(function(e){
            $(this).children('.new-notification').addClass('hide')
            $('.nav-messages__content .messages-content ul li').removeClass('announced')
            $(this).children('.new-notification').removeClass('announced')
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
    
        const btn_filter = $('.filter-status .filter-status__icon')
        btn_filter.click(function() {
            if (!($(this).hasClass('active'))){
                btn_filter.removeClass('active')
                $(this).addClass('active')
            }
        })
    
        // Click search button (max-height: 1100px)
    
        const nav_left = $('.nav-left')
        const nav_mid = $('.nav-mid')
        const nav_right = $('.nav-right')
        const logo = $('.nav-left .logo')
        const btn_search = $('.nav-left .box-search')
        const btn_back_search = $('.nav-left .back-search')
        const nav_bar = $('.nav-mid .bars')
        const filter_status = $('.nav-mid .filter-status')
        
        btn_search.mousedown(function(e){
            e.stopPropagation()
        })
        btn_search.click(function(e){
            e.stopPropagation()
            un_active_all()
    
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

        filter_status.mousedown(function(e){
            e.stopPropagation()
        })
        filter_status.click(function(e){
            e.stopPropagation()
            un_active_all()
        })
    
        btn_back_search.mousedown(function(e){
            e.stopPropagation()
        })
        btn_back_search.click(function(e){
            e.stopPropagation()
            if ($(this).hasClass('display')){
                $(this).removeClass('display')
                logo.removeClass('hide')
                btn_search.removeClass('active')
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
            
            filter_status.toggleClass('display')
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
        
        btn_seen.click(function(){
            const notification_content = $('.nav-right .nav-notification__content li.unseen');
            notification_content.removeClass('unseen');
        })
        
        $('.nav-messages__content').on('click','li.unseen',function(){
            $(this).removeClass('unseen')
        })

        $('.nav-messages__content-search .back-search').click(function(){
            let box_search = $(this).siblings('.box-search')
            $(this).removeClass('display')
            box_search.removeClass('active')
            box_search.children('input').val('')
            $(this).parent().siblings('.messages-content').removeClass('hide')
            $(this).parent().siblings('.search-result').removeClass('display')
            $(this).siblings
        })
    
        $('.nav-messages__content-search .box-search input').focus(function(){
            $(this).parent().addClass('active')
            $(this).parent().siblings('.back-search').addClass('display')
            $(this).parent().parent().siblings('.messages-content').addClass('hide')
            $(this).parent().parent().siblings('.search-result').addClass('display')
        })
        
        $('.nav-messages__content').on('click','li ul li.message-content__item',function(){
            $(this).closest('.nav-messages__content').removeClass('display')
            $('.nav-message.active').removeClass('active')
            
            if(box_chat_list.children().length === 5){
                box_chat_list.children(':nth-last-child(1)').remove()
            }
        })
    }
    
        //TODO: event in calendar
    {
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
        
        //* rise action
        rise.mousedown(function(e){
            e.stopPropagation()
        })
        rise.click(function(e){
            e.stopPropagation()
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
            const get_calendar_time = $(this).parent().siblings('input.calendar__item-time').val()
            const content = $(this).children('p').html()

            let date = new Date(get_calendar_time);
            let rise_calendar_title = rise_calendar_detail.children('.calendar__header').children('p')
            let rise_calendar_time = rise_calendar_detail.children('.calendar__time').children('p')
            let rise_calendar_content = rise_calendar_detail.children('.calendar__content').children('p')
    
            rise_calendar_title.html(title)
            if (date != 'Invalid Date'){
                rise_calendar_time.html(date.getHours() + ":" + date.getMinutes() + " Ngay: " + date.getDate() + "-" + date.getMonth() + "-" + date.getFullYear())
            }
            else {
                rise_calendar_time.html('Unknown Time')
            }
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
            e.preventDefault();
        })
        btn_submit_add_calendar.click(function(){
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "June","July", "Aug", "Sep", "Oct", "Nov", "Dec"];
            
            let date = new Date(time_calendar.val())
            if(date != 'Invalid Date' && title_calendar.val() != ''){
                calendar_items.prepend(
                    "<li class='calendar__item'>"+
                        "<input hidden class='calendar__item-time' type='datetime-local' "+
                            "value='" + time_calendar.val() +
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
    
                $('#form_add_calendar')[0].reset()
    
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
            $(this).parent().parent().addClass('hide')
            is_none_calendar()
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
    
            calendar_item.addClass('hide')
            is_none_calendar()
        })
        btn_cancel_delete_all.click(function(){
            rise.removeClass('display')
            delete_all_calendar.removeClass('display')
            body.removeClass('darken')
        })
    
    }
    
    //TODO: event in main-right user online
    {
        let box_chat_list = $('.box-chat__list')
        //* Minimize tab-chat
        box_chat_list.on('click','.btn_down',function(){
            $(this).closest('.box-chat__list-item').addClass('minimize')
        })
        box_chat_list.on('click','.btn_up',function(){
            $(this).closest('.box-chat__list-item.minimize').removeClass('minimize')
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
            $(this).removeClass('display')
            $(this).siblings('.read-less').addClass('display')
        })
        list_news_feed.on('click','.read-less',function(){
            $(this).siblings('p').removeClass('more')
            $(this).removeClass('display')
            $(this).siblings('.read-more').addClass('display')
        })
    
    
        //* like
        list_news_feed.on('click','.btn-like',function(){
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

    }
    
    $(document).mousedown(function(){
        un_active_all()
    })
    
    })