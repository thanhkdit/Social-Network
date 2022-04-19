<script>
$(function(){
  const USER_LOGIN = "{{auth()->user()->id}}"
  const form_add_calendar = $('#form_add_calendar')
  form_add_calendar.on('submit', function(e) {
    e.preventDefault()
    const formData = new FormData($(this)[0])
    formData.append('user_id', USER_LOGIN)
    if (formData.get('time') && formData.get('title')) {
      $.ajax({
        url: '/add-calendar',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function(data){
          form_add_calendar[0].reset()
        }
      })
    }
  })
  
  const calendar_items = $('.main-right .calendar .calendar__items')
  calendar_items.on('click','.calendar__item-action .delete',function(){
    let calendar_id = $(this).attr('calendar-id')
    let item = $(this).parent().parent()
    $.post(
      '/destroy-calendar',
      {
        "calendar_id": calendar_id
      },
      function(data) {
        item.remove()
        is_none_calendar()
      }
    )
  })
  
  const body = $('body')
  const rise = $('#rise')
  const delete_all_calendar = $('#rise .delete_all_calendar')
  const btn_delete_all = $('.delete_all_calendar .delete_all')
  btn_delete_all.click(function(){
    $.post(
      'delete-all-calendar',
      {
        'user_id': '{{ auth()->user()->id }}'
      },
      function(data) {
        rise.removeClass('display')
        delete_all_calendar.removeClass('display')
        body.removeClass('darken')
        let calendar_item = $('.main-right .calendar .calendar__item')

        calendar_item.remove()
        is_none_calendar()
      }
    )
  })

  $('#btn_sync_calendar').click(function() {
    let instance = $(this)
    $(this).addClass('loading')
    $.post(
      'calendar/sync',
      function() {
        instance.removeClass('loading')
      }
    )
  })
})
</script>