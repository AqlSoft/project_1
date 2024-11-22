@extends('layouts.admin')

@section('title')
    السندات
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    السندات / سندات الإدخال
@endsection
@section('homeLinkActive')
    تعديل بيانات سند الإدخال
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('receipts.home') }}"><span class="btn-title">العودة إلى
                الرئيسية</span><i class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('receipts.input_receipts') }}">
            <i data-bs-toggle="tooltip" data-bs-title="العودة إلى سندات الإدخال" class="fas fa-file-invoice-dollar"></i>
        </a></button>
@endsection

@section('content')
    <style>
        .input-group label,
        .input-group button,
        .input-group select.form-control,
        .input-group .form-control {
            height: 36px !important;
            border: 1px solid
        }
    </style>
    <div class="container pt-5">
        <fieldset style="width: 90%">
            <legend>
                تعديل بيانات سند الإدخال
            </legend>
            <form action="{{ route('receipts.updateInputReceipt') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $item->id }}">
                <div class="input-group mt-4">
                    <label class="input-group-text" for="greg_date_input">فى يوم:</label>
                    <label class="input-group-text">
                        {{ $item->greg_date }}
                    </label>

                    <label class="input-group-text" for="hij_date_input"> الموافق: </label>
                    <label class="input-group-text" id="hij_date_display">
                        {{ $item->hij_date }}
                    </label>
                    <input class="" type="hidden" name="hij_date_input" id="hij_date_input">
                    <select class="form-control" name="contract" id="contract" style="height: 45px">

                        <option>{{ $item->the_client->name }} -
                            رقم العقد [
                            {{ $item->the_contract->s_number }} ]</option>


                    </select>
                </div>
                <div class="input-group mt-3">
                    <label class="input-group-text" for="hij_date_input"> اسم السائق: </label>
                    <input class="form-control" type="text" name="driver" placeholder="اسم السائق"
                        value="{{ $item->driver }}">
                </div>
                <div class="input-group mt-3">
                    <label class="input-group-text" for="hij_date_input"> المزرعة أو المصدر: </label>
                    <input class="form-control" type="text" name="farm" placeholder="اسم المزرعة / المصدر"
                        value="{{ $item->farm }}">
                </div>
                <div class="input-group mt-3">
                    <label class="input-group-text" for="hij_date_input"> ملاحظات أخرى: </label>
                    <input class="form-control" type="text" name="notes" placeholder="ملاحظات أخرى"
                        value="{{ $item->notes }}">
                </div>
                <div class="input-group mt-3">
                    <label for="" class="input-group-text">نوع السند</label>
                    <label for="" class="input-group-text" style="padding:1em">
                        <select class="" name="" id=""
                            style="height: 36px; width: 100%; background: transparent; border: 0; outline: 0">
                            <option>{{ 'ترتيب مخزن' }}</option>
                        </select>
                    </label>

                    <label class="input-group-text"> الرقم المسلسل:

                    </label>
                    <input type="text" class="form-control text-primary fw-bold" value="{{ $item->s_number }}">

                    <button type="submit" value="حفظ" class="input-group-text"> حفظ </button>
                </div>

            </form>
        </fieldset>
    </div>
@endsection
@section('script')
@endsection
