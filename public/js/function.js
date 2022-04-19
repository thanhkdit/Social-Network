
function is_none_calendar(){
  let calendar_items = $('.main-right .calendar__items')
  let calendar_not_have = $('.main-right .calendar__items .not-have')
  let condition = calendar_items.children().not('.hide')
  if(condition.length == 1){
      calendar_not_have.css('display','block')
  }
  else {
      calendar_not_have.css('display','none')
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

function resize(){
  un_active_all()
  if (window.matchMedia('(max-width: 800px)').matches) {
      TAB_CHAT_NUMS = 1
  } else if (window.matchMedia('(max-width: 1300px)').matches) {
      TAB_CHAT_NUMS = 2
  } else if (window.matchMedia('(max-width: 1600px)').matches) {
      TAB_CHAT_NUMS = 3
  } else {
      TAB_CHAT_NUMS = 4
  }
  let box_chat_list = $('.box-chat__list')
  //Remove element tab chat
  if(box_chat_list.children().length > TAB_CHAT_NUMS){
      box_chat_list.children(`:nth-child(n+${TAB_CHAT_NUMS + 1})`).remove()
  }

  //Button main left, main right
  if (window.matchMedia('(max-width: 1380px)').matches){
      $('.main-left__btn-close').removeClass('display')
      $('.main-left__btn-open').addClass('display')
      $('.main-left').addClass('minimize')
      $('.main-left').addClass('hightlight')

      $('.main-right__btn-close').removeClass('display')
      $('.main-right__btn-open').addClass('display')
      $('.main-right').addClass('minimize')
      $('.main-right').addClass('hightlight')

      $('.box-chat__list').addClass('small-screen')
  } else {
      $('.main-left__btn-close').removeClass('display')
      $('.main-left__btn-open').removeClass('display')
      $('.main-left').removeClass('minimize')
      $('.main-left').removeClass('hightlight')

      $('.main-right__btn-close').removeClass('display')
      $('.main-right__btn-open').removeClass('display')
      $('.main-right').removeClass('minimize')
      $('.main-right').removeClass('hightlight')
      
      $('.box-chat__list').removeClass('small-screen')
  }
  if (window.matchMedia('(max-width: 1000px)').matches){
      $('.main-content').addClass('small-screen')
  } else {
      $('.main-content').removeClass('small-screen')
  }
}

const except_display = ['.functions-content__tag, .preview', '.btn-main-menu']
const except_hide = ['.calendar__item', '.new-notification', '.new-notification', '.post-tag-item']

function un_active_all(){
  $(`.display:not(${except_display})`).removeClass('display')
  $('.active').removeClass('active')
  $('.small').removeClass('small')
  $('.darken').removeClass('darken')
  $(`.hide:not(${except_hide})`).removeClass('hide')
  
  if (window.matchMedia('(max-width: 1380px)').matches){
      $('.main-left').addClass('hightlight')
      $('.main-left').addClass('minimize')
      $('.main-left__btn-close').removeClass('display')
      $('.main-left__btn-open').addClass('display')

      $('.main-right').addClass('hightlight')
      $('.main-right').addClass('minimize')
      $('.main-right__btn-close').removeClass('display')
      $('.main-right__btn-open').addClass('display')
  }
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
function getExtension(filename) {
  var parts = filename.split('.');
  return parts[parts.length - 1];
}

function isImage(filename) {
  var ext = getExtension(filename);
  switch (ext.toLowerCase()) {
    case 'jpg':
    case 'gif':
    case 'bmp':
    case 'png':
      //etc
      return true;
  }
  return false;
}

function isVideo(filename) {
  var ext = getExtension(filename);
  switch (ext.toLowerCase()) {
      case 'm4v':
      case 'avi':
      case 'mpg':
      case 'mp4':
      // etc
      return true;
  }
  return false;
}

//* Setting layout for img, video in post
function setLayoutPost() {
  $('.new-feed .photos-video').each(function() {
      const children = $(this).children()
      if (children.length > 0 && children.length < 4) {
          children.css({'width': '49%'})
          $(this).css({'display': 'flex', 'justify-content': 'space-between'})
      }
  })
}

//* remove 1 file
function remove_file(element, index){
  var attachments = element.get(0).files
  var fileBuffer = new DataTransfer();

  // append the file list to an array iteratively
  for (let i = 0; i < attachments.length; i++) {
      // Exclude file in specified index
      if (index !== i)
          fileBuffer.items.add(attachments[i]);
  }
  
  // Assign buffer to file input
  element.get(0).files = fileBuffer.files;
}

//* add emoji to input
function emoji(input, pickerPos){
  $(input).emojioneArea({
      pickerPosition: pickerPos,
      filtersPosition: "bottom"
  })
}
function urlify(text) {
  var urlRegex = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)/g;
  return text.replace(urlRegex, function(url) {
    return '<a target="_blank" href="' + url + '" class="link-text">' + url + '</a>';
  })
}

function truncateText() {
  let content_truncate = $('.content-truncate p')
  content_truncate.each(function(index){
      if ($(this).outerHeight() < $(this)[0].scrollHeight && $(this).outerHeight() > 123){
          $(this).siblings('.read-more').addClass('display-inline')
      }
      else {
          $(this).siblings('.read-more').removeClass('display-inline')
      }
  })
}

function formatMessage(message) {
  return message
          .replace(/&#10;/g, '\n')
          .replace(/&#09;/g, '\t')
          .replace(/<img[^>]*alt="([^"]+)"[^>]*>/ig, '$1')
          .replace(/\n|\r/g, '')
          .replace(/<br[^>]*>/ig, '\n')
          .replace(/(?:<(?:div|p|ol|ul|li|pre|code|object)[^>]*>)+/ig, '<div>')
          .replace(/(?:<\/(?:div|p|ol|ul|li|pre|code|object)>)+/ig, '</div>')
          .replace(/\n<div><\/div>/ig, '\n')
          .replace(/<div><\/div>\n/ig, '\n')
          .replace(/(?:<div>)+<\/div>/ig, '\n')
          .replace(/([^\n])<\/div><div>/ig, '$1\n')
          .replace(/(?:<\/div>)+/ig, '</div>')
          .replace(/([^\n])<\/div>([^\n])/ig, '$1\n$2')
          .replace(/<\/div>/ig, '')
          .replace(/([^\n])<div>/ig, '$1\n')
          .replace(/\n<div>/ig, '\n')
          .replace(/<div>\n/ig, '\n\n')
          .replace(/<(?:[^>]+)?>/g, '')
          .replace(/&nbsp;/g, ' ')
          .replace(/&lt;/g, '<')
          .replace(/&gt;/g, '>')
          .replace(/&quot;/g, '"')
          .replace(/&#x27;/g, "'")
          .replace(/&#x60;/g, '`')
          .replace(/&#60;/g, '<')
          .replace(/&#62;/g, '>')
          .replace(/&amp;/g, '&');
}

function count_notifications() {
  const nums = $('.nav-notification__content li ul li.unseen').length
  let new_noti = $('.nav-right__buttons-item.nav-notification').find('.new-notification')
  new_noti.html(nums)
  if (nums < 1) {
    new_noti.addClass('hide')
  } else {
    new_noti.removeClass('hide')
  }
}