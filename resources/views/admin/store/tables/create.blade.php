@extends('layouts.admin')
@section('title') العملاء @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') العملاء @endsection
@section('homeLinkActive') إضافة جديد @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('tables.home') }}"><span class="btn-title">Go Home</span><i class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('store.settings') }}"><span class="btn-title">Settings</span><i class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')
    <div class="container">
        <div class="border p-3 ">
            <fieldset  dir="rtl" onload="initWork()">
                <legend class="">إضافة طبلية جديدة</legend>
                <form class="p-3 m-3 mt-5" id="regForm" action="{{ route('tables.store') }}" method="post">
                    @csrf
                    <style>
                        table tr td {border-left: 0 !important; font-weight: bolder;}
                        table tr td input {display: inline-block; width: 80%; background-color: transparent; border: 1px solid transparent; border-bottom-color: #777; margin: 0 16px}
                    </style>
                    <table class=" w-100">
                        <tr>
                            <td class="text-left">رقم الطبلية:</td>
                            <td><input type="text" name="name" id="" value="{{old('name')}}"></td>
                            <td class="text-left">الحجم:</td>
                            <td>
                                <select  name="size" id="">
                                    <option {{ old('size')== 1 ? 'selected' : ''}} value="1">صغيرة</option>
                                    <option {{ old('size')== 2 ? 'selected' : ''}} value="2">كبيرة</option>
                                    <option {{ old('size')== 3 ? 'selected' : ''}} value="3">وسط</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">الرقم المسلسل:</td>
                            <td><input type="text" name="serial" id="" value="{{old('serial')}}"></td>
                            <td class="text-left">السعة:</td>
                            <td><input type="text" name="capacity" id="" value="{{old('capacity')}}"></td>
                        </tr>
                    </table>
                    

                    <!-- One "tab" for each step in the form: -->
                    
                    <div style="">
                        <br>
                        <button id="dismiss_btn" class="btn btn-info" 
                        onclick="window.location='{{route('tables.home')}}'" type="button" id="submitBtn">إلغاء</button>
                        <button class="btn btn-success" type="submit" id="submitBtn">إدراج</button>
                    </div>
                    

                </form>
            </fieldset>
        </div>

        <div class="alterContext">
            <ul class="menu-items">
                <li class="context-menu-item">
                    Vew Category Items
                </li>
                <li class="context-menu-item">
                    Add New Category
                </li>
                <li class="context-menu-item">
                    Edit Category
                </li>
                <li class="context-menu-item">
                    Delete Category
                </li>
            </ul>
        </div>

    </div>

@endsection


@section('script')


    <script>
        $('.accordion-button i').click(function () {
            $(this).toggleClass('fa-folder-open fa-folder')
        })

        $('#Type').change(function(){
            if ($(this).val() == 1) {

            } else if ($(this).val() == 1) {

            }
        });

    </script>
@endsection
