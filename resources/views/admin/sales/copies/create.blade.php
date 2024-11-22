@extends('layouts.admin')
@section('headerLinks')
@parent
@endsection
@section('title') إضافة عقد جديد @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') العقود @endsection
@section('homeLinkActive') إضافة عقد جديد @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('contracts.home') }}"><span class="btn-title">Go Home</span><i class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.setting') }}"><span class="btn-title">Settings</span><i class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')
    <div class="container">
        <div class="border">
            <fieldset  dir="rtl" class="m-3 mt-5" >
                <legend style="right: 20px; left: auto">إضافة عقد جديد</legend>
                <form class="p-3" id="regForm" action="{{ route('contract.store', $client->id) }}" method="post">
                    @csrf
                    <style>
                        table tr td {border-left: 0 !important; font-weight: bolder;}
                        table tr td input {display: inline-block; background-color: transparent; border: 1px solid transparent; border-bottom-color: #777; margin: 0 16px}
                    </style>

@foreach($items as $in => $item)
    {{$item->a_name}}
@endforeach

                    <div class="row" dir="rtl">
                        <b> اسم العميل:</b> &nbsp;
                        <span>{{$client->name}}</span>، &nbsp;
                        <b> اسم المدير:</b> &nbsp;
                        <span>{{$client->person}}</span>، &nbsp;
                        <b> هاتف:</b> &nbsp;
                        <span>{{$client->phone}}</span>، &nbsp;
                        <b> سجل تجاري:</b> &nbsp;
                        <span>{{$client->cr}}</span>.
                    </div>

                    <div class="label text-right font-weight-bold">الموعد</div>
                    
                    <table class=" w-100">
                        <tr>
                            <td class="text-left">في يوم:</td>
                            <td class="cal-1">
                                <input type="date" class="dateGrabber" data-target="in_day" style="width: 30px" id="in_day">
                                <span style="padding: 0 1em;" id="in_day_greg_display">result</span>
                             <input type="hidden" name="in_day_greg_input" id="in_day_greg_input">
                            </td>
                            <td class="text-left">الموافق:</td>
                            <td class="cal-2" >
                                <span style="padding: 0 1em;" id="in_day_hijri_display">result</span>
                                <input type="hidden" name="in_day_hijri_input" id="in_day_hijri_input">                              
                            </td>
                        </tr>
                    </table>
                    
                    <br>
                    <div class="label text-right font-weight-bold">الوحدات التخزينية</div>
                    <table class="w-100">
                        <tr>
                            <td>م</td>
                            <td>الصنف</td>
                            <td>العدد</td>
                            <td>المدة</td>
                            <td>الايجار الشهري</td>
                            <td>القيمة</td>
                            <td>الضريبة</td>
                            <td>الاجمالى</td>
                            
                        </tr>
                        <tr>
                            <td>1</td>
                            <td >طبالى صغير</td>
                            <td><input id="smallTables" type="number" name="smallTables" value="0" style="width:100px"
                                onblur="fillInFields(this)"></td>
                            <td>3 شهور</td>
                            <td><span id="smallTablesMonthlyAmount">60</span> ريال </td>
                            <td id="smallTablesValue">0</td>
                            <td id="smallTablesVAT">0</td>
                            <td id="smallTablesAfterVat">0</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td >طبالى كبيرة</td>
                            <td><input id="largeTables" type="number" name="largeTables" value="0" style="width:100px" 
                                onblur="fillInFields(this)"></td>
                            <td>3 شهور</td>
                            <td><span id="largeTablesMonthlyAmount">90</span> ريال </td>
                            <td id="largeTablesValue">0</td>
                            <td id="largeTablesVAT">0</td>
                            <td id="largeTablesAfterVat">0</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td >
                                غرف صغيرة
                                <select name="bigrooms" id="" style="display: block">
                                    <option value="1">المستودع A - الغرفة A5</option>
                                    <option value="2">المستودع B - الغرفة B5</option>
                                    <option value="3">المستودع C - الغرفة C5</option>
                                    <option value="4">المستودع D - الغرفة D5</option>
                                </select>
                            </td>
                            <td><input id="smallRooms" type="number" name="smallRooms" value="0" style="width:100px" min="0" max="1" step="1"
                                onblur="fillInFields(this)"></td>
                            <td>3 شهور</td>
                            <td><span id="smallRoomsMonthlyAmount">5000</span> ريال </td>
                            <td id="smallRoomsValue">0</td>
                            <td id="smallRoomsVAT">0</td>
                            <td id="smallRoomsAfterVat">0</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td >
                                غرف كبيرة
                                <select name="bigrooms" id="" style="display: block">
                                    <option value="1">المستودع A - الغرفة A1</option>
                                    <option value="2">المستودع A - الغرفة A2</option>
                                    <option value="3">المستودع A - الغرفة A3</option>
                                    <option value="4">المستودع A - الغرفة A4</option>
                                    <option value="5">المستودع B - الغرفة B1</option>
                                    <option value="6">المستودع B - الغرفة B2</option>
                                    <option value="7">المستودع B - الغرفة B3</option>
                                    <option value="8">المستودع B - الغرفة B4</option>
                                    <option value="9">المستودع C - الغرفة C1</option>
                                    <option value="10">المستودع C - الغرفة C2</option>
                                    <option value="11">المستودع C - الغرفة C3</option>
                                    <option value="12">المستودع C - الغرفة C4</option>
                                    <option value="13">المستودع D - الغرفة D1</option>
                                    <option value="14">المستودع D - الغرفة D2</option>
                                    <option value="15">المستودع D - الغرفة D3</option>
                                    <option value="16">المستودع D - الغرفة D4</option>
                                    
                                </select>
                            </td>
                            <td><input id="largeRooms" type="number" name="largeRooms"  value="0" style="width:100px" min="0" max="1" step="1"
                                onblur="fillInFields(this)"></td>
                            <td>3 شهور</td>
                            <td><span id="largeRoomsMonthlyAmount">6000</span> ريال </td>
                            <td id="largeRoomsValue">0</td>
                            <td id="largeRoomsVAT">0</td>
                            <td id="largeRoomsAfterVat">0</td>
                        </tr>
                        <tr style="border-top: 2px solid #666">
                            <td colspan="6" class="text-left">المجموع:</td>
                            <td id="totalsSum"></td>
                        </tr>
                    </table>
                    <script></script>
                    <br>
                    <table class="w-100">   
                        <tr>
                            <td class="text-left">بداية العقد:</td>
                            <td class="cal-1">
                                <input type="date" class="dateGrabber" data-target="starts_in" style="width: 30px" id="starts_in">
                                <span style="padding: 0 1em;" id="starts_in_greg_display">result</span>
                                <input type="hidden" name="starts_in_greg_input" id="starts_in_greg_input">
                            </td>
                            <td class="text-left">الموافق:</td>
                            <td class="cal-2" >
                                <span style="padding: 0 1em;" id="starts_in_hijri_display">result</span>
                                <input type="hidden" name="starts_in_hijri_input" id="starts_in_hijri_input">                              
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">نهاية العقد:</td>
                            <td class="cal-1">
                                <input type="date" class="dateGrabber" data-target="ends_in" style="width: 30px" id="ends_in">
                                <span style="padding: 0 1em;" id="ends_in_greg_display">00/00/2000</span>
                             <input type="hidden" name="ends_in_greg_input" id="ends_in_greg_input">
                            </td>
                            <td class="text-left">الموافق:</td>
                            <td class="cal-2" >
                                <span style="padding: 0 1em;" id="ends_in_hijri_display">00/00/1400</span>
                                <input type="hidden" name="ends_in_hijri_input" id="ends_in_hijri_input">  
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">المطلوب مقدما:</td>
                            <td><input type="text" name="name" id="" value="{{old('name')}}"></td>
                            <td class="text-left">الباقي يسدد في:</td>
                            <td>
                                <input type="number" name="paymentPeriod" id="" value="{{ old('paymentPeriod') ? old('paymentPeriod') : 0 }}"  style="width: 80px" step=1>
                                <select name="bigrooms" id="">
                                    <option value="0">تم سداد كامل القيمة</option>
                                    <option value="days">يوم / أيم</option>
                                    <option value="weeks">اسبوع / أسابيع</option>
                                    <option value="months">شهر / أشهر</option>
                                </select>
                            </td>

                        </tr>
                        <tr>
                            <td colspan="4" class="text-right pr-3">شروط إضافية:
                                <input class="rooms" type="hidden" name="street" id="" value="{{old('street')}}" placeholder="">
                            </td>
                        </tr>
                    </table>
                    <!-- One "tab" for each step in the form: -->
                    <div style="">
                        <br>
                        <button id="dismiss_btn" class="btn btn-success" 
                        onclick="window.location='{{ route('clients.home') }}'">إلغاء</button>
                        <button class="btn btn-secondary" type="submit" id="submitBtn">إدراج</button>
                    </div>
                </form>
            </fieldset>
        </div>
        <div class="alterContext">
            <ul class="menu-items">
                <li class="context-menu-item">
                    Vew Category Items
                </li>
                <li class="context-menu-item">
                    Add New Category
                </li>
                <li class="context-menu-item">
                    Edit Category
                </li>
                <li class="context-menu-item">
                    Delete Category
                </li>
            </ul>
        </div>
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
