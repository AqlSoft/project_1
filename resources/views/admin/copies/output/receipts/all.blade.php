@extends('layouts.admin')

@section('title')
    عرض سندات الإخراج
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    السندات / سندات الإخراج
@endsection
@section('homeLinkActive')
    عرض سندات الإخراج
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('receipts.output.create', 1) }}"><span class="btn-title">إضافة
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
        <div class="search">


            <div class="row">
                <div id="pageTitle" class="col col-4 ">
                    عرض سندات الإخراج
                </div>
                <div class="col col-8">
                    <div class="input-group">
                        <label for="aj_search" class="input-group-text"><i class="fa fa-search"></i></label>
                        <input type="text" data-search-token="{{ csrf_token() }}"
                            data-search-url="{{ route('receipts.search_output_receipts') }}" class="form-control"
                            name="search" id="aj_search" placeholder="ابحث عن سند بالرقم المسلسل"
                            data-tab="{{ $type }}">
                    </div>
                </div>
            </div>

        </div>



        <div id="receipts_data">
            <fieldset class="my-4 py-5">
                <legend class="p-0" style="background-clip: transparent; box-shadow: none">
                    <div class="legend-item d-inline-block {{ $type == 1 ? 'active' : '' }}" style="">
                        <a href="{{ route('receipts.output_receipts', [1]) }}"> سندات جارية </a>
                        <a data-bs-toggle="tooltip" data-bs-title="إضافة سند جديد"
                            href="{{ route('receipts.output.create', [1]) }}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="legend-item d-inline-block {{ $type == 2 ? 'active' : '' }}">
                        <a href="{{ route('receipts.output_receipts', [2]) }}"> سندات معتمدة </a>
                    </div>
                </legend>
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
                                            <a href="{{ route('receipts.editOutputReceipt', [$item->id]) }}"><i
                                                    class="fa fa-edit text-primary" data-bs-toggle="tooltip"
                                                    data-bs-title="تعديل بيانات السند"></i></a>

                                            <a class="displayReceipt" data-receipt-id="{{ $item->id }}"
                                                data-search-token="{{ csrf_token() }}"
                                                data-search-url="{{ route('receipts.displayReceiptInfo') }}"
                                                data-tab="1"><i class="fa fa-eye text-primary" data-bs-toggle="tooltip"
                                                    data-bs-title="عرض محتويات السند"></i></a>

                                            <a href="{{ route('output.entry.create', [$item->id, 0]) }}"><i
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
                                    <td colspan="5"> لا يوجد سندات قيد التشغيل</td>
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

                                            <a class="displayReceipt" data-receipt-id="{{ $item->id }}"
                                                data-search-token="{{ csrf_token() }}"
                                                data-search-url="{{ route('receipts.displayReceiptInfo') }}"
                                                data-tab="1"><i class="fa fa-eye text-primary" data-bs-toggle="tooltip"
                                                    data-bs-title="عرض محتويات السند"></i></a>
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
                                    <td colspan="5"> لا يوجد سندات معتمدة حتى الان</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                @endif
            </fieldset>
            <div>
                {{ $receipts->links() }}
            </div>
        </div>

    </div>
    <div id="receitInfo">
        show
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

            $(document).on('click', '.displayReceipt', function(e) {
                e.preventDefault();
                let ajax_search_url = $(this).attr('data-search-url');
                let ajax_search_token = $(this).attr('data-search-token');
                let ajax_search_id = $(this).attr('data-receipt-id');
                let ajax_search_tab = $(this).attr('data-tab');

                console.log(ajax_search_token);
                jQuery.ajax({
                    url: ajax_search_url,
                    type: 'post',
                    dataType: 'html',
                    data: {
                        id: ajax_search_id,
                        '_token': ajax_search_token,
                        tab: ajax_search_tab
                    },
                    cash: false,
                    success: function(data) {
                        //console.log(data)
                        $('#receitInfo').html(data);
                        $('#receitInfo').addClass('show');

                    },
                    error: function() {

                    }
                });
            });

        });
    </script>
@endsection
