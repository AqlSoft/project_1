@extends('layouts.admin')
@section('title')
    المبيعات
@endsection
@section('homeLink')
    الحركات
@endsection
@section('homeLinkActive')
    الرئيسية
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
    <style>
        * {
            font: 400 1em/1.2 Cairo;
        }

        .card .card-header {
            padding: 5px 1em
        }

        .card .card-header h4 {
            color: #007bff;
            font: bold 18px/1.5 Cairo;
            text-align: right;
        }

        .card .card-body {
            display: flex;
            padding: 10px 1em;
        }

        .card-body .item {
            padding: 0.5em 1.2em;
        }

        .card-body .item a {
            box-shadow: 0 0 5px 1px #f5f5f5;
            color: #555;
            display: block;
            overflow: hidden;
        }

        .card-body .item a:hover {
            box-shadow: 0 0 5px 1px #c2c2c2;
        }

        .card-body .item .item-link {
            padding: 5px 0 0 1.2em;
            height: 40px;
            display: inline-block;
            float: right;
        }

        .card-body .item .item-icon {
            text-align: center;
            width: 50px;
            height: 40px;
            line-height: 40px;
            display: inline-block;
            float: right;
        }
    </style>
    <div class="container pt-5" style="min-height: 100vh">
        <div class="cards w-75">
            <div class="card w-100">
                <div class="card-header">
                    <h4>الحركات</h4>
                </div>
                <div class="card-body row">
                    <div class="item col col-4">
                        <a href="{{ route('receipts.in.all') }}">
                            <div class="item-icon"><i class="fa fa-tags"></i></div>
                            <div class="item-link"> جميع سندات الإدخال </div>
                        </a>
                    </div>
                    <div class="item col col-4">
                        <a href="{{ route('receipts.out.all', 0) }}">
                            <div class="item-icon"><i class="fa fa-plus"></i></div>
                            <div class="item-link"> جميع سندات الإخراج </div>
                        </a>
                    </div>

                    <div class="item col col-4">
                        <a href="{{ route('receipts.in.all') }}">
                            <div class="item-icon"><i class="fa fa-tags"></i></div>
                            <div class="item-link">السندات الملغاة</div>
                        </a>
                    </div>
                    <div class="item col col-4">
                        <a href="{{ route('receipt.create', 0) }}">
                            <div class="item-icon"><i class="fa fa-plus"></i></div>
                            <div class="item-link">إضافة سند جديد</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
@endsection
