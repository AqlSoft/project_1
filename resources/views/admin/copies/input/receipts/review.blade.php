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
        .receipt {
            width: 21cm;
            padding: 0 1cm;
            height: 30cm;
            background-color: #fff;
            position: relative;
            margin-bottom: 4em;
        }


        @media print and (max-width: 21cm) {

            html,
            body,
            .receipt {
                width: 21cm;
                padding: 0cm;
                height: 30cm
            }

            .buttons {
                display: none
            }

            footer.main-footer {
                display: none
            }
        }
    </style>

    <div class="container py-3">

        <div class="receipt">
            <div class="row mb-3 py-3" style="background-color: #fff; border-bottom: 3px solid #0282fa">
                <div class="col" style="width: 35%">
                    <div class="d-grid text-center">
                        <h4 class="card-title fw-bold text-primary">مخازن أيمن الغماس </h4>
                        <p class="card-text pt-3" style="font-size: 10px">تخزين | تبريد | تجميد | شراع | بيع | تصدير</p>
                        <p class="card-text py-0"><small class="text-muted">سجل تجارى 123456789</small></p>
                    </div>
                </div>
                <div class="col text-center" style="width: 25%">
                    <img src="{{ asset('assets/admin/uploads/images/logo.png') }}" alt="" width="60">
                    <b class="d-block text-center">
                        سند استلام بضاعة</b>
                </div>
                <div class="col" style="width: 40%">
                    <div class="d-grid text-center ">
                        <h4 class="card-title fw-bold text-primary">Ayman Al Ghamas Stores</h4>
                        <p class="card-text pt-3" style="font-size: 10px">Storing | Colling | Freezing | Purchase | Sell |
                            Export</p>
                        <p class="card-text"><small class="text-muted">CR: 123456789</small></p>
                    </div>
                </div>
            </div>

            <div class="row receipt_info p-1" style="background-color: #ddd; margin: 0">
                <div class="col col-5">
                    <span class="text-right fw-bold"> التاريخ: </span>
                    <span class="px-2 text-primary"> {{ $receipt->greg_date }} </span>
                </div>
                <div class="col col-2">
                </div>
                <div class="col col-5">
                    <span class="text-right fw-bold">مسلسل: </span>
                    <span class="px-2 fw-bold text-primary">{{ $receipt->s_number }}</span>
                </div>
                <div class="col col-5">
                    <span class="text-right fw-bold">العميل: </span>
                    <span class="px-2 text-primary">{{ $receipt->theClient->name }}</span>
                </div>
                <div class="col col-2 text-center m-0 text-primary">

                </div>
                <div class="col col-5">
                    <span class="text-right fw-bold"> المزرعة / المصدر: </span>
                    <span class="px-2 text-primary">{{ $receipt->farm }}</span>
                </div>
                <div class="col col-8">
                    <span class="text-right fw-bold"> أخرى: </span>
                    <span class="px-2 text-primary">{{ $receipt->notes }}</span>
                </div>
                <div class="col col-4">
                    <span class="text-right fw-bold"> العقد: </span>
                    <span class="px-2 text-primary">{{ $receipt->theContract->s_number }}</span>
                </div>
            </div>
            <table class="w-100">
                <thead>
                    <tr class="">
                        <th class="fw-bold bg-primary py-2 fs-6">#</th>
                        <th class="fw-bold bg-primary py-2 fs-6">رقم الطبلية</th>
                        <th class="fw-bold bg-primary py-2 fs-6">حجم الطبلية</th>
                        <th class="fw-bold bg-primary py-2 fs-6">الإصناف</th>
                        <th class="fw-bold bg-primary py-2 fs-6">حجم الكرتون</th>
                        <th class="fw-bold bg-primary py-2 fs-6">الكمية</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($entries))
                        @foreach ($entries as $index => $entry)
                            <tr>
                                <td class="fw-normal border-left">{{ ++$index }}</td>
                                <td class="fw-normal border-left">{{ $entry->tableName }}</td>
                                <td class="fw-normal border-left">{{ $entry->table_size == 1 ? 'صغيرة' : 'كبيرة' }}</td>
                                <td class="fw-normal border-left">{{ $entry->itemName }}</td>
                                <td class="fw-normal border-left">{{ $entry->boxName }}</td>
                                <td class="fw-normal">{{ $entry->tableItemQty }}</td>
                            </tr>
                        @endforeach
                    @else
                        <div class="text-right">لم يتم بعد إضافة أى إدخالات على هذا السند</div>
                    @endif
                </tbody>
            </table>


            <div class="buttons">
                <button class="btn btn-outline-primary"
                    onclick="window.location='{{ route('input.entry.create', [$receipt->id, 0]) }}'">
                    العودة للسند
                </button>

                <button class="btn btn-outline-primary">طباعة</button>
                <button class="btn btn-outline-primary">العودة للسندات</button>
            </div>

            <div class=""
                style="height: 100px; background-color: #ccc; width: 21cm; right: 0; bottom: 0; position: absolute">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate, expedita culpa saepe nesciunt tenetur
                molestiae quae illum commodi error alias voluptas! Impedit mollitia nisi libero voluptatibus maiores ad
                provident a alias aspernatur?
            </div>
        </div>


    </div>{{-- The container --}}
@endsection
@section('script')
@endsection
