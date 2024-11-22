@extends('layouts.admin')

@section('title')
    عرض سندات التسوية
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    السندات / سندات التسوية
@endsection
@section('homeLinkActive')
    عرض سندات التسوية
@endsection
@section('links')
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

        #pageTitle {
            border: 1px solid #777;
            height: 36px;
            background-color: rgb(15, 125, 228);
            padding: 4px 18px;
            border-radius: 12px;
            font: bold 18px / 1.5 Cairo;
            color: #fff;
            text-align: right;
        }
    </style>

    <div class="container pt-3">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">

                <button class="nav-link">
                    <a href="{{ route('operating.home', [2]) }}">الرئيسية</a>
                </button>
                <button class="nav-link active">
                    <a href="{{ route('operating.inventory.receipts', [1]) }}"> سندات جارية </a>
                    <a href="{{route('operating.inventory.create', [2])}}" data-bs-toggle="tooltip" data-bs-title="إضافة سند جديد"> <i class="fa fa-plus"></i></a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('operating.inventory.receipts', [2]) }}"> سندات معتمدة </a>
                </button>

            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background:#fff">


            <fieldset class="my-4 py-5">
                <legend>
                    عرض سندات التسوية
                </legend>
                <div class="section-heading">

                    <div class="search">
                        <div class="input-group">
                            <label for="aj_search" class="input-group-text"><i class="fa fa-search"></i></label>
                            <input type="text" data-search-token="{{ csrf_token() }}"
                                data-search-url="{{ route('reception.search') }}" class="form-control"
                                id="aj_search_by_number" placeholder="ابحث بالرقم المسلسل" data-tab="{{ $type }}">
                            <input type="text" data-search-token="{{ csrf_token() }}"
                                data-search-url="{{ route('reception.search') }}" class="form-control"
                                id="aj_search_by_contract" placeholder="ابحث برقم العقد" data-tab="{{ $type }}">
                            <input type="text" data-search-token="{{ csrf_token() }}"
                                data-search-url="{{ route('reception.search') }}" class="form-control"
                                id="aj_search_by_client" placeholder="ابحث باسم العميل" data-tab="{{ $type }}">
                        </div>
                    </div>
                </div>
                <br>
                <div id="receipts_data">
                    @if ($type != 2)
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
                                            <td>{{ ++$in }}</td>
                                            <td>{{ $item->hij_date }}</td>
                                            <td>{{ $item->s_number }}</td>
                                            <td>{{ $item->driver }}</td>
                                            <td>{{ $item->the_contract }}</td>
                                            <td><a
                                                    href="{{ route('clients.view', [$item->client_id]) }}">{{ $item->the_client }}</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('receipts.editInventoryReceipt', [$item->id]) }}"><i
                                                        class="fa fa-edit text-primary" data-bs-toggle="tooltip"
                                                        data-bs-title="تعديل بيانات السند"></i></a>

                                                <a href="{{ route('inventory.entry.create', [$item->id]) }}"><i
                                                        class="fa fa-sign-out-alt text-info" data-bs-toggle="tooltip"
                                                        data-bs-title="إخراج بضاعة بموجب السند"></i></a>

                                                <a href="{{ route('receipt.destroy', [$item->id]) }}"><i
                                                        class="fa fa-trash text-danger"data-bs-toggle="tooltip"
                                                        data-bs-title="حذف السند"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5"> لا يوجد سندات تسوية قيد التشغيل</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    @elseif ($type == 2)
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
                                            <td>{{ ++$in }}</td>
                                            <td>{{ $item->hij_date }}</td>
                                            <td>{{ $item->s_number }}</td>
                                            <td>{{ $item->driver }}</td>
                                            <td>{{ $item->the_contract }}</td>
                                            <td><a
                                                    href="{{ route('clients.view', [$item->client_id]) }}">{{ $item->the_client }}</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('receipts.output.view', [$item->id]) }}"><i
                                                        class="fa fa-eye text-primary px-1"data-bs-toggle="tooltip"
                                                        data-bs-title="عرض السند"></i></a>
                                                <a href="{{ route('receipts.output.print', [$item->id]) }}"><i
                                                        class="fa fa-print text-primary px-1" data-bs-toggle="tooltip"
                                                        data-bs-title="طباعة السند"></i></a>

                                                <a href="{{ route('receipt.park', [$item->id, 0]) }}"><i
                                                        class="fa fa-hourglass-end text-info px-1" data-bs-toggle="tooltip"
                                                        data-bs-title="إلغاء تفعيل السند"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5"> لا يوجد سندات تسوية معتمدة حتى الان</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    @endif
                    {{ $receipts->links() }}
                    <div>
            </fieldset>
        </div>
    </div>
    </div>


    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('input', '#aj_search', function() {
                let ajax_search_url = $('#aj_search').attr('data-search-url');
                let ajax_search_token = $('#aj_search').attr('data-search-token');
                let ajax_search_query = $('#aj_search').val();
                let ajax_search_tab = $('#aj_search').attr('data-tab');


                jQuery.ajax({
                    url: ajax_search_url,
                    type: 'post',
                    dataType: 'html',
                    data: {
                        search: ajax_search_query,
                        '_token': ajax_search_token,
                        ajax_search_url: ajax_search_url,
                        tab: ajax_search_tab
                    },
                    cash: false,
                    success: function(data) {
                        $('#receipts_data').html(data);
                    },
                    error: function() {

                    }
                });
            });

            $(document).on('click', '#search ul.pagination li a', function(e) {
                e.preventDefault();
                let ajax_search_url = $(this).attr('href');
                let ajax_search_token = $('#aj_search').attr('data-search-token');
                let ajax_search_query = $('#aj_search').val();
                let ajax_search_tab = $('#aj_search').attr('data-tab');

                console.log(ajax_search_token);
                jQuery.ajax({
                    url: ajax_search_url,
                    type: 'post',
                    dataType: 'html',
                    data: {
                        search: ajax_search_query,
                        '_token': ajax_search_token,
                        tab: ajax_search_tab
                    },
                    cash: false,
                    success: function(data) {
                        $('#receipts_data').html(data);
                    },
                    error: function() {

                    }
                });
            });

        });
    </script>
@endsection
