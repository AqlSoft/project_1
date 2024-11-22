@extends('layouts.admin')
@section('title')
    Items Categories
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    Items Categories
@endsection
@section('homeLinkActive')
    Create New
@endsection

@section('content')
    <div class="container">
        <div class="buttons">
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('tables.stats') }}"> <i
                        class="fa fa-chart-line"></i> احصائيات
                </a></button>
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('tables.home') }}"> <i
                        class="fa fa-list"></i>
                    الطبالى</button>
            <button type="button" class="btn btn-sm px-2 btn-success"><a>
                    <i class="fa fa-edit"></i>
                    تعديل</a></button>
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a
                    href="{{ route('table.view', [$t->id]) }}">
                    <i class="fa fa-eye"></i>
                    عرض</a></button>
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('table.create') }}"> <i
                        class="fa fa-plus"></i>
                    إضافة </a></button>
            <button class="btn  btn-sm px-2 btn-outline-danger"
                onclick="if(!confirm('انت على وشك القيام بعملية لا يمكن التراجع عنها، هل أنت متأكد؟'))return false"><a
                    href="{{ route('table.delete', $t->id) }}">
                    <i class="fa fa-trash"></i> حذف</a> </button>
        </div>
        <div class="border p-3 ">
            <fieldset dir="rtl" onload="initWork()">
                <legend class="">تعديل بيانات طبلية</legend>
                <form class="p-3 m-3 mt-5" id="regForm" action="{{ route('table.update') }}" method="post">
                    @csrf
                    <style>
                        table tr td,
                        table tr th {
                            background-color: #fff;
                        }

                        table td select,
                        table td input[type=text] {
                            border: 0;
                            padding: 8px 16px;
                            outline: 0;
                            width: 80%;
                            border-bottom: 2px solid #757575
                        }

                        table td input[type=text]:focus {
                            border: 0;
                            border-bottom: 2px solid #66f
                        }

                        table tr:hover td,
                        table tr:hover th {
                            background-color: #f8f8f8;
                        }
                    </style>
                    </style>
                    <input type="hidden" name="id" value="{{ $t->id }}">
                    <table class="w-100">
                        <tr>
                            <td class="text-left">رقم الطبلية:</td>
                            <td><input type="text" name="name" id="name" value="{{ $t->name }}"
                                    class="p-2"></td>
                            <td class="text-left">الحجم:</td>
                            <td>
                                <select class="form-control" name="size" id="size">
                                    <option {{ $t->size == 1 ? 'selected' : '' }} value="1">صغيرة</option>
                                    <option {{ $t->size == 2 ? 'selected' : '' }} value="2">كبيرة</option>
                                    <option {{ $t->size == 3 ? 'selected' : '' }} value="3">وسط</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">الرقم المسلسل:</td>
                            <td><input type="text" name="serial" id="" value="{{ $t->serial }}"></td>
                            <td class="text-left">السعة:</td>
                            <td><input type="text" name="capacity" id="" value="{{ $t->capacity }}"></td>
                        </tr>
                    </table>


                    <!-- One "tab" for each step in the form: -->

                    <div class="buttons">

                        <button id="dismiss_btn" class="btn btn-outline-info btn-sm"
                            onclick="window.location='{{ route('tables.home') }}'" type="button"
                            id="submitBtn">العودة</button>
                        <button class="btn btn-outline-success btn-sm" type="submit" id="submitBtn">تحديث
                            البيانات</button>
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
