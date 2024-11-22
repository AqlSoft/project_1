@extends('layouts.admin')
@section('title')
    Dashboard
@endsection
@section('homePage')
    Dashboard
@endsection
@section('homeLink')
    Dashboard
@endsection
@section('homeLinkActive')
    Home
@endsection
@section('links')
    <button class="btn btn-sm btn-primary">
        <a href="{{ route('admin.dashboard.show') }}" title="Go To admin dashboard setting">
            <i class="fas fa-cogs text-light"></i></a></button>
@endsection

@section('content')
    <div class="container pt-5" style="min-height: 100vh">
        <div class="cards">
            <div class="card w-100">
                <div class="card-header">
                    <h4> لوحة التحكم الرئيسية </h4>
                </div>
                <div class="card-body row">
                    <div class="col col-3 text-center mb-3">
                        <div class="border border-info">
                            <div class="p-5"><i class="text-primary fa-3x fa fa-users"></i></div>
                            <a href="{{ route('users.home') }}" class="p-2 fs-4 d-block bg-info"> المستخدمين
                            </a>
                        </div>
                    </div>

                    <div class="col col-3 text-center mb-3">
                        <div class="border border-info">
                            <div class="p-5"><i class="text-primary fa-3x fas fa-balance-scale"></i></div>
                            <a href="{{ route('accounts.home', 1) }}" class="p-2 fs-4 d-block bg-info">
                                الحسابات العامة </a>
                        </div>
                    </div>

                    <div class="col col-3 text-center mb-3">
                        <div class="border border-info">
                            <div class="p-5"><i class="text-primary fa-3x fas fa-dolly-flatbed"></i></div>
                            <a href="{{ route('receipts.input_receipts', [1]) }}"
                                class="p-2 fs-4 d-block bg-info">التخزين</a>
                        </div>
                    </div>

                    <div class="col col-3 text-center mb-3">
                        <div class="border border-info">
                            <div class="p-5"><i class="text-primary fa-3x fas fa-shopping-basket"></i></div>
                            <a href="{{ route('receipts.input_receipts', [1]) }}"
                                class="p-2 fs-4 d-block bg-info bg-info">المشتريات</a>
                        </div>
                    </div>

                    <div class="col col-3 text-center mb-3">
                        <div class="border border-info">
                            <div class="p-5"><i class="text-primary fa-3x fas fa-shopping-cart"></i></div>
                            <a href="{{ route('receipts.input_receipts', [1]) }}"
                                class="p-2 fs-4 d-block bg-info bg-info">المبيعات</a>
                        </div>
                    </div>

                    <div class="col col-3 text-center mb-3">
                        <div class="border border-info">
                            <div class="p-5"><i class="text-primary fa-3x fas fa-cogs"></i></div>
                            <a href="{{ route('operating.home') }}" class="p-2 fs-4 d-block bg-info bg-info">التشغيل</a>
                        </div>
                    </div>

                    <div class="col col-3 text-center mb-3">
                        <div class="border border-info">
                            <div class="p-5"><i class="text-primary fa-3x fas fa-users-cog"></i></div>
                            <a href="{{ route('receipts.input_receipts', [1]) }}"
                                class="p-2 fs-4 d-block bg-info bg-info">الموارد البشرية</a>
                        </div>
                    </div>

                    <div class="col col-3 text-center mb-3">
                        <div class="border border-info">
                            <div class="p-5"><i class="text-primary fa-3x fas fa-warehouse"></i></div>
                            <a href="{{ route('stores.home') }}" class="p-2 fs-4 d-block bg-info bg-info">المخازن</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
