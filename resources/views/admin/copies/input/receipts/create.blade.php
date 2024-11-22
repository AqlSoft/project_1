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
    إنشاء سند إدخال جديد
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('clients.home') }}"><span class="btn-title">العودة إلى
                الرئيسية</span><i class="fa fa-home text-light"></i></a></button>
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
                إضافة سند إستلام بضاعة
            </legend>
            <form action="{{ route('receipts.storeInputReceipt') }}" method="POST">
                @csrf

                <div class="input-group mt-4">
                    <label class="input-group-text" for="greg_date_input">فى يوم:</label>
                    <label class="input-group-text">
                        <input class="" type="date" name="greg_date_input" id="greg_date_input"
                            style="width: 1.4em; padding: 0; border: 0; outline: 0;background-color: #0000" value="">
                    </label>
                    <label class="form-control" style="width: 2em">
                        <p class="" id="greg_date_display">Result</p>
                        {{-- <input class="" type="hidden" name="hij_date_input" id="hij_date_input"> --}}
                    </label>
                    <label class="input-group-text" for="hij_date_input"> الموافق: </label>
                    <input class="" type="hidden" name="hij_date_input" id="hij_date_input">
                    <label class="input-group-text"id="hij_date_display"> Result </label>
                </div>
                <div class="input-group mt-3">
                    <input type="text" id="searchClients" class="form-control">
                    <select class="form-control" name="contract" id="contract" style="height: 45px">
                        <option value="no_client">----</option>
                        @if (count($contracts))
                            @foreach ($contracts as $o => $item)
                                <option {{ old('contract') == $item->id . ',' . $item->client ? 'selected' : '' }}
                                    value="{{ $item->id }},{{ $item->client }}">{{ $item->theClient->name }} - العقد
                                    {{ $item->s_number }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="input-group mt-3">
                    <label for="" class="input-group-text">سند</label>
                    <label for="" class="input-group-text" style="padding:1em">
                        <select class="" name="type" id="type"
                            style="height: 36px; width: 100%; background: transparent; border: 0; outline: 0">
                            <option value="1">إدخال</option>
                        </select>
                    </label>
                    <input class="form-control" type="text" value="{{ old('driver') }}" name="driver"
                        placeholder="اسم السائق">
                    <input class="form-control" type="text" value="{{ old('farm') }}" name="farm"
                        placeholder="اسم المزرعة / المصدر">
                </div>
                <div class="input-group mt-3">
                    <input class="form-control" type="text" value="{{ old('notes') }}" name="notes"
                        placeholder="ملاحظات أخرى">

                    <label class="input-group-text" id="s_number_label" data-in-value="{{ $lir }}"
                        data-out-value="{{ $lor }}"> الرقم المسلسل:
                        <input type="number" name="s_number" id="s_number_input" value="{{ old('s_number') }}">
                        {{-- <span id="s_n_generated"></span> --}}
                    </label>
                    <button type="submit" value="حفظ" class="input-group-text"> حفظ </button>
                </div>

            </form>
        </fieldset>
    </div>

    <div class="hidden" style="display: none">{{ $contracts }}</div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#type').val(1);
            $('#s_n_generated').html($('#s_number_label').attr('data-in-value')).css('color', 'blue')
            $('#s_number_input').val($('#s_number_label').attr('data-in-value'))

            let today = new Date();

            $('#greg_date_input').val(dateFormatNumeral(today));
            $('[name=greg_date]').val(dateFormatNumeral(today));
            $('#greg_date_display').html(dateFormatNumeral(today));
            //dateFormatNumeral (today)
            $('#hij_date_display').html(today.toLocaleDateString('ar-sa'))
            $('#hij_date_input').val($('#hij_date_display').html());
        })

        $(document).on('change', '#type', function() {
            if ($('#type').val() == 1) {
                $('#s_n_generated').html($('#s_number_label').attr('data-in-value')).css('color', 'blue')
                $('#s_number_input').val($('#s_number_label').attr('data-in-value'))
            } else {
                $('#s_n_generated').html($('#s_number_label').attr('data-out-value')).css('color', 'red')
                $('#s_number_input').val($('#s_number_label').attr('data-out-value'))
            }
        })

        $(document).on('change', '#s_n_picker', function() {

        })



        let contracts = JSON.parse($('div.hidden').html());
        //console.log(contracts)

        $(document).on('keyup', '#searchClients', function() {
            let v = $('#searchClients').val();


            let options = []
            contracts.forEach(i => {
                if (i.theClient.name.indexOf(v) > -1) {
                    options.push('<option value="' + i.id + ','+i.theClient.id+'">' + i.theClient.name + ' - ' + i.s_number +
                        '</option>')
                }

            });
            $('#contract').html('')
            if (options.length > 0) {
                options.forEach(option => {
                    $('#contract').append(option)
                })
            } else {
                $('#contract').append('<option>لم يطابق البحث أى نتائج</option>')
            }

        })

        // let gregDate = document.getElementById('greg_date_input'),
        //     hijgDate = document.getElementById('hij_date_input'),
        //     gregDateDisplay = document.getElementById('greg_date_display'),
        //     hijDateDisplay = document.getElementById('hij_date_display')
        // window.onload = function() {
        //     let today = new Date();
        //     //gregDate.value = today.toLocaleDateString('ar-sa');
        //     gregDateDisplay.innerHTML = dateFormatNumeral(today);
        //     //dateFormatNumeral (today)
        //     hijDateDisplay.innerHTML = hijgDate.value = today.toLocaleDateString('ar-sa');
        // }

        // gregDate.onchange = function() {
        //     let today = new Date(this.value);
        //     //gregDate.value = today.toLocaleDateString('ar-sa');
        //     gregDateDisplay.innerHTML = dateFormatNumeral(today);
        //     //dateFormatNumeral (today)
        //     hijDateDisplay.innerHTML = hijgDate.value = today.toLocaleDateString('ar-sa');
        // }

        let putZero = function(n) {
            return n <= 9 ? "0" + n : n;
        }

        function dateFormatNumeral(date) {
            return date.getFullYear() + '-' + [putZero(date.getMonth() + 1)] + '-' + putZero(date.getDate());
        }
    </script>
@endsection
