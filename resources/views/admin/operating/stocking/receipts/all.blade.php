@extends('layouts.admin')

@section('title')
    سندات الإدخال
@endsection

@section('pageHeading')
    عرض سندات الإدخال
@endsection


@section('content')

    <div class="container mb-5 pt-3">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link">
                    <a href="{{ route('stocking.home', [2]) }}">الرئيسية</a>
                </button>

                <button class="nav-link active">
                    <a>السندات </a> &nbsp;
                    <a href="{{ route('stocking.create', 0) }}"><i class="fa fa-plus"></i> </a>
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background-color: #fff">

            <div class="section-heading">

                <div class="search">
                    <div class="input-group">
                        <label for="aj_search" class="input-group-text"><i class="fa fa-search"></i></label>
                        <input type="text" data-search-token="{{ csrf_token() }}"
                            data-search-url="{{ route('stocking.search') }}" class="form-control" id="aj_search_by_number"
                            placeholder="ابحث بالرقم المسلسل">

                    </div>

                </div>
            </div>

            <div id="receipts_data">
                <table class="w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>رقم السند</th>
                            <th>التاريخ</th>
                            <th>الشرح</th>
                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($receipts))
                            @foreach ($receipts as $in => $item)
                                <tr>
                                    <td>{{ ++$in }}</td>
                                    <td>

                                        <a class="btn btn-sm displayReceipt btn-block p-1 mb-1 bg-secondary"
                                            data-receipt-id="{{ $item->id }}" data-search-token="{{ csrf_token() }}"
                                            data-search-url="{{ route('stocking.info') }}" data-tab="1"
                                            class="fa fa-eye text-primary" data-bs-toggle="tooltip"
                                            data-bs-title="عرض محتويات السند">{{ $item->s_number }}</a>

                                    </td>
                                    <td>
                                        {{ $item->greg_date }}
                                        <span class="btn btn-sm btn-block p-1 mb-1 bg-secondary">بواسطة:
                                            {{ $item->the_admin }}</span>
                                    </td>

                                    <td>
                                        {{ $item->brief }}
                                        {{ $item->notes }}
                                    </td>
                                    <td>

                                        <a href="{{ route('stocking.entries.create', [$item->id, 0]) }}"><i
                                                class="fa fa-sign-in-alt text-info" data-bs-toggle="tooltip"
                                                data-bs-title="عرض المحتويات"></i></a>

                                        <a href="{{ route('stocking.edit', [$item->id]) }}"><i
                                                class="fa fa-edit text-primary" data-bs-toggle="tooltip"
                                                data-bs-title="تعديل بيانات المحضر"></i></a>

                                        <a href="{{ route('stocking.print', [$item->id]) }}"><i
                                                class="fa fa-print text-primary px-1" data-bs-toggle="tooltip"
                                                data-bs-title="طباعة السند"></i></a>

                                        <a href="{{ route('stocking.destroy', [$item->id]) }}"
                                            onclick="if (!confirm('انت على وشك القيام بعملية لا يمكن الرجوع نها، هل أنت متأكد؟')) return false"><i
                                                class="fa fa-trash text-danger"data-bs-toggle="tooltip"
                                                data-bs-title="حذف السند"></i></a>



                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>

                                <td colspan="6"> لا يوجد سندات قيد التشغيل حتى الآن</td>

                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="my-3 ">
                    {{ $receipts->links() }}
                </div>
            </div>

        </div>
    </div>


    <div id="loader">
        <div class="loader"></div>
    </div>

    <div id="receitInfo">
        show
    </div>
    <div id="display-receipt" class="d-none">
        show
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#aj_search_by_number').focus();
            $('#aj_search_by_number').val(localStorage.getItem('input_search_by_number_value'));

            $(document).on('input', '#aj_search_by_number', function() {
                showLoader()
                let ajax_search_url = $('#aj_search_by_number').attr('data-search-url');
                let ajax_search_token = $('#aj_search_by_number').attr('data-search-token');
                let ajax_search_query = $('#aj_search_by_number').val();
                let ajax_search_tab = $('#aj_search_by_number').attr('data-tab');

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
                        removeLoader()
                        localStorage.setItem('input_search_by_number_value', ajax_search_query)
                        $('#receipts_data').html(data);
                    },
                    error: function() {
                        removeLoader()
                    }
                });
            });

            $(document).on('click', '#search ul.pagination li a', function(e) {
                e.preventDefault();
                showLoader()
                let ajax_search_url = $(this).attr('href');
                let ajax_search_token = $('#aj_search_by_number').attr('data-search-token');
                let ajax_search_query = $('#aj_search_by_number').val();
                let ajax_search_tab = $('#aj_search_by_number').attr('data-tab');


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
                        removeLoader()
                        $('#receipts_data').html(data);
                    },
                    error: function() {
                        removeLoader();
                        $('#receipts_data').html('حدث خطأ');
                    }
                });
            });

            $(document).on('click', '.displayReceipt', function(e) {
                e.preventDefault();
                showLoader()
                let ajax_search_url = $(this).attr('data-search-url');
                let ajax_search_token = $(this).attr('data-search-token');
                let ajax_search_id = $(this).attr('data-receipt-id');
                let ajax_search_tab = $(this).attr('data-tab');


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
                        removeLoader()
                        $('#receitInfo').html(data);
                        $('#receitInfo').addClass('show');

                    },
                    error: function() {
                        removeLoader()
                    }
                });
            });

            function showLoader() {
                $('#loader').css({
                    display: 'block'
                });
            }

            function removeLoader() {
                $('#loader').css({
                    display: 'none'
                });
            }
        });
    </script>
@endsection
