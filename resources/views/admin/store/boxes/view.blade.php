@extends('layouts.admin')
@section('title')
    عرض صنف ثلاجة
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    المخازن
@endsection
@section('homeLinkActive')
    عرض بيانات صنف ثلاجة
@endsection
@section('links')
@endsection
@section('content')
    <div class="container pt-2">

        <div class="buttons">
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('store.items.stats') }}"> <i
                        class="fa fa-chart-line"></i>
                    احصائيات</a></button>
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('store.items.home') }}"> <i
                        class="fa fa-list"></i>
                    الأصناف</button>
            <button type="button" class="btn btn-sm px-2 btn-success"><a>
                    <i class="fa fa-eye"></i>
                    عرض</a></button>
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a
                    href="{{ route('store.items.edit', $item->id) }}">
                    <i class="fa fa-edit"></i>
                    تعديل </a></button>
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('store.items.create') }}">
                    <i class="fa fa-plus"></i>
                    إضافة </a></button>
            <button type="button" class="btn btn-sm px-2 btn-outline-danger"><a
                    href="{{ route('store.items.remove', $item->id) }}">
                    <i class="fa fa-plus"></i>
                    حذف </a></button>
        </div>

        <fieldset>
            <legend>عرض بيانات صنف ثلاجة</legend>

            <br>
            <div class="row p-3">
                <div>{{ $item->name }}</div>
                <div>{{ $item->short }}</div>

                <div class="shadow"><img
                        src="{{ asset('storage/app/admin/uploads/images/' . $item->pic == 'none' ? 'default.png' : $item->pic) }}"
                        alt="">
                </div>

            </div>


        </fieldset>
        <br>


    </div>
@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection
