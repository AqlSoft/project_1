@extends('layouts.admin')

@section('title')
    الجرد والتسوية
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    سندات الجرد
@endsection
@section('homeLinkActive')
    جرد وتسوية بضاعة على سند
@endsection


@section('content')

    <div class="container pt-3">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">

                <button class="nav-link">
                    <a href="{{ route('operating.home', [2]) }}">الرئيسية</a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('operating.inventory.receipts', [1]) }}">
                        السندات
                    </a>
                </button>
                <button class="nav-link active">
                    تسوية بضاعة على السند
                </button>

            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background:#fff">
            <fieldset style="width: 90%">
                <legend>سند تسوية حمولات طبالى رقم" <span class="text-danger"> {{ $receipt->s_number }} </span></legend>
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
                        <span id="current_client" data-client-id="{{ $receipt->client->id }}" class="label">العميل:
                        </span>
                        <span class="data"><a
                                href="{{ route('clients.view', [$receipt->client->id, 2]) }}">{{ $receipt->client->a_name }}</a></span>
                    </div>
                    <div class="col col-4 text-center m-0 text-primary">
                        <h3 class="fs-4">
                            سند تسوية حمولات طبالي</h3>
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
                        <span class="data"><a
                                href="{{ route('contract.view', [$receipt->contract->id, 2]) }}">{{ $receipt->contract->s_number }}</a></span>
                    </div>
                </div>

                @if (isset($entries) && count($entries))
                    @php $counter =1 @endphp
                    <table class="w-75 m-auto">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>نوع السجل</td>
                                <td>رقم الطبلية</td>
                                <td>الحجم</td>
                                <td>الصنف</td>
                                <td>الكرتون</td>
                                <td>الكمية المخرجة</td>
                                @if ($receipt->confirmation != 'approved')
                                    <td><i class="fa fa-cogs"></i></td>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $index => $entry)
                                <form id="form_{{ $index }}" action="{{ route('receipt.entry.update') }}"
                                    method="POST" class="mt-1">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $entry->id }}">
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $entry->type == 1 ? 'إدخال' : 'إخراج' }}</td>
                                        <td>{{ $entry->table->name }}</td>
                                        <td>{{ $entry->table->size == 1 ? 'صغيرة' : 'كبيرة' }}</td>
                                        <td>{{ $entry->item->name }}</td>
                                        <td>{{ $entry->box->name }}</td>
                                        <td>{{ $entry->tableItemQty }}</td>



                                        @if ($receipt->confirmation != 'approved')
                                            <td><a href="{{ route('receipt.entry.delete', $entry->id) }}"><i
                                                        class="fa fa-trash text-danger" style="border-radius: opx"></i></a>
                                            </td>
                                        @endif
                                    </tr>

                                </form>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="buttons">
                        <button class="btn btn-sm font-weight-bold btn-primary"><a
                                href="{{ route('operating.inventory.receipts', [1]) }}">
                                سدات التسوية </a></button>
                        <button class="btn btn-sm font-weight-bold btn-primary"><a
                                href="{{ route('operating.print_inventory_receipts', [$receipt->id]) }}">عرض</a></button>
                        <button class="btn btn-sm font-weight-bold btn-info">طباعة</button>
                    </div>
                @else
                    <div class="text-right">لم يتم بعد إضافة أى إدخالات على هذا السند</div>
                @endif


            </fieldset>

            @if ($receipt->confirmation != 'approved')
                <fieldset style="width: 90%">
                    <legend>
                        اختيار طبالى لجرد كمياتها على السند
                    </legend>
                    <br>
                    @foreach ($tables as $i => $t)
                        @foreach ($t->itemsArray as $key => $value)
                            @foreach ($t->itemsBoxes as $ib => $box)
                                @if ($box[$value->item_id]->totalQty != 0)
                                    <form action="{{ route('receipts.storeInventoryReceipt') }}" method="POST">
                                        @csrf

                                        <input type="hidden" name="receipt" value="{{ $receipt->id }}">
                                        <div class="input-group border mb-2 w-75" style="display: flex; margin: auto">
                                            <div style="flex:1; padding: 5px 15px">
                                                {{ $t->tableName }}
                                                <input type="hidden" name="table" value="{{ $t->table_id }}">
                                                <input type="hidden" name="table_size" value="{{ $t->table_size }}">
                                            </div>
                                            <div style="flex:1; padding: 5px 15px">
                                                {{ $value->itemName }}
                                                <input type="hidden" name="item" value="{{ $value->item_id }}">
                                            </div>
                                            <div style="flex:1; padding: 5px 15px">
                                                {{ $box[$value->item_id]->boxName }}
                                                <input type="hidden" name="box"
                                                    value="{{ $box[$value->item_id]->box_size }}">
                                            </div>
                                            <div style="flex:1; padding: 5px 15px">
                                                {{ $box[$value->item_id]->totalQty }}
                                                <input type="hidden" name="totalQty"
                                                    value="{{ $box[$value->item_id]->totalQty }}">
                                                <input type="hidden" name="type"
                                                    value="{{ $box[$value->item_id]->totalQty > 0 ? 2 : 1 }}">
                                            </div>
                                            <div style="flex:1">
                                                <button type="submit"
                                                    style="height: 100%; padding: 5px 16px">تسوية</button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            @endforeach
                        @endforeach
                    @endforeach
                </fieldset>
            @endif
        </div>


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
