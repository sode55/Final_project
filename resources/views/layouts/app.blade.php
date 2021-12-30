<!doctype html>
<html lang="en">
   <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'bus booking') }}</title>

        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/datatables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
   </head>
   <body>

        <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
            <div class="container">
                @guest
                    <a class="navbar-brand" href="">{{ config('app.name', 'bus booking') }}</a>
                @else
                    <a class="navbar-brand" href="">Dashboard</a>
                @endguest

                <ul class="navbar-nav navbar-right ml-auto">

                        <li class="nav-item">
                            <a class="nav-link" href="">{{ __('Login') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#" id="create-contact" data-toggle="modal" data-target="#modal-create-contact"><i class="fas fa-user"></i> Create A Contact</a>
                        </li>
                        <li class="nav-item pl-4 pl-1">
                            <span class="navbar-text text-white">Hi <span class="k"></span>!</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Log out</a>
                        </li>
                </ul>
            </div>
        </nav>

        <div class="content">
            <div class="container">
                @yield('content')
            </div>
        </div>

{{--        @include('parts.modals')--}}

{{--        <!-- JavaScript -->--}}
{{--        <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>--}}
{{--        <script src="{{ asset('js/popper.min.js') }}"></script>--}}
{{--        <script src="{{ asset('js/bootstrap.min.js') }}"></script>--}}
{{--        <script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>--}}
{{--        <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>--}}
{{--        <script src="{{ asset('js/plugins/mask/jquery.mask.min.js') }}"></script>--}}
{{--        @yield('extra-js')--}}

   </body>
</html>
