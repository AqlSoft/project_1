@extends('layouts.admin')

@section('title')
    السندات
@endsection
@section('pageHeading')
    سندات اخراج البضاعة
@endsection


@section('content')
    <div class="container py-5">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">

                <button class="nav-link">
                    <a href="{{ route('operating.home', [2]) }}">الرئيسية</a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('delivery.home', [1]) }}">
                        السندات
                    </a>
                </button>
                <button class="nav-link active">
                    انشاء سند جديد
                </button>

            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background:#fff">
            <form action="{{ route('delivery.update') }}" method="POST">
                <input type="hidden" name="id" value="{{ $receipt->id }}">
                @csrf
                <div id="receipt_date" class="mt-3 input-group">
                    <label class="input-group-text" for="greg_date_picker">بتاريخ:</label>

                    <label class="input-group-text">
                        <span id="greg_date_display">{{ $receipt->greg_date }}</span>

                    </label>
                    <label class="input-group-text">الموافق:</label>
                    <label class="input-group-text">
                        <span id="hijri_date_display">{{ $receipt->hij_date }}</span>

                    </label>
                    <label for="" class="input-group-text">سند</label>

                    <select name="type" id="type" class="form-control">
                        <option value="2">اخراج البضاعة</option>
                    </select>
                </div>

                <div class="input-group mt-1">
                    <label class="input-group-text" for="greg_date_picker">اختر عميل:</label>
                    <input type="text" id="searchClients" class="form-control" placeholder="ابحث عن عميل آخر">
                    <label class="input-group-text" data-bs-toggle="modal" data-bs-target="#add-new-client">
                        <a href="{{ route('clients.home') }}"><i data-bs-toggle="tooltip" data-bs-title="إضافة عميل جديد"
                                class="fa fa-plus"></i></a>
                    </label>
                    <select class="form-control" name="contract" id="contract" style="height: 45px">
                        <option value="no_client">----</option>
                        @if (count($contracts))
                            @foreach ($contracts as $o => $item)
                                <option {{ $receipt->contract_id == $item->id ? 'selected' : '' }}
                                    value="{{ $item->id }}">
                                    {{ $item->client_name }} - العقد
                                    {{ $item->s_number }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="input-group mt-1">
                    <label class="input-group-text" for="greg_date_picker">السائق:</label>
                    <select class="form-control" id="driver" value="{{ old('driver') }}" name="driver"
                        placeholder="اسم السائق">
                        <option value="no_client">----</option>
                        @foreach ($drivers as $item)
                            <option {{ $item->id == $receipt->driver ? 'selected' : '' }} value="{{ $item->id }}">
                                {{ $item->a_name . ' - ' . $item->e_name }}</option>
                        @endforeach
                    </select>
                    <label class="input-group-text" data-bs-toggle="modal" data-bs-target="#add-new-driver">
                        <i data-bs-toggle="tooltip" data-bs-title="إضافة سائق جديد" class="fa fa-plus"></i>
                    </label>
                    <label class="input-group-text" for="greg_date_picker">المزرعة:</label>
                    <input class="form-control" type="text" value="{{ $receipt->farm }}" name="farm"
                        placeholder="اسم المزرعة / المصدر">
                </div>

                <div class="input-group mt-1">
                    <label class="input-group-text" for="greg_date_picker">ملاحظات:</label>
                    <input class="form-control" type="text" value="{{ $receipt->notes }}" name="notes"
                        placeholder="ملاحظات أخرى">
                    <label class="input-group-text"> الرقم المسلسل:
                        {{-- <span id="s_n_generated"></span> --}}
                    </label>
                    <input class="form-control" type="number" name="s_number" id="s_number_input"
                        value="{{ $receipt->s_number }}">
                    <button type="submit" class="input-group-text"> تحديث البيانات </button>
                    <button type="button" class="input-group-text"
                        onclick="window.location.href='{{ route('contract.view', [$receipt->contract_id, 5]) }}'"> الذهاب
                        للعقد </button>
                </div>
            </form>
        </div>
    </div>
    {{-- Hidden forms --}}
    <!-- Modal -->
    <div class="modal fade" id="add-new-driver" tabindex="-1" aria-labelledby="add-new-driverLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="display: flex">
                    <h1 class="modal-title fs-5 text-right" style="flex: auto" id="add-new-driverLabel">إضافة سائق جديد
                    </h1>
                    <button type="button" style="width: 50px" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="" action="{{ route('drivers.store') }}" method="POST">
                        @csrf
                        <div id="" class="mt-3 input-group">
                            <label for="driver-a-name" class="input-group-text">الاسم بالعربى</label>
                            <input class="form-control" type="search" name="a_name" id="driver-a-name"
                                placeholder="مصطفى الكنــــــــــــانى">
                        </div>
                        <div id="" class="mt-3 input-group">
                            <label for="driver-e-name" class="input-group-text"> الاسم اللانجليزية</label>
                            <input class="form-control" type="search" name="e_name" id="driver-e-name"
                                placeholder="John Doe!">
                        </div>


                        <div id="receipt-date" class="mt-3 input-group">
                            <label for="car-type" class="input-group-text"> نوع المركبة</label>
                            <select class="form-control" name="nationality" id="nationality">
                                @foreach ($trucks as $type)
                                    <option value="{{ $type->id }}"> {{ $type->a_name }} - {{ $type->e_name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div id="" class="mt-3 input-group">
                            <label for="car-panel" class="input-group-text"> رقم اللوحة</label>
                            <input class="form-control" type="search" name="car_panel" id="car-panel"
                                placeholder="A B C 1250">

                            <label for="car-model" class="input-group-text"> الموديل</label>
                            <input class="form-control" type="search" name="car_model" id="car-model"
                                placeholder="Mercedes">
                        </div>

                        <div id="" class="mt-3 input-group">
                            <label for="phone_number" class="input-group-text">رقم الهاتف</label>
                            <input class="form-control" type="search" name="phone_number" id="phone_number"
                                placeholder="05XXXXXXXX">

                            <label for="iqama" class="input-group-text"> رقم الإقامة</label>
                            <input class="form-control" type="search" name="iqama" id="iqama"
                                placeholder="2123123123">
                        </div>
                        <div id="" class="mt-3 input-group">
                            <label for="nationality" class="input-group-text">الجنسية</label>
                            <select class="form-control" name="nationality" id="nationality">
                                @foreach ($contries as $country)
                                    <option value="{{ $country->id }}">{{ $country->iso }} - {{ $country->a_name }}
                                    </option>
                                @endforeach
                            </select>

                            <button class="input-group-text" type="submit">حفظ البيانات</button>
                            <button type="button" class="btn btn-secondary input-group-text"
                                data-bs-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Hidden forms --}}

    <div class="hidden" id="contracts_list" style="display: none">{{ $contracts }}</div>
@endsection
@section('script')
    <script>
        window.addEventListener('load', function() {

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
                gregDateInput.value = date.toLocaleDateString('en-sa')
                //  قيمة التاريخ الهجرى، يتم تعيينه لحقل الادخال عند تحميل الصفحة
                hijriDateDisplay.innerHTML = date.toLocaleDateString('ar-sa')
                hijriDateInput.value = date.toLocaleDateString('ar-sa')
                console.log(hijriDateDisplay.innerHTML)
            }

            gregDatePicker.addEventListener('change', () => {
                const the_greg_date_picked = new Date(gregDatePicker.value)
                setDateValues(the_greg_date_picked)
            });

        })

        let contracts = JSON.parse($('#contracts_list').html());

        $(document).on('keyup', '#searchClients', function() {
            let v = $('#searchClients').val();
            let options = []
            contracts.forEach(i => {
                if (i.client_name.indexOf(v) > -1) {
                    options.push('<option value="' + i.id + ',' + i.client + '">' + i.client_name +
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
