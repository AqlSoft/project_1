@extends('layouts.admin')

@section('title') الاخراج @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') سندات الاخراج @endsection
@section('homeLinkActive') إخراج بضاعة على سند @endsection
@section('links')

<button class="btn btn-sm btn-primary"><a href="{{ route('receipts.out.all') }}"><span class="btn-title">العودة إلى الرئيسية</span><i class="fa fa-home text-light"></i></a></button>
<button class="btn btn-sm btn-primary"><a href="{{ route('table.create') }}"><span class="btn-title">إضافة طبلية جديدة</span><i class="fa fa-th text-light"></i></a></button>
<button class="btn btn-sm btn-primary"><a href="{{ route('store.items.add') }}"><span class="btn-title">إضافة صنف جديد</span><i class="fa fa-tag text-light"></i></a></button>
<button class="btn btn-sm btn-primary"><a href="{{ route('store.box.size.add') }}"><span class="btn-title">إضافة حجم كرتون</span><i class="fa fa-box text-light"></i></a></button>
@endsection

@section('content')
<style>
    #table_create input, #table_create select {
        padding: 0 10px;
    }

    * {
        font-family: Cairo
    }
    
    b {
        color: rgb(0, 81, 255)
    }

    nav .nav-tabs {
        padding: 0 40px;
    }

    nav .nav-tabs button.nav-link {
        margin: 0 3px 0;
        border: 1px solid #6c757d;
        color: #999
    }
    nav .nav-tabs button.nav-link.active {
        color: rgb(0, 81, 255);
        border: 1px solid #6c757d;
        border-bottom: 5px solid #ffffff;
    }

    .nav-link a {
        color: #999;
        font: bold 14px/1.4 Cairo;
    }
    .nav-link.active a {
        color: inherit
    }

    .tab-content {
        border: 1px solid #345678;
        margin-top: -4px;
        text-align: right;
        padding: .5em;
    }
    .tab-pane h4 {
        font: bold 14px/1.4 Cairo;
        color:rgb(0, 81, 255);
        border: 2px solid transparent;
        display: inline-block ;
        border-bottom-color: #345678;
        padding: 6px 1em;
    }
    ol {
        list-style-type:none; 
        padding: 0;
    }
    ol li {
        margin-bottom: 8px;
        background-color: #e4e3e3;
        padding: 5px;
    }
    div.create-form.total {
        padding: 0.25em;
        background-color: #e4e3e3;
    }

    div.create-form.total > div {
        padding: 0.25em 1em
    }

    div.create-form.total > div:first-child { 
        text-align: left;
        font: bolder 16px/1 Cairo;
    }

    div.create-form.total > div.number { 
        border: 1px solid #345678;
        background-color: #efefef;
    }

    div.create-form .col button,
    div.create-form .col label {
        font: bold 10px/1 'Cairo';
        padding: 3px 12px !important;
    }

    div.create-form .col button{
        height: 33px !important;
    }
    div.create-form .col select, 
    div.create-form div.col input[type=text],
    div.create-form div.col input[type=number] {
        font: normal 12px/1 'Cairo' !important;
        height: 33px !important;
        text-align: center;
        width: 100%;
    }

    .teb_footer {
        justify-content: end; 
        background-color:rgb(031, 117, 254); 
        width: auto; 
        margin: 0; 
        height: 40px; 
        position: absolute; 
        bottom: -8px; 
        left: -8px; 
        right: -8px;
    }
    
    .teb_footer > div {
        margin: 5px 0; 
        height: 30px; 
        line-height: 30px;
        color: white;
    }
    
    .teb_footer > div.number {
        border: 1px solid #345678;
        margin: 5px 16px;
        background-color: #fff;
        color: #345678
    }
    
    .teb_footer > div.text {
        font: bolder 16px/1.8 'Cairo';
        text-align: left;
    }
    div.hide {
        display: none;
    }
    .input-group label,
    .input-group button,
    .input-group select.form-control, 
    .input-group select.form-control option, 
    .input-group .form-control {
        height: 36px !important;
        border: 1px solid;
        line-height: 36px;
        padding-top: 0;
    }
</style>
<fieldset style="width: 90%">
    <legend>
       اختيار طبالى لإخراجها على السند  
    </legend>
    <br>

@if (count($tables))

<form action="{{ route('receipt.entry.store.out') }}" method="POST" class="mb-1" id="pick_entry">
    @csrf
    <input type="hidden" name="receipt_id" value="{{$receipt->id}}"> 
    <input type="hidden" name="contract_id" value="{{$receipt->contract_id}}"> 
    <div class="input-group">
        <label class="input-group-text">طبلية رقم:</label>
        <select class="form-control" id="pick_table_id" name="table_id">
            <option hidden>اختر الطبلية</option>
            @foreach($tables as $i => $table )
            <option value="{{$table->id}}">{{$table->name}}</option>
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
    @else
    <div class="text-right"> لا يوجد أى بضاعة لاخراجها</div>
    @endif
