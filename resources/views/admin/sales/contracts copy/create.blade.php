@extends('layouts.admin')
@section('headerLinks')
    @parent
@endsection
@section('title')
    إضافة عقد جديد
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    العقود
@endsection
@section('homeLinkActive')
    إضافة عقد جديد
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('contracts.home') }}"><span class="btn-title">Go Home</span><i
                class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.setting') }}"><span class="btn-title">Settings</span><i
                class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')
    <style>
        <style>b {
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
            color: rgb(0, 81, 255);
            border: 2px solid transparent;
            display: inline-block;
            border-bottom-color: #345678;
            padding: 6px 1em;
        }

        ol {
            list-style-type: none;
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

        div.create-form.total>div {
            padding: 0.25em 1em
        }

        div.create-form.total>div:first-child {
            text-align: left;
            font: bolder 16px/1 Cairo;
        }

        div.create-form.total>div.number {
            border: 1px solid #345678;
            background-color: #efefef;
        }

        div.create-form .col button,
        div.create-form .col label {
            font: bold 10px/1 'Cairo';
            padding: 3px 12px !important;
        }

        div.create-form .col button {
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
            background-color: rgb(031, 117, 254);
            width: auto;
            margin: 0;
            height: 40px;
            position: absolute;
            bottom: -8px;
            left: -8px;
            right: -8px;
        }

        .teb_footer>div {
            margin: 5px 0;
            height: 30px;
            line-height: 30px;
            color: white;
        }

        .teb_footer>div.number {
            border: 1px solid #345678;
            margin: 5px 16px;
            background-color: #fff;
            color: #345678
        }

        .teb_footer>div.text {
            font: bolder 16px/1.8 'Cairo';
            text-align: left;
        }

        div.hide {
            display: none;
        }
    </style>
    <div class="container">
        <div class="border">

            <fieldset dir="rtl" class="m-3 mt-5">
                <legend style="right: 20px; left: auto">إضافة عقد جديد</legend>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                            type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">البيانات
                            الأساسية</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                            type="button" role="tab" aria-controls="home-tab-pane" aria-selected="false">اصناف
                            العقد</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                            type="button" role="tab" aria-controls="home-tab-pane" aria-selected="false">التدفقات
                            النقدية</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="others-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                            type="button" role="tab" aria-controls="home-tab-pane" aria-selected="false">شروط
                            أخرى</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                        tabindex="0">
                        <form class="p-3" id="regForm" action="{{ route('contract.store', $client->id) }}"
                            method="post">
                            @csrf
                            <style>
                                table tr td {
                                    border-left: 0 !important;
                                    font-weight: bolder;
                                }

                                table tr td input {
                                    display: inline-block;
                                    background-color: transparent;
                                    border: 1px solid transparent;
                                    border-bottom-color: #777;
                                    margin: 0 16px
                                }
                            </style>
                            <div class="row" dir="rtl">
                                <b> اسم العميل:</b> &nbsp;
                                <span>{{ $client->name }}</span>، &nbsp;
                                <b> اسم المدير:</b> &nbsp;
                                <span>{{ $client->person }}</span>، &nbsp;
                                <b> هاتف:</b> &nbsp;
                                <span>{{ $client->phone }}</span>، &nbsp;
                                <b> سجل تجاري:</b> &nbsp;
                                <span>{{ $client->cr }}</span>.
                                <b> إقامة :</b> &nbsp;
                                <span>{{ $client->iqama }}</span>.
                            </div>

                            <div class="label text-right font-weight-bold">الترقيم</div>

                            <table class=" w-100">
                                <tr>
                                    <td class="text-left">نوع العقد:</td>
                                    <td class="">
                                        <select name="type" id="type" required>
                                            <option></option>
                                            <option value="1">عقد تأجير أساسى</option>
                                            <option value="2">زيادة عدد طبالى</option>
                                            <option value="3">تمديد مدة عقد</option>
                                        </select>
                                    </td>
                                    <td class="text-left">الكود:</td>
                                    <td class="">
                                        <input type="text" name="code" id="code" value="{{ $cCode }}"
                                            required>
                                    </td>
                                    <td class="text-left">الرقم المسلسل:</td>
                                    <td class="">
                                        <input type="text" name="s_number" id="s_number" value="{{ $lastContract }}"
                                            required>
                                    </td>
                                </tr>
                            </table>

                            <div class="label text-right font-weight-bold">الموعد</div>

                            <table class=" w-100">
                                <tr>
                                    <td class="text-left">في يوم:</td>
                                    <td class="cal-1">
                                        <input type="date" class="dateGrabber" data-target="in_day" style="width: 30px"
                                            id="in_day">
                                        <span style="padding: 0 1em;" id="in_day_greg_display">result</span>
                                        <input type="hidden" name="in_day_greg_input" id="in_day_greg_input">
                                    </td>
                                    <td class="text-left">الموافق:</td>
                                    <td class="cal-2">
                                        <span style="padding: 0 1em;" id="in_day_hijri_display">result</span>
                                        <input type="hidden" name="in_day_hijri_input" id="in_day_hijri_input">
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div class="label text-right font-weight-bold">التوقيت والمدة</div>
                            <table class="w-100">
                                <tr>
                                    <td>
                                        <label>الفترة المبدئية</label>
                                    </td>
                                    <td><input type="number" name="start_period" id="start_period"></td>
                                    <td colspan="2">
                                        <label>شهر/أشهر، بعدها يتم التجديد لمدة:</label>
                                    </td>
                                    <td><input type="number" name="renew_period" id="start_period"></td>
                                    <td>شهر/أشهر</td>
                                </tr>
                                <tr>
                                    <td class="text-left">بداية العقد:</td>
                                    <td class="cal-1" colspan="2">
                                        <input type="date" class="dateGrabber" data-target="starts_in"
                                            style="width: 30px" id="starts_in">
                                        <span style="padding: 0 1em;" id="starts_in_greg_display">result</span>
                                        <input type="hidden" name="starts_in_greg_input" id="starts_in_greg_input">
                                    </td>
                                    <td class="text-left">الموافق:</td>
                                    <td class="cal-2" colspan="2">
                                        <span style="padding: 0 1em;" id="starts_in_hijri_display">result</span>
                                        <input type="hidden" name="starts_in_hijri_input" id="starts_in_hijri_input">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">نهاية العقد:</td>
                                    <td class="cal-1" colspan="2">
                                        <input type="date" class="dateGrabber" data-target="ends_in"
                                            style="width: 30px" id="ends_in">
                                        <span style="padding: 0 1em;" id="ends_in_greg_display">00/00/2000</span>
                                        <input type="hidden" name="ends_in_greg_input" id="ends_in_greg_input">
                                    </td>
                                    <td class="text-left">الموافق:</td>
                                    <td class="cal-2" colspan="2">
                                        <span style="padding: 0 1em;" id="ends_in_hijri_display">00/00/1400</span>
                                        <input type="hidden" name="ends_in_hijri_input" id="ends_in_hijri_input">
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
                    </div>
                    {{-- <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">...</div>
                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...</div>
                    <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div> --}}
                </div>
            </fieldset>
        </div>
    </div>


    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function fillInFields(el) {
            let total = parseFloat(document.getElementById(el.id + 'Value').innerHTML = document.getElementById(el.id +
                'MonthlyAmount').innerHTML * 3.00 * el.value)
            let Vat = document.getElementById(el.id + 'VAT').innerHTML = document.getElementById(el.id + 'MonthlyAmount')
                .innerHTML * 3.00 * el.value * 0.15
            document.getElementById(el.id + 'AfterVat').innerHTML = total + Vat;
            let aaa = parseFloat(document.getElementById('smallTablesAfterVat', 10).innerHTML)
            let bbb = parseFloat(document.getElementById('largeTablesAfterVat', 10).innerHTML)
            let ccc = parseFloat(document.getElementById('smallRoomsAfterVat', 10).innerHTML)
            let ddd = parseFloat(document.getElementById('largeRoomsAfterVat', 10).innerHTML)
            totalsSum.innerHTML = aaa + bbb + ccc + ddd
        }
    </script>
    <script>
        let dateInputs = ['in_day', 'starts_in', 'ends_in'];
        window.onload = function() {
            dateInputs.forEach((id) => {
                const dateInput = document.getElementById(id)
                updateOnload(id)

                dateInput.onchange = function(e) {
                    updateOnchange(e.target.id)
                }
            })
        }

        function updateOnload(id) {
            let today = new Date();
            document.getElementById(id + '_greg_display').innerHTML = today.toLocaleDateString('ar-eg')
            document.getElementById(id + '_greg_input').value = dateFormatNumeral(today)
            document.getElementById(id + '_hijri_display').innerHTML = today.toLocaleDateString('ar-sa')
            document.getElementById(id + '_hijri_input').value = today.toLocaleDateString('ar-sa')
        }

        function updateOnchange(id) {
            let today = new Date(document.getElementById(id).value);
            document.getElementById(id + '_greg_display').innerHTML = today.toLocaleDateString('ar-eg')
            document.getElementById(id + '_greg_input').value = dateFormatNumeral(today)
            document.getElementById(id + '_hijri_display').innerHTML = today.toLocaleDateString('ar-sa')
            document.getElementById(id + '_hijri_input').value = today.toLocaleDateString('ar-sa')
        }

        function dateFormatNumeral(date) {
            return date.getFullYear() + '-' + [date.getMonth() + 1] + '-' + date.getDate();
        }
    </script>
@endsection
