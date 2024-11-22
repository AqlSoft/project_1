@extends('layouts.admin')
@section('title') الإعدادات العامة @endsection
@section('homeLink') الأدوار @endsection
@section('homeLinkActive') إضافة دور جديد @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('rules.home') }}">
        <span class="btn-title">العودة إلى الرئيسية</span>
        <i class="fa fa-home text-light"></i></a>
    </button>

@endsection
@section('content')
<style>
    
</style>
<div class="container" style="min-height: 100vh">
    <fieldset>
        <legend>إضافة دور جديد</legend>
        
        <form action="{{ route('rules.store') }}" method="post">

            @csrf
            <div class="input-group mt-3">
                <label for="name" class="input-group-text required">اسم الدور:</label>
                <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                
            </div>
           
            <div style="">
                <br>
                <button id="dismiss_btn" class="btn btn-info" 
                onclick="window.location='{{route('rules.home')}}'" type="button" id="submitBtn">إلغاء</button>
                <button class="btn btn-success" type="submit" id="submitBtn">تسجيل دور جديد</button>
            </div>
            
        </form>
        <div class="alert alert-sm px-3 py-1 alert-secondary float-right d-inline-block text-info mt-3 text-right">( <span style="color: red">*</span> ) تشير إلى حقول مطلوبة.</div>
    </fieldset>

</div>
@endsection


@section('script')
@endsection
