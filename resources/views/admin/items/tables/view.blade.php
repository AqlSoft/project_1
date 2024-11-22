@extends('layouts.admin')
@section('title')
    الطبالي
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    الطبالي
@endsection
@section('homeLinkActive')
    عرض بيانات طبلية
@endsection

@section('content')
    <style type="text/css">
        .h3 {
            font: Bold 1.1em/1.3 "Cairo SemiBold";
            color: #2e6da4;
        }

        table tr td:nth-child(2) {
            border-left: 1px solid #777 !important;
        }

        table tr:first-child td:last-child {
            border-left: 0;
            border-right: 2px solid #777
        }
    </style>

    <div class="container">
        <div class="buttons">
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('tables.stats') }}"> <i
                        class="fa fa-chart-line"></i> احصائيات
                </a></button>
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('tables.home') }}"> <i
                        class="fa fa-list"></i>
                    الطبالى</button>
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a
                    href="{{ route('table.edit', [$table->id]) }}">
                    <i class="fa fa-edit"></i>
                    تعديل</a></button>
            <button type="button" class="btn btn-sm px-2 btn-success"><a>
                    <i class="fa fa-eye"></i>
                    عرض</a></button>
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('table.create') }}"> <i
                        class="fa fa-plus"></i>
                    إضافة </a></button>
        </div>



        <fieldset class="mb-5">
            <legend>عرض سجل العمليات على الطبلية</legend>

            <br>
            @php
                $credit = 0;
                $total_in = 0;
                $total_out = 0;
            @endphp
            <table class="w-100">
                <thead style="border-bottom: 2px solid #333">
                    <tr>
                        <th class="fw-bold" rowspan="2">#</th>
                        <th class="fw-bold" colspan="2">التسجيل</th>
                        <th class="fw-bold" colspan="2">الأصناف</th>
                        <th class="fw-bold" colspan="3">بيانات السند</th>
                        <th class="fw-bold" colspan="3">بيانات الكميات</th>
                    </tr>
                    <tr>
                        <th class="fw-bold">تاريخ</th>
                        <th class="fw-bold">بواسطة</th>
                        <th class="fw-bold">اسم</th>
                        <th class="fw-bold">حجم</th>
                        <th class="fw-bold">SN</th>
                        <th class="fw-bold">in/out</th>
                        <th class="fw-bold">العميل</th>
                        <th class="fw-bold">ادخال</th>
                        <th class="fw-bold">اخراج</th>
                        <th class="fw-bold">باق</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registry as $ie => $entry)
                        <tr>
                            <td class="fw-normal">{{ ++$ie }}</td>
                            <td class="fw-normal">{{ $entry->created_at }}</td>
                            <td class="fw-normal">{{ $entry->creator }}</td>
                            <td class="fw-normal">{{ $entry->itemName }}</td>
                            <td class="fw-normal">{{ $entry->boxName }}</td>
                            <td class="fw-normal">{{ $entry->type == 1 ? 'In' : 'Out' }}</td>
                            <td class="fw-normal">{{ $entry->receipt_sn }}</td>
                            <td class="fw-normal">{{ $entry->clientName }}</td>
                            <td class="fw-normal">{{ $entry->inputs ? $entry->inputs : '0' }}</td>
                            <td class="fw-normal">{{ $entry->outputs ? $entry->outputs : '0' }}</td>
                            @php
                                if ($entry->type == 1) {
                                    $credit += $entry->inputs;
                                    $total_in += $entry->inputs;
                                } else {
                                    $credit -= $entry->outputs;
                                    $total_out += $entry->outputs;
                                }
                            @endphp
                            <td class="fw-normal" style="{{ $credit < 0 ? 'background-color:#f003; color: #f55' : '' }}">
                                {{ $credit }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot style="border-top: 2px solid #333">
                    <tr class="">
                        <th class="fw-bold" colspan="8">الرصيد المتبقى</th>
                        <th class="fw-bold">{{ $total_in }}</th>
                        <th class="fw-bold">{{ $total_out }}</th>
                        <th class="fw-bold">{{ $load = $total_in - $total_out }}</th>
                    </tr>
                </tfoot>
            </table>
        </fieldset>

        <fieldset class="mb-5">
            <legend> بيانات الطبلية </legend>
            <br>
            <table class="w-100">
                <tr>
                    <th>رقم الطبلية:</th>
                    <td>{{ $table->name }}</td>
                    <td rowspan="12"><img src="{{ asset('assets\admin\uploads\images\transactions.webp') }}"
                            alt="" width="400"></td>
                </tr>
                <tr>
                    <th>الرقم المسلسل:</th>
                    <td>{{ $table->serial }}</td>
                </tr>
                <tr>
                    <th>الحالة</th>
                    <td>{{ $load == 0 ? 'فارغة' : 'بها بضاعة' }}</td>
                </tr>
                <tr>
                    <th>العميل:</th>
                    <td class="fw-normal">{{ $table->clientName }}</td>
                </tr>
                <tr>
                    <th>العقد:</th>
                    <td>{{ $table->contract ? $table->contract->s_number : 'غير مرتبطة' }}</td>
                </tr>
                <tr>
                    <th>الحمولة:</th>
                    <td class="fw-bold">{{ $total_in - $total_out }}</td>
                </tr>

            </table>
        </fieldset>
    </div>
@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection
