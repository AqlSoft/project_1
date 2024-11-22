@extends('layouts.admin')
@section('title') الإعدادات العامة @endsection
@section('homeLink') المستخدمين @endsection
@section('homeLinkActive') إضافة مستخدمين @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('users.home') }}">
        <span class="btn-title">العودة إلى الرئيسية</span>
        <i class="fa fa-home text-light"></i></a>
    </button>

@endsection
@section('content')
<style>
    
</style>
<div class="container" style="min-height: 100vh">
    <fieldset>
        <legend>إضافة مستخدم جديد</legend>
        
        <form action="{{ route('admins.store') }}" method="post">

            @csrf
            <div class="input-group mt-3">
                <label for="firstName" class="input-group-text required">الاسم الأول</label>
                <input type="text" name="firstName" id="firstName" class="form-control" required value="{{ old('firstName') }}">
                <label for="lastName" class="input-group-text required">اسم العائلة</label>
                <input type="text" name="lastName" id="lastName" class="form-control" required value="{{ old('lastName') }}">
                <label for="title" class="input-group-text"> اللقب </label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
            </div>
            <div class="input-group mt-3">
                <label for="userName" class="input-group-text required">اسم المستخدم</label>
                <input type="text" name="userName" id="userName" class="form-control" required value="{{ old('userName') }}">
                <label for="profession" class="input-group-text required">الوظيفة</label>
                <select name="profession" id="profession" class="form-control" required value="{{ old('profession') }}">
                    <option hidden>حدد الوظيفة</option>
                    @foreach ($professions as $p => $profession)
                    <option value="{{$p}}">{{$profession[1]}}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-group mt-3">
                <label for="email" class="input-group-text required required">البريد الالكترونى</label>
                <input type="text" name="email" id="email" class="form-control" value="{{old('email')}}" required>
                <label for="password" class="input-group-text required">كلمة المرور</label>
                <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}" required>
            </div>

            <div class="input-group mt-3">
                <label for="gender" class="input-group-text">النوع</label>
                <select name="gender" id="gender" class="form-control" value="{{ old('gender') }}">
                    <option hidden>اختر الجنس</option>
                    <option value="1">ذكر</option>
                    <option value="0">أنثى</option>
                </select>
                <label for="dob" class="input-group-text required">تاريخ الميلاد</label>
                <input type="date" name="dob" id="dob" class="form-control" placeholder="اسم المستخدم" required value="{{ old('dob') }}">
            </div>

            <div class="input-group mt-3">
                <label for="phone" class="input-group-text">رقم الهاتف</label>
                <input type="text" name="phone" id="dob" class="form-control" value="{{ old('phone') }}">
                <label for="natId" class="input-group-text required">رقم الهوية</label>
                <input type="text" name="natId" id="natId" class="form-control" required value="{{ old('natId') }}">
            </div>

            <div style="">
                <br>
                <button id="dismiss_btn" class="btn btn-info" 
                onclick="window.location='{{route('users.home')}}'" type="button" id="submitBtn">إلغاء</button>
                <button class="btn btn-success" type="submit" id="submitBtn">تسجيل موظف جديد</button>
            </div>
            
        </form>
        <div class="alert alert-sm px-3 py-1 alert-secondary float-right d-inline-block text-info mt-3 text-right">( <span style="color: red">*</span> ) تشير إلى حقول مطلوبة.</div>
    </fieldset>

</div>
@endsection


@section('script')
@endsection
