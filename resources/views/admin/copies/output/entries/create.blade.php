@extends('layouts.admin')

@section('title')
    الاخراج
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    سندات الاخراج
@endsection
@section('homeLinkActive')
    إخراج بضاعة على سند
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('receipts.out.all') }}"><span class="btn-title">العودة إلى
                الرئيسية</span><i class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('table.create') }}"><span class="btn-title">إضافة طبلية
                جديدة</span><i class="fa fa-th text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('store.items.add') }}"><span class="btn-title">إضافة صنف
                جديد</span><i class="fa fa-tag text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('store.box.size.add') }}"><span class="btn-title">إضافة حجم
                كرتون</span><i class="fa fa-box text-light"></i></a></button>
@endsection

@section('content')
    <style>

    </style>
    <div class="container pt-3">
        @if ($receipt->confirmation != 'approved')
            <fieldset style="width: 90%">
                <legend>
                    اختيار طبالى لإخراجها على السند
                </legend>
                <br>
                @php $counter = 1 @endphp
                @if (count($tables))
                    <form action="{{ route('receipt.entry.store.out') }}" method="POST" class="mb-1" id="myForm">
                        @csrf
                        <input type="hidden" name="receipt_id" value="{{ $receipt->id }}">
                        <input type="hidden" name="contract_id" id="contract_id" value="{{ $receipt->contract_id }}">
                        {{-- <input type="number" class="search_pallet" id="searchPallet"> --}}
                        <div class="input-group">
                            
                            <label class="input-group-text">طبلية رقم:</label>
                            <input class="form-control" type="number" class="search_pallet" id="searchPallet"
                                placeholder="البحث">
                            <select class="form-control" id="pick_table_id" name="table_id">
                                <option hidden>اختر الطبلية</option>
                                @foreach ($tables as $i => $table)
                                    <option value="{{ $table->table_id }}">{{ $table->name }}</option>
                                @endforeach
                            </select>

                            <select class="form-control" id="pick_item_id" name="item_id">
                                <option hidden>اختر الصنف</option>
                            </select>
                            <select class="form-control" id="pick_box_size" name="box_size">
                                <option hidden>اختر الحجم</option>
                            </select>
                            <input type="number" name="qty" id="pic_qty" class="form-control">
                            <button class="input-group-text">إضافة إلى السند</button>

                        </div>

                    </form>
                    <script>
                        const input1 = document.querySelector('#searchPallet');
                        const input2 = document.querySelector('#pick_item_id');
                        const input3 = document.querySelector('#pick_box_size');
                        const input4 = document.querySelector('#pic_qty');

                        input1.addEventListener('keydown', function(e) {
                            if (entered(e)) {
                                input2.focus()
                            }
                        });
                        input2.addEventListener('keydown', function(e) {
                            if (entered(e)) {
                                input3.focus()
                            }
                        });
                        input3.addEventListener('keydown', function(e) {
                            if (entered(e)) {
                                input4.focus()
                            }
                        });


                        function entered(evt) {
                            return evt.keyCode === 13
                        }
                    </script>
                @else
                    <div class="text-right"> لا يوجد أى بضاعة لاخراجها</div>
                @endif

            </fieldset>
        @endif
        <fieldset style="width: 90%">
            {{-- <legend>سند استلام بضاعة رقم" <span class="text-danger"> {{ $receipt->s_number }} </span></legend> --}}
            <br>

            <div class="row receipt_info">
                <div class="col col-4">
                    <span class="label">التاريخ: </span>
                    <span class="data">{{ $receipt->greg_date }}</span>
                </div>
                <div class="col col-4">
                </div>
                <div class="col col-4">
                    <span class="label">مسلسل: </span>
                    <span class="data">{{ $receipt->s_number }}</span>
                </div>
                <div class="col col-4">
                    <span id="current_client" data-client-id="{{ $receipt->theClient->id }}" class="label">العميل:
                    </span>
                    <span class="data">{{ $receipt->theClient->name }}</span>
                </div>
                <div class="col col-4 text-center m-0 text-primary">
                    <h3>
                        سند {{ $receipt->type == 1 ? 'استلام' : 'تسليم' }} بضاعة</h3>
                </div>
                <div class="col col-4">
                    <span class="label"> المزرعة / المصدر: </span>
                    <span class="data">{{ $receipt->farm }}</span>
                </div>
                <div class="col col-8">
                    <span class="label"> أخرى: </span>
                    <span class="data">{{ $receipt->notes }}</span>
                </div>
                <div class="col col-4">
                    <span class="label"> العقد: </span>
                    <span class="data">{{ $receipt->theContract->s_number }}</span>
                </div>
            </div>

            @if (isset($receipt_entries) && count($receipt_entries))
                @foreach ($receipt_entries as $index => $entry)
                    <form id="form_{{ $index }}" action="{{ route('receipt.entry.update') }}" method="POST"
                        class="mt-1">

                        @csrf
                        <input type="hidden" name="id" value="{{ $entry->id }}">
                        <div class="input-group">
                            <label class="input-group-text">{{$counter++}}</label>
                            <input class="form-control update-input" type="number" name="table_name"
                                data-form-id="#form_{{ $index }}" id="" value="{{ $entry->table->name }}">
                            <input class="form-control update-input" type="hidden" name="table_id"
                                data-form-id="#form_{{ $index }}" id="" value="{{ $entry->table_id }}">

                            <select class="form-control update-input" name="item" id="item"
                                data-form-id="#form_{{ $index }}">
                                <option hidden>الصنف</option>
                                @if (count($items))
                                    @foreach ($items as $item)
                                        <option {{ $entry->item_id == $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif

                            </select>

                            <select class="form-control update-input" name="box" id="box"
                                data-form-id="#form_{{ $index }}">
                                <option hidden>حجم الكرتون</option>
                                @if (count($boxes))
                                    @foreach ($boxes as $box)
                                        <option {{ $entry->box_size == $box->id ? 'selected' : '' }}
                                            value="{{ $box->id }}">{{ $box->short }}</option>
                                    @endforeach
                                @endif
                            </select>

                            <input class="form-control update-input" type="number" name="qty" id="qty"
                                data-form-id="#form_{{ $index }}" value="{{ $entry->tableItemQty }}"
                                placeholder="الكمية المدخلة 1234">
                            @if ($receipt->confirmation != 'approved')
                                <label class="input-group-text"> <a
                                        href="{{ route('receipt.entry.delete', $entry->id) }}"><i
                                            class="fa fa-trash text-danger" style="border-radius: opx"></i></a> </label>
                                <button type="submit" id="button_{{ $index }}"
                                    class="input-group-text text-primary">تحديث</button>
                            @endif
                        </div>
                    </form>
                @endforeach
                <div class="buttons">
                    <button class="btn btn-sm font-weight-bold btn-primary"><a
                            href="{{ route('receipts.output_receipts', [1]) }}"> سدات الإخراج </a></button>
                    <button class="btn btn-sm font-weight-bold btn-primary"><a
                            href="{{ route('receipts.output.view', [$receipt->id]) }}">عرض</a></button>
                    <button class="btn btn-sm font-weight-bold btn-info">طباعة</button>
                </div>
            @else
                <div class="text-right">لم يتم بعد إضافة أى إدخالات على هذا السند</div>
            @endif


        </fieldset>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        window.onload = function() {
            document.getElementById('myForm').reset();
            $('#searchPallet').focus()

        }



        $(document).on('keyup', '#searchPallet', function() {

            for (key in $('#pick_table_id option')) {
                if ($('#pick_table_id option')[key].value == undefined) continue
                if ($(this).val() == $('#pick_table_id option')[key].textContent) {
                    $('#pick_table_id option')[key].setAttribute('selected', 'true')

                }
            }

            var myFormData = new FormData($('#form_id')[0])
            if ($('#pick_table_id').val() != null && $('#pick_table_id').val() > 0) {
                $.ajax({
                    type: 'post',
                    url: "{{ route('table.contents.aj') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'table': $('#pick_table_id').val(),
                        'contract': $('#contract_id').val(),
                    },
                    success: function(response) {

                        $('#pick_item_id').html('')
                        $('#pick_item_id').append('<option hidden>اختر الصنف</option>')

                        response.forEach(entry => {
                            $('#pick_item_id').append('<option value="' + entry.item_id + '">' +
                                entry.item_name + '</option>')
                        })
                    },
                    error: function() {}
                })
            } else {
                $('#tableQuery > div').css('display', 'none');
            }


        });
        $(document).on('change', '#pick_box_size', function() {

            if ($('#pick_box_size').val() != null && $('#pick_box_size').val() > 0) {
                $.ajax({
                    type: 'post',
                    url: "{{ route('table.itemQty.aj') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'table': $('#pick_table_id').val(),
                        'item': $('#pick_item_id').val(),
                        'box': $('#pick_box_size').val(),
                        'contract': $('#contract_id').val(),
                    },
                    success: function(response) {

                        $('#pic_qty').attr('max', response)
                        $('#pic_qty').val(response)

                    },
                    error: function() {}
                })
            } else {
                $('#tableQuery > div').css('display', 'none');
            }
        });
        $(document).on('change', '#pick_item_id', function() {

            if ($('#pick_item_id').val() != null && $('#pick_item_id').val() > 0) {
                $.ajax({
                    type: 'post',
                    url: "{{ route('table.itemBox.aj') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'table': $('#pick_table_id').val(),
                        'item': $('#pick_item_id').val(),
                        'contract': $('#contract_id').val(),
                    },
                    success: function(response) {

                        $('#pick_box_size').html('')
                        $('#pick_box_size').append('<option hidden>اختر الحجم</option>')

                        response.forEach(box => {
                            $('#pick_box_size').append('<option value="' + box.box_size +
                                '">' + box.name + '</option>')
                        })
                    },
                    error: function() {}
                })
            } else {
                $('#tableQuery > div').css('display', 'none');
            }
        });
    </script>
@endsection
