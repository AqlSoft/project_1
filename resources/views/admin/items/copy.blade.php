@extends('layouts.admin')
@section('title') أصناف المبيعات @endsection

@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') المبيعات @endsection
@section('homeLinkActive') الأصناف / إضافة صنف جديد  @endsection
@section('links')
    <button class="btn btn-sm btn-primary">
        <a href="{{ route('items.home') }}">
            <span class="btn-title">العودة للرئيسية</span>
            <i class="fa fa-home text-light"></i>
        </a>
    </button>
    <button class="btn btn-sm btn-primary">
        <a href="{{ route('items.cats.create', 0) }}">
            <span class="btn-title">إضافة تصنيف جديد</span>
            <i class="fa fa-tags text-light"></i>
        </a>
    </button>
    <button class="btn btn-sm btn-primary">
        <a href="{{ route('items.mu.create') }}">
            <span class="btn-title">إضافة وحدة قياس</span>
            <i class="fa fa-tools text-light"></i>
        </a>
    </button>
@endsection
@section('content')

<div class="container">
    <div class="border">
        <fieldset class="pb-0">
            <legend>إضافة تصنيف جديد</legend>
            <form class="pl-3 pr-3" id="regForm" action="{{ route('item.store') }}" method="post" dir=rtl>
                @csrf
                <table id="data" class="striped" style="width: 100%; margin-top: 1em" dir(rtl)>
                    <tr>
                        <td><label for="a_name" >اسم الصنف:</label></td>
                        <td colspan="2"><input value="{{$item->a_name}}" type="text" name="a_name" id="a_name" placeholder="الاسم بالعربى"></td>
                        <td><input value="{{$item->e_name}}" type="text" name="e_name" id="e_name" placeholder="الاسم باللغة الأخرى"></td>
                    </tr>
                    <tr>
                        <td><label for="parent_cat" >التصنيف الأب:</label></td>
                        <td>
                            <select name="parent_cat" id="parent_cat">
                                @foreach ($cats as $i => $cat)
                                    <option {{$item->parent_cat== $cat->id ? 'selected': ''}} value="{{$cat->id}}">{{$cat->a_name}} - {{$cat->parent}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><label for="unit" >التصنيف الأب:</label></td>
                        <td>
                            <select name="unit" id="unit">
                                @foreach ($mus as $i => $mu)
                                    <option {{$item->unit== $mu->id ? 'selected': ''}} value="{{$mu->id}}">{{$mu->a_name}} - {{$mu->e_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="Brief" >وصف الصنف:</label></td>
                        <td colspan="2"><input value="{{$item->brief}}" type="text" name="Brief" id="Brief" placeholder="وصف الصنف"></td>
                        <td><input value="{{$item->barcode}}" type="text" name="barcode" id="barcode" placeholder="الباركود"></td>
                    </tr>
                </table>
                
                <div class="" style="padding-top: 1em">
                    <button id="dismiss_btn" class="btn btn-info" onclick="window.location='{{route('items.home')}}'" type="button" id="submitBtn">إلغاء</button>
                    <button class="btn btn-success" type="submit" id="submitBtn">ادخال</button>
                </div>
            </form>
        </fieldset>
    </div>
</div>
@endsection

