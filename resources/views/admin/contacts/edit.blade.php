@extends('layouts.admin')
@section('title')
    جهات الاتصال
@endsection

@section('pageHeading')
    تعديل مدخل جديد
@endsection

@section('content')
    <div class="container p-3" style="min-height: 100vh">

        <fieldset>
            <legend style="top: -1.6rem; padding: 0.375rem 1rem">
                تعديل بيانات جهة اتصال &nbsp;
                <a class="btn btn-sm btn-outline-primary py-1" data-bs-toggle="tooltip" data-bs-title="عرض بيانات جهة اتصال"
                    href="{{ route('contacts.show', [$contact->id]) }}"><i class="fa fa-eye"></i></a>
            </legend>
            <form class="my-4" action="{{ route('contacts.update') }}" method="POST">
                @csrf

                <input type="hidden" name="id" value="{{ $contact->id }}">

                <div class="input-group my-2">
                    <label for="name" class="input-group-text">الاسم</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $contact->name }}">
                    <label for="phone" class="input-group-text">الهاتف</label>
                    <input type="text" class="form-control" name="phone" id="phone" value="{{ $contact->phone }}">
                </div>
                <div class="input-group my-2">
                    <label for="email" class="input-group-text">البريد الالكترونى</label>
                    <input type="text" class="form-control" name="email" id="email" value="{{ $contact->email }}">
                    <label for="iqama" class="input-group-text">الهوية / الإقامة</label>
                    <input type="text" class="form-control" name="iqama" id="iqama" value="{{ $contact->iqama }}">
                </div>
                <div class="input-group my-2">
                    <label for="rule" class="input-group-text">الوظيفة</label>
                    <input type="text" class="form-control" name="rule" id="rule" value="{{ $contact->rule }}">

                    <button class="input-group-text" type="submit">تحديث البيانات</button>

                </div>
            </form>


        </fieldset>

    </div>
@endsection


@section('script')
@endsection