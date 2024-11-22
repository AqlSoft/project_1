@extends('layouts.admin')
@section('title')
    الإعدادات العامة
@endsection
@section('homeLink')
    الإجراءات
@endsection
@section('homeLinkActive')
    تعديل بيانات إجراء
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('rules.home') }}">
            <span class="btn-title">العودة إلى الأدوار</span>
            <i class="fa fa-home text-light"></i></a>
    </button>
@endsection
@section('content')
    <style>

    </style>
    <div class="container" style="min-height: 100vh">
        <fieldset>
            <legend>تحديث بيانات الإجراء</legend>

            <form action="{{ route('permissions.update') }}" method="post">

                @csrf
                <input type="hidden" name="id" value="{{ $permission->id }}">


                <div class="input-group mt-3">
                    <label for="name" class="input-group-text required">اسم الصلاحية:</label>
                    <input type="text" name="name" id="name" class="form-control" required
                        value="{{ $permission->name }}">

                    <label for="url" class="input-group-text required"> رابط الصلاحية: </label>
                    <input type="text" name="url" id="url" class="form-control" required
                        value="{{ $permission->url }}">

                </div>

                <div class="input-group mt-3">
                    <label for="display_name_ar" class="input-group-text required">الاسم الظاهر:</label>
                    <input type="text" name="display_name_ar" id="display_name_ar" class="form-control" required
                        value="{{ $permission->display_name_ar }}" placeholder="الاسم العربى">
                    <input type="text" name="display_name_en" id="display_name_en" class="form-control" required
                        value="{{ $permission->display_name_en }}" placeholder="الاسم اللاتينى">

                </div>
                <div class="input-group mt-3">
                    <label for="type" class="input-group-text required"> نوع الصلاحية: </label>
                    <select name="type" id="type" class="form-control text-right">>
                        <option hidden>النوع</option>

                        <option {{ $permission->type == 'action' ? 'selected' : '' }} value="action">حدث</option>
                        <option {{ $permission->type == 'view' ? 'selected' : '' }} value="view">عرض</option>
                    </select>
                    <label for="status" class="input-group-text required"> حالة التفعيل: </label>
                    <select name="status" id="status" class="form-control">
                        <option {{ $permission->status == 1 ? 'selected' : '' }} value="1"> مفعلة </option>
                        <option {{ $permission->status == 0 ? 'selected' : '' }} value="0"> معطلة </option>
                    </select>
                </div>

                <div class="input-group mt-3">

                    <label for="menu_id" class="input-group-text required"> المجموعة: </label>
                    <select name="menu_id" id="menu_id" class="form-control text-right">>
                        <option hidden>اختر المجموعة</option>
                        @foreach ($menues as $i => $menu)
                            <option {{ $permission->menu_id == $menu->id ? 'selected' : '' }} value="{{ $menu->id }}">
                                {{ $menu->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-success input-group-text" type="submit">تحديث بيانات الصلاحية
                    </button>
                </div>
            </form>
            <div class="alert alert-sm px-3 py-1 alert-secondary float-right d-inline-block text-info mt-3 text-right">(
                <span style="color: red">*</span> ) تشير إلى حقول مطلوبة.
            </div>
        </fieldset>

    </div>
@endsection


@section('script')
@endsection
