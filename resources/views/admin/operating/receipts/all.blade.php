@extends('layouts.admin')

@section('title')
    السندات
@endsection

@section('pageHeading')
    عرض جميع السندات
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

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link {{ $type == 1 ? 'active' : '' }}">
                    <a href="{{ route('receipts.all', [1]) }}"> استلام البضاعة </a>
                    <a data-bs-toggle="tooltip" data-bs-title="إضافة سند جديد" href="{{ route('reception.create', 1) }}"><i
                            class="fa fa-plus"></i></a>
                    <a data-bs-toggle="tooltip" data-bs-title="عرض كل السندات" href="{{ route('reception.home', [1]) }}"><i
                            class="fa fa-layer-group"></i></a>
                </button>
                <button class="nav-link {{ $type == 2 ? 'active' : '' }}">
                    <a href="{{ route('receipts.all', [2]) }}"> صرف البضاعة </a>
                    <a data-bs-toggle="tooltip" data-bs-title="إضافة سند جديد"
                        href="{{ route('receipts.output.create', 1) }}"><i class="fa fa-plus"></i></a>
                    <a data-bs-toggle="tooltip" data-bs-title="عرض كل السندات"
                        href="{{ route('receipts.output_receipts', [1]) }}"><i class="fa fa-layer-group"></i></a>
                </button>
                <button class="nav-link  {{ $type == 3 ? 'active' : '' }}">
                    <a href="{{ route('receipts.all', [3]) }}"> ترتيب الطبالى </a>
                    <a data-bs-toggle="tooltip" data-bs-title="إضافة سند جديد" href="{{ route('arrange.create', 1) }}"><i
                            class="fa fa-plus"></i></a>
                    <a data-bs-toggle="tooltip" data-bs-title="عرض كل السندات" href="{{ route('arrange.home', [1]) }}"><i
                            class="fa fa-layer-group"></i></a>
                </button>
                <button class="nav-link  {{ $type == 4 ? 'active' : '' }}">
                    <a href="{{ route('receipts.all', [4]) }}"> تسوية الطبالى </a>
                    <a data-bs-toggle="tooltip" data-bs-title="إضافة سند جديد" href="{{ route('arrange.create', 1) }}"><i
                            class="fa fa-plus"></i></a>
                    <a data-bs-toggle="tooltip" data-bs-title="عرض كل السندات" href="{{ route('arrange.home', [1]) }}"><i
                            class="fa fa-layer-group"></i></a>
                </button>
                <button class="nav-link  {{ $type == 5 ? 'active' : '' }}">
                    <a href="{{ route('receipts.all', [5]) }}"> ترتيب المخازن </a>
                    <a data-bs-toggle="tooltip" data-bs-title="إضافة سند جديد" href="{{ route('arrange.create', 1) }}"><i
                            class="fa fa-plus"></i></a>
                    <a data-bs-toggle="tooltip" data-bs-title="عرض كل السندات" href="{{ route('arrange.home', [1]) }}"><i
                            class="fa fa-layer-group"></i></a>
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background-color: #fff">

            <div id="clients_data">


                <fieldset class="my-5 py-5">
                    <legend>

                        جميع السندات
                    </legend>

                    <table class="w-100">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>التاريخ</td>
                                <td>رقم السند</td>
                                <td>تحكم</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($receipts))
                                @foreach ($receipts as $in => $item)
                                    <tr>
                                        <td>{{ isset($_GET['page']) ? ++$in + ($_GET['page'] - 1) * 10 : ++$in }}</td>
                                        <td>
                                            {{ $item->hij_date }} هـ <br>
                                            {{ $item->greg_date }} م
                                        </td>
                                        <td>
                                            رقم: {{ $item->s_number }} <br>
                                            بواسطة: {{ $item->the_admin }}
                                        </td>

                                        <td>
                                            <a href="{{ route('reception.print', [$item->id]) }}"><i
                                                    class="fa fa-print text-primary" data-bs-toggle="tooltip"
                                                    data-bs-title="طباعة السند"></i></a>

                                            <a href="{{ route('reception.park', [$item->id, 0]) }}"><i
                                                    class="fa fa-ban text-info" data-bs-toggle="tooltip"
                                                    data-bs-title="إلغاء السند"></i></a>

                                            <a href="{{ route('reception.destroy', [$item->id, 0]) }}"
                                                onclick="if(!confirm('سوف يتم حذف السند! هل أنت متأكد؟ هذه الحركة لا يمكن الرجوع عنها'))return false"><i
                                                    class="fa fa-trash text-danger"data-bs-toggle="tooltip"
                                                    data-bs-title="حذف السند"></i></a>
                                            <a href="{{ route('reception.view', [$item->id, 0]) }}"><i
                                                    class="fa fa-eye text-primary"data-bs-toggle="tooltip"
                                                    data-bs-title="عرض السند"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5"> لم يتم اعتماد سندات بعد</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $receipts->links() }}
                </fieldset>
            </div>
            <div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script></script>
@endsection
