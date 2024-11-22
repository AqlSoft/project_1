@extends('layouts.admin')
@section('title')
    جهات الاتصال
@endsection
@section('pageHeading')
    إضافة جهة اتصال جديدة
@endsection


@section('content')
    <div class="container p-3" style="min-height: 100vh">

        <fieldset>
            <legend style="top: -1.6rem; padding: 0.375rem 1rem">
                إضافة جهة اتصال جديدة &nbsp;
                <a class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" title="عرض جميع جهات الاتصال"
                    href="{{ route('contacts.home') }}"><i class="fa fa-list"></i></a>
            </legend>
            <form class="my-3" action="{{ route('contacts.store') }}" method="POST">
                @csrf
                <div class="input-group my-2">
                    <label for="name" class="input-group-text">الاسم</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="اسم جهة الاتصال">
                    <label for="phone" class="input-group-text">الهاتف</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="+9665XXXXXXXX">
                </div>
                <div class="input-group my-2">
                    <label for="email" class="input-group-text">البريد الالكترونى</label>
                    <input type="text" class="form-control" name="email" id="email"
                        placeholder="البريد الالكترونى">
                    <label for="iqama" class="input-group-text">الهوية / الإثامة</label>
                    <input type="text" class="form-control" name="iqama" id="iqama" placeholder="1015457896">
                </div>
                <div class="input-group my-2">
                    <label for="rule" class="input-group-text">الوظيفة</label>
                    <input type="text" class="form-control" name="rule" id="rule" placeholder="الوظيفة">

                    <button class="input-group-text" type="submit">إدخال البيانات</button>


                </div>
            </form>


        </fieldset>

    </div>
@endsection


@section('script')
@endsection
