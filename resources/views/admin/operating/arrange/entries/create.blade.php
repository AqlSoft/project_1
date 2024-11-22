@extends('layouts.admin')

@section('title')
    السندات
@endsection
@section('pageHeading')
    سجلات ترتيب الطبالى
@endsection

@section('content')
    <style>
        form .row .col.col-auto input,
        form .row .col.col-auto span.order,
        form .row .col.col-auto select {
            padding: 0.1rem 1rem;
            margin: .2rem auto .3rem;
            border: 1px solid #ddd;
            background-color: #f7f7f7;
            outline: none;
            /* border-radius: 1.3rem; */
            display: block;
            width: 90%;
            box-sizing: border-box;
        }


        label {
            padding: 0 1rem;
        }

        form .row .col.col-auto {
            max-width: 18%;
            padding: 0;
            border-radius: 1rem;
            margin: 0 2px;
            border: 1px solid #ccc;
            box-sizing: border-box;

        }
    </style>

    <div class="container pt-3">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">

                <button class="nav-link">
                    <a href="{{ route('arrange.home', [2]) }}">الرئيسية</a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('arrange.home', [1]) }}">
                        السندات الجارية
                    </a>
                </button>
                <button class="nav-link active">
                    انشاء وتعديل سجلات عمليات الترتيب

                </button>

            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background:#fff">
            <fieldset class="mt-5 mx-3">
                <legend>
                    نموذج ترتيب الطبالى
                </legend>

                <div class="the_form entries_form mt-2">
                    <form id="save_form" action="{{ route('arrange.entries.store') }}" method="POST">
                        @csrf
                        @php
                            $table_id = null == isset($the_copy) ? null : $the_copy->table_id;
                            $item_id = null == isset($the_copy) ? null : $the_copy->item_id;
                            $box_size = null == isset($the_copy) ? null : $the_copy->box_size;

                            $inputs = null == isset($the_copy) ? null : $the_copy->inputs;
                            $outputs = null == isset($the_copy) ? null : $the_copy->outputs;
                        @endphp
                        <input type="hidden" id="contract" name="contract_id" value="{{ $receipt->contract_id }}">
                        <input type="hidden" id="receipt" name="receipt_id" value="{{ $receipt->id }}">
                        <div class="row">

                            <div class="col col-auto">
                                <label for="the_table">اختر الطبلية</label>
                                <select name="table_id" id="the_table" data-url="{{ route('get.table.contents') }}"
                                    data-token="{{ csrf_token() }}" data-contract="{{ $receipt->contract_id }}">
                                    <option hidden></option>
                                    @foreach ($tables as $item)
                                        <option {{ $table_id == $item->table_id ? 'selected' : '' }}
                                            value="{{ $item->table_id }}">{{ $item->table_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col col-auto">
                                <label for="the_items">اسم الصنف</label>
                                <select name="item_id" id="the_items" required>
                                    <option hidden></option>
                                    @foreach ($items as $item)
                                        <option {{ $item_id == $item->item_id ? 'selected' : '' }}
                                            value="{{ $item->item_id }}">{{ $item->item_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col col-auto">
                                <label for="the_box">حجم الكرتون</label>
                                <select name="box_size" id="the_box" required>
                                    <option hidden></option>
                                    @foreach ($boxes as $box)
                                        <option {{ $box_size == $box->box_size ? 'selected' : '' }}
                                            value="{{ $box->box_size }}">{{ $box->box_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col col-auto">
                                <label for="input">مدخلات</label>
                                <input type="number" name="inputs" id="input" data-form-id="#form"
                                    value="{{ $inputs }}" placeholder="اضافة">
                            </div>
                            <div class="col col-auto">
                                <label for="output">مخرجات</label>
                                <input type="number" name="outputs" id="output" data-form-id="#form"
                                    value="{{ $outputs }}" placeholder="خصم">
                            </div>
                            <div class="col col-auto buttons">
                                <button class="btn btn-sm btn-outline-primary" type="submit" name="save"
                                    data-bs-toggle="tooltip" title="حفظ السجل"><i style="transform: rotateY(180deg)"
                                        class="fas fa-paper-plane"></i> حفظ</button>

                            </div>

                        </div>
                    </form>
                    <div id="tableContents"></div>
                </div>
            </fieldset>
            <fieldset class="mt-5 mx-3">
                <legend>
                    السجلات على السند
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
                        <span id="current_client" data-client-id="{{ $receipt->client_id }}" class="label">العميل: </span>
                        <span class="data"><a target="_blank"
                                href="{{ 'clients.view', $client->id }}">{{ mb_substr($client->a_name, 0, 25) }}</a></span>
                    </div>
                    <div class="col col-4 text-center m-0 text-primary">
                        <h3>
                            سند ترتيب طبالى
                        </h3>
                    </div>
                    <div class="col col-4">
                        <span class="label"> المزرعة / المصدر: </span>
                        <span class="data">{{ $receipt->farm }}</span>
                    </div>
                    <div class="col col-8">
                        <span class="label"> أخرى: </span>
                        <span class="data">{{ $receipt->notes ? $receipt->notes : 'لا يوجد' }}</span>
                    </div>
                    <div class="col col-4">
                        <span class="label"> العقد: </span>
                        <span class="data"> <a target="_blank"
                                href="{{ route('contract.view', [$receipt->contract_id, 2]) }}">{{ $contract->s_number }}</a></span>
                    </div>
                </div>

                @if (count($entries))
                    @php
                        $c = 1;
                    @endphp
                    <table class="w-100">
                        <thead class="">
                            <tr class="">
                                <th class="">#</th>
                                <th class="">طبلية رقم</th>
                                <th class="">الصنف</th>
                                <th class="">كرتون</th>
                                <th class="">مدخلات</th>
                                <th class="">مخرجات</th>
                                <th class="">التحكم</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($entries as $entry)
                                <form id="update_form" action="{{ route('arrange.entries.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" id="entry" name="entry_id" value="{{ $entry->id }}">

                                    <tr class="">
                                        <td class="">
                                            <span>{{ str_pad($c++, 2, '00', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td class="">
                                            {{ $entry->table_name }}
                                        </td>
                                        <td class="">
                                            {{ $entry->item_name }}
                                        </td>
                                        <td class="">
                                            {{ $entry->box_name }}
                                        </td>
                                        <td style="width: 15%">
                                            <input type="number" name="inputs" id="input" data-form-id="#form"
                                                placeholder="اضافة" value="{{ $entry->inputs }}">
                                        </td>
                                        <td style="width: 15%">
                                            <input type="number" name="outputs" id="output" data-form-id="#form"
                                                placeholder="حذف" value="{{ $entry->outputs }}">
                                        </td>
                                        <td class="w-25">
                                            <div class="buttons p-0 m-0">
                                                <button class="btn btn-sm btn-outline-primary" type="submit"
                                                    name="save" data-bs-toggle="tooltip" title="تحديث السجل"><i
                                                        class="fas fa-magic"></i> تحديث
                                                </button>
                                                <button class="btn btn-sm btn-outline-primary" type="button"
                                                    name="repeat" data-bs-toggle="tooltip" title="تكرار السجل">
                                                    <a
                                                        href="{{ route('arrange.entries.copy', [$receipt->id, $entry->id]) }}"><i
                                                            class="fas fa-level-down-alt"></i> تكرار</a></button>
                                                <button class="btn btn-sm btn-outline-primary"
                                                    type="button"data-bs-toggle="tooltip" title="حذف السجل">
                                                    <a href="{{ route('arrange.entries.delete', [$entry->id]) }}">
                                                        <i class="fas fa-times-circle"></i> حذف</a>
                                                </button>
                                            </div>
                                        </td>
                                </form>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="buttons">
                        <button class="btn btn-sm btn-outline-primary">
                            <a href="{{ route('arrange.home', $receipt->id) }}"> العودة لسندات الترتيب </a>
                        </button>
                        <button class="btn btn-sm btn-outline-primary"><a
                                href="{{ route('arrange.print', $receipt->id) }}">اعتماد
                                وطباعة</a></button>
                        <button class="btn btn-sm btn-outline-primary"><a
                                href="{{ route('contract.view', [$receipt->contract_id, 3]) }}">
                                الذهاب للعقد </a></button>
                    </div>
                @else
                    <div class="alert alert-warning text-right">لم يتم بعد إضافة أى سجلات على هذا السند</div>
                @endif
            </fieldset>


        </div>

    </div>
    <div id="loader">
        <div class="loader"></div>
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        showLoader()
        $(document).ready(() => {
            removeLoader()
        })

        $(document).on('blur', '#the_table', function() {
            let ajax_url = $('#the_table').attr('data-url');
            let ajax_token = $('#the_table').attr('data-token');
            let ajax_table = $('#the_table').val();
            let ajax_contract = $('#the_table').attr('data-contract');

            //console.log(ajax_search_token);
            jQuery.ajax({
                url: ajax_url,
                type: 'post',
                dataType: 'html',
                data: {
                    '_token': ajax_token,
                    ajax_url: ajax_url,
                    table: ajax_table,
                    contract: ajax_contract
                },
                cash: false,
                success: function(data) {

                    $('#tableContents').html(data);
                },
                error: function() {
                    // implement falure
                }
            });
        });

        function showLoader() {
            $('#loader').css({
                display: 'block'
            });
        }

        function removeLoader() {
            $('#loader').css({
                display: 'none'
            })
        }
    </script>
@endsection
