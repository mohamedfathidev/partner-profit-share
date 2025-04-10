<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Webmin - Bootstrap 4 & Angular 5 Admin Dashboard Template" />
    <meta name="author" content="potenzaglobalsolutions.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="icon" href="{{ asset('assets/images/EG.ico') }}">
    @include('layouts.head')


</head>

<body>
    <div class="wrapper">

        <!--=================================
 preloader -->

        <div id="pre-loader">
            <img src="assets/images/pre-loader/loader-01.svg" alt="">
        </div>

        <!--=================================
 preloader -->

        @include('layouts.main-header')

        @include('layouts.main-sidebar')

        <!--=================================
 Main content -->
        <!-- main-content -->
        <div class="content-wrapper">

            @yield('page-header')

            @yield('content')

            <!--=================================
 wrapper -->

            <!--=================================
 footer -->

            @include('layouts.footer')
        </div><!-- main content wrapper end-->
    </div>
    </div>
    </div>

    <!--=================================
 footer -->

    @include('layouts.footer-scripts')

    @stack('scripts')

    @stack('js-code')

    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <script>
        $(document).ready(function() {
            @if (session('success'))
                toastr.success(
                "{{ session('success') }}"); // there is a probelm navigate back show the message again and return
                @php
                    session()->forget('success');
                @endphp
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}");
                @php
                    session()->forget('error');
                @endphp
            @endif

            @if (session('warning'))
                toastr.warning("{{ session('warning') }}");
                @php
                    session()->forget('warning');
                @endphp
            @endif

            @if (session('info'))
                toastr.info("{{ session('info') }}");
                @php
                    session()->forget('info');
                @endphp
            @endif
        });
    </script>
</body>

</html>
