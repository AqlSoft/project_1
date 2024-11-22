@extends('layouts.admin')
@section('title')
    احصائيات عامة على العقد
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    العقود
@endsection
@section('homeLinkActive')
    احصائيات العقد
@endsection
@section('links')
@endsection
@section('content')
    <div class="container pt-4">
        <div class="border p-3">

            <fieldset dir="rtl" class="m-3">
                <legend style="right: 20px; left: auto"> بيانات العقد
                    <a href="{{ route('contract.edit', [$contract->id, 1]) }}"><i class="fa fa-edit"></i></a>
                </legend>

            </fieldset>
        </div>
    </div>
@endsection


@section('script')
    {{-- <script src="{{ asset('resources\js\datatablesar.js') }}"></script> --}}
    <script src="cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
    <script></script>
@endsection
