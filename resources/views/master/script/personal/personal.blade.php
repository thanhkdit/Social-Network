@include('master.script.chat.functions')
<script>
  $('.accept-request').click(function(){
    const instance = $(this)
    const status = 1
    const friendId = $(this).attr('friend_id')
    $.post(
      'update-request',
      {
        friend_id: friendId,
        user_id: user_id,
        status: status
      },
      function(data) {
        if (data) {
          instance.siblings('.btn').addClass('hide-element')
          instance.addClass('hide-element')
          instance.siblings('.accepted-request').removeClass('hide-element')
          instance.siblings('.personal-top__buttons-message').removeClass('hide-element')
          socket.emit('sendNotificationRequestToServer', data)
        }
      }
    )
  })

  $('.reject-request').click(function(){
    const instance = $(this)
    const status = 0
    const friendId = $(this).attr('friend_id')
    $.post(
      'update-request',
      {
        friend_id: friendId,
        user_id: user_id,
        status: status
      },
      function(data) {
        if (data) {
          instance.siblings('.btn').addClass('hide-element')
          instance.addClass('hide-element')
          instance.siblings('.rejected-request').removeClass('hide-element')
          instance.siblings('.personal-top__buttons-message').removeClass('hide-element')
          socket.emit('sendNotificationRequestToServer', data)
        }
      }
    )
  })

  $('.personal-top__buttons-add-friend.add-friend').click(function(){
    const instance = $(this)
    let status = 0
    const friendId = $(this).attr('friend_id')
    // tạo quan hệ gửi kết bạn vào bảng relationship thì cột user_first < user_second
    if (user_id > friendId) {
      status = 4 // pending second first
    } else {
      status = 3 // pending first second
    }
    $.post(
      'update-request',
      {
        friend_id: friendId,
        user_id: user_id,
        status: status
      },
      function(data) {
        if (data) {
          instance.siblings('.btn.request').removeClass('hide-element')
          instance.addClass('hide-element')
          socket.emit('sendNotificationRequestToServer', data)
        }
      }
    )
  })

  $('.personal-top__buttons-add-friend.unfriend').click(function(){
    const instance = $(this)
    const status = -1
    const friendId = $(this).attr('friend_id')
    $.post(
      'update-request',
      {
        friend_id: friendId,
        user_id: user_id,
        status: status
      },
      function(data) {
        if (data) {
          instance.siblings('.btn.add-friend').removeClass('hide-element')
          instance.addClass('hide-element')
        }
      }
    )
  })

  socket.on('sendNotificationRequestToClient', (data) => {
    // Notification
    if (data.user_receive == user_id) {
      console.log('oik')
      let str =
          "<li class='unseen' notification_id='" + data.notification.id + "'> " +
              "<a href='" + data.notification.link + "'>" +
                  "<div class='avatar'>" +
                    "<img src='" + data.user_avatar + "' alt=''>" +
                  "</div>" +
                  "<div>" +
                      "<span>" + data.notification.content + "</span>" +
                      "<small>Just sent</small>" +
                  "</div>" +
              "</a>" +
          "</li>"
          
      $('.nav-notification__content-title.new').after(str)
      let new_noti = $('.nav-right__buttons-item.nav-notification').find('.new-notification')
      let nums_notification = Number(new_noti.html())
      new_noti.html(nums_notification + 1);
      new_noti.removeClass('hide')
    }
  })

  $('#nav-left__search').keyup(function() {
      let mid_box_search_result = $('.nav-mid .box-search__result ul')
      let left_box_search_result = $('.nav-left .box-search__result ul')
    if ($(this).val()) {
      $.post(
        '/search',
        {
          value: $(this).val()
        },
        function(data) {
          let str = ''
          data.data.forEach((item) => {
            str +=
              "<li>" +
                "<a href='/other-personal/" + item.id + "'>" +
                  "<div class='avatar'>" +
                      "<img src='" + item.avatar + "' alt=''>" +
                  "</div>" +
                  "<div class='name'>" +
                    "<p>" + item.name + "</p>" +
                    "<small>" + item.description + "</small>" +
                  "</div>" +
                "</a>" +
              "</li>"
          })
          mid_box_search_result.html(str)
          left_box_search_result.html(str)
        }
      )
    } else {
      mid_box_search_result.html('')
      left_box_search_result.html('')
    }
  })

  $('#nav-mid__search').keyup(function() {
    if ($(this).val()) {
      let mid_box_search_result = $('.nav-mid .box-search__result ul')
      let left_box_search_result = $('.nav-left .box-search__result ul')
      $.post(
        '/search',
        {
          value: $(this).val()
        },
        function(data) {
          let str = ''
          data.data.forEach((item) => {
            str +=
              "<li>" +
                "<a href='/other-personal/" + item.id + "'>" +
                  "<div class='avatar'>" +
                      "<img src='" + item.avatar + "' alt=''>" +
                  "</div>" +
                  "<div class='name'>" +
                    "<p>" + item.name + "</p>" +
                    "<small>" + item.description + "</small>" +
                  "</div>" +
                "</a>" +
              "</li>"
          })
          mid_box_search_result.html(str)
          left_box_search_result.html(str)
        }
      )
    } else {
      mid_box_search_result.html('')
      left_box_search_result.html('')
    }
  })

  $('#input-search-message').keyup(function() {
    let box_search_result = $('.nav-messages__content .search-result ul')
    $.post(
      'search-message',
      {
        value: $(this).val()
      },
      function(data) {
        let str = ''
        data.data.forEach((item) => {
          str +=
            "<li class='search-item user_id_" + item.id + "' user_id='" + item.id + "'>" +
              "<div class='avatar'>" +
                  "<img src='" + item.avatar + "' alt=''>" +
              "</div>" +
              "<div class='username'>" +
                  "<p>" + item.name + "</p>" +
                  "<small>" + item.description + "</small>" +
              "</div>" +
            "</li>"
        })
        box_search_result.html(str)
      }
    )
  })
</script>