@extends('layouts.admin')

@section('title') Clients - Create @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Accounts / Clients @endsection
@section('homeLinkActive') View Client @endsection
@section('links')

<button class="btn btn-sm btn-primary"><a href="{{ route('clients.home') }}"><span class="btn-title">العودة إلى الرئيسية</span><i class="fa fa-home text-light"></i></a></button>
@endsection

@section('content')
<style>
    table tr td {
        padding: 3px 5px;
    }
    table tr td select {
        width: 98%;
        margin: auto;
        display: inline-block
    }

</style>
<div class="container">

    <h4 class="text-right">{{$client->name}}</h4>
    <table class="w-100" dir="rtl">
        <tr>
            <td class="text-left">المجال:</td>
            <td class="text-right">{{ $scopes[$client->scope] }}</td>
        </tr>
        <tr>
            <td class="text-left">الهاتف:</td>
            <td class="text-right">{{ $client->phone }}</td>
        </tr>
        <tr>
            <td class="text-left">العنوان:</td>
            <td class="text-right" colspan="3">{{ $client->state }} - {{ $client->city }} - {{ $client->street }}</td>

        </tr>
    </table>

    <fieldset>
        <legend>استلام بضاعة على العقد</legend>
        <br>
        <form action="">
            @csrf
            <table class="w-100">
                <tr>
                    <td style="width: 20%" class="text-left">في يوم:</td>
                    <td style="width: 20%" class="cal-1">
                        <input type="date" class="dateGrabber" data-target="in_day" style="width: 30px" id="in_day">
                        <span style="padding: 0 1em;" id="in_day_greg_display">result</span>
                        <input type="hidden" name="in_day_greg_input" id="in_day_greg_input">
                    </td>
                    <td style="width: 20%" class="cal-2" >
                        <span style="padding: 0 1em;" id="in_day_hijri_display">result</span>
                        <input type="hidden" name="in_day_hijri_input" id="in_day_hijri_input">                              
                    </td>
                    <td style="width: 20%">رقم السند</td>
                    <td style="width: 20%"><input type="text" name="doc_number"></td>
                </tr>
                <tr>
                    <td>
                        <select name="size">
                            <option hidden>رقم الطبلية</option>
                            @foreach ($storeItems as $i => $item)
                            <option value="{{$item->id}}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="size">
                            <option hidden>حجم الطبلية</option>
                            <option value="1"> صغيرة </option>
                            <option value="2"> كبيرة </option>
                        </select>
                    </td>
                    <td>
                        <select name="item" >
                            <option hidden>الصنف</option>
                            @foreach ($storeItems as $i => $item)
                            <option value="{{$item->id}}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="table" >
                            <option hidden>حجم الكرتون</option>
                            @foreach ($boxSizes as $i => $size)
                            <option value="{{$size->id}}">{{ $size->short }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" name="table" placeholder="الكمية"></td>
                </tr>

                <tr>
                    <td>ملاحظات</td>
                    {{--                    <td colspan=4>--}}
                    <td colspan="4"><input type="text" name="notes" value="{{old('notes')}}"></td>
                    <td><button type="submit" class="btn btn-sm btn-primary"> تسجيل السند </button></td>
                </tr>
            </table>
        </form>
    </fieldset>


    {{-- <form action="{{route('contract.items.store')}}" method="post">
        @csrf
        <div class="input-group">
            <label for="" class="input-group-text">1</label>
            <input type="text" name="name[]" class="form-control">
            <input type="text" name="size[]" class="form-control">
            <input type="text" name="item[]" class="form-control">
            <input type="text" name="qty[]" class="form-control">
            <span class="input-group-text" title="Repeate Record"><i class="fa fa-copy"></i></span>
            <span class="input-group-text" title="New Record"><i class="fa fa-plus"></i></span>
            <span class="input-group-text" title="delete Record"><i class="fa fa-minus"></i></span>
        </div>

        <div class="input-group">
            <label for="" class="input-group-text">2</label>
            <input type="text" name="name[]" class="form-control">
            <input type="text" name="size[]" class="form-control">
            <input type="text" name="item[]" class="form-control">
            <input type="text" name="qty[]" class="form-control">
            <span class="input-group-text" title="Repeate Record"><i class="fa fa-copy"></i></span>
            <span class="input-group-text" title="New Record"><i class="fa fa-plus"></i></span>
            <span class="input-group-text" title="delete Record"><i class="fa fa-minus"></i></span>
        </div>

        <div class="input-group">
            <label for="" class="input-group-text">3</label>
            <input type="text" name="name[]" class="form-control">
            <input type="text" name="size[]" class="form-control">
            <input type="text" name="item[]" class="form-control">
            <input type="text" name="qty[]" class="form-control">
            <span class="input-group-text" title="Repeate Record"><i class="fa fa-copy"></i></span>
            <span class="input-group-text" title="New Record"><i class="fa fa-plus"></i></span>
            <span class="input-group-text" title="delete Record"><i class="fa fa-minus"></i></span>
        </div>
        
        <button type="submit">save</button>
    </form> --}}
    <h4 class="text-right">الادخالات السابقة</h4>
    <table class="w-100" dir="rtl">
        <tr>
            
        </tr>
    </table>
</div>

@endsection
@section('script')
<script type="text/javascript">

    function fillInFields(el) {
        let total = parseFloat(document.getElementById(el.id+'Value').innerHTML=document.getElementById(el.id+'MonthlyAmount').innerHTML*3.00*el.value)
        let Vat = document.getElementById(el.id+'VAT').innerHTML=document.getElementById(el.id+'MonthlyAmount').innerHTML*3.00*el.value*0.15
        document.getElementById(el.id+'AfterVat').innerHTML=total+Vat;
        let aaa = parseFloat(document.getElementById('smallTablesAfterVat', 10).innerHTML)
        let bbb = parseFloat(document.getElementById('largeTablesAfterVat', 10).innerHTML)
        let ccc = parseFloat(document.getElementById('smallRoomsAfterVat', 10).innerHTML)
        let ddd = parseFloat(document.getElementById('largeRoomsAfterVat', 10).innerHTML)
        totalsSum.innerHTML = aaa+bbb+ccc+ddd
    }

</script>
<script>
    let dateInputs = ['in_day', 'starts_in', 'ends_in'];
    window.onload = function () {
        dateInputs.forEach( (id) => {
            const dateInput = document.getElementById(id)
            updateOnload (id)
            
            dateInput.onchange = function (e) {
                updateOnchange (e.target.id)
            }
        })
    }

    function updateOnload (id) {
        let today = new Date ();
            document.getElementById(id+'_greg_display').innerHTML = today.toLocaleDateString('ar-eg')
            document.getElementById(id+'_greg_input').value = dateFormatNumeral (today)
            document.getElementById(id+'_hijri_display').innerHTML = today.toLocaleDateString('ar-sa')
            document.getElementById(id+'_hijri_input').value = today.toLocaleDateString('ar-sa')
    }

    function updateOnchange (id) {
        let today = new Date (document.getElementById(id).value);
            document.getElementById(id+'_greg_display').innerHTML = today.toLocaleDateString('ar-eg')
            document.getElementById(id+'_greg_input').value = dateFormatNumeral (today)
            document.getElementById(id+'_hijri_display').innerHTML = today.toLocaleDateString('ar-sa')
            document.getElementById(id+'_hijri_input').value = today.toLocaleDateString('ar-sa')
    }

    function dateFormatNumeral (date) {
        return date.getFullYear()+ '-' +[date.getMonth()+1]+ '-' +date.getDate();
    }

   
</script>
@endsection
