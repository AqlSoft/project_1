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
                <form class="p-3" id="regForm" action="{{ route('clients.store') }}" method="post">
                    @csrf
                    <style>
                        table tr td {border-left: 0 !important; font-weight: bolder;}
                        table tr td input {display: inline-block; width: 80%; background-color: transparent; border: 1px solid transparent; border-bottom-color: #777; margin: 0 16px}
                        .request-error {
                            margin: 0;padding: 0;
                            font: normal 10px/1 Cairo;
                            text-align: right;
                            color: red;
                            padding-right: 10%;
                        }
                    </style>
                    <table class=" w-100">
                        <tr>
                            <td class="text-left">اسم العميل:</td>
                            <td><input type="text" name="name" id="" value="{{old('name')}}">
                                @error('name')
                                <div class="request-error">{{ $message }}</div>
                                @enderror
                            </td>
                            <td class="text-left">نوع العميل:</td>
                            <td>
                                <select name="scope" id="" style="width: 80%">
                                    <option hidden>حدد نوع العميل</option>
                                    @foreach ($scope as $index => $value)
                                    <option {{ old('scope') == $index ? 'selected' : '' }} value="{{ $index }}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">الرقم المسلسل:</td>
                            <td><input type="text" name="s_number" id="" value="{{old('s_number')? old('s_number'):$lastClient->s_number+1}}">
                                @error('s_number')
                                <div class="request-error">{{ $message }}</div>
                                @enderror
                            </td>
                            <td class="text-left">الموقع الالكترونى:</td>
                            <td><input type="text" name="website" id="" value="{{old('website')}}"></td>
                        </tr>
                        <tr>
                            <td class="text-left">البريد الالكترونى:</td>
                            <td><input type="text" name="email" id="" value="{{old('email')}}"></td>
                            <td class="text-left">الهاتف:</td>
                            <td><input type="text" name="phone" id="" value="{{old('phone')}}">
                                @error('phone')
                                <div class="request-error">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">السجل التجارى:</td>
                            <td><input type="text" name="cr" id="" value="{{old('cr')}}"></td>
                            <td class="text-left">الرقم الضريبى:</td>
                            <td><input type="text" name="vat" id="" value="{{old('vat')}}"></td>
                        </tr>
                        <tr>
                            <td class="text-left">الممثل:</td>
                            <td><input type="text" name="person" id="" value="{{old('person')}}">
                                @error('person')
                                <div class="request-error">{{ $message }}</div>
                                @enderror
                            </td>
                            <td class="text-left">الإقامة:</td>
                            <td><input type="text" name="iqama" id="" value="{{old('iqama')}}">
                                @error('name')
                                <div class="request-error">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">العنوان:</td>
                            <td>
                                <input type="text" name="state" id="" value="{{old('state')}}" placeholder="المنطقة">
                            </td>
                            <td>
                                <input type="text" name="city" id="" value="{{old('city')}}" placeholder="المدينة">
                            </td>
                            <td>
                                <input type="text" name="street" id="" value="{{old('street')}}" placeholder="العنوان المفصل">
                            </td>
                            
                        </tr>
                    </table>

                    <!-- One "tab" for each step in the form: -->
                    
                    <div style="">
                        <br>
                        <button id="dismiss_btn" class="btn btn-success" 
                        onclick="window.location='{{route('clients.home')}}'" type="button" id="submitBtn">إلغاء</button>
                        <button class="btn btn-secondary" type="submit" id="submitBtn">إدراج</button>
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
