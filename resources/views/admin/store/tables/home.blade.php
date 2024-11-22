@extends('layouts.admin')
@section('title')
    hhh
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    التخزين
@endsection
@section('homeLinkActive')
    الرئيسية
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('tables.create') }}"><span class="btn-title">إضافة وحدات
                تخزينية</span><i class="fa fa-plus text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('store.settings') }}"><span class="btn-title">ضبط المخازن</span><i
                class="fa fa-home text-light"></i></a></button>
@endsection
@section('content')

    <div class="container">
        <div class="search">
            <form method="POST">
                <div class="row mb-3">
                    <div class="col col-5">
                        <div class="input-group">
                            <label for="aj_search" class="input-group-text"><i class="fa fa-search"></i></label>
                            <input type="text" data-search-token="{{ csrf_token() }}"
                                data-search-url="{{ route('treasuries.aj') }}" class="form-control" name="search"
                                id="aj_search">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="data_show">
            <div class="row">
                <div class="col col-4 border">

                </div>
            </div>
            <table dir="rtl" id="data" style="width:100%">
                <thead>
                    <tr>
                        <th>مسلسل</th>
                        <th>رقم الطبلية</th>
                        <th>حجم الطبلية</th>
                        <th>السعة</th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>

                    @php $i = 1 @endphp
                    @if (count($tables))
                        @if (isset($tables) && !empty($tables))
                            @foreach ($tables as $table)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $table->name }}</td>
                                    <td>{{ $tableSizes[$table->size] }}</td>
                                    <td>{{ $table->capacity }}</td>
                                    <td>
                                        اه
                                        <button class="btn p-0"><a href="/admin/sales/cats/view/{{ $table->id }}"><span
                                                    class="btn-title"> عرض محتويات الطبلية {{ $table->name }}</span><i
                                                    class="fa fa-eye text-primary"></i></a></button>
                                        <button class="btn p-0"><a href="/admin/sales/cats/edit/{{ $table->id }}"><span
                                                    class="btn-title"> تعديل بيانات الطبلية {{ $table->name }}</span><i
                                                    class="fa fa-edit text-info"></i></a></button>
                                        <button class="btn p-0"><a
                                                href="/admin/sales/cats/delete/{{ $table->id }}"><span
                                                    class="btn-title"> حذف الطبلية بشكل نهائى {{ $table->name }}</span><i
                                                    class="fa fa-trash text-danger"></i></a></button>

                                    </td>
                                </tr>
                                @php $i++ @endphp
                            @endforeach
                        @endif
                    @else
                        <tr>
                            <td colspan="5">No data to display</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{ $tables->links() }}
        </div>

    </div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection
