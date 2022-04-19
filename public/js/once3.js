is_none_calendar()

//TODO: hiển thị nút: read more
{
    let content_truncate = $('.content-truncate p')
    content_truncate.each(function(index){
        if ($(this).outerHeight() < $(this)[0].scrollHeight){
            $(this).siblings('.read-more').addClass('display')
        }
        else {
            $(this).siblings('.read-more').removeClass('display')
        }
    })
}
