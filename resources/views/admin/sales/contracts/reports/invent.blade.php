<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/print_style.css') }}">

</head>

<body class="print">

    <div class="receipt-container">
 
        <table dir="rtl">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>SN</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contracts as $i => $contract)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $contract->clientName }}</td>
                        <td>{{ $contract->s_number }}</td>
                        <td>{{ $contract->total_inputs }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    </div>{{-- The container --}}
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <script>
        $('.bars').click(
            function() {
                $('.buttons').slideToggle(300)
            }
        )
    </script>

</body>

</html>
