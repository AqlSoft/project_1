@extends('layouts.admin')

@section('title')
    السندات
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    السندات / سندات الإخراج
@endsection
@section('homeLinkActive')
    إنشاء سند إخراج جديد
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('receipts.home') }}"><span class="btn-title">العودة إلى
                الرئيسية</span><i class="fa fa-home text-light"></i></a></button>
@endsection

@section('content')
    <style>
        .input-group label,
        .input-group button,
        .input-group select.form-control,
        .input-group .form-control {
            height: 36px !important;
            border: 1px solid;
        }
    </style>

    <div class="container pt-3">

        <fieldset style="width: 90%">
            <legend>
                إضافة سند إخراج بضاعة

            </legend>
            <form action="{{ route('receipts.storeOutputReceipt') }}" method="POST">
                @csrf
                <div class="input-group mt-4">
                    <label class="input-group-text" for="greg_date_input">فى يوم:</label>
                    <label class="input-group-text">
                        <input class="" type="date" name="greg_date_input" id="greg_date_input"
                            style="width: 1.4em; padding: 0; border: 0; outline: 0;background-color: #0000"
                            value="{{ old('greg_date_input') }}">
                    </label>
                    <label class="form-control" style="width: 2em ">
                        <p class="" id="greg_date_display">Result</p>
                        <input class="d-none" type="text" name="greg_date">
                        <input class="d-none" type="text" name="hij_date_input" id="hij_date_input">
                    </label>
                    <label class="input-group-text"> الموافق: </label>
                    <label class="input-group-text"id="hij_date_display">
                        Result
                    </label>
                </div>
                <div class="input-group mt-3">
                    <input type="text" id="searchClients" class="form-control">
                    <select class="form-control" name="contract" id="contract" style="height: 45px">

                        <option value="no_client">--------</option>
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
                            <option selected value="4">جرد / تسوية</option>
                        </select>
                    </label>
                    <input class="form-control" type="text" name="driver" placeholder="اسم المستلم">
                    <input class="form-control" type="text" name="farm" placeholder="الوجهة / التاجر">
                </div>
                <div class="input-group mt-3">
                    <input class="form-control" type="text" name="notes" placeholder="ملاحظات أخرى">

                    <label class="input-group-text" id="s_number_label" data-in-value="{{ $the_serial }}"
                        data-out-value="{{ $the_serial }}"> الرقم المسلسل:
                        <input type="number" name="s_number" id="s_number_input" value="">
                        {{-- <span id="s_n_generated"></span> --}}
                    </label>
                    <button type="submit" value="حفظ" class="input-group-text"> حفظ </button>
                </div>


            </form>

            @if ($last5 != null)

                @if (count($last5) == 0)
                    <div class="alert alert-warning mt-3">
                        لا يوجد سندات غير معتمدة
                    </div>
                @else
                    <h4 class="mx-5 mt-5 mb-2">عرض أخر {{ count($last5) }} سندات</h4>
                    <div class="mx-5">
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>التاريخ</th>
                                    <th>رقم السند</th>
                                    <th>مرجعى</th>
                                    <th>العقد</th>
                                    <th>اجمالي</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($last5 as $in => $item)
                                    <tr>
                                        <td>{{ ++$in }}</td>
                                        <td>
                                            {{ $item->hij_date }} <br>
                                            {{ $item->greg_date }}
                                        </td>
                                        <td>
                                            <a class="btn btn-sm displayReceipt btn-block p-1 mb-1 bg-secondary"
                                                data-receipt-id="{{ $item->id }}"
                                                data-search-token="{{ csrf_token() }}"
                                                data-search-url="{{ route('delivery.info') }}" data-tab="1"
                                                class="fa fa-eye text-primary" data-bs-toggle="tooltip"
                                                data-bs-title="عرض محتويات السند">{{ $item->s_number }}</a>
                                            <span class="btn btn-sm btn-block p-1 mb-1 bg-secondary">بواسطة:
                                                {{ $item->theAdmin }}</span>
                                        </td>
                                        <td>
                                            السائق
                                            : {{ $item->driver }} <br>
                                            ملاحظات: {{ $item->notes }}
                                        </td>
                                        <td><a class="btn btn-sm btn-block p-1 mb-1 bg-secondary"
                                                href="{{ route('contract.view', [$item->contract_id, 5]) }}"
                                                data-bs-toggle="tooltip" data-bs-title="رؤية العقد">العقد:
                                                {{ $item->contractSerialNumber }}</a>

                                            <a class="btn btn-sm btn-block p-1 bg-secondary"
                                                href="{{ route('clients.view', [$item->client_id]) }}"
                                                data-bs-toggle="tooltip" data-bs-title="رؤية العميل"> العميل:
                                                {{ $item->clientName }}</a>
                                        </td>
                                        <td>{{ $item->total_outputs }}</td>
                                        <td>

                                            <a href="{{ route('delivery.entries.create', [$item->id, 0]) }}"><i
                                                    class="fa fa-sign-in-alt text-info" data-bs-toggle="tooltip"
                                                    data-bs-title="استلام بضاعة على السند"></i></a>

                                            <a href="{{ route('delivery.approve', [$item->id]) }}"><i
                                                    class="fa fa-check text-success" data-bs-toggle="tooltip"
                                                    data-bs-title="اعتماد السند"></i></a>

                                            <a href="{{ route('delivery.edit', [$item->id]) }}"><i
                                                    class="fa fa-edit text-primary" data-bs-toggle="tooltip"
                                                    data-bs-title="تعديل بيانات السند"></i></a>
                                            <a class="" href="{{ route('stores.table.position', [$item->id]) }}"
                                                data-tab="1"><i class="fa fa-th text-primary" data-bs-toggle="tooltip"
                                                    data-bs-title="تسكين طبالى السند"></i></a>

                                            <a href="{{ route('delivery.destroy', [$item->id]) }}"
                                                onclick="if (!confirm('انت على وشك القيام بعملية لا يمكن الرجوع نها، هل أنت متأكد؟')) return false"><i
                                                    class="fa fa-trash text-danger"data-bs-toggle="tooltip"
                                                    data-bs-title="حذف السند"></i></a>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                @endif

            @endif

        </fieldset>
    </div>
    <div class="hidden" style="display: none">{{ $contracts }}</div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#type').val(4);
            $('#s_n_generated').html($('#s_number_label').attr('data-in-value')).css('color', 'red')
            $('#s_number_input').val($('#s_number_label').attr('data-in-value'))
        });

        $(document).on('change', '#type', function() {
            if ($('#type').val() == 1) {
                $('#s_n_generated').html($('#s_number_label').attr('data-in-value')).css('color', 'blue')
                $('#s_number_input').val($('#s_number_label').attr('data-in-value'))
            } else {
                $('#s_n_generated').html($('#s_number_label').attr('data-out-value')).css('color', 'red')
                $('#s_number_input').val($('#s_number_label').attr('data-out-value'))
            }
        });

        $(window).on('load', function() {
            let today = new Date();

            $('#greg_date_input').val(dateFormatNumeral(today));
            $('[name=greg_date]').val(dateFormatNumeral(today));
            $('#greg_date_display').html(dateFormatNumeral(today));
            //dateFormatNumeral (today)
            console.log($('[name=greg_date]').val())
            $('#hij_date_display').html(today.toLocaleDateString('ar-sa'))
            $('#hij_date_input').val($('#hij_date_display').html());
        });

        $('#greg_date_input').on('change', function() {
            let today = new Date(this.value);
            //gregDate.value = today.toLocaleDateString('ar-sa');

            $('#greg_date_display').html(dateFormatNumeral(today));
            //dateFormatNumeral (today)
            $('#hij_date_input').val(today.toLocaleDateString('ar-sa'))
            $('#hij_date_display').html($('#hij_date_input').val());
        });
        let contracts = JSON.parse($('div.hidden').html());
        //console.log(contracts)

        $(document).on('keyup', '#searchClients', function() {
            let v = $('#searchClients').val();


            let options = []
            contracts.forEach(i => {
                if (i.theClient.a_name.indexOf(v) > -1) {
                    options.push('<option value="' + i.id + ',' + i.theClient.id + '">' + i.theClient
                        .a_name +
                        ' - ' + i.s_number +
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

        });

        let putZero = function(n) {
            return n <= 11 ? "0" + n : n;
        };

        function dateFormatNumeral(date) {
            return date.getFullYear() + '-' + [putZero(date.getMonth() + 1)] + '-' + putZero(date.getDate());
        };
    </script>
@endsection
