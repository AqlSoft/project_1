@extends('layouts.admin')

@section('title')
عناصر المخزن
@endsection

@section('pageHeading')
    الطبــــــالي
@endsection


@section('content')
    <div class="container">
        <div class="buttons">
            <button type=button class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('tables.stats') }}"> <i
                        class="fa fa-chart-line"></i> احصائيات
                </a></button>
            <button type=button class="btn btn-sm px-2 btn-success"> <i class="fa fa-list"></i>
                الطبالى</button>
            <button type=button class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('table.create') }}"> <i
                        class="fa fa-plus"></i>
                    إضافة </a></button>
        </div>

        <fieldset class="mb-5">
            <legend>جميع الطبالى</legend>
            <div class="search">
                <div class="row my-3">
                    <div class="col col-3">
                        <h4 class="text-right">بحث الطبالى</h4>
                    </div>
                    <div class="col col-6">
                        <div class="input-group">
                            <label for="aj_search" class="input-group-text"><i class="fa fa-card"></i>الرقم</label>
                            <input type="text" data-search-token="{{ csrf_token() }}"
                                data-search-url="{{ route('tables.search') }}" class="form-control" name="search"
                                id="aj_search">

                            <label for="size" class="input-group-text">الحجم</label>
                            <select name="" id="aj_size" class="form-control">
                                <option value="0">الكل</option>
                                <option value="1">صغيرة</option>
                                <option value="2">كبيرة</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div id="data_show">
                <table dir="rtl" style="width:100%; margin-top: 20px">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>مسلسل</th>
                            <th>رقم الطبلية</th>
                            <th>حجم الطبلية</th>
                            <th>السعة القصوى</th>
                            <th>التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = isset($_GET['page']) ? ($_GET['page'] - 1) * 10 : 0;
                        @endphp

                        @if (count($tables))
                            @foreach ($tables as $i => $table)
                                <tr>
                                    <td>{{ ++$counter }}</td>
                                    <td>{{ $table->serial }}</td>
                                    <td>{{ $table->name }}</td>
                                    <td>{{ $tableSizes[$table->size] }}</td>
                                    <td>{{ $table->capacity }}</td>
                                    <td>
                                        <button class="btn p-0" title="عرض بيانات الطبلية" data-bs-toggle="tooltip"><a
                                                href="{{ route('table.view', $table->id) }}"><i
                                                    class="fa fa-eye text-primary"></i></a></button>
                                        <button class="btn p-0" title="تعديل بيانات الطبلية" data-bs-toggle="tooltip">
                                            <a href="{{ route('table.edit', $table->id) }}"><i
                                                    class="fa fa-edit text-info"></i></a></button>
                                        <button class="btn p-0" title="حذف الطبلية بشكل نهائى" data-bs-toggle="tooltip"
                                            onclick="if(!confirm('انت على وشك القيام بعملية لا يمكن التراجع عنها، هل أنت متأكد؟'))return false"><a
                                                href="{{ route('table.delete', $table->id) }}">
                                                <i class="fa fa-trash text-danger"></i></a></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">لا يوجد طبالى مسجلة حتى الان</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <br>

                {{ $tables->links() }}
            </div>
        </fieldset>
    </div>
@endsection



@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('keyup', '#aj_search', function() {
                let ajax_search_url = $('#aj_search').attr('data-search-url');
                let ajax_search_token = $('#aj_search').attr('data-search-token');
                let ajax_search_query = $('#aj_search').val();


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
                        $('#data_show').html(data);
                    },
                    error: function() {

                    }
                });
            });


            $(document).on('change', '#aj_size', function() {
                let ajax_search_url = $('#aj_search').attr('data-search-url');
                let ajax_search_token = $('#aj_search').attr('data-search-token');
                let ajax_search_query = $('#aj_size').val();


                jQuery.ajax({
                    url: ajax_search_url,
                    type: 'post',
                    dataType: 'html',
                    data: {
                        size: ajax_search_query,
                        '_token': ajax_search_token,
                        ajax_search_url: ajax_search_url
                    },
                    cash: false,
                    success: function(data) {
                        console.log(data)
                        $('#data_show').html(data);
                    },
                    error: function() {

                    }
                });
            });

            $(document).on('click', '#search-links a.page-link', function(e) {
                e.preventDefault();

                let ajax_search_url = $('#aj_search').attr('data-search-url') + '?page=' + $(
                    '#search-links a.page-link').html();
                // $(this).attr('href').split('?')[0];
                let ajax_search_token = $('#aj_search').attr('data-search-token');
                let ajax_search_query = $('#aj_search').val();


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
                        $('#data_show').html(data);
                    },
                    error: function() {

                    }
                });
            });

        });
    </script>
@endsection
