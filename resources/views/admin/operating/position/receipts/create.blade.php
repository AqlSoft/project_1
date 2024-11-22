@extends('layouts.admin')

@section('title')
    السندات
@endsection
@section('pageHeading')
    سندات ترتيب المخازن
@endsection

@section('content')
    <div class="container pt-5">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">

                <button class="nav-link">
                    <a href="{{ route('operating.home', [2]) }}">الرئيسية</a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('position.home', [2]) }}">السندات</a>
                </button>

                <button class="nav-link active">
                    انشاء سند جديد
                </button>

            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background:#fff">

            <form action="{{ route('position.store') }}" method="POST">
                @csrf
                <div id="receipt_date" class="mt-3 input-group">
                    <label class="input-group-text" for="greg_date_picker">بتاريخ:</label>
                    <label class="input-group-text">
                        <input type="date" name="greg_date" id="greg_date_picker" value="">
                    </label>
                    <label class="input-group-text">
                        <span id="greg_date_display"></span>
                        <input type="hidden" name="greg_date" id="greg_date_input" value="">
                    </label>
                    <label class="input-group-text">الموافق:</label>
                    <label class="input-group-text">
                        <span id="hijri_date_display"></span>
                        <input type="hidden" name="hijri_date" value="" id="hijri_date_input">
                    </label>
                    <label for="type" class="input-group-text">سند</label>

                    <select name="type" id="type" class="form-control">
                        <option value="5">ترتيب مخزن</option>
                    </select>
                </div>
                <div class="input-group mt-1">
                    <label class="input-group-text" for="contract">اختر عميل:</label>
                    <input type="text" id="searchClients" class="form-control" placeholder="اكتب الحروف الأولى">
                    <label class="input-group-text" data-bs-toggle="modal" data-bs-target="#add-new-client">
                        <a href="{{ route('clients.home') }}"><i data-bs-toggle="tooltip" data-bs-title="إضافة عميل جديد"
                                class="fa fa-plus"></i></a>
                    </label>
                    <select class="form-control" name="contract" id="contract" style="height: 45px">
                        <option value="no_client">----</option>
                        @if (count($contracts))
                            @foreach ($contracts as $o => $contract)
                                <option {{ old('contract') == $contract->id ? 'selected' : '' }}
                                    value="{{ $contract->id }}">{{ $contract->client_name }} - رقم العقد
                                    {{ $contract->s_number }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>



                <div class="input-group mt-1">

                    <label class="input-group-text" for="reason">السبب:</label>
                    <input class="form-control" type="text" value="{{ old('reasom') }}" name="reason"
                        placeholder="شرح سبب عملية الترتيب">
                </div>

                <div class="input-group mt-1">
                    <label class="input-group-text" for="notes">ملاحظات:</label>
                    <input class="form-control" type="text" id="notes" value="{{ old('notes') }}" name="notes"
                        placeholder="ملاحظات أخرى">
                    <label class="input-group-text" id="s_number_label" data-serial="{{ $lir }}"> الرقم
                        المسلسل:
                        <input type="number" name="s_number" id="s_number_input" value="{{ $lir }}">

                    </label>
                    <button type="submit" value="حفظ" class="input-group-text"> حفظ السند </button>
                </div>
            </form>

        </div>
    </div>

    <div class="hidden" id="contracts_list" style="display: none">{{ $contracts }}</div>
@endsection
@section('script')
    <script>
        window.addEventListener('load', function() {

            function initiateDatePicker() {

            }
            // قيمة تاريخ اليوم الميلادى الافتراضية
            const the_greg_date = new Date();
            const gregDateStringFormat = (date) => {
                let year = date.getFullYear();
                let month = date.getMonth() + 1;
                month = month.toString().padStart(2, '0')
                let day = date.getDate();
                day = day.toString().padStart(2, '0')
                return `${year}-${month}-${day}`
            }

            // حقل إدخال التاريخ الميلادى
            const gregDatePicker = document.getElementById('greg_date_picker');
            const gregDateInput = document.getElementById('greg_date_input');
            // حقل عرض التاريخ الميلادى
            const gregDateDisplay = document.getElementById('greg_date_display');
            // حقل إدخال التاريخ الهجرى
            const hijriDateDisplay = document.getElementById('hijri_date_display');
            const hijriDateInput = document.getElementById('hijri_date_input');

            setDateValues = (date) => {
                // قيمة التاريخ الميلادى، يتم تعيينه لحقل الادخال عند تحميل الصفحة
                gregDatePicker.value = gregDateStringFormat(date)
                gregDateDisplay.innerHTML = date.toLocaleDateString('en-sa')
                gregDateInput.value = gregDateStringFormat(date)
                //  قيمة التاريخ الهجرى، يتم تعيينه لحقل الادخال عند تحميل الصفحة
                hijriDateDisplay.innerHTML = date.toLocaleDateString('ar-sa')
                hijriDateInput.value = date.toLocaleDateString('ar-sa')
                console.log(hijriDateDisplay.innerHTML)
            }

            setDateValues(the_greg_date);

            gregDatePicker.addEventListener('change', () => {
                const the_greg_date_picked = new Date(gregDatePicker.value)
                setDateValues(the_greg_date_picked)
            });

            const gen_sn = () => {
                const rsn = document.getElementById('s_number_label').getAttribute('data-serial')
                const picked_sn = rsn.length <= 6 ? rsn : rsn.toString().slice(-6)
                const zero_filled_sn = picked_sn.padStart(6, '0')
                return '4516' + zero_filled_sn
            }
            document.getElementById('s_number_input').value = gen_sn()
        })

        let contracts = JSON.parse($('#contracts_list').html());
        // console.log(contracts)

        $(document).on('keyup', '#searchClients', function() {
            let v = $('#searchClients').val();

            let options = []
            contracts.forEach(i => {

                if (i.client_name.indexOf(v) > -1) {
                    options.push('<option value="' + i.id + '">' + i.client_name +
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

        })
    </script>
@endsection
