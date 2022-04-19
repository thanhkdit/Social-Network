@include('master.script.chat.functions')
<script>

//TODO: Config socket.io
const ip_address = '127.0.0.1'
const socket_port = '3000'
const socket = io(ip_address + ':' + socket_port)
const user_id = '{{Auth::user()->id}}'

$(function(){
//TODO: Tạo tab chat
{
    let user_online__list = $('.user-online__list')
    let nav_messages_content = $('.nav-messages__content')
    let search_result = $('.nav-messages__content .search-result ul')
    let box_chat_list = $('.box-chat__list')
    
    // TAB_CHAT_NUMS So luong tab-chat la 4, neu = 5 thi xoa bo tab-chat dau tien
    const USER_LOGIN = '{{Auth::user()->id}}';

    user_online__list.on('click','.user-online__list-item',function(){
        let your_friend_id = $(this).attr('user_id')
        let has_tab_chat = $('.box-chat__list-item .user_id_' + your_friend_id)

        //* Seen
        data_seen = {
            'user_id': user_id,
            'friend_id': your_friend_id
        }
        socket.emit('sendSeenToServer', data_seen)

        //Neu tab-chat da co roi thi ko hien thi nua
        if (has_tab_chat.length == 0){
            if(box_chat_list.children().length >= TAB_CHAT_NUMS){
                box_chat_list.children(':nth-last-child(1)').remove()
            }

            $.post(
                '/get-tab-chat',
                {
                    'your_id': USER_LOGIN,
                    'your_friend_id': your_friend_id,
                    _token: '{{ csrf_token() }}'
                },
                function(data){
                    //* Tham số của get_tab_chat: 'data', 'user_id', 'your_friend_id'
                    get_tab_chat(data, USER_LOGIN, your_friend_id)
                }
            )
        }
        else {
            has_tab_chat.find('.new-message').removeClass('new-message')
        }
    })

    nav_messages_content.on('click','li ul li.message-content__item',function(){
        $(this).closest('.nav-messages__content').removeClass('display')
        $('.nav-message.active').removeClass('active')

        let your_friend_id = $(this).attr('user_id')
        let has_tab_chat = $('.box-chat__list-item .user_id_' + your_friend_id)

        //* Seen
        data_seen = {
            'user_id': user_id,
            'friend_id': your_friend_id
        }
        socket.emit('sendSeenToServer', data_seen)
        //Neu tab-chat da co roi thi ko hien thi nua
        if (has_tab_chat.length == 0){
            if(box_chat_list.children().length >= TAB_CHAT_NUMS){
                box_chat_list.children(':nth-last-child(1)').remove()
            }

            $.post(
                '/get-tab-chat',
                {
                    'your_id': USER_LOGIN,
                    'your_friend_id': your_friend_id,
                    _token: '{{ csrf_token() }}'
                },
                function(data){
                    //* Tham số của get_tab_chat: 'data', 'user_id', 'your_friend_id'
                    get_tab_chat(data, USER_LOGIN, your_friend_id)
                    
                }
            )
        }
        else {
            has_tab_chat.find('.new-message').removeClass('new-message')
        }
    })
    
    search_result.on('click','li',function(){
        $(this).closest('.nav-messages__content').removeClass('display')
        $('.nav-message.active').removeClass('active')

        let your_friend_id = $(this).attr('user_id')
        let has_tab_chat = $('.box-chat__list-item .user_id_' + your_friend_id)

        //* Seen
        data_seen = {
            'user_id': user_id,
            'friend_id': your_friend_id
        }
        socket.emit('sendSeenToServer', data_seen)

        //Neu tab-chat da co roi thi ko hien thi nua
        if (has_tab_chat.length == 0){
            if(box_chat_list.children().length >= TAB_CHAT_NUMS){
                box_chat_list.children(':nth-last-child(1)').remove()
            }

            $.post(
                '/get-tab-chat',
                {
                    'your_id': USER_LOGIN,
                    'your_friend_id': your_friend_id,
                    _token: '{{ csrf_token() }}'
                },
                function(data){
                    //* Tham số của get_tab_chat: 'data', 'user_id', 'your_friend_id'
                    get_tab_chat(data, USER_LOGIN, your_friend_id)
                }
            )
        }
        else {
            has_tab_chat.find('.new-message').removeClass('new-message')
        }
    })

    $('.personal-top__buttons-message.message').on('click', function(){
        let your_friend_id = $(this).attr('friend_id')
        let has_tab_chat = $('.box-chat__list-item .user_id_' + your_friend_id)

        //* Seen
        data_seen = {
            'user_id': user_id,
            'friend_id': your_friend_id
        }
        socket.emit('sendSeenToServer', data_seen)

        //Neu tab-chat da co roi thi ko hien thi nua
        if (has_tab_chat.length == 0){
            if(box_chat_list.children().length >= TAB_CHAT_NUMS){
                box_chat_list.children(':nth-last-child(1)').remove()
            }

            $.post(
                '/get-tab-chat',
                {
                    'your_id': USER_LOGIN,
                    'your_friend_id': your_friend_id,
                    _token: '{{ csrf_token() }}'
                },
                function(data){
                    //* Tham số của get_tab_chat: 'data', 'user_id', 'your_friend_id'
                    get_tab_chat(data, USER_LOGIN, your_friend_id)
                }
            )
        }
        else {
            has_tab_chat.find('.new-message').removeClass('new-message')
        }
    })
}
//TODO: Chat real-time with socket.io
{
    let box_chat_list = $('.box-chat__list')
    box_chat_list.on('submit','.form-input-chat', function(e){
        e.preventDefault()
        $(this).find('.emojionearea').removeClass('focus-chat')
        let close_preview = $(this).find('.preview-buttons__close')
        let time_send = $.now();
        let message = $(this).find('.emojionearea-editor').html()
        message = formatMessage(message)
        $(this).find('.emojionearea-editor').html('')
        let formData = new FormData($(this)[0])
        // var ins = document.getElementById('fileToUpload').files.length;
        // for (var x = 0; x < ins; x++) {
        //     fd.append("fileToUpload[]", document.getElementById('fileToUpload').files[x]);
        // }
        // for (var pair of formData.entries()) {
        //     console.log(pair[0]+ ', '+ pair[1]);
        // }
        
        if (message != '' || formData.get('f_media[]').size != 0){
            let receive_id = $(this).attr('user_id')
            formData.append('message', message)
            formData.append('user_id', user_id)
            formData.append('receive_id', receive_id)
            formData.append('time_send', time_send)
            formData.append('_token', '{{ csrf_token() }}')
            $(this).find('.emojionearea-editor').html('')
    $.ajax ( {
        url : '/send-message',
        type : 'POST',
        data : formData,
        processData : false,
        contentType : false,
        success : function(data) {
            close_preview.click()
            $(this).find('.chat-image-input').val('')
            socket.emit('sendChatToServer', data)
        }
    });
        }
    })

    socket.on('sendChatToClient', (data) => {
        //* Thay thế ký tự đặc biệt
        // urlify(data['message']) = escapeHtml(urlify(data['message']))
        /**
            ** tab_chat_content1: tab-chat của người gửi tin nhắn (user 1)
            - Chỉ tồn tại trong client của người gửi tin
            - User 1 gửi tin => tin hiển thị phía bên phải tab-chat
            - User 1 là người gửi tin khi: tab-chat có class "user_id_2" (user_id != receive_id)
            */
        /**
            ** tab_chat_content2: tab-chat của người nhận tin nhắn (user 2)
            - Chỉ tồn tại trong client của người nhận tin
            - User 2 nhận tin => tin hiển thị phía bên trái tab-chat
            - User 2 là người nhận tin khi: tab-chat có class "user_id_2" (user_id == receive_id)
            */
        let tab_chat_content1 = $('.tab-chat.user_id_' + data['receive_id'] + ' .tab-chat__content ul')
        let tab_chat_content2 = $('.tab-chat.user_id_' + data['user_id'] + ' .tab-chat__content ul')

        let message_image = ''
        if (data['images']) {
            for (let i = 0; i< data['images'].length; i++) {
                if (data['images_type'][i] == 1) {
                    message_image += "<img class='image_zoom image_message' src='" + data['images'][i] +"' alt='sadfa'>"
                } else {
                    message_image += 
                        "<span class='video video_zoom photos-video__item video_message'>" +
                            "<video src='" + data['images'][i] + "'></video>" +
                        "</span>"
                }
            }
        }
        //* Nếu người gửi có tab-chat (gừi thì chắc chắn có)
        if (tab_chat_content1.length != 0 && user_id == data['user_id']){
            let date = new Date(Number(data['time_send']))
            let date_minutes = date.getMinutes()<10?"0"+date.getMinutes():date.getMinutes()
            let time_send = date.getHours() + ':' + 
                            date_minutes + ', ' + 
                            date.getDate() + '-' + 
                            (date.getMonth()+1) + '-' + 
                            date.getFullYear()
            tab_chat_content1.prepend(
                "<li class='your-chat'>"+
                    "<div class='chat-content'>"+
                        "<span class='avatar'>"+
                            "<img src='" + data['your_avatar'] + "' alt=''>"+
                        "</span>"+
                        "<span class='icon-unseen'>"+
                            "<i class='far fa-check-circle'></i>"+
                        "</span>"+
                        "<p>"+
                            urlify(data['message']) + message_image +
                        "</p>"+
                        "<small class='time-hover'>"+
                            time_send +
                        "</small>"+
                    "</div>"+
                " </li>"
            )
        }
        //* Nếu người nhận có tab-chat
        if (tab_chat_content2.length != 0 && user_id == data['receive_id']){
            let tab_chat_top = $('.box-chat__list-item.user_id_' + data['user_id'] + ' .tab-chat__top')

            let date = new Date(Number(data['time_send']))
            let date_minutes = date.getMinutes()<10?"0"+date.getMinutes():date.getMinutes()
            let time_send = date.getHours() + ':' + 
                            date_minutes + ', ' + 
                            date.getDate() + '-' + 
                            (date.getMonth()+1) + '-' + 
                            date.getFullYear()

            tab_chat_top.addClass('new-message')
            tab_chat_content2.prepend(
                "<li class='your-friend'>"+
                    "<div class='chat-content'>"+
                        "<span class='avatar'>"+
                            "<img src='" + data['friend_avatar'] + "' alt=''>"+
                        "</span>"+
                        "<p>"+
                            urlify(data['message']) + message_image +
                        "</p>"+
                        "<small class='time-hover'>"+
                            time_send +
                        "</small>"+
                    "</div>"+
                " </li>"
            )
        }
        //*Nếu người nhận chưa có tab-chat
        else if (user_id == data['receive_id']){
            // Đây là trường hợp chỉ xảy ra nếu là người nhận tin
            // Tham số của get_tab_chat: 'data', 'user_id', 'your_friend_id'
            $.post(
                '/get-tab-chat',
                {
                    'your_id': user_id,
                    'your_friend_id': data['user_id'],
                    _token: '{{ csrf_token() }}'
                },
                function(dataMessage){
                    //* Tham số của get_tab_chat: 'data', 'user_id', 'your_friend_id'
                    get_tab_chat(dataMessage, user_id, data['user_id'])
                    let tab_chat_top = $('.box-chat__list-item.user_id_'+data['user_id']+' .tab-chat__top')
                    tab_chat_top.addClass('new-message')
                }
            )
        }

        //* Thêm tin nhắn vừa gửi vào nav-messages-content
        // Phía người nhận
        if (user_id == data['receive_id']){
            let nav_message_item = $('.nav-messages__content .messages-content .message-content__item.user_id_'+data['user_id'])
            // Nếu đã tồn tại chat trong nav-messages-content thì đưa <li></li> lên trên cùng <ul></ul>
            if (nav_message_item.length != 0){
                let nav_message_item_content = nav_message_item.find('div p')
                let nav_message_item_time = nav_message_item.find('div small')
                nav_message_item.addClass('unseen')
                nav_message_item_content.html(data['message'])
                nav_message_item_time.html('Just Received')
                nav_message_item.prependTo(nav_message_item.parent())
            }
            // Nếu chưa tồn tại chat trong nav-messages-content thì tạo mới
            else {
                console.log('here')
                let nav_messages_content = $('.nav-messages__content .messages-content ul')
                nav_messages_content.prepend(
                    "<li class='message-content__item user_id_"+ data['user_id'] + " unseen' user_id='" + data['user_id'] + "'>" +
                        "<img src='"+ data['friend_avatar'] +"'>" +
                        "<div>" +
                            "<span>" +
                                data['friend_name'] +
                            "</span>" +
                            "<p>" +
                                urlify(data['message']) +
                            "</p>" +
                            "<small>" +
                                "Just received" +
                            "</small>" +
                        "</div>" +
                    "</li>"
                )
            }
            
            //* cộng thêm 1 vào số tin nhắn mới
            let message_notification = $('.nav-message .new-notification')
            if (message_notification.hasClass('hide')){
                // trong event.js: Khi click vào btn-nav-messages thì sẽ thêm class 'hide' vào để ẩn đi số tin nhắn mới và xóa hết class 'announced'
                message_notification.html('1')
                message_notification.removeClass('hide')
                nav_message_item.addClass('announced')
            }
            else {
                // class 'announced' để xác định xem đã thông báo tin nhắn mới của user hay chưa,
                // tránh việc gửi nhiều tin nhắn và cộng thông báo nhiều lần (chỉ cần +1 lần thôi)
                
                if (!nav_message_item.hasClass('announced')){
                    message_notification.html(Number(message_notification.html()) + 1)
                    nav_message_item.addClass('announced')
                }
            }
        }
        // Phía người gửi
        else if (user_id == data['user_id']) {
            let nav_message_item = $('.nav-messages__content .messages-content .message-content__item.user_id_'+data['receive_id'])
            // Nếu đã tồn tại chat trong nav-messages-content thì đưa <li></li> lên trên cùng <ul></ul>
            if (nav_message_item.length != 0){
                let nav_message_item_content = nav_message_item.find('div p')
                let nav_message_item_time = nav_message_item.find('div small')
                nav_message_item.removeClass('unseen')
                nav_message_item_content.text(data['message'])
                nav_message_item_time.text('Just sent')
                nav_message_item.prependTo(nav_message_item.parent())
            }
            // Nếu chưa tồn tại chat trong nav-messages-content thì tạo mới
            else {
                let nav_messages_content = $('.nav-messages__content .messages-content ul')
                nav_messages_content.prepend(
                    "<li class='message-content__item user_id_"+ data['receive_id'] + "' user_id='" + data['receive_id'] + "'>" +
                        "<img src='"+ data['your_avatar'] +"'>" +
                        "<div>" +
                            "<span>" +
                                data['your_name'] +
                            "</span>" +
                            "<p>" +
                                urlify(data['message']) +
                            "</p>" +
                            "<small>" +
                                "Just sent" +
                            "</small>" +
                        "</div>" +
                    "</li>"
                )
            }
        }
    })
}

//TODO: Check user online
{
    //* online
    socket.on('connect',function(){
        socket.emit('sendUserOnlineToServer',user_id)
    })
    
    socket.on('sendUserOnlineToClient',function(user_online){
        //* user_online_now: kiểm tra xem đã có user_online trong list user online chưa
        let user_online_now = $(".user-online__list-item[user_id='" + user_online + "']")
        let avatar_in_tab_chat = $('.box-chat__list-item.user_id_' + user_online + ' .tab-chat__top .avatar')
        
        $.post(
            'update-user-status-online',
            {
                'user_id': user_online,
                _token: '{{ csrf_token() }}'
            },
            function(user){
                if (user_online != user_id && user_online_now.length == 0){
                    let user_online_list = $('.user-online__list')

                    user_online_list.prepend(
                        "<li class='user-online__list-item' user_id='" + user.id + "'>" +
                            "<div class='avatar online'>" +
                                "<a href=''>" +
                                    "<img src='" + user.avatar + "' alt=''>" +
                                "</a>" +
                            "</div>" +
                            "<div class='username'>" +
                                "<p>" + user.name + "</p>" +
                            "</div>" +
                        "</li>"
                    )
                }

                avatar_in_tab_chat.addClass('online')
            }
        )
    })

    //* offline
    socket.on('sendUserOfflineToClient', (user_offline) => {
        //* user_online_now: kiểm tra xem đã có user_online trong list user online chưa
        let user_online_now = $(".user-online__list-item[user_id='" + user_offline + "']")
        let avatar_in_tab_chat = $('.box-chat__list-item.user_id_' + user_offline + ' .tab-chat__top .avatar')

        $.post(
            'update-user-status-offline',
            {
                'user_id': user_offline,
                _token: '{{ csrf_token() }}'
            },
            function(user_id){
                user_online_now.remove()
                avatar_in_tab_chat.removeClass('online')
            }
        )
    })

}

//TODO: update status_seen => 1 (seen)
{
    let box_chat_list = $('.box-chat__list')
    box_chat_list.on('click','.tab-chat__content',function(e){
        let friend_id = $(this).attr('user_id')
        
        data = {
            'user_id': user_id,
            'friend_id': friend_id
        }
        socket.emit('sendSeenToServer', data)
    })
    box_chat_list.on('click','.tab-chat__bottom',function(e){
        let friend_id = $(this).attr('user_id')
        
        data = {
            'user_id': user_id,
            'friend_id': friend_id
        }
        socket.emit('sendSeenToServer', data)
    })
    box_chat_list.on('click','.tab-chat .btn_up',function(e){
        let friend_id = $(this).attr('user_id')
        
        data = {
            'user_id': user_id,
            'friend_id': friend_id
        }
        socket.emit('sendSeenToServer', data)
    })
    box_chat_list.on('mousewheel','.tab-chat__content ul',function(e){
        let friend_id = $(this).parent().attr('user_id')
        data = {
            'user_id': user_id,
            'friend_id': friend_id
        }
        socket.emit('sendSeenToServer', data)
    })

    socket.on('sendSeenToClient', (data) => {
        seen_message(data,user_id)
    })
}

//TODO: Scroll and get more messages
{
    let box_chat_list = $('.box-chat__list')
    box_chat_list.on('mouseenter','.tab-chat',function(){
        let tab_chat_content = $(this).children('.tab-chat__content')
        let ul = tab_chat_content.children('ul')
        let friend_id = tab_chat_content.attr('user_id')
        let check = true
        // delta: số pixel tối thiểu để được coi la cuộn, tránh cuộn nhầm
        var lastScrollTop = 0, delta = 1;
        var max_scroll_top = ul[0].scrollHeight - ul.outerHeight()
        var message_id = null
        ul.unbind('scroll')
        ul.scroll(function () {
            var nowScrollTop = ul.scrollTop();
            if(Math.abs(lastScrollTop - nowScrollTop) >= delta){
                if (nowScrollTop < lastScrollTop && Math.floor(Math.abs(nowScrollTop)) >= Math.floor(max_scroll_top-1)){
                    // SCROLL UP and SCROLL_TOP = MAX
                    // get more messages
                    let current_nums_row = ul.children('li').length
                    if (check == false) {
                        return false
                    }
                    check = false
                    $.post(
                        'get-more-messages',
                        {
                            'your_id': user_id,
                            'your_friend_id': friend_id,
                            'current_nums_row': current_nums_row,
                            _token: '{{ csrf_token() }}'
                        },
                        function(data){
                            let data_messages = data.data
                            var messages = ''
                            $.each(data_messages, function(index, item){
                                let date = new Date(item['time'])
                                let date_minutes = date.getMinutes()<10?"0"+date.getMinutes():date.getMinutes()
                                let time_send = date.getHours() + ':' + 
                                                date_minutes + ', ' + 
                                                date.getDate() + '-' + 
                                                (date.getMonth()+1) + '-' + 
                                                date.getFullYear()
                                
                                let message_image = ''
                                if (item['images'].length > 0) {
                                    for (let i = 0; i < item['images'].length; i++) {
                                        if (item['images'][i].type == 1) {
                                            message_image += "<img class='image_zoom image_message' src='" + item['images'][i].url +"' alt='sadfa'>"
                                        } else {
                                            message_image += 
                                                "<span class='video video_zoom photos-video__item video_message'>" +
                                                    "<video src='" + item['images'][i].url + "'></video>" +
                                                "</span>"
                                        }
                                    }
                                }
                                /**
                                * Mình cần hiển thị 10 tin nhắn và xác định có hiển thị thời gian gửi hay không
                                * Phải select 11 tin nhắn từ DB để: so sanh thời gian gửi của tin 10 và tin 11
                                * Không hiển thị tin 11
                                * 
                                * resources/views/master/script/function.blade.php/get_tab_chat cũng dùng cái này
                                */
                                //* Nếu thời gian giữa 2 tin nhắn ít hơn DIFF_TIME mili giây thì không hiện thị thẻ <small> time_send </small>
                                let check_diff_time = false
                                let data_messages_length = data_messages.length

                                if (index < data_messages_length - 1){
                                    let date2 = new Date(data_messages[index + 1]['time'])
                                    let diff_in_time = date.getTime() - date2.getTime();
                                    check_diff_time = diff_in_time >= DIFF_TIME ? true : false
                                
                                    if(item['user_id'] == user_id){
                                        messages = messages + "<li class='your-chat' message_id='" + item['id'] + "'>"
                                        if (check_diff_time){
                                            messages = messages + "<small class='time'>" + time_send + "</small>"
                                        }
                                        messages = messages + "<div class='chat-content'>"+
                                                                "<span class='avatar'>"+
                                                                    "<img src='" + data.friend_avatar + "' alt=''>"+
                                                                "</span>"+
                                                                "<span class='icon-unseen'>"+
                                                                    "<i class='far fa-check-circle'></i>"+
                                                                "</span>"+
                                                                "<p>"+
                                                                    urlify(item['message']) + message_image +
                                                                "</p>"+
                                                                "<small class='time-hover'>"+
                                                                    time_send +
                                                                "</small>"+
                                                            "</div>"+
                                                        " </li>"
                                    }
                                    else{
                                        messages = messages + "<li class='your-friend' message_id='" + item['id'] + "'>"
                                        if (check_diff_time){
                                            messages = messages + "<small class='time'>" + time_send + "</small>"
                                        }
                                        messages = messages + "<div class='chat-content'>"+
                                                                "<span class='avatar'>"+
                                                                    "<img src='" + data.friend_avatar + "' alt=''>"+
                                                                "</span>"+
                                                                "<p>"+
                                                                    urlify(item['message']) + message_image +
                                                                "</p>"+
                                                                "<small class='time-hover'>"+
                                                                    time_send +
                                                                "</small>"+
                                                            "</div>"+
                                                        " </li>"
                                    }
                                }
                                //Để hiện thị được tin nhắn trên cùng
                                else if (index == data_messages_length - 1 && data_messages_length < 11){
                                    if(item['user_id'] == user_id){
                                        messages = messages + "<li class='your-chat " + data['is_seen'] + "' message_id='" + item['id'] + "'>"
                                        messages = messages + "<small class='time'>" + time_send + "</small>"
                                        messages = messages + "<div class='chat-content'>"+
                                                                "<span class='avatar'>"+
                                                                    "<img src='" + data['friend_avatar'] + "' alt='avatar'>"+
                                                                "</span>"+
                                                                "<span class='icon-unseen'>"+
                                                                    "<i class='far fa-check-circle'></i>"+
                                                                "</span>"+
                                                                "<p>"+
                                                                    urlify(item['message']) + message_image +
                                                                "</p>"+
                                                                "<small class='time-hover'>"+
                                                                    time_send +
                                                                "</small>"+
                                                            "</div>"+
                                                        " </li>"
                                    }
                                    else{
                                        messages = messages + "<li class='your-friend' message_id='" + item['id'] + "'>"
                                        messages = messages + "<small class='time'>" + time_send + "</small>"
                                        messages = messages + "<div class='chat-content'>"+
                                                                "<span class='avatar'>"+
                                                                    "<img src='" + data['friend_avatar'] + "' alt=''>"+
                                                                "</span>"+
                                                                "<p>"+
                                                                    urlify(item['message']) + message_image +
                                                                "</p>"+
                                                                "<small class='time-hover'>"+
                                                                    time_send +
                                                                "</small>"+
                                                            "</div>"+
                                                        " </li>"
                                    }
                                    // Hiển thị thông báo là tin nhắn trên cùng
                                    messages = messages + "<li class='your-friend' style='font-size: 13px; color: #888'> This is the first message </li>"
                                }
                            })
                            ul.append(messages)
                            check = true
                            max_scroll_top = ul[0].scrollHeight - ul.outerHeight()
                        }
                    )
                }
                lastScrollTop = nowScrollTop;
                max_scroll_top = ul[0].scrollHeight - ul.outerHeight()
            }
        });
    })
}

//TODO: Search friends
{
    let input_search = $('#nav-messages__search-input')
    input_search.keyup(function(){
        let search_value = $(this).val()
        $.post(
            'search-friends',
            {
                'user_id': user_id,
                'search_value': search_value,
                _token: "{{ csrf_token() }}"
            },
            function(data){
                let search_result_ul = $('.nav-messages__content .search-result ul')
                let result = ""
                let is_online = ""
                $.each(data,function(index, item){
                    is_online = item.status_online==1?"online":""
                    result = result + 
                                "<li class='search-item' user_id='"+ item.friend_id +"'>" +
                                    "<div class='avatar "+ is_online +"'>" +
                                        "<img src='images/user_avatar/"+ item.avatar +"'>" +
                                    "</div>" +
                                    "<div class='username'>" +
                                        "<p>"+ item.name +"</p>" +
                                        "<small>"+ item.description +"</small>" +
                                    "</div>" +
                                "</li>"
                })
                search_result_ul.html(result);
            }
        )
    })
}
})
</script>