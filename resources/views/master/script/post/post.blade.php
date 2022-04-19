@include('master.script.chat.functions')
<script>

const list_news_feed = $('.list-news-feed')

//TODO: Create post
{
  $('#form-create-post').submit(function(e) {
    e.preventDefault()
    let button = $(this).find('.create-post-button input')
    let content = $('#post-content')
    let file = $('#post-media')
    let formData = new FormData($(this)[0])
    if (content.val().trim() != '' || file[0].files.length > 0) {
      button.addClass('loading')
      button.attr('type', 'button')
      $.ajax ({
        url : '/post/create',
        type : 'POST',
        data : formData,
        processData : false,
        contentType : false,
        success : function(data) {
          button.removeClass('loading')
          button.attr('type', 'submit')
          $('#rise').removeClass('display')
          $('#rise .create-post').removeClass('display')
          $('body').removeClass('darken')
          socket.emit('sendNotificationToServer', data)
          window.location.href = '?new_post=1';
        }
      });
    }
  })

  socket.on('sendNotificationToClient', (data) => {
    if (data.user_receive.includes(Number(user_id))) {
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

    if (Number(data.user_tag) == Number(user_id)) {
      let str =
          "<li class='unseen' notification_id='" + data.notification_tag.id + "'> " +
              "<a href='" + data.notification_tag.link + "'>" +
                  "<div class='avatar'>" +
                    "<img src='" + data.user_avatar + "' alt=''>" +
                  "</div>" +
                  "<div>" +
                      "<span>" + data.notification_tag.content + "</span>" +
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
}

//TODO: Like post
{
  //* like
  list_news_feed.on('click','.btn-like.post',function(){
    const parent = $(this).closest('.new-feed')
    const postId = parent.attr('post_id')
    $.post(
      '/post/like',
      {
        post_id: postId,
        _token: '{{ csrf_token() }}'
      },
      function (data) {
        parent.find('.new-feed__bottom .like-nums span').html(data.nums_like)
        socket.emit('sendNotificationLikeToServer', data)
      }
    )
  })

  socket.on('sendNotificationLikeToClient', (data) => {
    if (data.user_receive == Number(user_id)) {
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
}

//TODO: Like comment
{
  //* like
  list_news_feed.on('click','.btn-like.comment',function(){
    const parent = $(this).closest('.list-comments__item')
    const commentId = parent.attr('comment_id')
    $(this).addClass('like')
    $.post(
      '/comment/like',
      {
        comment_id: commentId,
        _token: '{{ csrf_token() }}'
      },
      function (data) {
        if (data.nums_like > 0) {
          parent.find('.nums-like.comment').removeClass('hide-element')
          parent.find('.nums-like.comment span').html(data.nums_like)
        } else {
          parent.find('.nums-like.comment').addClass('hide-element')
        }
      }
    )
  })
}

//TODO: Like reply
{
  //* like
  list_news_feed.on('click','.btn-like.reply',function(){
    const parent = $(this).closest('.list-comments__item.reply')
    const replyId = parent.attr('reply_id')
    $(this).addClass('like')
    $.post(
      '/reply/like',
      {
        reply_id: replyId,
        _token: '{{ csrf_token() }}'
      },
      function (data) {
        if (data.nums_like > 0) {
          parent.find('.nums-like.reply').removeClass('hide-element')
          parent.find('.nums-like.reply span').html(data.nums_like)
        } else {
          parent.find('.nums-like.reply').addClass('hide-element')
        }
      }
    )
  })
}

//TODO: Change option post
{
  list_news_feed.on('click', '.new-feed .functions-item', function() {
    let option_id = $(this).attr('option_id')
    let new_feed = $(this).closest('.new-feed')
    let post_id = new_feed.attr('post_id')
    const instance = $(this)
    const follow_post = 1
    const reaction_post = 2
    const unfollow_post = 3
    const save_post = 4
    const hide_post = 5
    const display_post = 6
    const unsave_post = 7
    const save_and_follow_post = 8
    const notify_post = 9
    const no_notify_post = 10
    const save_and_notify_post = 11
    $.post(
      '/post/change-option',
      {
        option_id: option_id,
        post_id: post_id,
        _token: '{{ csrf_token() }}'
      },
      function(data) {
        if (data.option_id == hide_post || data.option_id == display_post || data.option_id == unsave_post) {
          new_feed.remove()
        }
        if (data.option_id == notify_post) {
          instance.parent().append(
            "<li class='functions-item turn-on-noti' option_id='" + no_notify_post + "'>" +
                "<i class='far fa-bell'></i>" +
                "<span>Turn on notification</span>" +
            "</li>"
          )
          instance.remove()
        } else if (data.option_id == no_notify_post) {
          instance.parent().append(
            "<li class='functions-item turn-of-noti' option_id='" + notify_post + "'>" +
                "<i class='far fa-times-circle'></i>" +
                "<span>Turn off notification</span>" +
            "</li>"
          )
          instance.remove()
        }
      }
    )
  })
  
}

//TODO: Comment
{
  list_news_feed.on('submit', '.form-input-comment', function (e) {
    e.preventDefault()
    let time_send = $.now();
    let new_feed = $(this).closest('.new-feed')
    let post_id = new_feed.attr('post_id')
    let comment = $(this).find('.emojionearea-editor').html()
    comment = formatMessage(comment)
    $(this).find('.emojionearea-editor').html('')
    $(this).find('.input-comment').val('')
    let formData = new FormData($(this)[0])
    if (comment != '' || formData.get('f_media').size != 0){
            let receive_id = $(this).attr('user_id')
            formData.append('comment', comment)
            formData.append('user_id', user_id)
            formData.append('post_id', post_id)
            formData.append('time_send', time_send)
            formData.append('_token', '{{ csrf_token() }}')
            $(this).find('.emojionearea-editor').html('')
            $.ajax ( {
                url : '/post/send-comment',
                type : 'POST',
                data : formData,
                processData : false,
                contentType : false,
                success : function(data) {
                    $(this).find('.comment-file-input').val('')
                    socket.emit('sendCommentToServer', data)
                }
            });
        }
  })
  socket.on('sendCommentToClient', (data) => {
    let comment = data.data.comment
    if (data.data.comment == null) {
      comment = ''
    }
    // Notification
    console.log(data.user_receive, user_id)
    if (data.user_receive == user_id && data.notification.content) {
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

    if (data.user_receive2.includes(Number(user_id))) {
      let str =  
          "<li class='unseen' notification_id='" + data.notification2.id + "'> " +
              "<a href='" + data.notification2.link + "'>" +
                  "<div class='avatar'>" +
                    "<img src='" + data.user_avatar + "' alt=''>" +
                  "</div>" +
                  "<div>" +
                      "<span>" + data.notification2.content + "</span>" +
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

    // Comment
    let list_box_comment = $('.new-feed[post_id=' + data.data.post_id + '] .list-comments.comment')
    let str1 = "<li class='list-comments__item comment' comment_id='" + data.data.comment_id + "'>" +
        "<a href='/other-personal/" + data.data.user_id + "' class='avatar'>" +
            "<img src='" + data.data.user_avatar + "' alt=''>" +
        "</a>" +
        "<div class='list-comments__item-content'>" +
            "<div class='list-comments__item-content__text content-truncate'>" +
                "<a href='/other-personal/" + data.data.user_id + "'>" + data.data.user_name + "</a>" +
                "<div class='comment'><p class='url-text'>" + urlify(comment) + "</p>" +
                  "<div class='read-more'>" +
                      "read more" +
                  "</div>" +
                  "<div class='read-less'>" +
                      "read less" +
                  "</div>"
    let str2 = "</div>" +
                "<div class='nums-like hide-element'>" +
                    "<i class='fas fa-thumbs-up'></i>" +
                    "<span></span>" +
                "</div>" +
            "</div>" +
            "<div class='list-comments__item-content__buttons'>" +
                "<span class='btn-like comment'>Like</span>" +
                "<span class='btn-reply comment'>Reply</span>" +
                "<span class='time'>Just sent</span>" +
            "</div>" +
            "<div class='list-comments__item-content__reply'>" +
                "<div class='box-reply'>" +
                    "<span class='avatar online'>" +
                        "<img src='./images/profile-pic.png' alt=''>" +
                    "</span>" +
                    "<form method='post' action='#' class='form-input-reply' enctype='multipart/form-data'>" +
                        "<input autocomplete='off' type='text' class='input-reply' placeholder='Reply ...'>" +
                        "<div class='form-input-reply__btn'>" +
                            "<label for='reply-file-input' class='fas fa-photo-video'></label>" +
                            "<input autocomplete='off' id='reply-file-input' name='f_media' type='file' hidden>" +
                        "</div>" +
                        "<button type='submit'><i class='fas fa-paper-plane'></i></button>" +
                    "</form>" +
                "</div>" +
            "</div>" +
            "<ul class='list-comments reply' comment_id='" + data.data.comment_id + "'>" +
            "</ul>" +
        "</div>" +
      "</li>"
    let image = ""
    if (data.data.images) {
      if (data.data.images_type == 1) {
        image += "<div class='photos-video__item'>" +
                  "<img class='image_zoom' src='" + data.data.images + "' alt=''>" +
                "</div>"
      } else {
        image += "<div class='video video_zoom photos-video__item'>" +
                  "<video src='" + data.data.images + "'></video>" +
                "</div>"
      }
    }
    let comments = str1 + image + str2
    list_box_comment.prepend(comments)
    truncateText()
    let input_chat = list_box_comment.find('input').get(0)
    emoji(input_chat, 'top')
  })
}

//TODO: Reply
{
  list_news_feed.on('submit', '.form-input-reply', function (e) {
    e.preventDefault()
    let time_send = $.now();
    let comment = $(this).closest('.list-comments__item')
    let comment_id = comment.attr('comment_id')
    let reply = $(this).find('.emojionearea-editor').html()
    reply = formatMessage(reply)
    $(this).find('.emojionearea-editor').html('')
    $(this).find('.input-reply').val('')
    let formData = new FormData($(this)[0])
    if (reply != '' || formData.get('f_media').size != 0){
      let receive_id = $(this).attr('user_id')
      formData.append('reply', reply)
      formData.append('user_id', user_id)
      formData.append('comment_id', comment_id)
      formData.append('time_send', time_send)
      formData.append('_token', '{{ csrf_token() }}')
      $(this).find('.emojionearea-editor').html('')
      $.ajax ( {
          url : '/post/send-reply',
          type : 'POST',
          data : formData,
          processData : false,
          contentType : false,
          success : function(data) {
            $(this).find('.reply-file-input').val('')
            socket.emit('sendReplyToServer', data)
          }
      });
    }
  })
  socket.on('sendReplyToClient', (data) => {
    let reply = data.data.reply
    if (data.data.reply == null) {
      reply = ''
    }
    // Notification
    if (data.user_receive == user_id) {
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

    //TODO: Reply
    let list_reply = $('.list-comments.reply[comment_id=' + data.data.comment_id + ']')
    let str1 = "<li class='list-comments__item reply' reply_id='" + data.data.reply_id + "'>" +
        "<a href='/other-personal/" + data.data.user_id + "' class='avatar'>" +
            "<img src='" + data.data.user_avatar + "' alt=''>" +
        "</a>" +
        "<div class='list-comments__item-content'>" +
            "<div class='list-comments__item-content__text content-truncate'>" +
                "<a href='/other-personal/" + data.data.user_id + "'>" + data.data.user_name + "</a>" +
                "<div class='comment'><p class='url-text'>" + urlify(reply) + "</p>" +
                  "<div class='read-more'>" +
                      "read more" +
                  "</div>" +
                  "<div class='read-less'>" +
                      "read less" +
                  "</div>"
    let str2 = "</div>" +
                "<div class='nums-like hide-element'>" +
                    "<i class='fas fa-thumbs-up'></i>" +
                    "<span></span>" +
                "</div>" +
            "</div>" +
            "<div class='list-comments__item-content__buttons'>" +
                "<span class='btn-like reply'>Like</span>" +
                "<span class='time'>Just sent</span>" +
            "</div>" +
          "</div>" +
        "</li>"
    let image = ""
    if (data.data.images) {
      if (data.data.images_type == 1) {
        image += "<div class='photos-video__item'>" +
                  "<img class='image_zoom' src='" + data.data.images + "' alt=''>" +
                "</div>"
      } else {
        image += "<div class='video video_zoom photos-video__item'>" +
                  "<video src='" + data.data.images + "'></video>" +
                "</div>"
      }
    }
    let replies = str1 + image + str2
    list_reply.prepend(replies)
    truncateText()
  })
}

//TODO: Load more comments
{
  list_news_feed.on('click', '.load-more-comments.comment', function() {
    const parent = $(this).closest('.new-feed')
    const postId = parent.attr('post_id')
    const currentNums = parent.find('.list-comments__item.comment').length
    $.post(
      'post/load-more-comments',
      {
        post_id: postId,
        current_nums: currentNums
      },
      function(data) {
        const configImage = 1
        let str = ""
        data.data.forEach(function(comment, index) {
          if (index < 10) {
            str +=
                "<li class='list-comments__item comment' comment_id='" + comment.id + "'>" +
                  "<a href='/other-personal/" + comment.user.id + "' class='avatar'>" +
                      "<img src='" + comment.user.avatar + "' alt=''>" +
                  "</a>" +
                  "<div class='list-comments__item-content'>" +
                      "<div class='list-comments__item-content__text content-truncate'>" +
                          "<a href='/other-personal/" + comment.user.id + "'>" + comment.user.name + "</a>" +
                          "<div class='comment'>" +
                              "<p class='url-text'>" + urlify(comment.comment) + "</p>"
            
            comment.images.forEach(function (image){
                  if (image.type == configImage) {
                    str +=
                      "<div class='photos-video__item'>" +
                          "<img class='image_zoom photos-video__item' src='" + image.url + "' alt=''>" +
                      "</div>"
                  } else {
                    str +=
                      "<div class='video video_zoom photos-video__item'>" +
                          "<video src='" + image.url + "'></video>" +
                      "</div>"
                  }
            })
            str +=
                          "</div>" +
                          "<div class='read-more'>" +
                              "read more" +
                          "</div>" +
                          "<div class='read-less'>" +
                              "read less" +
                          "</div>" +
                          "<div class='nums-like " + (comment.nums_like > 0 ? "" : "hide-element") + "'>" +
                              "<i class='fas fa-thumbs-up'></i>" +
                              "<span>" + comment.nums_like + "</span>" +
                          "</div>" +
                      "</div>" +
                      "<div class='list-comments__item-content__buttons'>" +
                          "<span class='btn-like comment " + (comment.nums_like > 0 ? "like" : "") + "'>Like</span>" +
                          "<span class='btn-reply'>Reply</span>" +
                          "<span class='time'>" +
                              comment.created_at
                          "</span>" +
                      "</div>"
            let sub_str = "<div class='list-comments__item-content__reply'>" +
                          "<div class='box-reply'>" +
                              "<span class='avatar online'>" +
                                  "<img src='{{ auth()->user()->avatar }}' alt=''>" +
                              "</span>" +
                              "<form method='post' action='#' class='form-input-reply' enctype='multipart/form-data'>" +
                                  "<input autocomplete='off' type='text' class='input-reply' placeholder='Reply ...'>" +
                                  "<div class='form-input-reply__btn'>" +
                                      "<label for='reply-file-input-" + comment.id + "' class='fas fa-photo-video'></label>" +
                                      "<input autocomplete='off' name='f_media' id='reply-file-input-" + comment.id + "' type='file' hidden>" +
                                  "</div>" +
                                  "<button type='submit'><i class='fas fa-paper-plane'></i></button>" +
                              "</form>" +
                          "</div>" +
                      "</div>" +
                      "<ul class='list-comments reply' comment_id='" + comment.id + "'>"
            str += sub_str
            comment.replies.forEach(function(reply) {
              str +=
                  "<li class='list-comments__item reply' reply_id='" + reply.id + "'>" +
                      "<a href='/other-personal/" + reply.user.id + "' class='avatar'>" +
                          "<img src='" + reply.user.avatar + "' alt=''>" +
                      "</a>" +
                      "<div class='list-comments__item-content'>" +
                          "<div class='list-comments__item-content__text content-truncate'>" +
                              "<a href='/other-personal/" + reply.user.id + "'>" + reply.user.name + "</a>" +
                              "<div class='comment'>" +
                                  "<p class='url-text'>" + urlify(reply.reply) + "</p>"
              
              reply.images.forEach(function(image) {
                if (image.type == configImage) {
                  str +=
                    "<div class='photos-video__item'>" +
                        "<img class='image_zoom photos-video__item' src='" + image.url + "' alt=''>" +
                    "</div>"
                } else {
                  str +=
                    "<div class='video video_zoom photos-video__item'>" +
                        "<video src='" + image.url + "'></video>" +
                    "</div>"
                }
              })
              str +=
                              "</div>" +
                              "<div class='read-more'>" +
                                  "read more" +
                              "</div>" +
                              "<div class='read-less'>" +
                                  "read less" +
                              "</div>" +
                              "<div class='nums-like " + (reply.nums_like > 0 ? '' : 'hide-element') + "'>" +
                                  "<i class='fas fa-thumbs-up'></i>" +
                                  "<span>" + reply.nums_like + "</span>" +
                              "</div>" +
                          "</div>" +
                          "<div class='list-comments__item-content__buttons'>" +
                              "<span class='btn-like reply " + (reply.nums_like > 0 ? 'like' : '') + "'>Like</span>" +
                              "<span class='time'>" +
                                  reply.created_at +
                              "</span>" +
                          "</div>" +
                      "</div>" +
                  "</li>"
            })

            str += "</ul>"
            if (data.nums_replies[index] > 1) {
              str +=
                "<div class='load-more-comments reply'>" +
                    "Load more replies" +
                "</div>"
            }
            str +=
                "</div>" +
              "</li>"
          }
        })
        if (!data.has_more_comments) {
          parent.find('.load-more-comments.comment').addClass('hide-element')
        }

        parent.find('.list-comments.comment').append(str)
        let input_chat = parent.find('.form-input-reply input.input-reply')
        input_chat.each(function() {
          emoji($(this), 'top')
        })
      }
    )
  })
}

//TODO: Load more replies
{
  list_news_feed.on('click', '.load-more-comments.reply', function() {
    const parent = $(this).closest('.list-comments__item.comment')
    const commentId = parent.attr('comment_id')
    const currentNums = parent.find('.list-comments__item.reply').length
    $.post(
      'post/load-more-replies',
      {
        comment_id: commentId,
        current_nums: currentNums
      },
      function (data) {
        let str = ""
        data.data.forEach(function(reply, index) {
          if (index < 10) {
            str +=
                "<li class='list-comments__item reply' reply_id='" + reply.id + "'>" +
                    "<a href='/other-personal/" + reply.user.id + "' class='avatar'>" +
                        "<img src='" + reply.user.avatar + "' alt=''>" +
                    "</a>" +
                    "<div class='list-comments__item-content'>" +
                        "<div class='list-comments__item-content__text content-truncate'>" +
                            "<a href='/other-personal/" + reply.user.id + "'>" + reply.user.name + "</a>" +
                            "<div class='comment'>" +
                                "<p class='url-text'>" + urlify(reply.reply) + "</p>"
            
            reply.images.forEach(function(image) {
              if (image.type == configImage) {
                str +=
                  "<div class='photos-video__item'>" +
                      "<img class='image_zoom photos-video__item' src='" + image.url + "' alt=''>" +
                  "</div>"
              } else {
                str +=
                  "<div class='video video_zoom photos-video__item'>" +
                      "<video src='" + image.url + "'></video>" +
                  "</div>"
              }
            })
            str +=
                        "</div>" +
                        "<div class='read-more'>" +
                            "read more" +
                        "</div>" +
                        "<div class='read-less'>" +
                            "read less" +
                        "</div>" +
                        "<div class='nums-like " + (reply.nums_like > 0 ? '' : 'hide-element') + "'>" +
                            "<i class='fas fa-thumbs-up'></i>" +
                            "<span>" + reply.nums_like + "</span>" +
                        "</div>" +
                    "</div>" +
                    "<div class='list-comments__item-content__buttons'>" +
                        "<span class='btn-like reply " + (reply.nums_like > 0 ? 'like' : '') + "'>Like</span>" +
                        "<span class='time'>" +
                            reply.created_at +
                        "</span>" +
                    "</div>" +
                "</div>" +
            "</li>"
          }
        })
        str += "</ul>"

        if (!data.has_more_replies) {
          parent.find('.load-more-comments.reply').addClass('hide-element')
        }

        parent.find('.list-comments.reply').append(str)
      })
  })
}

//TODO: Seen all notification
{
  $('.nav-notification__content .nav-notification__seen').click(function(e) {
    $.post(
      'seen-all-notifications',
      function(data) {
        $('.nav-notification__content li ul li').removeClass('unseen')
      }
    )
  })

  $('.nav-notification__content').on('click', 'li ul li', function(e) {
    const instance = $(this)
    const notification_id = instance.attr('notification_id')
    const href = instance.find('a').attr('href')
    e.preventDefault()
    $.post(
      'seen-notification',
      {
        notification_id: notification_id
      },
      function(data) {
        instance.removeClass('unseen')
        window.location.href = href
      }
    )
  })
}

//TODO: Delete post
{
  list_news_feed.on('click', '.delete-post', function() {
    let parent = $(this).closest('.new-feed')
    let postId = parent.attr('post_id')
    $.post(
      'post/delete',
      {
        post_id: postId
      },
      function() {
        location.reload()
      }
    )
  })
}
</script>