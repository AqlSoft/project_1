@extends('layouts.admin')
@section('title') العملاء @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') العملاء @endsection
@section('homeLinkActive') إضافة جديد @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.cats.home') }}"><span class="btn-title">Go Home</span><i class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.setting') }}"><span class="btn-title">Settings</span><i class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')
    <div class="container">
        <div class="border">
            <fieldset  dir="rtl" onload="initWork()">
                <legend class="">إضافة عميل جديد</legend>
                <form class="p-3" id="regForm" action="{{ route('services.store') }}" method="post">
                    @csrf
                    <style>
                        table tr td {border-left: 0 !important; font-weight: bolder;}
                        table tr td input, table tr td select {display: inline-block; width: 80%; background-color: transparent; border: 1px solid transparent; border-bottom-color: #777; margin: 0 16px}
                    </style>
                    <table class=" w-100">
                        <tr>
                            <td class="text-left">اسم الخدمة:</td>
                            <td><input type="text" name="name" id="" value="{{old('name')}}"></td>
                            <td class="text-left">وصف الخدمة:</td>
                            <td><input type="text" name="brief" id="" value="{{old('brief')}}"></td>
                        </tr>
                        {{-- <tr>
                            <td class="text-left">الوحدة:</td>
                            <td>
                                <select name="unit" id="" value="{{old('unit')}}">
                                    <option value="1">ط/شهر</option>
                                    <option value="1">ط/فترة</option>
                                </select>
                            </td>
                            <td class="text-left">السعر:</td>
                            <td><input type="number" step=".01" value="0.00" name="price" id="" value="{{old('price')}}"></td>
                        </tr> --}}
                    </table>
                    

                    <!-- One "tab" for each step in the form: -->
                    
                    <div style="">
                        <br>
                        <button id="dismiss_btn" class="btn-info pr-3 pl-3 p-1" 
                        onclick="window.location='{{route('services.home')}}'" type="button" id="submitBtn">إلغاء</button>
                        <button class="btn-success pr-3 pl-3 p-1" type="submit" id="submitBtn">إدراج</button>
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
