@extends('layouts.admin')

@section('title')
    سندات الإدخال
@endsection

@section('pageHeading')
    عرض سندات الإدخال
@endsection

@section('content')
    <div class="container mb-5 pt-3">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link">
                    <a href="{{ route('operating.home', [2]) }}">الرئيسية</a>
                </button>
                <button class="nav-link {{ $type == 1 ? 'active' : '' }}">
                    <a href="{{ route('reception.home', [1]) }}">
                        السندات ( الجارية ) تحت الاجراء
                        <a data-bs-toggle="tooltip" data-bs-title="إضافة سند استلام جديد" class="btn btn-primary text-light"
                            href="{{ route('reception.create', [0]) }}"><i class="fa fa-plus"></i></a>
                    </a>
                </button>
                <button class="nav-link  {{ $type != 1 ? 'active' : '' }}">
                    <a href="{{ route('reception.home', [2]) }}">السندات المعتمدة</a>
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background-color: #fff">

            <div class="section-heading">

            </div>
        </div>
    </div>
@endsection
