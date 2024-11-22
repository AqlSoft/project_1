@extends('layouts.admin')

@section('title')
    سندات الترتيب
@endsection

@section('pageHeading')
    عرض سندات الترتيب
@endsection


@section('content')
    <div class="container pt-5">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link">
                    <a href="{{ route('operating.home', [2]) }}">الرئيسية</a>
                </button>
                <button class="nav-link {{ $tab == 1 ? 'active' : '' }}">
                    <a href="{{ route('arrange.home', [1]) }}">
                        السندات ( الجارية ) تحت الاجراء
                    </a>
                    <a data-bs-toggle="tooltip" data-bs-title="إضافة سند استلام جديد" class="btn btn-primary text-light"
                        href="{{ route('arrange.create', [0]) }}"><i class="fa fa-plus"></i></a>
                </button>
                <button class="nav-link  {{ $tab != 1 ? 'active' : '' }}">
                    <a href="{{ route('arrange.home', [2]) }}">السندات المعتمدة</a>
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background-color: #fff">
            <div class="section-heading">

                <div class="search">
                    <div class="input-group">
                        <label for="aj_search" class="input-group-text"><i class="fa fa-search"></i></label>
                        <input type="text" data-search-token="{{ csrf_token() }}"
                            data-search-url="{{ route('arrange.search') }}" class="form-control" id="aj_search_by_number"
                            placeholder="ابحث بالرقم المسلسل" data-tab="{{ $tab }}">
                        <input type="text" data-search-token="{{ csrf_token() }}"
                            data-search-url="{{ route('arrange.search') }}" class="form-control" id="aj_search_by_contract"
                            placeholder="ابحث برقم العقد" data-tab="{{ $tab }}">
                        <input type="text" data-search-token="{{ csrf_token() }}"
                            data-search-url="{{ route('arrange.search') }}" class="form-control" id="aj_search_by_client"
                            placeholder="ابحث باسم العميل" data-tab="{{ $tab }}">
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
                            <th>البيانات</th>
                            <th>حيثيات</th>
                            <th>ادخالات</th>
                            <th>اخراجات</th>
                            <th>تحكم</th>
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
                                            data-search-url="{{ route('arrange.info') }}" data-tab="1"
                                            class="fa fa-eye text-primary" data-bs-toggle="tooltip"
                                            data-bs-title="عرض محتويات السند">{{ $item->s_number }}</a>
                                        <span class="btn btn-sm btn-block p-1 mb-1 bg-secondary">بواسطة:
                                            {{ $item->admin_name }}</span>
                                    </td>
                                    <td>
                                        {{ $item->hij_date }}<br>
                                        {{ $item->greg_date }}

                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-block p-1 mb-1 bg-secondary"
                                            href="{{ route('contract.view', [$item->contract_id, 1]) }}"
                                            data-bs-toggle="tooltip" data-bs-title="رؤية العقد">العقد:
                                            {{ $item->the_contract }}</a>

                                        <a class="btn btn-sm btn-block p-1 bg-secondary"
                                            href="{{ route('clients.view', [$item->client_id]) }}" data-bs-toggle="tooltip"
                                            data-bs-title="رؤية العميل"> العميل:
                                            {{ $item->clientAName }}</a>
                                    </td>

                                    <td>
                                        السبب: {{ $item->reason }}<br>
                                        المندوب: {{ $item->contact }}
                                    </td>
                                    <td>{{ $item->total_inputs }}</td>
                                    <td>{{ $item->total_outputs }}</td>

                                    <td>
                                        @if ($tab != 2)
                                            <a href="{{ route('arrange.edit', [$item->id]) }}"><i
                                                    class="fa fa-edit text-primary" data-bs-toggle="tooltip"
                                                    data-bs-title="تعديل بيانات السند"></i></a>

                                            <a href="{{ route('arrange.approve', [$item->id]) }}"><i
                                                    class="fa fa-check text-success" data-bs-toggle="tooltip"
                                                    data-bs-title="اعتماد السند"></i></a>

                                            <a href="{{ route('arrange.entries.create', [$item->id, 0]) }}"><i
                                                    class="fa fa-sign-in-alt text-info" data-bs-toggle="tooltip"
                                                    data-bs-title="اختيار طبالي لترتيب كمياتها على السند"></i></a>

                                            <a href="{{ route('arrange.destroy', [$item->id]) }}"
                                                onclick="if (!confirm('انت على وشك القيام بعملية لا يمكن الرجوع عنها، هل أنت متأكد؟')) return false"><i
                                                    class="fa fa-trash text-danger"data-bs-toggle="tooltip"
                                                    data-bs-title="حذف السند"></i></a>
                                        @elseif ($tab == 2)
                                            <a href="{{ route('arrange.print', [$item->id]) }}"><i
                                                    class="fa fa-print text-primary" data-bs-toggle="tooltip"
                                                    data-bs-title="طباعة السند"></i></a>



                                            <a href="{{ route('arrange.park', [$item->id]) }}"><i
                                                    class="fa fa-ban text-info"data-bs-toggle="tooltip"
                                                    data-bs-title="إلغاء تفعيل السند"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6"> لا يوجد سندات
                                    {{ $tab == 2 ? 'معتمدة' : 'قيد التشغيل' }}
                                    حتى الآن.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="mt-3">
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
            $(document).on('input', '#aj_search_by_number', function() {
                let ajax_search_url = $('#aj_search_by_number').attr('data-search-url');
                let ajax_search_token = $('#aj_search_by_number').attr('data-search-token');
                let ajax_search_query = $('#aj_search_by_number').val();
                let ajax_search_tab = $('#aj_search_by_number').attr('data-tab');

                console.log(ajax_search_token);
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
                        // implement falure
                    }
                });
            });

            $(document).on('click', '#search ul.pagination li a', function(e) {
                e.preventDefault();
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
                        $('#receipts_data').html(data);
                    },
                    error: function() {
                        removeLoader()
                        // implement falure
                    }
                });
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
                    // implement falure
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
            })
        }
    </script>
@endsection
