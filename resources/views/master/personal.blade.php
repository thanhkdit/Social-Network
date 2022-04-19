<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <base href="{{ asset('') }}">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- socket.io -->
    <script src="https://cdn.socket.io/4.1.2/socket.io.min.js" integrity="sha384-toS6mmwu70G0fw54EGlWWeA4z3dyJ+dlXBtSURSKN4vyRFOcxd3Bzjj/AoOwY+Rg" crossorigin="anonymous"></script>

    <!-- boostrap -->
    <link rel="stylesheet" href="bootstrap5/css/bootstrap.min.css">

    <!-- emojionearea -->
    <link rel="stylesheet" href="emojionearea/dist/emojionearea.min.css" integrity="sha512-vEia6TQGr3FqC6h55/NdU3QSM5XR6HSl5fW71QTKrgeER98LIMGwymBVM867C1XHIkYD9nMTfWK2A0xcodKHNA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- fontawesome -->
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="fontawesome/js/all.min.js">

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400&display=swap" rel="stylesheet">

</head>
<body onresize="resize()">

    @include('master.nav')

    <main class="container-1">

        @include('master.personal_left')
        @yield('content')
        @include('master.main_right')

    </main>

    @include('master.box_chat_list')
    @include('master.rise')
    @include('master.zoom_layout')

<script src="js/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<!-- emojionearea -->
<script src="emojionearea/dist/emojionearea.min.js"></script>

<!-- masonry -->
<script src="js/imagesloaded.pkgd.min.js"></script>
<script src="js/masonry.pkgd.min.js"></script>

<script src="js/config.js"></script>
<script src="js/function.js"></script>
<script src="js/once.js"></script>
<script src="js/auto.js"></script>
<script src="js/event.js"></script>

<!-- bootstrap 5 -->
<script src="bootstrap5/js/bootstrap.min.js"></script>

<!--//TODO: Chat -->
@include('master.script.chat.chatting')

<!--//TODO: Calendar -->
@include('master.script.calendar.calendar')

<!--//TODO: Post -->
@include('master.script.post.post')

<!--//TODO: Personal -->
@include('master.script.personal.personal')

</body>
</html>