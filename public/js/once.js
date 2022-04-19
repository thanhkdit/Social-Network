is_none_calendar()

$('.url-text').each(function(index, item) {
    item.innerHTML = urlify(item.innerHTML)
})

// setLayoutPost()
count_notifications()

//TODO: masonry cho user image
{
    //* append items thì phải sử dụng masonry thì masonry mới nhận
    $('.list-user-images').imagesLoaded( function() {
        $('.list-user-images').masonry({
            gutter: 10
        })
    })
}

//TODO: hiển thị nút: read more
{
    truncateText()
}

// Display button open close main-left, main-right
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
}
if (window.matchMedia('(max-width: 1000px)').matches){
    $('.main-content').addClass('small-screen')
} else {
    $('.main-content').removeClass('small-screen')
}