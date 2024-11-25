<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/FontAwesome/css/all.min.css')}}">
    {{-- types of fontAwesome
        fas => Solid icons
        far => Regular icons
        fab => Bradns icons
    ex:
        fas fa-heart
    --}}
    <style>
        a{
            text-decoration: none;
            color: #111
        }
    </style>
    <title>@yield('title')</title>
</head>
<body>

    @yield('content')

    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
</body>
</html>
