@extends('layouts.admin')
@section('title') Items Categories @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Items Categories @endsection
@section('homeLinkActive') Create New @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.cats.home') }}"><span class="btn-title">Go Home</span><i class="fa fa-plus text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.setting') }}"><span class="btn-title">Settings</span><i class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col col-12 border">
                <fieldset class="pb-0">
                    <legend> تعديل بيانات تصنيف </legend>
                    <form class="pl-3 pr-3" id="regForm" action="{{ route('items.cats.update') }}" method="post" dir=rtl>
                        @csrf
                        <input type="hidden" id="code" name="id" value="{{$cc->id}}">
                        <table id="data" class="striped" style="width: 100%; margin-top: 1em" dir(rtl)>
                            <tr>
                                <td><label for="parent_cat" >التصنيف الأب:</label></td>
                                <td>
                                    <select id="parent_cat"  name="parent_cat">
                                        <option hide>اختر التصنيف الأب</option>
                                        @foreach ($cats as $in => $cat)
                                        @if ($cat->level <= 2)
                                        <option class="" {{ $cc->parent_cat == $cat->id ? 'selected':'' }} value="{{ $cat->level }}|{{ $cat->id }}">
                                            {{$cat->a_name }} - {{ $cat->e_name }}
                                        </option>
        
                                        @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td><label for="code">الكود:</label></td>
                                <td><input type="text" id="code" name="code" required placeholder="A123C5" value="{{$cc->code}}"></td>
                            </tr>
                            <tr>
                                <td> <label for="a_name">اسم التصنيف</label></td>
                                <td colspan="2"><input type="text" id="a_name" name="a_name" required  value="{{$cc->a_name}}"></td>
                                <td><input type="text" id="e_name" name="e_name" required value="{{$cc->e_name}}"></td>
                            </tr>
                            <tr>
                                <td><label for="brief" >الوصف</label></td>
                                <td colspan="3"><input type="text" style="width: 90%; margin: auto" id="brief" name="brief" value="{{$cc->brief}}"></td>
                            </tr>
                        </table>
    
                        <div class="" style="padding-top: 1em">
                            <button id="dismiss_btn" class="btn btn-info" onclick="window.location='{{route('items.cats.home')}}'" type="button" id="submitBtn">إلغاء</button>
                            <button class="btn btn-success" type="submit" id="submitBtn">تحديث</button>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>

    </div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection
