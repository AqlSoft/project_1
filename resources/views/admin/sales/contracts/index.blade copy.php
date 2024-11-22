@extends('layouts.admin')
@section('title')
    الحركات
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    الحركات
@endsection
@section('homeLinkActive')
    الصفحة الرئيسية
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('item.create') }}"><span class="btn-title">إضافة صنف خدمى</span><i
                class="fa fa-tag text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.cats.create', 0) }}"><span class="btn-title">إضافة تصنيف
                مبيعات</span><i class="fa fa-tags text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('contract.create', 0) }}"><span class="btn-title">إضافة عقد
                خدمات</span><i class="fa fa-plus text-light"></i></a></button>
@endsection
@section('content')
    <div class="container py-5">
        <div class="search">

            <div class="row mb-3">
                <div class="col col-5">
                    <div class="input-group">
                        <label for="aj_search" class="input-group-text"><i class="fa fa-search"></i></label>
                        <input type="text" data-search-token="{{ csrf_token() }}"
                            data-search-url="{{ route('contracts.search') }}" class="form-control" name="search"
                            id="aj_search">
                    </div>
                </div>
            </div>

        </div>
        <div id="contractsData">
            <table dir="rtl" id="data" class="" style="width:100%">
                <thead>
                    <tr>
                        <th>م</th>
                        <th>الرقم المسلسل</th>
                        <th>العميل</th>
                        <th>نوع العقد</th>
                        <th>الحالة</th>

                    </tr>
                </thead>
                <tbody>


                    @if (count($contracts))
                        @if (isset($contracts) && !empty($contracts))
                            @foreach ($contracts as $in => $contract)
                                <tr>
                                    <td>{{ ++$in }}</td>

                                    <td>{{ $contract->s_number }}</td>
                                    <td>{{ $contract->owner->name }}</td>
                                    <td>{{ $contract->contract_type }}</td>
                                    <td>
                                        <a href="{{ route('contract.view', [$contract->id, 1]) }}"><i
                                                class="fa fa-eye text-primary"></i></a>
                                        @if ($contract->status != 1)
                                            <a href="{{ route('contract.edit', [$contract->id, 1]) }}"><i
                                                    class="fa fa-edit text-primary"></i></a>
                                            <a href="{{ route('contract.delete', [$contract->id]) }}"><i
                                                    class="fa fa-trash text-danger"></i></a>
                                            <form style="display: inline" action="{{ route('contract.approve') }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $contract->id }}">
                                                <button style="display: inline; background: #0000; border: none;"
                                                    type="submit"><i class="text-success fas fa-check"
                                                        data-bs-toggle="tooltop" data-bs-title="اعتماد العقد"></i></button>
                                            </form>
                                        @else
                                            <a href="{{ route('contract.park', [$contract->id]) }}"><i
                                                    class="fa fa-parking text-info" title="إيقاف العقد للتعديل"></i></a>
                                            <a href="{{ route('receipts.input.create', [$contract->id]) }}"><i
                                                    class="fa fa-spinner fa-fw" title="إضافة سندات على العقد"></i></a>
                                            <a href="{{ route('contract.print', [$contract->id]) }}"><i
                                                    class="fa fa-print fa-fw" title="طباعة العقد"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @else
                        <tr>
                            <td colspan="5">No data to display</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{ $contracts->links() }}
        </div>

    </div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('input', '#aj_search', function() {
                let ajax_search_url = $('#aj_search').attr('data-search-url');
                let ajax_search_token = $('#aj_search').attr('data-search-token');
                let ajax_search_query = $('#aj_search').val();

                console.log(ajax_search_token);
                jQuery.ajax({
                    url: ajax_search_url,
                    type: 'post',
                    dataType: 'html',
                    data: {
                        search: ajax_search_query,
                        '_token': ajax_search_token,
                        ajax_search_url: ajax_search_url
                    },
                    cash: false,
                    success: function(data) {
                        $('#contractsData').html(data);
                    },
                    error: function() {

                    }
                });
            });

            $(document).on('click', '#links ul.pagination li a', function(e) {
                e.preventDefault();
                let ajax_search_url = $(this).attr('href');
                let ajax_search_token = $('#aj_search').attr('data-search-token');
                let ajax_search_query = $('#aj_search').val();

                console.log(ajax_search_token);
                jQuery.ajax({
                    url: ajax_search_url,
                    type: 'post',
                    dataType: 'html',
                    data: {
                        search: ajax_search_query,
                        '_token': ajax_search_token
                    },
                    cash: false,
                    success: function(data) {
                        $('#clients_data').html(data);
                    },
                    error: function() {

                    }
                });
            });

        });
    @endsection
