<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="{{ asset('assets/admin/css/print_style.css') }}"> --}}

    <style>
        html {
            width: 21cm;
        }

        @media print {
            html {
                width: 21cm;
            }



            .contract-container {
                width: calc (21cm - 2em);
                height: 30cm;
                background-color: #ddd;
                font: normal 0.8em / 1.2 Cairo;
                padding: 1em;
                margin: 1em;
                overflow: hidden
            }
        }
    </style>
</head>

<body class="print" dir="rtl">

    <div class="contract-container">

        <div class="receipt position-relative" dir="rtl">
            <div class="d-flex" style="border-bottom: 3px solid #0282fa; padding-bottom: 0">
                <div class="col">
                    <div class="d-grid text-center">
                        <h4 class="card-title fw-bold text-primary" style="font-size: 20px; padding: 0">مخازن أيمن
                            الغماس </h4>
                        <p class="p-0" style="font-size: 12px">تخزين | تبريد | تجميد | شراع | بيع | تصدير
                            <small class="d-block">س ت: 123456789</small>
                            <b class="text-primary fs-6">عقد تأجير مساحات تخزينية</b>
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
                            <small class="d-block">CR: 123456789</small>
                            <b class="text-primary fs-6">Store Spaces Rent Contract</b>
                        </p>

                    </div>
                </div>
            </div>


            <div class="text-right">
                <h4 class="d-block text-center"> عقد تأجير طبالى </h4>
                بعون الله وتوفيقه، فى يوم
                <b>{{ $contract->in_day_greg }}</b>
                م، الموافق
                <b>{{ $contract->in_day_hij }}</b>
                ، قد اجتمع كل من:-<br>
                <ol class="my-0" style="list-style-type: auto; padding: 1em 1.5em 0">
                    <li>
                        شركة <b>{{ 'مخازن أيمن الغماس ' }}</b> سجل تجاري <b>{{ $client->cr }}</b> ،
                        ويمثلها
                        المدير العام <b>{{ $contractor->name }}</b>
                        وعنوانه الوطنى: <b>{{ $company->state }} - {{ $company->city }} -
                            {{ $company->street }}.</b>، هاتف جوال: <b>{{ $company->phone }}</b>
                        ، بريد الكتروني: <b>{{ 'admin@ag-stores.com' }}</b> <span class="party float-left">طرف
                            أول.</span>
                    </li>
                    <li>شركة
                        <b>{{ $client->name }}</b>
                        ويمثلها السيد:
                        <b class="clientName">{{ $client->person ? $client->person : $client->name }}</b>، سجل تجاري:
                        <b class="clientCR">{{ $client->cr }}</b>
                        هاتف:
                        <b class="clientCR">{{ $client->phone }}</b> وعنوانه:
                        <b class="clientCR">{{ $client->address }}</b>
                    </li>
                    <p>
                        حيث أن الطرف الأول لديه مخازن تبريد وتجميد ويعمب فى مجا لالتخزين بخدماته ومرخص
                        له
                        بمزاولة المهنة بموجب الترخيص رقم (41063418526) وحيث أن الطرف الثانى يرغب فى
                        استئجار
                        (طبالى / غرف) لدى الطرف الأول، فقد اتفقا وهما بكامل أهليتهما الشرعية المعتبرة
                        للتوقيع
                        على هذا العقد فيما يلى:-
                    </p>


                    <ol class="my-0" style="list-style-type: auto; padding: 0 1.5em 1em">
                        <li class="px-3 bg-light my-0">تعتبر المقدمة والتمهيد أعلاه جزءًا لا يتجزأ من العقد
                            ويجب
                            تفسيره وتطبيقه على هذا الأساس.</li>
                        {{-- {{ var_dump() }} --}}
                        <li> أصناف العقد
                            <table class="w-100">
                                <tr>
                                    <td>#</td>
                                    <td>المادة</td>
                                    <td>وحدة القياس</td>
                                    <td>المدة</td>
                                    <td>الكمية</td>
                                    <td>سعر الوحدة</td>
                                    <td>الخصم </td>
                                    <td>الضريبة</td>
                                    <td>الاجمالى</td>
                                    <td></td>
                                </tr>
                                @if (count($contract->items))
                                    @foreach ($contract->items as $ii => $item)
                                        <tr>
                                            <td>{{ ++$ii }}</td>
                                            <td>{{ $itemsArr[$contract->items[$ii - 1]->item] }}</td>
                                            <td>{{ $unitsArr[$contract->items[$ii - 1]->unit] }}</td>
                                            <td>{{ $contract->start_period }}</td>
                                            <td>{{ $contract->items[$ii - 1]->qty }}</td>
                                            <td>{{ $contract->items[$ii - 1]->unit_price }}</td>
                                            <td>{{ $contract->items[$ii - 1]->discount }}</td>
                                            <td>{{ number_format(($contract->items[$ii - 1]->qty * $contract->items[$ii - 1]->unit_price * $contract->start_period - $contract->items[$ii - 1]->discount) * 0.15, 2) }}
                                            </td>
                                            <td>{{ number_format(($contract->items[$ii - 1]->qty * $contract->items[$ii - 1]->unit_price * $contract->start_period - $contract->items[$ii - 1]->discount) * 1.15, 2) }}
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </li>
                    </ol>
                    <li class="px-3 bg-light my-0">
                        مدة الإيجار 3 أشهر إلزامى، وبدخول أول يوم بالشهر التالى يتم التجديد تلقائيا إذا
                        رغب
                        الطرف الأول وبدون إشعار الطرف الثانى.
                    </li>
                    <li class="px-3 bg-light my-0">
                        يبدأ الإيجار فى تاريخ {{ $contract->starts_in_hij }} وينتهى فى
                        {{ $contract->ends_in_hij }}.
                    </li>
                    <li class="px-3 bg-light my-0">
                        يلتزم الطرف الثانى بدفع قيمة الايجار والالتزام بالسداد لقيمة الايجار الشهرية
                        مقدماً، ولا
                        يحق للطرف الثانى إخارج البضاعة قبل سداد كامل المستحقات للطرف الأول.
                    </li>
                    <li class="px-3 bg-light my-0">
                        بعد تقيع الطرف الثانى على العقد يكون ملزما بسداد كامل قيمة العقد حسب البند رقم
                        (3) حتى
                        وإن لم يتم توريد البضاعة كلياً أو جزئياً، أو أنه قد تم تخزين البضاعة لمدة أقل
                        منالمدة
                        المتفق عليها.
                    </li>
                    <li class="px-3 bg-light my-0">
                        يتم سدسد مقدم حسب البند رقم (5) وفى حالة تأخر السداد لمدة شهر؛ يحق للطرف الأول
                        بيع
                        الكمية المخزنة لديه أو جزء منها واستيفاء مبلغ الإيجار المستحق على الطرف الثانى.
                    </li>
                    <li class="px-3 bg-light my-0">
                        الطرف الأول (المؤجر) مسئول مسئولية كاملة عن الكميات المخزنة ومسئول عن توفير
                        الكهرباء
                        وعدم توقف أجهزة التبريد.
                    </li>
                    <li class="px-3 bg-light my-0">
                        الطرف الأول غير مسئول عن البضاعة فى حالة الكوارث الطبيعية لا سمح الله.
                    </li>
                    <li class="px-3 bg-light my-0">
                        إخراج البضاعة من الغرف يكون بحضور الطرف الثانى أو مندوبه المسجل بالعقد أو عن
                        طريق إشعار
                        برسالة نصية أو رسالة واتساب يتم إرسالها عن طريق الرقم المسجل من الجوال المدون
                        ببيانات
                        الطرف الثانى إلى احد الهواتف المبينه فى عنوان الطرف الاول بالعقد، على أن يكون
                        التبليغ
                        قبد الإخراج بيومين على الاقل حتى لا تؤثر الصدمات الحرارية على جودة البضاعة.
                    </li>
                    <li class="px-3 bg-light my-0">
                        في حالة قرب تاريخ الانتهاء المدون على المنتج للموجودات داخل الثلاجة فإن الطرف
                        الثاني
                        (المستأجر) يلتزم بسحب الكمية واخلاء الثلاجة من المنتج وسداد المبالغ المستحقة
                        للطرف الأول
                        وفي حالة عدم السحب او السداد يتم تبليغ الجهات المعنية لاتلاف
                        البضاعة وهذا لا يسقط حق الطرف الأول في مطالبة الطرف الثاني بقيمة الايجار والطرف
                        الأول
                        غير مسؤول عن تاريخ المخزون
                    </li>
                    <li class="px-3 bg-light my-0">
                        يقوم الطرف الثاني بتوصيل الكميات المطلوب تخزينها الى موقع الثلاجات للطرف الاول.
                    </li>
                    <li class="px-3 bg-light my-0">
                        يلتزم الطرف الثاني بفرز المنتج قبل تعبئته واستبعاد كل ما هو تالف ويعبأ بأكياس
                        مخصصة
                        للتخزين والطرف الأول غير مسئولعن أي تلف للمنتج إذا كان هذا التلف ناتج عن سوء
                        التعبئة أو
                        المنتج نفسه.
                    </li>
                    <li class="px-3 bg-light my-0">
                        يلتزم الطرف الثاني بتوريد البضاعة في الصباح الباكر وبعد العصر تلافيا لتعرض
                        المنتج لصدمة
                        حرارية.
                    </li>
                    <li class="px-3 bg-light my-0">
                        يلتزم الطرف الأول بالمحافظة على منتجات الطرف الثاني حسب المتبع بالمواصفات الفنية
                        في
                        طريقة التخزين.
                    </li>
                    <li class="px-3 bg-light my-0">
                        الطرف الأول غير مسؤول عن المنتج وصلاحيته ورائحته ويخلي مسؤوليته تماما من تخزين
                        هذا
                        المنتج.
                    </li>
                    <li class="px-3 bg-light my-0">
                        أي خلافات تنشأ بين الطرفين في تفسير بنود العقد يتم التحكيم فيها بواسطة الجهات
                        المختصة أو
                        طرف يرضى تحكيمه الطرفان.
                    </li>

                </ol>

            </div>
            <div class="d-flex pt-4" style="">
                <div class="col">
                    <div class="d-grid text-right">
                        <h5 class="card-title text-primary" style="font-size: 18px; padding: 0"><b>طرف أول:
                            </b>مخازن أيمن الغماس </h5>
                        <b class="text-right">الاسم:</b><br>
                        <b class="text-right">التوقيع:</b><br>

                    </div>
                </div>
                <div class="col border-0">

                </div>
                <div class="col">
                    <div class="d-grid text-right">
                        <h5 class="card-title text-primary" style="font-size: 20px; padding: 0">
                            <b>طرف ثان:
                            </b> {{ $client->name }}
                        </h5>
                        <b class="text-right">الاسم:</b><br>
                        <b class="text-right">التوقيع:</b><br>

                    </div>
                </div>
            </div>
        </div>
        <div class="buttons">
            <button class="btn btn-outline-primary" onclick="window.location='{{ route('contracts.home') }}'">
                العودة للعقود
            </button>

            <button class="btn btn-outline-primary"
                onclick="window.location='{{ route('contract.view', [$contract->id, 1]) }}'">عرص العقد</button>
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>تهانينا!</strong> {{ Session::get('success') }}.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>تنبيه!</strong> {{ Session::get('error') }}.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (Session::has('warning'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>تحذير!</strong> {{ Session::get('warning') }}.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>







    {{-- <script>
            let buttons = document.querySelectorAll('nav div button');
            buttons.forEach(element => {
                element.addEventListener('click', function() {
                    document.querySelector('nav button.active').classList.remove('active');
                    this.classList.add('active')
                    document.querySelector('.tab-pane.active').classList.remove('show')
                    document.querySelector('.tab-pane.active').classList.remove('active')
                    document.querySelector(this.getAttribute('data-bs-target')).classList.add('active');
                    document.querySelector(this.getAttribute('data-bs-target')).classList.add('show');
                })
            });
        </script> --}}

    {{-- The container --}}
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

</body>

</html>
