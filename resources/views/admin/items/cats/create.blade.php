@extends('layouts.admin')
@section('title') تصنيفات المبيعات @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') تصنيفات المبيعات @endsection
@section('homeLinkActive') إضافة تصنيف جديد @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.cats.home') }}"><span class="btn-title">العودة للرئيسية</span><i class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.setting') }}"><span class="btn-title">الاعدادات</span><i class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')
<style>

</style>
    <div class="container">
        <div class="border">
            <fieldset class="pb-0">
                <legend>إضافة تصنيف جديد</legend>
                <form class="pl-3 pr-3" id="regForm" action="{{ route('items.cats.store') }}" method="post" dir=rtl>
                    @csrf
                    <table id="data" class="striped" style="width: 100%; margin-top: 1em" dir(rtl)>
                        <tr>
                            <td><label for="parent_cat" >التصنيف الأب:</label></td>
                            <td>
                                <select id="parent_cat"  name="parent_cat">
                                    <option value="">اختر التصنيف الأب</option>
                                    @foreach ($cats as $in => $cat)
                                    @if ($cat->level <= 2)
                                    <option class="" {{ $parent == $cat->id ? 'selected':'' }} value="{{ $cat->level }}|{{ $cat->id }}">
                                        {{$cat->a_name }} - {{ $cat->e_name }}
                                    </option>
    
                                    @endif
                                    @endforeach
                                </select>
                            </td>
                            <td><label for="code">الكود:</label></td>
                            <td><input type="text" id="code" name="code" required placeholder="A123C5"></td>
                        </tr>
                        <tr>
                            <td> <label for="a_name">اسم التصنيف</label></td>
                            <td colspan="2"><input type="text" id="a_name" name="a_name" required  placeholder="الاسم بالعربى"></td>
                            <td><input type="text" id="e_name" name="e_name" required placeholder="الاسم باللغة الأخرى"></td>
                        </tr>
                        <tr>
                            <td><label for="brief" >الوصف</label></td>
                            <td colspan="3"><input type="text" style="width: 90%; margin: auto" id="brief" name="brief" placeholder="وصف مختصر للتصنيف"></td>
                        </tr>
                    </table>

                    <div class="" style="padding-top: 1em">
                        <button id="dismiss_btn" class="btn btn-info" onclick="window.location='{{route('items.cats.home')}}'" type="button" id="submitBtn">إلغاء</button>
                        <button class="btn btn-success" type="submit" id="submitBtn">ادخال</button>
                    </div>
                </form>
            </fieldset>
        </div>

        {{-- <div class="alterContext">
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
        </div> --}}

    </div>

@endsection


@section('script')

    {{-- <script>
        $('.accordion-button i').click(function () {
            $(this).toggleClass('fa-folder-open fa-folder')
        })

        $('#Type').change(function(){
            if ($(this).val() == 1) {

            } else if ($(this).val() == 1) {

            }
        });

    </script> --}}
@endsection
