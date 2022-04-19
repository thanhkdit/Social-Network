//TODO: Variable
var TAB_CHAT_NUMS = 4
if (window.matchMedia('(max-width: 800px)').matches) {
    TAB_CHAT_NUMS = 1
} else if (window.matchMedia('(max-width: 1000px)').matches) {
    TAB_CHAT_NUMS = 2
} else if (window.matchMedia('(max-width: 1600px)').matches) {
    TAB_CHAT_NUMS = 3
} else {
    TAB_CHAT_NUMS = 4
}
var checkShift = false
//* Nếu thời gian giữa 2 tin nhắn ít hơn DIFF_TIME mili giây thì không hiện thị thẻ <small> time_send </small>
const DIFF_TIME = 1800000

//TODO: emoji
let form_input_comment = $('.form-input-comment')
let form_input_reply = $('.form-input-reply')   
let form_input_chat = $('.form-input-chat')
const body = $('body')
body.on('mousedown','.emojionearea-button',function(e){
    e.stopPropagation()
})
body.on('mousedown','.emojionearea-button',function(e){
    e.stopPropagation()
})
body.on('mousedown','.emojionearea-picker',function(e){
    e.stopPropagation()
})
body.on('mousedown','.emojionearea-button',function(e){
    e.stopPropagation()
})
body.on('mousedown','.emojionearea-picker',function(e){
    e.stopPropagation()
})

$('#post-content').emojioneArea({
    pickerPosition: "bottom"
})

$('.input-comment').emojioneArea({
})

$('.input-reply').emojioneArea({
})

$('.input-tab-chat').emojioneArea({
})
//TODO: Mansory

$('.image-preview').imagesLoaded(function () {
    $('.image-preview').masonry({
        // options...
        itemSelector: '.image-preview__one',
        columnWidth: 2
    });
});
$('.functions-content__image').imagesLoaded(function () {
    $('.functions-content__image').masonry({
        // options...
        itemSelector: '.functions-content__image-one',
        columnWidth: 2
    });
});