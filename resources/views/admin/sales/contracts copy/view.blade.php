@extends('layouts.admin')
@section('title')
    العقود
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    العقود
@endsection
@section('homeLinkActive')
    عرض تفاصيل العقد
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('contracts.home') }}"><span class="btn-title">Go Home</span><i
                class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('contract.print', [$contract->id]) }}"><i
                class="fa fa-print fa-fw" title="طباعة العقد"></i></a></button>
    @if ($contract->status)
        <button class="btn btn-sm btn-primary">
            <a>
                <form id="park" action="{{ route('contract.park') }}" method="post"> @csrf
                    <input type="hidden" name="id" value="{{ $contract->id }}">
                    <span class="btn-title">إيقاف العقد للتعديل</span>
                    <i class="fa fa-box-open text-light" onclick=""></i>
                </form>
            </a>
        </button>
    @else
        <button class="btn btn-sm btn-primary">
            <a>
                <form id="approve" action="{{ route('contract.approve') }}" method="post"> @csrf
                    <input type="hidden" name="id" value="{{ $contract->id }}">
                    <span class="btn-title">اعتماد العقد</span>
                    <i class="fa fa-check text-light" onclick="$('#approve').submit()"></i>
                </form>
            </a>
        </button>
    @endif
    <button class="btn btn-sm btn-primary"><a href="{{ route('contracts.setting') }}"><span
                class="btn-title">Settings</span><i class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')
    <div class="container pt-4">
        <div class="border p-3">

            <fieldset dir="rtl" class="m-3">
                <legend style="right: 20px; left: auto"> بيانات العقد
                    <a href="{{ route('contract.edit', [$contract->id, 1]) }}"><i class="fa fa-edit"></i></a>
                </legend>
                <br>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                        <button class="nav-link {{ $tab == 1 ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true"> <a href="{{ route('contract.view', [$contract->id, 1]) }}">العقد</a>
                        </button>
                        <button class="nav-link {{ $tab == 2 ? 'active' : '' }}" id="nav-profile-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false">
                            <a href="{{ route('contract.view', [$contract->id, 2]) }}">السندات</a>
                        </button>
                        <button class="nav-link {{ $tab == 3 ? 'active' : '' }}" id="nav-contact-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                            aria-selected="false">
                            <a href="{{ route('contract.view', [$contract->id, 3]) }}">تقارير الأصناف</a>
                        </button>
                        <button class="nav-link {{ $tab == 4 ? 'active' : '' }}" id="nav-disabled-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-disabled" type="button" role="tab" aria-controls="nav-disabled"
                            aria-selected="false">
                            <a href="{{ route('contract.view', [$contract->id, 4]) }}">تقارير الطبليات</a>
                        </button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent" style="">
                    <div class="tab-pane fade {{ $tab == 1 ? 'show active' : '' }}" id="nav-home" role="tabpanel"
                        aria-labelledby="nav-home-tab" tabindex="0">
                        <div class="text-right">
                            <h4 class="d-block text-center"> عقد تأجير طبالى </h4>
                            بعون الله وتوفيقه، فى يوم
                            <b>{{ $contract->in_day_greg }}</b>
                            م، الموافق
                            <b>{{ $contract->in_day_hij }}</b>
                            ، قد اجتمع كل من:-<br>
                            <ol class="my-0" style="list-style-type: auto; padding: 1em 1.5em 0">
                                <li>
                                    شركة <b>{{ $company->company }}</b> سجل تجاري <b>{{ $company->cr }}</b> ، ويمثلها
                                    المدير العام <b>{{ $contractor->name }}</b>
                                    وعنوانه الوطنى: <b>{{ $company->state }} - {{ $company->city }} -
                                        {{ $company->street }}.</b>، هاتف جوال: <b>{{ $company->phone }}</b>
                                    ، بريد الكتروني: <b>{{ $company->email }}</b> <span class="party float-left">طرف
                                        أول.</span>
                                </li>
                                <li>
                                    <b>{{ $client->name }}</b>
                                    ويمثلها:
                                    <b class="clientName">{{ $client->person }}</b>، سجل تجاري: <b
                                        class="clientCR">{{ $client->cr }}</b>
                                </li>
                                <p>
                                    حيث أن الطرف الأول لديه مخازن تبريد وتجميد ويعمب فى مجا لالتخزين بخدماته ومرخص له
                                    بمزاولة المهنة بموجب الترخيص رقم (41063418526) وحيث أن الطرف الثانى يرغب فى استئجار
                                    (طبالى / غرف) لدى الطرف الأول، فقد اتفقا وهما بكامل أهليتهما الشرعية المعتبرة للتوقيع
                                    على هذا العقد فيما يلى:-
                                </p>

                            </ol>
                            <ol class="my-0" style="list-style-type: auto; padding: 0 1.5em 1em">
                                <li class="px-3 bg-light my-0">تعتبر المقدمة والتمهيد أعلاه جزءًا لا يتجزأ من العقد ويجب
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
                                <li class="px-3 bg-light my-0">
                                    مدة الإيجار 3 أشهر غلزامى، وبدخول أول يوم بالشهر التالى يتم التجديد تلقائيا إذا رغب
                                    الطرف الأول وبدون إشعار الطرف الثانى.
                                </li>
                                <li class="px-3 bg-light my-0">
                                    يبدأ الإيجار فى تاريخ {{ $contract->starts_in_hij }} وينتهى فى
                                    {{ $contract->ends_in_hij }}.
                                </li>
                                <li class="px-3 bg-light my-0">
                                    يلتزم الطرف الثانى بدفع قيمة الايجار والالتزام بالسداد لقيمة الايجار الشهرية مقدماً، ولا
                                    يحق للطرف الثانى إخارج البضاعة قبل سداد كامل المستحقات للطرف الأول.
                                </li>
                                <li class="px-3 bg-light my-0">
                                    بعد تقيع الطرف الثانى على العقد يكون ملزما بسداد كامل قيمة العقد حسب البند رقم (3) حتى
                                    وإن لم يتم توريد البضاعة كلياً أو جزئياً، أو أنه قد تم تخزين البضاعة لمدة أقل منالمدة
                                    المتفق عليها.
                                </li>
                                <li class="px-3 bg-light my-0">
                                    يتم سدسد مقدم حسب البند رقم (5) وفى حالة تأخر السداد لمدة شهر؛ يحق للطرف الأول بيع
                                    الكمية المخزنة لديه أو جزء منها واستيفاء مبلغ الإيجار المستحق على الطرف الثانى.
                                </li>
                                <li class="px-3 bg-light my-0">
                                    الطرف الأول (المؤجر) مسئول مسئولية كاملة عن الكميات المخزنة ومسئول عن توفير الكهرباء
                                    وعدم توقف أجهزة التبريد.
                                </li>
                                <li class="px-3 bg-light my-0">
                                    الطرف الأول غير مسئول عن البضاعة فى حالة الكوارث الطبيعية لا سمح الله.
                                </li>
                                <li class="px-3 bg-light my-0">
                                    إخراج البضاعة من الغرف يكون بحضور الطرف الثانى أو مندوبه المسجل بالعقد أو عن طريق إشعار
                                    برسالة نصية أو رسالة واتساب يتم إرسالها عن طريق الرقم المسجل من الجوال المدون ببيانات
                                    الطرف الثانى إلى احد الهواتف المبينه فى عنوان الطرف الاول بالعقد، على أن يكون التبليغ
                                    قبد الإخراج بيومين على الاقل حتى لا تؤثر الصدمات الحرارية على جودة البضاعة.
                                </li>
                                <li class="px-3 bg-light my-0">
                                    في حالة قرب تاريخ الانتهاء المدون على المنتج للموجودات داخل الثلاجة فإن الطرف الثاني
                                    (المستأجر) يلتزم بسحب الكمية واخلاء الثلاجة من المنتج وسداد المبالغ المستحقة للطرف الأول
                                    وفي حالة عدم السحب او السداد يتم تبليغ الجهات المعنية لاتلاف
                                    البضاعة وهذا لا يسقط حق الطرف الأول في مطالبة الطرف الثاني بقيمة الايجار والطرف الأول
                                    غير مسؤول عن تاريخ المخزون
                                </li>
                                <li class="px-3 bg-light my-0">
                                    يقوم الطرف الثاني بتوصيل الكميات المطلوب تخزينها الى موقع الثلاجات للطرف الاول.
                                </li>
                                <li class="px-3 bg-light my-0">
                                    يلتزم الطرف الثاني بفرز المنتج قبل تعبئته واستبعاد كل ما هو تالف ويعبأ بأكياس مخصصة
                                    للتخزين والطرف الأول غير مسئولعن أي تلف للمنتج إذا كان هذا التلف ناتج عن سوء التعبئة أو
                                    المنتج نفسه.
                                </li>
                                <li class="px-3 bg-light my-0">
                                    يلتزم الطرف الثاني بتوريد البضاعة في الصباح الباكر وبعد العصر تلافيا لتعرض المنتج لصدمة
                                    حرارية.
                                </li>
                                <li class="px-3 bg-light my-0">
                                    يلتزم الطرف الأول بالمحافظة على منتجات الطرف الثاني حسب المتبع بالمواصفات الفنية في
                                    طريقة التخزين.
                                </li>
                                <li class="px-3 bg-light my-0">
                                    الطرف الأول غير مسؤول عن المنتج وصلاحيته ورائحته ويخلي مسؤوليته تماما من تخزين هذا
                                    المنتج.
                                </li>
                                <li class="px-3 bg-light my-0">
                                    أي خلافات تنشأ بين الطرفين في تفسير بنود العقد يتم التحكيم فيها بواسطة الجهات المختصة أو
                                    طرف يرضى تحكيمه الطرفان.
                                </li>

                            </ol>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $tab == 2 ? 'show active' : '' }}" id="nav-profile" role="tabpanel"
                        aria-labelledby="nav-profile-tab" tabindex="1">
                        <h4 class=""> السندات التابعة للعقد </h4>
                        <form action="{{ route('contract.additems') }}">
                            @csrf
                            <input type="hidden" name="contract" value="{{ $contract->id }}">

                            <table class="w-100">
                                <tr>
                                    <td>#</td>
                                    <td> مسلسل </td>
                                    <td> نوع السند </td>
                                    <td> تاريخ الادخال </td>
                                    <td> السائق </td>
                                    <td> ملاحظات </td>
                                    <td> عمليات </td>
                                </tr>
                                @if (count($contract->inputs))
                                    @php $docNum = 0 @endphp
                                    @foreach ($contract->inputs as $ii => $item)
                                        <tr>
                                            <td>{{ ++$docNum }}</td>
                                            <td>{{ $item->s_number }}</td>
                                            <td>{{ receiptType($item->type) }}</td>
                                            <td>{{ $item->hij_date }}</td>
                                            <td>{{ $item->driver }}</td>
                                            <td>{{ $item->notes }}</td>
                                            <td>
                                                <a href="{{ route('receipts.input.view', [$item->id]) }}"><i
                                                        class="text-primary fas fa-eye"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </form>
                    </div>
                    <div class="tab-pane fade {{ $tab == 3 ? 'show active' : '' }}" id="nav-contact" role="tabpanel"
                        aria-labelledby="nav-contact-tab" tabindex="1">

                        <h4 class=""> تفاصيل الأصناف وأحجام الكرتون </h4>
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الصنف</th>
                                    <th>المدخلات</th>
                                    <th>المخرجات</th>
                                    <th>الاجمالى</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($itemsInArr)
                                    @php
                                        $totalIn = 0;
                                        $totalOut = 0;

                                    @endphp
                                    @foreach ($itemsInArr as $in => $item)
                                        <tr>
                                            <td>#</td>
                                            <td class="text-right">{{ $item->item_name }}</td>
                                            <td class="text-right">{{ $tqin = $item->total_qty }}</td>
                                            @php $totalIn += $tqin @endphp
                                            <td class="text-right">
                                                @php $tqout = 0 @endphp
                                                @foreach ($itemsOutArr as $ou => $oi)
                                                    @if ($oi->item_id == $item->item_id)
                                                        @php $tqout = $oi->total_qty @endphp
                                                    @endif
                                                @endforeach
                                                {{ $tqout }}
                                                @php $totalOut += $tqout @endphp
                                            </td>
                                            <td>{{ $tqin - $tqout }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <th colspan="2">الاجمالى</th>
                                <th>{{ isset($totalIn) ? $totalIn : 0 }}</th>
                                <th>{{ isset($totalOut) ? $totalOut : 0 }}</th>
                                <th>{{ isset($totalIn) ? $totalIn - $totalOut : 0 }}</th>
                            </tfoot>
                        </table>

                    </div>
                    <div class="tab-pane fade {{ $tab == 4 ? 'show active' : '' }}" id="nav-disabled" role="tabpanel"
                        aria-labelledby="nav-disabled-tab" tabindex="1">
                        <h4 class="">
                            تفاصيل الطبليات أعداد وحمولة </h4>

                        <table class="w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>رقم الطبلية</th>
                                    <th>الحجم</th>
                                    <th>الأصناف</th>
                                    <th>الكمية المدخلة</th>
                                    <th>الكمية المخرجة</th>
                                    <th>الكمية المتبقية</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tablesInArr)
                                    @php
                                        $totalIn = 0;
                                        $totalOut = 0;
                                        $indexOfTables = 0;
                                    @endphp
                                    @foreach ($tablesInArr as $in => $table)
                                        <tr>
                                            <td>{{ ++$indexOfTables }}</td>
                                            <td class="text-right">{{ $table['in']->table_name }}</td>
                                            <td class="text-right">{{ $table['in']->table_size == 1 ? 'صغيرة' : 'كبيرة' }}
                                            </td>
                                            <td class="text-right">{{ $table['in']->item_name }}</td>
                                            <td class="text-right">{{ $in = $table['in']->total_qty }}</td>
                                            @php $totalIn += $in @endphp
                                            <td class="text-right">{{ $out = $table['out'] == null ? 0 : $table['out'] }}
                                            </td>@php $totalOut += $out @endphp
                                            <td class="text-right">{{ $total = $in - $out }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                <th colspan="4">الاجمالى</th>
                                <th>{{ isset($totalIn) ? $totalIn : 0 }}</th>
                                <th>{{ isset($totalOut) ? $totalOut : 0 }}</th>
                                <th>{{ isset($totalIn) ? $totalIn - $totalOut : 0 }}</th>
                                </tr>
                                <th colspan="4">
                                اجمالى عدد الطبالى
                                </th>
                                <th>{{ count($tablesInArr) }}</th>
                                <th>{{ isset($totalOut) ? $totalOut : 0 }}</th>
                                <th>{{ isset($totalIn) ? $totalIn - $totalOut : 0 }}</th>
                                <tr>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </fieldset>
            
            {{$inputs->links()}}
        </div>
    </div>
@endsection


@section('script')
    <script>
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
    </script>
    <script src="{{ asset('resources\js\datatablesar.js') }}"></script>
@endsection
