<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->
<head>
    <title>Home | Mantis Bootstrap 5 Admin Template</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('panel.layouts.header')
</head>
<!-- [Head] end -->

<!-- [Body] Start -->
<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Sidebar Menu ] start -->
    @include('panel.layouts.sidebar')
    <!-- [ Sidebar Menu ] end --> 
    
    <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        @include('panel.layouts.navbar')
    </header>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    @yield('content')
    <!-- [ Main Content ] end -->

    <footer class="pc-footer">
        @include('panel.layouts.footer')
    </footer>

    @include('panel.layouts.script')
</body>
<!-- [Body] end -->
</html>
