@extends('layouts.admin')
@section('title')
    التشغـــــــــــيل
@endsection
@section('homeLink')
    السنـــــــــــدات
@endsection
@section('homeLinkActive')
    الرئيســــــــية
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('item.create') }}"><span class="btn-title">إضافة صنف خدمى</span>
            <i class="fa fa-tag text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.cats.create', 0) }}"><span class="btn-title">إضافة تصنيف
                مبيعات</span>
            <i class="fa fa-tags text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('contract.create', 0) }}"><span class="btn-title">إضافة عقد
                خدمات</span><i class="fa fa-plus text-light"></i></a></button>
@endsection
@section('content')
    <div class="container pt-5" style="min-height: 100vh">
        <div class="cards">
            <div class="card w-100">
                <div class="card-header">
                    <h4>التشغـــــــــــيل</h4>
                </div>
                <div class="card-body row">

                    <div class="col col-3 text-center mb-3">
                        <div class="border border-info">
                            <div class="p-5"><i data-bs-toggle="tooltip" data-bs-title="سندات الإدخال"
                                    class="text-primary fa-3x fas fa-cubes"></i></div>
                            <a href="{{ route('receipts.input_receipts', [1]) }}" class="p-2 fs-4 d-block bg-info"> جميع
                                العملــــــيات
                            </a>
                        </div>
                    </div>


                    <div class="col col-3 text-center mb-3">
                        <div class="border border-info">
                            <div class="p-5"><i data-bs-toggle="tooltip" data-bs-title="سندات الإدخال"
                                    class="text-primary fa-3x fas fa-file-invoice-dollar"></i></div>
                            <a href="{{ route('receipts.input_receipts', [1]) }}" class="p-2 fs-4 d-block bg-info"> سندات
                                الإدخال
                            </a>
                        </div>
                    </div>

                    <div class="col col-3 text-center mb-3">
                        <div class="border border-info">
                            <div class="p-5"><i data-bs-toggle="tooltip" data-bs-title="سندات الإخراج"
                                    class="text-primary fa-3x fas fa-file-invoice"></i></div>
                            <a href="{{ route('receipts.output_receipts', 1) }}" class="p-2 fs-4 d-block bg-info"> سندات
                                الإخراج
                            </a>
                        </div>
                    </div>

                    <div class="col col-3 text-center mb-3">
                        <div class="border border-info">
                            <div class="p-5"><i data-bs-toggle="tooltip" data-bs-title="ترتيب المخازن"
                                    class="text-primary fa-3x fas fa-sort-amount-down-alt"></i>
                            </div>
                            <a href="{{ route('receipts.input_receipts', [1]) }}" class="p-2 fs-4 d-block bg-info">ترتيب
                                المخازن</a>
                        </div>
                    </div>

                    <div class="col col-3 text-center mb-3">
                        <div class="border border-info">
                            <div class="p-5"><i data-bs-toggle="tooltip" data-bs-title="السندات الملغاة والمحذوفة"
                                    class="text-primary fa-3x fas fa-dolly-flatbed"></i></div>
                            <a href="{{ route('receipts.input_receipts', [1]) }}" class="p-2 fs-4 d-block bg-info"> عمليات
                                الجرد
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> {{-- the Em=nd Of Card --}}

        <div class="card w-100">
            <div class="card-header">
                <h4>التقــــــارير</h4>
            </div>
            <div class="card-body row">
                <div class="col col-3 text-center mb-3">
                    <div class="border border-info">
                        <div class="p-5"><i data-bs-toggle="tooltip" data-bs-title="السندات الملغاة والمحذوفة"
                                class="text-primary fa-3x fa fa-times-circle"></i></div>
                        <a href="{{ route('parked.receipts.home', [1]) }}" class="p-2 fs-4 d-block bg-info">السندات
                            الملغاة</a>
                    </div>
                </div>

                <div class="col col-3 text-center mb-3">
                    <div class="border border-info">
                        <div class="p-5"><i data-bs-toggle="tooltip" data-bs-title="السندات الملغاة والمحذوفة"
                                class="text-primary fa-3x fa fa-sliders-h"></i></div>
                        <a href="{{ route('receipts.input_receipts', [1]) }}" class="p-2 fs-4 d-block bg-info">اعدادات
                            التشغيل</a>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection


@section('script')
@endsection
