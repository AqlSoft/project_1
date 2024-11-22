<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Print')</title>
    @section('headerLinks')
        <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/print_style.css') }}">
    @show
</head>

<body class="print  position-relative">

    <table class="w-100">
        <thead>
            <tr>
                <td style="height: 1.5cm">
                    {{-- ---------------------------------- The Header of Print Page ---------------------------------- --}}
                    <header>
                        @section('print-header')
                            <img src="{{ asset('assets\admin\uploads\images\main-print-header.png') }}" alt=""
                                width="100%">
                        @show
                    </header>
                    {{-- ---------------------------------- The Header of Print Page ---------------------------------- --}}
                </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>
                    {{-- ---------------------------------- The Body of Print Page --------------------------------------- --}}
                    <div class="container" dir="rtl">
                        @yield('printed')

                        <div class="controls" dir="ltr">
                            <div class="bars">
                                <i class="fa fa-bars text-primary"></i>
                            </div>
                            <div class="buttons">
                                @yield ('buttons')
                            </div>
                        </div>
                    </div>
                    {{-- ---------------------------------- The Body of Print Page ---------------------------------- --}}
                </td>
            </tr>
        </tbody>

        <tfoot>
            <tr>
                <td style="height: 1.5cm;">
                    {{-- ---------------------------------- The Footer of Print Page ---------------------------------- --}}
                    <footer class="printFooter" dir="rtl">
                        @section('printFooter')
                            <div class="row">
                                <div class="col col-8 bg-primary">
                                    <p class="text-white pt-2 pb-1 text-center m-0">

                                        عميلنا العزيز:<br>
                                        الرجاء التأكد من الأصناف والكميات قبل مغادرة الثلاجة.
                                    </p>
                                    <p class="text-white pt-1 pb-2 text-center m-0">
                                        القصيم - بريدة - طريق الملك فهد - جوال 0509314449
                                    </p>
                                </div>
                                <div
                                    class="col col-4 pt-3 fw-bold bg-{{ $receipt->confirmation == 'approved' ? 'success' : 'info' }} text-center fs-1 text-white">
                                    {{ $receipt->confirmation == 'approved' ? 'معتمدة' : 'نسخة للعرض' }}
                                </div>
                            </div>
                        @show
                    </footer>
                    {{-- ---------------------------------- The Footer of Print Page ---------------------------------- --}}

                </td>
            </tr>
        </tfoot>
    </table>
    @section('footerLinks')
        <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
        <script>
            $('.bars').click(function() {
                $(this).next('.buttons').slideToggle(200)
            })
        </script>
    @show


</body>

</html>
