@extends('layouts.admin')

@section('title')
    السائقين
@endsection
@section('pageHeading')
    السائقين
@endsection

@section('content')
    <div class="container pt-5">

        <fieldset style="width: 90%">
            <legend>
                البحث عن السائقين
            </legend>

            <div class="d-flex gap-3">
                <div id="" class="mt-3 input-group">
                    <label for="driver-name" class="input-group-text">بالاسم</label>
                    <input class="form-control" type="search" name="driver-name" id="driver-name" placeholder="نص البحث">
                    <button id="find-driver-by-name" class="input-group-text"><i class="fa fa-search"></i></button>
                </div>
                <div id="receipt-date" class="mt-3 input-group">
                    <label for="driver-name" class="input-group-text"> برقم الهاتف</label>
                    <input class="form-control" type="search" name="driver-name" id="" placeholder="نص البحث">
                    <button id="find-driver-by-phone" class="input-group-text"><i class="fa fa-search"></i></button>
                </div>
                <div id="receipt-date" class="mt-3 input-group">
                    <label for="driver-name" class="input-group-text"> بنوع المركبة</label>
                    <input class="form-control" type="search" name="driver-name" id="" placeholder="نص البحث">
                    <button id="find-driver-by-car" class="input-group-text"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </fieldset>
        <fieldset style="width: 90%">
            <legend>
                عرض بيانات السائقين
                <a title="إضافة سائق جديد" data-bs-toggle="tooltip" href="{{ route('drivers.create') }}"> &nbsp; <i
                        class="fa fa-plus"></i></a>
            </legend>

            <div id="drivers-data">
                <table class="w-100 mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الاتصال</th>
                            <th>المركبة</th>
                            <th>إقامة</th>
                            <th>الجنسية</th>
                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- {{ $drivers }} --}}
                        @if (count($drivers))
                            @php
                                $c = 0;
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            @endphp
                            @foreach ($drivers as $driver)
                                <tr>
                                    <td>{{ ++$c + ($page - 1) * 20 }}</td>
                                    <td>{{ $driver->a_name }} -- {{ $driver->e_name }}</td>
                                    <td>{{ $driver->phone_number }}</td>
                                    <td>{{ $driver->truck_name }} -- {{ $driver->car_panel }}</td>
                                    <td>{{ $driver->iqama }} </td>
                                    <td>{{ $driver->country }}</td>
                                    <td>
                                        <a href="{{ route('drivers.edit', [$driver->id]) }}"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('drivers.delete', [$driver->id]) }}"
                                            onclick="if(!confirm('يخربيتك هتحذف السواق، انت متأكد؟'))return false"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">لا يوجد سائقين مسجلين <a class="btn btn-primary btn-sm"
                                        href="{{ route('drivers.create') }}">إضافة أول
                                        سائق</a></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </fieldset>

        <div class="links">
            {{ $drivers->links() }}
        </div>
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
