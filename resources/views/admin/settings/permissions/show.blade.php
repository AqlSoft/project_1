@extends('layouts.admin')
@section('title') الإعدادات العامة @endsection
@section('homeLink') القوائم الفرعية @endsection
@section('homeLinkActive') عرض بيانات قائمة فرعية @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('rules.home') }}">
        <span class="btn-title">العودة إلى القوائم الفرعية</span>
        <i class="fa fa-home text-light"></i></a>
    </button>

@endsection
@section('content')
<style>
    
</style>
<div class="container" style="min-height: 100vh">
    <fieldset>
        <legend>عرض بيانات القائمة الفرعية</legend>
        <div class="text-right mt-3 mx-3">
            <b>اسم القائمة الفرعية:</b>
            <em>&nbsp; &nbsp; {{$subMenu->name}}</em>
        </div>
        <div class="text-right mx-3">
            <b>اسم القائمة الرئيسية:</b>
            <em>&nbsp; &nbsp; {{$subMenu->parentName}}</em>
        </div>
        <div class="text-right mx-3">
            <b>حالة تفعيل القائمة:</b>
            <em>&nbsp; &nbsp; {{$subMenu->status ? 'مفعلة':'معطلة'}}</em>
        </div>
        <div class="text-right mx-3">
            <b>حالة تفعيل القائمة:</b>
            <ul>
                @if (!count($subMenu->permissions))
                <li>No permissiond added <a href="{{route('permissions.create', [$subMenu->id, $subMenu->main_menu])}}"><i data-bs-toggle="tooltip" data-bs-title="إضافة صلاحية" class="fa fa-plus-square"></i></a></li>                    
                @endif
                {{'' }}
            </ul>
        </div>
        
        
    </fieldset>

</div>
@endsection


@section('script')
@endsection