</fieldset>

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
            <span id="current_client" data-client-id="{{$receipt->theClient->id}}" class="label">العميل: </span>
            <span class="data">{{$receipt->theClient->name}}</span>
        </div>
        <div class="col col-4 text-center m-0 text-primary"><h3>
            سند {{$receipt->type == 1 ? 'استلام' : 'تسليم'}} بضاعة</h3>
        </div>
        <div class="col col-4">
            <span class="label"> المزرعة / المصدر: </span>
            <span class="data">{{$receipt->farm}}</span>
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
    <form id="form_{{$index}}" action="{{route('receipt.entry.update')}}" method="POST" class="mt-1">

        @csrf
        <input type="hidden" name="id" value="{{$entry->id}}">
        <div class="input-group">
            <input class="form-control update-input" type="number" name="table_name" data-form-id="#form_{{$index}}" id="" value="{{$entry->table->name}}">
            <input class="form-control update-input" type="hidden" name="table_id" data-form-id="#form_{{$index}}" id="" value="{{$entry->table_id}}">
            
            <select class="form-control update-input" name="item" id="item" data-form-id="#form_{{$index}}">
                <option hidden>الصنف</option>
                @if(count($items)) @foreach ($items as $item)
                <option {{$entry->item_id == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                @endforeach @endif

            </select>
            
            <select class="form-control update-input" name="box" id="box" data-form-id="#form_{{$index}}">
                <option hidden>حجم الكرتون</option>
                @if(count($boxes)) @foreach ($boxes as $box)
                <option {{$entry->box_size == $box->id ? 'selected' : ''}} value="{{$box->id}}">{{$box->short}}</option>
                @endforeach @endif
            </select>

            <input class="form-control update-input" type="number" name="qty" id="qty"  data-form-id="#form_{{$index}}" value="{{$entry->qty}}" placeholder="الكمية المدخلة 1234">
            <label class="input-group-text">  <a href="{{ route('receipt.entry.delete', $entry) }}"><i class="fa fa-trash text-danger" style="border-radius: opx"></i></a>   </label>
            <button type="submit" id="button_{{$index}}" class="input-group-text text-primary">تحديث</button>
        </div>
    </form>
    @endforeach
    <div class="buttons">
        <button class="btn btn-sm font-weight-bold btn-primary">العودة للسندات</button>
        <button class="btn btn-sm font-weight-bold btn-primary">عرض</button>
        <button class="btn btn-sm font-weight-bold btn-info">طباعة</button>
    </div>
    @else
    <div class="text-right">لم يتم بعد إضافة أى إدخالات على هذا السند</div>
    

    @endif
    
    
</fieldset>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#pick_table_id').reset();
    })

    $(document).on('change', '#pick_table_id', function () {
        
        var myFormData = new FormData($('#form_id')[0])
        if ($('#pick_table_id').val() != null && $('#pick_table_id').val() > 0) {
            $.ajax({
                type:       'post',
                url:        "{{route('receipt.entry.table.contents')}}",
                data:    {
                    '_token': "{{csrf_token()}}",
                    'table_id': $('#pick_table_id').val(),
                },
                success: function (response) {
                    
                    console.log(response);
                    $('#pick_item_id').html('')
                    $('#pick_item_id').append('<option hidden>اختر الصنف</option>')
                    
                    response.forEach(entry => {
                        $('#pick_item_id').append('<option value="'+entry.item_id+'">'+entry.itemName+'</option>')
                    })

                    $('#pic_qty').val(0)
                },
                error: function () {
    
                }
            })
        } else {
            $('#tableQuery > div').css('display', 'none');
        }
    
        
    });
    $(document).on('change', '#pick_box_size', function () {
        
        if ($('#pick_box_size').val() != null && $('#pick_box_size').val() > 0) {
            $.ajax({
                type:       'post',
                url:        "{{route('receipt.entry.item.qty')}}",
                data:    {
                    '_token': "{{csrf_token()}}",
                    'table_id': $('#pick_table_id').val(),
                    'item_id': $('#pick_item_id').val(),
                    'box_size': $('#pick_box_size').val(),
                },
                success: function (response) {
                    
                    console.log(response);
                    $('#pic_qty').val(response.total_item_qty)
                    
                },
                error: function () {
    
                }
            })
        } else {
            $('#tableQuery > div').css('display', 'none');
        }
    
        
    });
    $(document).on('change', '#pick_item_id', function () {
        
        if ($('#pick_item_id').val() != null && $('#pick_item_id').val() > 0) {
            $.ajax({
                type:       'post',
                url:        "{{route('receipt.entry.item.box')}}",
                data:    {
                    '_token': "{{csrf_token()}}",
                    'table_id': $('#pick_table_id').val(),
                    'item_id': $('#pick_item_id').val(),
                },
                success: function (response) {
                    
                    console.log(response);
                    $('#pick_box_size').html('')
                    $('#pick_box_size').append('<option hidden>اختر الحجم</option>')
                    response.forEach(size => {
                        $('#pick_box_size').append('<option value="'+size.box_size+'">'+size.name+'</option>')
                    })
                    $('#pic_qty').val(response.total_item_qty)
                    
                },
                error: function () {
    
                }
            })
        } else {
            $('#tableQuery > div').css('display', 'none');
        }
    
        
    });


    
        
    
</script>

@endsection
