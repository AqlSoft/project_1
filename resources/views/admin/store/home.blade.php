@extends('layouts.admin')

@section('title')
    التخزين
@endsection

@section('pageHeading')
    التخزين
@endsection

@section('content')
    <div class="container pt-5">
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
        <fieldset>
            <legend>
                الطبالى
            </legend>
            <h6 class="text-right my-3 fw-bold text-primary">إحصائيات عامة</h6>
            <div class="row">
                <table class="col col-6 mb-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>حسب المخازن</th>
                            <th>حسب النظام</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>الطبالى الكبيرة</th>
                            <td>1500</td>
                            <td>{{ $largeTables }}</td>
                        </tr>
                        <tr>
                            <th>الطبالى الصغيرة</th>
                            <td>1500</td>
                            <td>{{ $smallTables }}</td>
                        </tr>
                        <tr>
                            <th>اجمالى الطبالى </th>
                            <th>3000</th>
                            <th>{{ $smallTables + $largeTables }}</th>
                        </tr>
                    </tbody>
                </table>

                <table class="col col-6 mb-3" style="border-right: 2px solid">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>حسب المخازن</th>
                            <th>حسب النظام</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>عدد الطبالى الكبيرة المحجوزة</th>
                            <td>{{ $largeOccupiedTables }}</th>
                            <td>{{ $largeOccupiedTables }}</th>
                        </tr>
                        <tr>
                            <th>عدد الطبالى الصغيرة المحجوزة</th>
                            <td>{{ $smallOccupiedTables }}</th>
                            <td>{{ $smallOccupiedTables }}</th>
                        </tr>
                        <tr>
                            <th>اجمالى الطبالى المحجوزة</th>
                            <th>{{ $smallOccupiedTables + $largeOccupiedTables }}</th>
                            <th>{{ $smallOccupiedTables + $largeOccupiedTables }}</th>
                        </tr>
                    </tbody>
                </table>

                <table class="col col-6 mb-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>حسب المخازن</th>
                            <th>حسب النظام</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>الطبالى الكبيرة</th>
                            <td>1500</td>
                            <td>{{ $largeTables }}</td>
                        </tr>
                        <tr>
                            <th>الطبالى الصغيرة</th>
                            <td>1500</td>
                            <td>{{ $smallTables }}</td>
                        </tr>
                        <tr>
                            <th>اجمالى الطبالى </th>
                            <th>3000</th>
                            <th>{{ $smallTables + $largeTables }}</th>
                        </tr>
                    </tbody>
                </table>

                <table class="col col-6 mb-3" style="border-right: 2px solid">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>حسب المخازن</th>
                            <th>حسب النظام</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>عدد الطبالى الكبيرة المحجوزة</th>
                            <td>{{ $largeOccupiedTables }}</th>
                            <td>{{ $largeOccupiedTables }}</th>
                        </tr>
                        <tr>
                            <th>عدد الطبالى الصغيرة المحجوزة</th>
                            <td>{{ $smallOccupiedTables }}</th>
                            <td>{{ $smallOccupiedTables }}</th>
                        </tr>
                        <tr>
                            <th>اجمالى الطبالى المحجوزة</th>
                            <th>{{ $smallOccupiedTables + $largeOccupiedTables }}</th>
                            <th>{{ $smallOccupiedTables + $largeOccupiedTables }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </fieldset>

    </div>
@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection
