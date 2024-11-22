@extends('layouts.admin')
@section('title') عنابر التخزين @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') عنابر التحزين @endsection
@section('homeLinkActive') إضافة غرفة جديدة @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('tables.home') }}"><span class="btn-title">العودة للرئيسية</span><i class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.setting') }}"><span class="btn-title">الاعدادات</span><i class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')
    <div class="container">
        <div class="border p-3 ">
            <fieldset  dir="rtl" onload="initWork()">
                <legend class="">إضافة غرفة جديدة</legend>
                <form class="p-3 m-3 mt-5" id="regForm" action="{{ route('room.store') }}" method="post">
                    @csrf
                    <style>
                        table tr td {border-left: 0 !important; font-weight: bolder;}
                        table tr td input {display: inline-block; width: 80%; background-color: transparent; border: 1px solid transparent; border-bottom-color: #777; margin: 0 16px}
                    </style>
                    <table class=" w-100">
                        <tr>
                            <td class="text-left">المخزن:</td>
                            <td>
                                <select  name="store" id="">
                                    @foreach($stores as $in => $store)
                                    <option dir="rtl" {{ old('store')== 1 ? 'selected' : ''}} value="{{ $store->id }}"> [{{ $store->e_name }}] - {{ $store->a_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-left">الحجم:</td>
                            <td>
                                <select  name="size" id="">
                                    <option hidden>اختر الحجم</option>
                                    @for ($y=1; $y<count($sizes); $y++)
                                    <option {{ old('size')== $y ? 'selected' : ''}} value="{{$y}}">{{$sizes[$y]}}</option>
                                    @endfor
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">الاسم العربى:</td>
                            <td><input type="text" name="a_name" id="" value="{{old('a_name')}}"></td>
                            <td class="text-left">الاسم باللغة الأخرى:</td>
                            <td><input type="text" name="e_name" id="" value="{{old('e_name')}}"></td>
                        </tr>
                        <tr>
                            <td class="text-left">الرقم المسلسل:</td>
                            <td><input type="text" name="serial" id="" value="{{old('serial')}}"></td>
                            <td class="text-left">الكود:</td>
                            <td><input type="text" name="code" id="" value="{{old('code')}}"></td>
                        </tr>
                    </table>

                    @error('a_name')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                    @enderror
                    @error('e_name')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                    @enderror
                    @error('serial')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                    @enderror
                    @error('code')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                    @enderror
                    

                    <!-- One "tab" for each step in the form: -->
                    
                    <div style="">
                        <br>
                        <button id="dismiss_btn" class="btn btn-info" 
                        onclick="window.location='{{route('rooms.home')}}'" type="button" id="submitBtn">إلغاء</button>
                        <button class="btn btn-success" type="submit" id="submitBtn">إدراج</button>
                    </div>
                    

                </form>
            </fieldset>
        </div>

    </div>

@endsection


@section('script')


@endsection
