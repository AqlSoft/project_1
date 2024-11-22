<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>طباعة السند</title>
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/reception.print.css') }}">
</head>

<body class="print">

    <div class="receipt-container">

        <div class="receipt position-relative" dir="rtl">
            <div class="d-flex" style="border-bottom: 3px solid #0282fa; padding-bottom: 0">
                <div class="col">
                    <div class="d-grid text-center">
                        <h4 class="card-title fw-bold text-primary" style="font-size: 20px; padding: 0">مخازن أيمن
                            الغماس </h4>
                        <p class="p-0" style="font-size: 12px">تخزين | تبريد | تجميد | شراع | بيع | تصدير
                            <small class="d-block">س ت: 123456789</small>
                            <b class="text-primary">سند استلام بضاعة</b>
                        </p>
                    </div>
                </div>
                <div class="col text-center">
                    <img src="{{ asset('assets/admin/uploads/images/logo.png') }}" alt="" width="90">

                </div>
                <div class="col">
                    <div class="d-grid text-center ">
                        <h4 class="card-title fw-bold text-primary" style="font-size: 20px; padding: 0">Ayman Al Ghamas
                            Stores</h4>
                        <p class="p-0" style="font-size: 10px">Storing | Colling | Freezing | Purchase | Sell
                            |
                            Export
                            <small class="d-block">س ت: 123456789</small>
                            <b class="text-primary">Goods reception document</b>
                        </p>

                    </div>
                </div>
            </div>

            <div class="row receipt_info p-1">
                <div class="col col-6">
                    <span class="text-right fw-bold"> التاريخ: </span>
                    <span class="px-2 text-primary"> {{ '$receipt->greg_date' }} </span>
                </div>

                <div class="col col-6">
                    <span class="text-right fw-bold">مسلسل: </span>
                    <span class="px-2 fw-bold text-primary">{{ '$receipt->s_number' }}</span>
                </div>
                <div class="col col-6">
                    <span class="text-right fw-bold">العميل: </span>
                    <span class="px-2 text-primary">{{ '$receipt->theClient->a_name' }}</span>
                </div>

                <div class="col col-4">
                    <span class="text-right fw-bold"> العقد: </span>
                    <span class="px-2 text-primary">{{ '$receipt->theContract->s_number' }}</span>
                </div>
                <div class="col col-6">
                    <span class="text-right fw-bold"> المزرعة / المصدر: </span>
                    <span class="px-2 text-primary">{{ '$receipt->farm' }}</span>
                </div>
                <div class="col col-6">
                    <span class="text-right fw-bold"> المندوب / السائق: </span>
                    <span class="px-2 text-primary">{{ '$driver != null ? $driver->a_name:غير معروف' }}</span>
                </div>
                <div class="col col-12">
                    <span class="text-right fw-bold"> أخرى: </span>
                    <span class="px-2 text-primary">{{ '$receipt->notes' }}</span>
                </div>
                <div class="col col-6">
                    <span class="text-right fw-bold"> اجمالى السند: </span>
                    <span class="px-2 text-primary">{{ "entries->sum('inputs')" }}</span>
                </div>
            </div>
            <table id="receipt_items_table">
                <thead>
                    <tr class="">
                        <th class="fw-bold bg-primary py-2 fs-6">#</th>
                        <th class="fw-bold bg-primary py-2 fs-6">رقم الطبلية</th>
                        <th class="fw-bold bg-primary py-2 fs-6">حجم الطبلية</th>
                        <th class="fw-bold bg-primary py-2 fs-6">الأصناف</th>
                        <th class="fw-bold bg-primary py-2 fs-6">حجم الكرتون</th>
                        <th class="fw-bold bg-primary py-2 fs-6">الكمية</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {{-- @if (count($entries))
                        @foreach ($entries as $index => $entry)
                            <tr>
                                <td class="fw-normal border-left">{{ ++$index }}</td>
                                <td class="fw-normal border-left">{{ $entry->tableName }}</td>
                                <td class="fw-normal border-left">{{ $entry->table_size == 1 ? 'صغيرة' : 'كبيرة' }}
                                </td>
                                <td class="fw-normal border-left">{{ $entry->itemName }}</td>
                                <td class="fw-normal border-left">{{ $entry->boxName }}</td>
                                <td class="fw-normal">{{ $entry->inputs }}</td>
                            </tr>
                        @endforeach
                    @else
                        <div class="text-right">لم يتم بعد إضافة أى إدخالات على هذا السند</div>
                    @endif
                </tbody> --}} -->
            </table>

            {{-- <div class="controls" dir="ltr">
                <div class="bars">
                    <i class="fa fa-bars text-primary"></i>
                </div>
                <div class="buttons">
                    <button class="btn btn-outline-primary"
                        onclick="window.location={{ route('reception.entries.create', [$receipt->id, 0]) }}">
                        العودة للسند
                    </button>
                    @if ($receipt->confirmation !== 'approved')
                        <button class="btn btn-outline-primary"
                            onclick="window.location='{{ route('reception.approve', [$receipt->id]) }}'"> اعتماد
                        </button>
                    @endif
                    @if ($receipt->confirmation == 'approved')
                        <button class="btn  mx-1 btn-outline-primary" onclick="window.print()"> طباعة</button>
                    @endif
                    <button class="btn btn-outline-primary"
                        onclick="window.location='{{ route('reception.home', [1]) }}'">الذهاب
                        للسندات</button>
                    <button class="btn btn-outline-primary"
                        onclick="window.location='{{ route('contract.view', [$receipt->theContract->id, 2]) }}'">الذهاب
                        للعقد</button>
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>تهانينا!</strong> {{ Session::get('success') }}.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>تنبيه!</strong> {{ Session::get('error') }}.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (Session::has('warning'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong>تحذير!</strong> {{ Session::get('warning') }}.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div> --}}


            <div class="footer" style="mb-3">
                <div class="signatures">
                    <div class="row">
                        <div class="col col-3 text-center">
                            <p class="d-inline-block py-3">أمين الثلاجة</p>
                        </div>
                        <div class="col col-3 text-center">
                            <p class="d-inline-block py-3">العميل</p>
                        </div>
                        <div class="col col-3 text-center">
                            <p class="d-inline-block py-3">الحسابات</p>
                        </div>
                        <div class="col col-3 text-center">
                            <p class="d-inline-block py-3">الإدارة</p>
                        </div>
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col col-8 bg-primary contact-info">
                        <p class="text-white pt-2 pb-1 text-center m-0">

                            عميلنا العزيز:<br>
                            الرجاء التأكد من الأصناف والكميات قبل مغادرة الثلاجة.
                        </p>
                        <p class="text-white pt-1 pb-2 text-center m-0">
                            القصيم - بريدة - طريق الملك فهد - جوال 0509314449
                        </p>
                    </div>
                    <div
                        class="col col-4 pt-3 fw-bold confirmation bg-{{ $receipt->confirmation == 'approved' ? 'success' : 'info' }} text-center fs-1 text-white">
                        {{ $receipt->confirmation == 'approved' ? 'معتمدة' : 'نسخة للعرض' }}
                    </div>
                </div>


            </div>
        </div>
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
