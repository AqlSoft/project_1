@extends('layouts.admin')
@section('title')
    التخزين
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    التخزين / الطبالى
@endsection
@section('homeLinkActive')
    إضافة طبالي جديدة
@endsection

@section('content')
    <div class="container">
        <div class="buttons">
            <button type=submit class="btn btn-sm px-2  btn-outline-primary"><a href="{{ route('tables.stats') }}">
                    <i class="fa fa-chart-line"></i>
                    احصائيات </a></button>
            <button type=submit class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('tables.home') }}">
                    <i class="fa fa-list"></i>
                    الطبالى</a></button>
            <button type=submit class="btn btn-sm px-2  btn-disabled">
                <i class="fa fa-edit"></i>
                تعديل</button>
            <button type=submit class="btn btn-sm px-2 btn-success">
                <i class="fa fa-plus"></i>
                إضافة
            </button>
        </div>
        <div class="border p-3 ">
            <fieldset dir="rtl" onload="initWork()">
                <legend class="">إضافة طبلية جديدة</legend>
                <form class="p-3 m-3 mt-5" id="regForm" action="{{ route('table.store') }}" method="post">
                    @csrf
                    <style>
                        table tr td,
                        table tr th {
                            background-color: #fff;
                        }

                        table td select,
                        table td input[type=text] {
                            border: 0;
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
                    <table class=" w-100">
                        <tr>
                            <td class="text-left">رقم الطبلية:</td>
                            <td><input type="text" name="name" id="tableNumber" value="{{ old('name') }}" required
                                    class="p-2">
                            </td>
                            <td class="text-left">الحجم:</td>
                            <td>
                                <select name="size" id="tableSize" class="px-3">
                                    <option {{ old('size') == 1 ? 'selected' : '' }} value="1">صغيرة</option>
                                    <option {{ old('size') == 2 ? 'selected' : '' }} value="2">كبيرة</option>
                                    <option {{ old('size') == 3 ? 'selected' : '' }} value="3">وسط</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">الرقم المسلسل:</td>
                            <td><input type="text" name="serial" id="serial_number" value="{{ old('serial') }}"
                                    class="p-2"></td>
                            <td class="text-left">السعة:</td>
                            <td><input type="text" name="capacity" id="capacity" value="{{ old('capacity') }}"
                                    class="p-2"></td>
                        </tr>
                    </table>
                    <!-- One "tab" for each step in the form: -->
                    <div class="buttons">

                        <button id="dismiss_btn" class="btn btn-outline-info btn-sm"
                            onclick="window.location='{{ route('tables.home') }}'" type="button"
                            id="submitBtn">إلغاء</button>
                        <button class="btn btn-outline-success btn-sm" type="submit" id="submitBtn">إدراج</button>
                    </div>
                    @error('name')
                        <div class="alert alert-sm text-danger">{{ $message }}</div>
                    @enderror

                    @error('serial')
                        <div class="alert alert-sm text-danger">{{ $message }}</div>
                    @enderror
                </form>
            </fieldset>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let tableNumber = document.getElementById('tableNumber');
        window.onload = tableNumber.focus();
        const serialNumber = document.getElementById('serial_number');
        const capacity = document.getElementById('capacity');
        tableNumber.addEventListener('keyup', function() {
            if (parseInt(this.value) >= 3000) {
                tableSize.value = 2;
                capacity.value = 286
            } else {
                tableSize.value = 1;
                capacity.value = 221
            }
            serialNumber.value = '45000' + this.value

        })
    </script>
@endsection
