@extends('layouts.admin')
@section('title')
    أصناف التخزين
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    المخازن
@endsection
@section('homeLinkActive')
    احصائيات الأصناف
@endsection
@section('links')
@endsection
@section('content')
    <div class="container pt-3">
        <style>
            .item {
                height: 72px;
                border: 1px solid #cde;
                margin: 3px 8px;
                overflow: hidden;
                display: flex;
            }

            .item-image {
                height: 72px;
                width: 80px;
                background-color: #333;
                background-size: cover;
            }

            .item-name {
                width: calc(100%-180px);
                height: 72px;
                text-align: right;
                width: calc(100% - 80px);
            }

            .item-controls {
                display: inline-block;
                width: 180px;
                text-align: center;
            }
        </style>

        <div class="buttons">
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('store.items.stats') }}"> <i
                        class="fa fa-chart-line"></i>
                    احصائيات</a></button>
            <button type="button" class="btn btn-sm px-2 btn-success"><a> <i class="fa fa-list"></i>
                    الأصناف</button>

            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('store.items.create') }}">
                    <i class="fa fa-plus"></i>
                    إضافة </a></button>

        </div>

        <fieldset>
            <legend>اسماء الأصناف</legend>
            <br>

            <div class="search">
                <form method="POST">
                    <div class="row mb-3">
                        <div class="col col-5">
                            <div class="input-group">
                                <input type="text" data-search-token="{{ csrf_token() }}"
                                    data-search-url="{{ route('treasuries.aj') }}" class="form-control" name="search"
                                    id="aj_search">
                                <label for="aj_search" class="input-group-text"><i class="fa fa-search"></i></label>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <br>
            @php
                $public_folder = asset('storage/app/admin/uploads/images/');
            @endphp

            @if (count($items))
                <div class="row p-3">
                    {{--  storage\app\admin\uploads\images\store_item_1710668689.png --}}
                    @foreach ($items as $in => $item)
                        <div class="col col-12 col-sm-6">
                            <div class="item">

                                <div class="item-image"
                                    style="background-image: url('{{ $public_folder . '/' . ($item->pic == 'none' ? 'default.png' : $item->pic) }}')">
                                </div>
                                <div class="item-name pr-3">
                                    {{ $item->name }}

                                    <div class="buttons">
                                        <button class="btn btn-outline-success btn-sm"><a
                                                href="{{ route('store.items.edit', [$item->id]) }}"> <i
                                                    class="fa fa-edit text-success"></i> تعديل </a></button>
                                        <button class="btn btn-outline-primary btn-sm"><a
                                                href="{{ route('store.items.view', [$item->id]) }}"><i
                                                    class="fa fa-eye text-primary"></i> رؤية المزيد </a></button>
                                        <button class="btn btn-outline-danger btn-sm"><a
                                                href="{{ route('store.items.remove', [$item->id]) }}"><i
                                                    class="fa fa-trash text-danger"></i> حذف </a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="col col-12 text-right">لم تتم إضافة أصناف بعد، استخدم النموذج بالأسفل لإضافة أصناف.</div>
            @endif
    </div>

    </fieldset>
    <br>


    </div>


@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection
