let inputFile = $('.register-avatar input')
inputFile.change(function(e){
  const file = e.target.files[0]
  if (file) {
    $(this).parent().find('.preview-avatar').attr('src', URL.createObjectURL(file))
  }
})