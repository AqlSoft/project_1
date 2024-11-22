<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Contract Document</title>
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>


    <style>
        html {
            width: 21cm;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box
        }

        .contract-container {
            padding: 1em;
            margin: 1em auto;
            overflow: hidden
        }

        @media print {
            * {
                font-family: Cairo;
            }

            html {
                width: 21cm;
                height: 29cm;
                overflow: hidden
            }



            .contract-container {
                width: calc (21cm - 2em);
                height: 29cm;
                font: normal 0.8em / 1.2 Cairo;
                padding: 0 1.5em;
                margin: 0.5rem auto;
                overflow: hidden
            }

            body.print {
                overflow: hidden
            }

            .buttons {
                display: none;
            }

            table tr td {
                padding: 2px 1em;
                border-bottom: 1px solid #777;
                border-right: 1px solid #777;
            }

            table tr td:first-child {
                border-right: none
            }

            table tr:last-child td {
                border-bottom: 2px solid #777;
            }


            table tr th {
                border-bottom: 2px solid #777 !important;
                border-top: 2px solid #777;
                border-right: 1px solid #777;
            }

            table tr th:first-child {
                border-right: none
            }

        }

        ol,
        ul {
            padding: 0 1rem 0 0;

        }

        p,
        ul li,
        ol li {
            margin: 0;
            padding: 0;
            text-align: justify;
            width: 100%;
        }

        table tr td {
            padding: 2px 1em;
            border-bottom: 1px solid #0282fa;
            border-right: 1px solid #0282fa;
        }

        table tr td:first-child {
            border-right: none
        }

        table tr:last-child td {
            border-bottom: 2px solid #0282fa;
        }


        table tr th {
            border-bottom: 2px solid #0282fa !important;
            border-top: 2px solid #0282fa;
            border-right: 1px solid #0282fa;
        }

        table tr th:first-child {
            border-right: none
        }
    </style>
</head>

<body class="print" dir="rtl">

    <div id="content">
        <p></p>
        <p></p>
        <p></p>
        <p></p>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

</body>

</html>
