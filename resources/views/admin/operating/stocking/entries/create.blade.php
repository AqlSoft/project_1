@extends('layouts.admin')

@section('title')
    السندات
@endsection
@section('pageHeading')
    محضر جرد بضاعة عميل
@endsection

@section('content')
    <div class="container m-3 p-3">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">

                <button class="nav-link">
                    <a href="{{ route('operating.home', [2]) }}">الرئيسية</a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('stocking.home', [1]) }}">
                        السندات الجارية
                    </a>
                </button>
                <button class="nav-link active">
                    انشاء سند جديد
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background:#fff">


            <fieldset style="">
                <legend>سند تسوية حمولات طبالى رقم" <span class="text-danger"> {{ $receipt->s_number }} </span>
                </legend>
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
                        <span id="current_client" data-client-id="{{ $receipt->client_id }}" class="label">العميل:
                        </span>
                        <span class="data">{{ $client->a_name }}</span>
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
                        <span class="data">{{ $contract->s_number }}</span>
                    </div>
                </div>


            </fieldset>
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
