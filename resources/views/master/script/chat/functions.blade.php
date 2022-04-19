<script>

function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function get_tab_chat(data, user_id, user_online_click){
    let box_chat_list = $('.box-chat__list')
    let messages = '';
    $.each(data['messages'], function(index, item){
        let date = new Date(item['time'])

        let date_minutes = date.getMinutes()<10?"0"+date.getMinutes():date.getMinutes()
        let time_send = date.getHours() + ':' + 
                date_minutes + ', ' + 
                date.getDate() + '-' + 
                (date.getMonth()+1) + '-' + 
                date.getFullYear()

        let message_image = ''
        if (item['images']) {
            for (let i = 0; i< item['images'].length; i++) {
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
        //* Thay thế ký tự đặc biệt
        // item['message'] = escapeHtml(item['message'])

        /**
         * Mình cần hiển thị 10 tin nhắn và xác định có hiển thị thời gian gửi hay không
         * Phải select 11 tin nhắn từ DB để: so sanh thời gian gửi của tin 10 và tin 11
         * Không hiển thị tin 11
         * 
         * resources/views/master/script/chatting.blade.php 'scroll and get more message' cũng dùng cái này
         */
        //* Nếu thời gian giữa 2 tin nhắn ít hơn DIFF_TIME mili giây thì không hiện thị thẻ <small> time_send </small>
        let check_diff_time = false
        let data_messages_length = data['messages'].length

        if (index < data_messages_length - 1){
            let date2 = new Date(data['messages'][index + 1]['time'])
            let diff_in_time = date.getTime() - date2.getTime();
            const DIFF_TIME = 1800000
            check_diff_time = diff_in_time >= DIFF_TIME ? true : false

            if(item['user_id'] == user_id){
                messages = messages + "<li class='your-chat " + data['is_seen'] + "' message_id='" + item['id'] + "'>"
                if (check_diff_time){
                    messages = messages + "<small class='time'>" + time_send + "</small>"
                }
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
                if (check_diff_time){
                    messages = messages + "<small class='time'>" + time_send + "</small>"
                }
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
    box_chat_list.prepend(
        "<li class='box-chat__list-item user_id_" + user_online_click + "'>"+
            "<div class='tab-chat user_id_"+ user_online_click +"'>"+
                "<div class='tab-chat__top'>"+
                    "<div class='avatar " + data['is_online'] + "'>"+
                        "<a href='/other-personal/" + user_online_click + "'><img src='" + data['friend_avatar'] + "'></a>"+
                    "</div>"+
                    "<div class='name'>"+
                        "<a href='/other-personal/" + user_online_click + "'>" + data['friend_name'] + "</a>"+
                    "</div>"+
                    "<div class='tab-chat__top-btn'>" +
                        "<div class='btn_down'>" +
                            "<i class='fas fa-chevron-down'></i>" +
                        "</div>" +
                        "<div class='btn_up' user_id='"+ user_online_click +"'>" +
                            "<i class='fas fa-chevron-up'></i>" +
                        "</div>" +
                        "<div class='btn_close'>" +
                            "<span>x</span>" +
                        "</div>" +
                    "</div>" +
                "</div>"+
                "<div class='tab-chat__content' user_id='" + user_online_click + "'>"+
                    "<ul>"+
                        messages +
                    "</ul>"+
                "</div>"+
                "<div class='tab-chat__bottom' user_id='" + user_online_click + "'>"+
                    "<form action='#' enctype='multipart/form-data' method='post' class='form-input-chat' user_id='" + user_online_click + "'>"+
                        "<div class='buttons'>" +
                            "<div class='alert alert-danger custom-alert'>" +

                            "</div>" +
                            "<div class='preview'>" +
                                "<div class='preview-top'>" +
                                    "<h6>Preview</h6>" +
                                    "<div class='preview-top__buttons'>" +
                                        "<div class='preview-buttons__minimize'>" +
                                            "<i class='fas fa-chevron-down'>" +

                                            "</i>" +
                                        "</div>" +
                                        "<div class='preview-buttons__close'>" +
                                            "<i class='fas fa-times'>" +
                                                
                                            "</i>" +
                                        "</div>" +
                                    "</div>" +
                                "</div>" +
                                "<div class='image-preview'>" +

                                "</div>" +
                            "</div>" +
                            "<input autocomplete='off' type='number' name='MAX_SIZE_FILE' class='max_size_file' value='6' hidden>" +
                            "<label class='label-chat-image-input'><i class='fas fa-photo-video btn-image'></i></label>" +
                            "<input autocomplete='off' type='file' class='chat-image-input' name='f_media[]' hidden multiple>" +
                        "</div>" +
                        "<div class='storage_message' style='display: none'></div>" +
                        "<textarea autocomplete='off' rows='1' type='text' class='input-tab-chat' name='chat_text'></textarea>" +
                        "<div class='btn_submit'>" +
                            "<button type='submit'>" +
                                "<i class='fas fa-paper-plane'></i>" +
                            "</button>" +
                        "</div>" +
                    "</form>" +
                "</div>" +
            "</div>"+
        "</li>"
    )
    let input_chat = $('.input-tab-chat').get(0)
    emoji(input_chat, 'top')
}

function seen_message(data, user_id){
    // Cho vào đây để update 1 bên client thôi, ko là nó update cả 2 đấy
    if (data.friend_id == user_id){
        $.post(
            'seen-message',
            {
                'user_id': data.user_id,
                'friend_id': data.friend_id,
                _token: '{{ csrf_token() }}'
            },
            function(data){
                let your_message = $('.box-chat__list-item.user_id_'+data['user_id']+' .tab-chat__content li:nth-child(1)')
                if (your_message.length != 0){
                    your_message.addClass('seen')
                }
            }
        )
    } else {
        let item_message = $('.nav-messages__content .messages-content .message-content__item.user_id_'+data.friend_id)
        
        if (item_message.hasClass('announced')) {
            let message_notification = $('.nav-message .new-notification')
            if (Number(message_notification.html()) <= 1) {
                message_notification.addClass('hide')
            }
            message_notification.html(Number(message_notification.html()) - 1)
        }
        // Bỏ class 'unseen' trong nav-messages-content
        item_message.removeClass('unseen')
        item_message.removeClass('announced')
        
    }
    
}

</script>