@extends('layouts.admin')

@section('title')
    جميع السندات
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    السندات
@endsection
@section('homeLinkActive')
    الرئيسية
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('receipt.create', 0) }}"><span class="btn-title">إضافة
                سند</span><i class="fa fa-plus text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('clients.home') }}"><span class="btn-title">العودة إلى
                العملاء</span><i class="fa fa-home text-light"></i></a></button>
@endsection

@section('content')

    <style>
        legend>div {
            height: 40px;
            background-color: rgb(49, 51, 59);
            color: #eee;
            line-height: 28px;
            padding: 6px 12px
        }

        legend>div.active {
            background-color: rgb(15, 125, 228);
        }
    </style>
    <div class="container pt-3">
        <div id="clients_data">


            <fieldset class="my-5 py-5">
                <legend class="p-0" style="background-clip: transparent; box-shadow: none">
                    <div class="legend-item d-inline-block {{ $type == 1 ? 'active' : '' }}" style="">
                        <a href="{{ route('receipts.all', [1]) }}"> سندات الإستلام</a>
                        <a data-bs-toggle="tooltip" data-bs-title="إضافة سند جديد"
                            href="{{ route('receipts.input.create', 1) }}"><i class="fa fa-plus"></i></a>
                        <a data-bs-toggle="tooltip" data-bs-title="عرض كل السندات"
                            href="{{ route('receipts.input_receipts', [1]) }}"><i class="fa fa-layer-group"></i></a>

                    </div>
                    <div class="legend-item d-inline-block {{ $type == 2 ? 'active' : '' }}">
                        <a href="{{ route('receipts.all', [2]) }}">سندات الإخراج</a>
                        <a data-bs-toggle="tooltip" data-bs-title="إضافة سند جديد"
                            href="{{ route('receipts.output.create', 1) }}"><i class="fa fa-plus"></i></a>
                        <a data-bs-toggle="tooltip" data-bs-title="عرض كل السندات"
                            href="{{ route('receipts.output_receipts', [1]) }}"><i class="fa fa-layer-group"></i></a>

                    </div>
                    <div class="legend-item d-inline-block {{ $type == 3 ? 'active' : '' }}">
                        <a href="{{ route('receipts.all', [3]) }}">سندات الترتيب</a>
                        <a data-bs-toggle="tooltip" data-bs-title="إضافة سند جديد"
                            href="{{ route('receipts.createArrangeReceipt', 1) }}"><i class="fa fa-plus"></i></a>
                        <a data-bs-toggle="tooltip" data-bs-title="عرض كل السندات"
                            href="{{ route('receipts.arrange_receipts', [1]) }}"><i class="fa fa-layer-group"></i></a>

                    </div>

                </legend>
                {{-- السندات المعنمدة لعمليات استلام البضاعة --}}
                @if ($type == 1)

                    <table class="w-100">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>التاريخ</td>
                                <td>رقم السند</td>
                                <td>السائق</td>
                                <td>العقد</td>
                                <td>العميل</td>
                                <td>تحكم</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($receipts))
                                @foreach ($receipts as $in => $item)
                                    <tr>
                                        <td>{{ isset($_GET['page']) ? ++$in + ($_GET['page'] - 1) * 10 : ++$in }}</td>
                                        <td>{{ $item->hij_date }}</td>
                                        <td>{{ $item->s_number }}</td>
                                        <td>{{ $item->driver }}</td>
                                        <td>{{ $item->contractNumber }}</td>
                                        <td>{{ $item->clientName }}</td>
                                        <td>
                                            <a href="{{ route('receipts.input.print', [$item->id]) }}"><i
                                                    class="fa fa-print text-primary" data-bs-toggle="tooltip"
                                                    data-bs-title="طباعة السند"></i></a>

                                            <a href="{{ route('receipt.cancel', [$item->id, 0]) }}"><i
                                                    class="fa fa-ban text-info" data-bs-toggle="tooltip"
                                                    data-bs-title="إلغاء السند"></i></a>

                                            <a href="{{ route('receipt.destroy', [$item->id, 0]) }}"
                                                onclick="if(!confirm('سوف يتم حذف السند! هل أنت متأكد؟ هذه الحركة لا يمكن الرجوع عنها'))return false"><i
                                                    class="fa fa-trash text-danger"data-bs-toggle="tooltip"
                                                    data-bs-title="حذف السند"></i></a>
                                            <a href="{{ route('receipts.input.view', [$item->id, 0]) }}"><i
                                                    class="fa fa-eye text-primary"data-bs-toggle="tooltip"
                                                    data-bs-title="عرض السند"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5"> لم يتم اعتماد سنتدات بعد</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{-- السندات المعنمدة لعمليات إخراج البضاعة --}}
                @elseif($type == 2)
                    <table class="w-100">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>التاريخ</td>
                                <td>رقم السند</td>
                                <td>السائق</td>
                                <td>العقد</td>
                                <td>العميل</td>
                                <td>تحكم</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($receipts))
                                @foreach ($receipts as $in => $oitem)
                                    @if ($oitem->status == 1)
                                        <tr>
                                            <td>{{ ++$in }}</td>
                                            <td>{{ $oitem->hij_date }}</td>
                                            <td>{{ $oitem->s_number }}</td>
                                            <td>{{ $oitem->driver }}</td>
                                            <td>{{ $oitem->contract }}</td>
                                            <td>{{ $oitem->client }}</td>
                                            <td>
                                                <a href="{{ route('receipts.print_output_receipts', [$oitem->id]) }}"><i
                                                        class="fa fa-print text-primary" data-bs-toggle="tooltip"
                                                        data-bs-title="طباعة السند"></i></a>

                                                <a href="{{ route('receipt.cancel', [$oitem->id, 0]) }}"><i
                                                        class="fa fa-ban text-info" data-bs-toggle="tooltip"
                                                        data-bs-title="إلغاء السند"></i></a>

                                                <a href="{{ route('receipt.park', [$item->id]) }}"><i
                                                        class="fa fa-trash text-danger"data-bs-toggle="tooltip"
                                                        data-bs-title="إلغاء تفعيل السند"></i></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5"> لم يتم اعتماد سنتدات بعد</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    {{-- السندات المعنمدة لعمليات ترتيب الطبالى داخل المخازن --}}
                @elseif($type == 3)
                    <table class="w-100">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>التاريخ</td>
                                <td>رقم السند</td>
                                <td>السائق</td>
                                <td>العقد</td>
                                <td>العميل</td>
                                <td>تحكم</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($receipts))
                                @foreach ($receipts as $in => $aitem)
                                    @if ($aitem->status == 1)
                                        <tr>
                                            <td>{{ ++$in }}</td>
                                            <td>{{ $aitem->hij_date }}</td>
                                            <td>{{ $aitem->s_number }}</td>
                                            <td>{{ $aitem->driver }}</td>
                                            <td>{{ $aitem->contract }}</td>
                                            <td>{{ $aitem->client }}</td>
                                            <td>
                                                <a href="{{ route('receipts.print_arrange_receipts', [$aitem->id]) }}"><i
                                                        class="fa fa-print text-primary" data-bs-toggle="tooltip"
                                                        data-bs-title="طباعة السند"></i></a>

                                                <a href="{{ route('receipt.cancel', [$aitem->id, 0]) }}"><i
                                                        class="fa fa-ban text-info" data-bs-toggle="tooltip"
                                                        data-bs-title="إلغاء السند"></i></a>

                                                <a href="{{ route('receipt.destroy', [$aitem->id, 0]) }}"><i
                                                        class="fa fa-trash text-danger"data-bs-toggle="tooltip"
                                                        data-bs-title="حذف السند"></i></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5"> لم يتم اعتماد سنتدات بعد</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                @endif


            </fieldset>
        </div>
        <div>
            {{ $receipts->links() }}
        </div>
    </div>

@endsection
@section('script')
    <script></script>
@endsection
