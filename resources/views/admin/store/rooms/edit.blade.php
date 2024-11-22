@extends('layouts.admin')
@section('title') الثلاجات @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') الثلاجات @endsection
@section('homeLinkActive') الغرف / تعديل بيانات غرفة @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.cats.home') }}"><span class="btn-title">Go Home</span><i class="fa fa-plus text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.setting') }}"><span class="btn-title">Settings</span><i class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')
    <div class="container">
        <div class="border p-3 ">
            <fieldset  dir="rtl" onload="initWork()">
                <legend class=""> تعديل بيانات غرفة </legend>
                <form class="p-3 m-3 mt-5" id="regForm" action="{{ route('room.update') }}" method="post">
                    @csrf
                    <style>
                        table tr td {border-left: 0 !important; font-weight: bolder;}
                        table tr td input {display: inline-block; width: 80%; background-color: transparent; border: 1px solid transparent; border-bottom-color: #777; margin: 0 16px}
                    </style>
                    <input type="hidden" name="id" value="{{$room->id}}">
                    <table class=" w-100">
                        <tr>
                            <td class="text-left">المخزن:</td>
                            <td>
                                <select  name="store" id="">
                                    @foreach($stores as $in => $store)
                                    <option dir="rtl" {{ $room->store== 1 ? 'selected' : ''}} value="{{ $store->id }}"> [{{ $store->e_name }}] - {{ $store->a_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-left">الحجم:</td>
                            <td>
                                <select  name="size" id="">
                                    <option hidden>اختر الحجم</option>
                                    @for ($y=1; $y<count($sizes); $y++)
                                    <option {{ $room->size == $y ? 'selected' : ''}} value="{{$y}}">{{$sizes[$y]}}</option>
                                    @endfor
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">الاسم العربى:</td>
                            <td><input type="text" name="a_name" id="" value="{{$room->a_name}}"></td>
                            <td class="text-left">الاسم باللغة الأخرى:</td>
                            <td><input type="text" name="e_name" id="" value="{{$room->e_name}}"></td>
                        </tr>
                        <tr>
                            <td class="text-left">الرقم المسلسل:</td>
                            <td><input type="text" name="serial" id="" value="{{$room->serial}}"></td>
                            <td class="text-left">الكود:</td>
                            <td><input type="text" name="code" id="" value="{{$room->code}}"></td>
                        </tr>
                    </table>
                    @error('a_name')
                    <div class="alert alert-danger text-right p-1 pr-3 m-1">{{ $message }}</div>
                    @enderror
                    @error('e_name')
                    <div class="alert alert-danger text-right p-1 pr-3 m-1">{{ $message }}</div>
                    @enderror
                    @error('serial')
                    <div class="alert alert-danger text-right p-1 pr-3 m-1">{{ $message }}</div>
                    @enderror
                    @error('code')
                    <div class="alert alert-danger text-right p-1 pr-3 m-1">{{ $message }}</div>
                    @enderror
                    
                    <div style="">
                        <br>
                        <button id="dismiss_btn" class="btn btn-info" 
                        onclick="window.location='{{route('rooms.home')}}'" type="button" id="submitBtn">العودة</button>
                        <button class="btn btn-success" type="submit" id="submitBtn">تحديث البيانات</button>
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
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection
