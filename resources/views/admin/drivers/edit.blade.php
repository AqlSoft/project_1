@extends('layouts.admin')

@section('title')
    إضافة سائق
@endsection
@section('pageHeading')
    إضافة سائق
@endsection

@section('content')
    <div class="container pt-5">
        <div class="quick-nav input-group fs-6 py-2 w-100">

            @if (isset($_SERVER['HTTP_REFERER']))
                <span class="text-center btn form-control btn-outline-primary">
                    <a class="d-inline-block py-1" href="{{ $_SERVER['HTTP_REFERER'] }}">
                        <i class="fas fa-random"></i> &nbsp; العودة للخلف &nbsp;
                    </a>
                </span>
            @endif

            <span class="text-center btn form-control btn-outline-primary">
                <a class="d-inline-block py-1" href="{{ route('drivers.home') }}">
                    <i class="fas fa-folder-open"></i> &nbsp; السائقين &nbsp;
                </a>
            </span>

            <span class="text-center btn form-control btn-primary">
                <a class="d-inline-block py-1" href="{{ route('drivers.home') }}">
                    <i class="fas fa-folder-plus"></i> &nbsp; تقارير السائقين &nbsp;
                </a>
            </span>
        </div>
        <fieldset style="width: 90%">
            <legend>
                تعديل بيانات سائق
            </legend>

            <form class="" action="{{ route('drivers.update') }}" method="post">
                @csrf @method('PUT')
                <input type="hidden" name="id" value="{{ $driver->id }}">
                <div id="" class="mt-3 input-group">
                    <label for="driver-a-name" class="input-group-text">الاسم بالعربى</label>
                    <input class="form-control" type="search" name="a_name" id="driver-a-name"
                        value="{{ $driver->a_name }}">

                    <label for="driver-e-name" class="input-group-text"> الاسم اللانجليزية</label>
                    <input class="form-control" type="search" name="e_name" id="driver-e-name"
                        value="{{ $driver->e_name }}">
                </div>


                <div id="receipt-date" class="mt-3 input-group">
                    <label for="car-type" class="input-group-text"> نوع المركبة</label>
                    <select class="form-control" name="car_type" id="car-type">
                        @foreach ($trucks as $type)
                            <option {{ $driver->car_type == $type->id ? 'selected' : '' }} value="{{ $type->id }}">
                                {{ $type->a_name }} - {{ $type->e_name }}</option>
                        @endforeach
                    </select>


                    <label for="car-panel" class="input-group-text"> رقم اللوحة</label>
                    <input class="form-control" type="search" name="car_panel" id="car-panel"
                        value="{{ $driver->car_panel }}">

                    <label for="car-model" class="input-group-text"> الموديل</label>
                    <input class="form-control" type="search" name="car_model" id="car-model"
                        value="{{ $driver->car_model }}">
                </div>

                <div id="" class="mt-3 input-group">
                    <label for="phone_number" class="input-group-text">رقم الهاتف</label>
                    <input class="form-control" type="search" name="phone_number" id="phone_number"
                        value="{{ $driver->phone_number }}">

                    <label for="iqama" class="input-group-text"> رقم الإقامة</label>
                    <input class="form-control" type="search" name="iqama" id="iqama" value="{{ $driver->iqama }}">

                    <label for="nationality" class="input-group-text">الجنسية</label>
                    <select class="form-control" name="nationality" id="nationality">
                        @foreach ($contries as $country)
                            <option {{ $driver->nationality == $country->id ? 'selected' : '' }}
                                value="{{ $country->id }}">{{ $country->iso }} - {{ $country->a_name }}</option>
                        @endforeach
                    </select>

                    <button class="input-group-text" type="submit">حفظ البيانات</button>
                </div>
            </form>
        </fieldset>

    </div>
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
                return '4509' + zero_filled_sn
            }
            document.getElementById('s_number_input').value = gen_sn()
        })



        $(document).on('change', '#type', function() {
            if ($('#type').val() == 1) {
                $('#s_n_generated').html($('#s_number_label').attr('data-in-value')).css('color', 'blue')
                $('#s_number_input').val($('#s_number_label').attr('data-in-value'))
            } else {
                $('#s_n_generated').html($('#s_number_label').attr('data-out-value')).css('color', 'red')
                $('#s_number_input').val($('#s_number_label').attr('data-out-value'))
            }
        })

        $(document).on('change', '#s_n_picker', function() {

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
