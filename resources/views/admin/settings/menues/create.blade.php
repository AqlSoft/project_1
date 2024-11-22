@extends('layouts.admin')
@section('title')
    الإعدادات العامة
@endsection
@section('homeLink')
    الأدوار
@endsection
@section('homeLinkActive')
    إضافة دور جديد
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('menues.home') }}">
            <span class="btn-title">العودة إلى الرئيسية</span>
            <i class="fa fa-home text-light"></i></a>
    </button>
@endsection
@section('content')
    <style>

    </style>
    <div class="container" style="min-height: 100vh">
        <fieldset>
            <legend>قائمة رئيسية جديدة </legend>

            <form action="{{ route('menues.store') }}" method="post">

                @csrf
                <div class="input-group mt-3">
                    <label for="menu_name" class="input-group-text required">اسم القائمة:</label>
                    <input type="text" name="name" id="menu_name" class="form-control" required value="">
                    <label for="menu_link" class="input-group-text required">رابط القائمة:</label>
                    <input type="text" name="menu_link" id="menu_link" class="form-control" required value="">
                </div>
                <div class="input-group mt-3">
                    <label for="menuStatus" class="input-group-text required"> حالة التفعيل: </label>
                    <select name="status" id="menuStatus" class="form-control" value="">
                        <option value="1">مفعلة</option>
                        <option value="0">معطلة</option>
                    </select>
                </div>



                <div style="">
                    <br>
                    <button id="dismiss_btn" class="btn btn-info" onclick="window.location='{{ route('menues.home') }}'"
                        type="button" id="submitBtn">إلغاء</button>
                    <button class="btn btn-success" type="submit" id="submitBtn">تسجيل دور جديد</button>
                </div>

            </form>
            <div class="alert alert-sm px-3 py-1 alert-secondary float-right d-inline-block text-info mt-3 text-right">(
                <span style="color: red">*</span> ) تشير إلى حقول مطلوبة.</div>
        </fieldset>

    </div>
@endsection


@section('script')
@endsection
