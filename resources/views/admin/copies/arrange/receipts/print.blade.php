@extends('layouts.admin')

@section('title')
    استلام بضاعة
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    سندات الإدخال
@endsection
@section('homeLinkActive')
    استلام بضاعة على السند
@endsection
@section('links')
    {{-- <button class="btn btn-sm btn-primary"><a href="{{ route('receipts.home') }}"><span class="btn-title">العودة إلى
                الرئيسية</span><i class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('table.create') }}"><span class="btn-title">إضافة طبلية
                جديدة</span><i class="fa fa-th text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('store.items.add') }}"><span class="btn-title">إضافة صنف
                جديد</span><i class="fa fa-tag text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('store.box.size.add') }}"><span class="btn-title">إضافة حجم
                كرتون</span><i class="fa fa-box text-light"></i></a></button> --}}
@endsection

@section('content')
    <style>
        @media print and (max-width: 21cm) {

            html,
            body {
                width: 21cm;
                padding: 0;
            }

            .buttons {
                display: none
            }
        }
    </style>

    <div class="container">
        <fieldset style="">
            {{-- <legend>سند استلام بضاعة رقم" <span class="text-danger"> {{ $receipt->s_number }} </span></legend> --}}
            <br>

            <div class="row receipt_info p-0">
                <div class="col col-4">
                    <span class="label">التاريخ: </span>
                    <span class="data">{{ $receipt->greg_date }}</span>
                </div>
                <div class="col col-4">
                </div>
                <div class="col col-4">
                    <span class="label">مسلسل: </span>
                    <span class="data">{{ $receipt->s_number }}</span>
                </div>
                <div class="col col-4">
                    <span id="current_client" data-client-id="{{ $receipt->theClient->id }}" class="label">العميل: </span>
                    <span class="data">{{ $receipt->theClient->name }}</span>
                </div>
                <div class="col col-4 text-center m-0 text-primary">
                    <h3>
                        سند استلام بضاعة</h3>
                </div>
                <div class="col col-4">
                    <span class="label"> المزرعة / المصدر: </span>
                    <span class="data">{{ $receipt->farm }}</span>
                </div>
                <div class="col col-8">
                    <span class="label"> أخرى: </span>
                    <span class="data">{{ $receipt->notes }}</span>
                </div>
                <div class="col col-4">
                    <span class="label"> العقد: </span>
                    <span class="data">{{ $receipt->theContract->s_number }}</span>
                </div>
            </div>

            <table class="w-100 mt-5">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>رقم الطبلية</th>
                        <th>حجم الطبلية</th>
                        <th>الإصناف</th>
                        <th>حجم الكرتون</th>
                        <th>الكمية</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($entries))
                        @foreach ($entries as $index => $entry)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>رقم الطبلية</td>
                                <td>حجم الطبلية</td>
                                <td>الإصناف</td>
                                <td>حجم الكرتون</td>
                                <td>الكمية</td>
                            </tr>
                        @endforeach
                    @else
                        <div class="text-right">لم يتم بعد إضافة أى إدخالات على هذا السند</div>
                    @endif
                </tbody>
            </table>


            <div class="buttons">
                <button class="btn btn-sm font-weight-bold btn-primary">
                    <a href="{{ route('input.entry.create', [$receipt->id, 0]) }}">
                        العودة للسند
                    </a>
                </button>

                <button class="btn btn-sm font-weight-bold btn-info">طباعة</button>
                <button class="btn btn-sm font-weight-bold btn-primary">العودة للسندات</button>
            </div>



        </fieldset>
    </div>
@endsection
@section('script')
@endsection
