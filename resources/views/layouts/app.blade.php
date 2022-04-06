<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from wieldy-html.g-axon.work/default/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Aug 2020 08:12:55 GMT -->

<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Wieldy - A fully responsive, HTML5 based admin template">
    <meta name="keywords"
        content="Responsive, HTML5, admin theme, business, professional, jQuery, web design, CSS3, sass">
    <!-- /meta tags -->
    <title>Wieldy - Admin Dashboard</title>

    <!-- Site favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- /site favicon -->

    <!-- Font Icon Styles -->
    <link rel="stylesheet" href="../node_modules/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../vendors/gaxon-icon/style.css">
    <!-- /font icon Styles -->

    <!-- Perfect Scrollbar stylesheet -->
    <link rel="stylesheet" href="../node_modules/perfect-scrollbar/css/perfect-scrollbar.css">
    <!-- /perfect scrollbar stylesheet -->

    <!-- Load Styles -->

    <link rel="stylesheet" href="assets/css/lite-style-1.min.css">
    <!-- /load styles -->

</head>

<body class="dt-sidebar--fixed dt-header--fixed">

    <!-- Loader -->
    <div class="dt-loader-container">
        <div class="dt-loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10">
                </circle>
            </svg>
        </div>
    </div>
    <!-- /loader -->

    <!-- Root -->
    <div class="dt-root">
        <!-- Header -->
        <header class="dt-header">

            <!-- Header container -->
            @include('include.header')
            <!-- /header container -->

        </header>
        <!-- /header -->

        <!-- Site Main -->
        <main class="dt-main">
            <!-- Sidebar -->
            <x-sidebar/>
            <!-- /sidebar -->

            <!-- Site Content Wrapper -->
            <div class="dt-content-wrapper">

                <!-- Site Content -->
                @yield('content')
                <!-- /site content -->

                <!-- Footer -->
                @include('include.footer')
                <!-- /footer -->

            </div>
            <!-- /site content wrapper -->

            <!-- Theme Chooser -->
            <div class="dt-customizer-toggle">
                <a href="javascript:void(0)" data-toggle="customizer"> <i class="icon icon-spin icon-setting"></i> </a>
            </div>
            <!-- /theme chooser -->

            <!-- Customizer Sidebar -->
            <x-right-sidebar/>
            <!-- /customizer sidebar -->

        </main>
    </div>
    <!-- /root -->

    <!-- Optional JavaScript -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/moment/moment.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Perfect Scrollbar jQuery -->
    <script src="../node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <!-- /perfect scrollbar jQuery -->

    <!-- masonry script -->
    <script src="../node_modules/masonry-layout/dist/masonry.pkgd.min.js"></script>
    <script src="../node_modules/sweetalert2/dist/sweetalert2.js"></script>

    <script src="../node_modules/chart.js/dist/Chart.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/custom/charts/dashboard-crypto.js"></script>
</body>

<!-- Mirrored from wieldy-html.g-axon.work/default/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Aug 2020 08:14:49 GMT -->

</html>
