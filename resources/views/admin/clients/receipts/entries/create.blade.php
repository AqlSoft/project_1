@extends('layouts.admin')

@section('title') الإدخال @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') سندات الإدخال @endsection
@section('homeLinkActive') إدخال بضاعة على سند @endsection
@section('links')

<button class="btn btn-sm btn-primary"><a href="{{ route('receipts.home') }}"><span class="btn-title">العودة إلى الرئيسية</span><i class="fa fa-home text-light"></i></a></button>
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
        تخصيص طبالى على السند   
    </legend>
    <br>


    <form action="{{route('receipt.entry.store')}}" method="POST">
        @csrf
        Receipt Id = {{ $receipt->id }} <br>
        Receipt type = {{ $receipt->type }} <br>
        The Clent = {{ $receipt->client_id }}
        <input type="hidden" name="receipt_id" value="{{$receipt->id}}">
        <div class="input-group">
            <input class="form-control" type="number" name="table_name" id="table" value="{{old('table_name')}}" placeholder=" رقم الطبلية ">
            <button id="submitEntry" type="submit" class="input-group-text" style="color: rgb(5, 160, 5)">إضافة</button>
        </div>
    </form>
    <div id="tableQuery" class="text-right">
        <div class="result" id="notFound" style="display: none">الطبلية رقم: &nbsp;<b class="tableNumber">000</b>&nbsp;غير موجودة، هل تود إضافتها إلى الموجودات؟ 
            <form action="{{route('table.store')}}" method="post" id="table_create">
                @csrf
                <input type="text" name="name" id="tableName" style="width: 120px">
                <select name="size" id="table_size" style="width: 120px; padding: 0 1em">
                    <option value="1">صغيرة</option>
                    <option value="2">كبيرة</option>
                </select>
                <input type="text" name="serial" id="table_serial" style="width: 120px">
                <input type="text" name="capacity" id="table_capacity" style="width: 120px">
                <button type="button" id="saveTable" style="height: 34px; padding: 0 1em; outline:0; border: 1px solid #777" >إلغاء</button>
                <button type="submit" id="saveTable" style="height: 34px; padding: 0 1em; outline:0; border: 1px solid #777" >إضافة</button>
            </form>
        </div>

        <div class="result" id="tableFree" style="display: none">الطبلية رقم: &nbsp;<b class="tableNumber">000</b>&nbsp; موجودة، وفارغة </div>
        <div class="result" id="tableBusy" style="display: none">الطبلية رقم: &nbsp;<b class="tableNumber">000</b>&nbsp; موجودة، و <b id="contract"></b> وبها  <b id="load"></b>  كرتون</div>
    </div>
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
            سند استلام بضاعة</h3>
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
        
    @if (count($entries))
    @foreach ($entries as $index => $entry)
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
    $(document).on('keyup', '#table', function () {
        
        var myFormData = new FormData($('#form_id')[0])
        if ($('#table').val() != null && $('#table').val() > 0) {
            $.ajax({
                type:       'post',
                url:        "{{route('receipt.entry.check.table')}}",
                data:    {
                    '_token': "{{csrf_token()}}",
                    'table_id': $('#table').val(),
                },
                success: function (response) {
                    
                    var tableInfo = '';
                    
                    if (response == '') {
                        $('#submitEntry').attr('type', 'button')
                        $('button#submitEntry').css('color', 'darkgrey')
                        $('#tableQuery > .result').css('display', 'none');
                        $('#notFound').css('display', 'block')
                        $('.tableNumber').html($('#table').val())
                        $('#tableName').val($('#table').val())
                        $('#table_serial').val($('#table').val().toString().padStart(8, '450000'))
                        $('#table_size').val(function () {
                            return $('#table').val() >= 3000 ? 2 : 1
                        })
                        $('#table_capacity').val(function () {
                            return $('#table').val() >= 3000 ? 299 : 221
                        })
                        
                    } else {
                        if (response.status == '0') {
                            $('#tableQuery > .result').css('display', 'none');
                            $('#tableFree').css('display', 'block')
                            $('.tableNumber').html($('#table').val())
                            $('#submitEntry').attr('type', 'submit')
                        }
                        if (response.status == '1') {
                            $('#submitEntry').attr('type', 'submit')
                            $('#tableQuery > .result').css('display', 'none');
                            $('#tableBusy').css('display', 'block')
                            $('.tableNumber').html($('#table').val())
                            if (response.the_client.id == $('#current_client').attr('data-client-id')) {
                                $('#submitEntry').attr('type', 'submit')
                                $('#contract').html('مرتبطة بهذا العقد')
                            
                            } else {
                                $('#submitEntry').attr('type', 'button')
                                $('#contract').html('مرتبطة بعقد آخر')
                            }
                            $('#load').html(response.the_load)
                        }
                        // var theLoad = response.the_load = 0 ? 'فارغة' : response.the_load;
                        // tableInfo = '<b>الطبلية رقم:</b> '+response.name+''
                    }
                    
                    //console.log(response.the_client.name)
                    
                },
                error: function () {
    
                }
            })
        } else {
            $('#tableQuery > div').css('display', 'none');
        }
    
        let number = 2
        let result = number.toString().padStart(7, '450000')
        
    });
        
    
</script>

@endsection
