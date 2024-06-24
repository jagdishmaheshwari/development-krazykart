<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>KrazyKart | Admin</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts and icons -->
    <script src="/js/plugin/webfont/webfont.min.js"></script>
    <link rel="icon" href="/admin/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="/fontawesome/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->

    <!-- <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script> -->

    <script src="/js/jquery.js"></script>


    <!-- CSS Files -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/datatable.css">
    <link rel="stylesheet" href="/css/common.css">
    <link rel="stylesheet" href="/css/dropzone.css" async>
    <link rel="stylesheet" href="/admin/css/style.css">
    <link rel="stylesheet" href="/css/atlantis.css">
    <script src="/js/sweetalert.js"></script>
    <script src="/admin/js/script.js"></script>
    <script src="/js/script.js"></script>
    <script src="/js/sortable.js"></script>
    <script src="/js/jquery-validate.min.js"></script>


    <script src="/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
    <script src="/js/plugin/chart-circle/circles.min.js"></script>


    <script src="/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <script src="/js/core/popper.min.js"></script>
    <script src="/js/core/bootstrap.min.js"></script>
    <script src="/js/atlantis.js"></script>
    {{-- <script src="/js/dropzone.js"></script> --}}
    {{-- <script src="/js/owl_carousel.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            // Global setup for AJAX requests
            $(document).ajaxStart(function() {
                // Show loader when an AJAX request starts
                $('#loader-overlay').fadeIn('fast');
            });

            $(document).ajaxStop(function() {
                // Hide loader when all AJAX requests complete
                $('#loader-overlay').fadeOut('fast');
            });

            // Example AJAX request
            // $.ajax({
            //     url: 'your-api-endpoint',
            //     method: 'GET',
            //     success: function(response) {
            //         // Handle successful response
            //         console.log(response);
            //     },
            //     error: function(xhr, status, error) {
            //         // Handle error
            //         console.error(status, error);
            //     }
            // });

            const alertHtml = sessionStorage.getItem('alertHtml');
            const alertType = sessionStorage.getItem('alertType');
            const alertPosition = sessionStorage.getItem('alertPosition');

            if (alertHtml && alertType && alertPosition) {
                $('body').append(alertHtml);
                const $alert = $('.alert').last();

                switch (alertType) {
                    case 'success':
                        $alert.addClass('alert-success');
                        break;
                    case 'warning':
                        $alert.addClass('alert-warning');
                        break;
                    case 'error':
                    case 'danger':
                        $alert.addClass('alert-danger');
                        break;
                }

                switch (alertPosition) {
                    case 'top-right':
                        $alert.addClass('top-0 end-0 mt-3 me-3');
                        break;
                    case 'top-left':
                        $alert.addClass('top-0 start-0 mt-3 ms-3');
                        break;
                    case 'top-center':
                        $alert.addClass('top-0 start-50 translate-middle-x mt-3');
                        break;
                    case 'bottom-right':
                        $alert.addClass('bottom-0 end-0 mb-3 me-3');
                        break;
                    case 'bottom-left':
                        $alert.addClass('bottom-0 start-0 mb-3 ms-3');
                        break;
                    case 'bottom-center':
                        $alert.addClass('bottom-0 start-50 translate-middle-x mb-3');
                        break;
                    default:
                        $alert.addClass('top-0 end-0 mt-3 me-3'); // Default to top-right
                }

                // Automatically remove the alert after a timeout (e.g., 5 seconds)
                setTimeout(function() {
                    $alert.remove();
                    sessionStorage.removeItem('alertHtml');
                    sessionStorage.removeItem('alertType');
                    sessionStorage.removeItem('alertPosition');
                }, 5000);
            }
        });
    </script>
    <style>
        #loader-overlay {
            display: none;
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            text-align: center;
        }

        .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            border: 2px solid white;
            border-bottom-color: transparent;
            font-size: 20px;
            scale: 4;
            /* Add your custom styles for the loader animation or text */
        }
    </style>
</head>

<body class="">
    <div class="wrapper __theme <?php echo isset($OpenSidebar) ? '' : 'sidebar_minimize'; ?> ">
        <div class="main-header">
            @include('admin.navbar')
        </div>
        @include('admin.aside')
        <div class="main-panel">
            <div class="content">
                <div id="loader-overlay">
                    <div class="loader"></div>
                </div>
