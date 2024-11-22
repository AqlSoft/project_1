@extends('layouts.admin')

@section('title')
    السندات
@endsection
@section('pageHeading')
    سندات ترتيب الطبالى
@endsection


@section('content')
    <div id="loader">
    </div>
    <div class="container mt-3 pt-3">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">

                <button class="nav-link">
                    <a href="{{ route('operating.home', [2]) }}">الرئيسية</a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('arrange.home', [1]) }}">
                        السندات الجارية
                    </a>
                </button>
                <button class="nav-link active">
                    انشاء سند جديد
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background:#fff">

            <form action="{{ route('arrange.store') }}" method="POST">
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
                        <option value="3">ترتيب طبالى / مخزن</option>
                    </select>
                </div>
                {{-- {{ $contracts }} --}}
                <div class="input-group mt-1">
                    <label class="input-group-text" for="contract">اختر عميل:</label>
                    <input type="text" id="searchClients" class="form-control" placeholder="اكتب الحروف الأولى">
                    <label class="input-group-text" data-bs-toggle="modal" data-bs-target="#add-new-client">
                        <a href="{{ route('clients.home') }}"><i data-bs-toggle="tooltip" data-bs-title="إضافة عميل جديد"
                                class="fa fa-plus"></i></a>
                    </label>
                    <select class="form-control" name="contract" id="contract" style="height: 45px">
                        <option hidden></option>

                        @if (count($contracts))
                            @foreach ($contracts as $o => $contract)
                                <option {{ old('contract') == $contract->id ? 'selected' : '' }}
                                    value="{{ $contract->id }}">{{ $contract->clientAName }} - رقم العقد
                                    {{ $contract->s_number }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="input-group mt-1">
                    <label class="input-group-text" for="contact">المندوب:</label>
                    <select class="form-control" id="contact" name="contact" placeholder="المندوب">
                        <option hidden></option>
                        @foreach ($contacts as $item)
                            <option value="{{ $item->id }}">{{ $item->name . ' - ' . $item->rule }}</option>
                        @endforeach
                    </select>

                    <label class="input-group-text" for="reason">سبب الترتيب:</label>
                    <input class="form-control" type="text" value="{{ old('reason') }}" name="reason" id="reason" />
                </div>
                @error('contact')
                    <small class="alert alert-sm text-danger">{{ $message }}</small>
                @enderror

                <div class="input-group mt-1">
                    <label class="input-group-text" for="notes">ملاحظات:</label>
                    <input class="form-control" type="text" id="notes" value="{{ old('notes') }}" name="notes"
                        placeholder="ملاحظات أخرى">
                    <label class="input-group-text" id="s_number_label" data-serial="{{ $lar }}"> الرقم
                        المسلسل:
                        <input type="number" name="s_number" id="s_number_input" value="{{ $lar }}">

                    </label>
                    <button type="submit" value="حفظ" class="input-group-text"> حفظ السند </button>
                </div>
            </form>
            @if ($last5 != null)

                @if (count($last5) == 0)
                    <div class="alert alert-warning mt-3">
                        لا يوجد سندات غير معتمدة
                    </div>
                @else
                    <h4 class="mx-5 mt-5 mb-2">عرض أخر {{ count($last5) }} سندات</h4>
                    <div class="mx-5">
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>التاريخ</th>
                                    <th>رقم السند</th>
                                    <th>مرجعى</th>
                                    <th>العقد</th>
                                    <th>اجمالي</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($last5 as $in => $item)
                                    <tr>
                                        <td>{{ ++$in }}</td>
                                        <td>
                                            {{ $item->hij_date }} <br>
                                            {{ $item->greg_date }}
                                        </td>
                                        <td>
                                            <a class="btn btn-sm displayReceipt btn-block p-1 mb-1 bg-secondary"
                                                data-receipt-id="{{ $item->id }}"
                                                data-search-token="{{ csrf_token() }}"
                                                data-search-url="{{ route('delivery.info') }}" data-tab="1"
                                                class="fa fa-eye text-primary" data-bs-toggle="tooltip"
                                                data-bs-title="عرض محتويات السند">{{ $item->s_number }}</a>
                                            <span class="btn btn-sm btn-block p-1 mb-1 bg-secondary">بواسطة:
                                                {{ $item->theAdmin }}</span>
                                        </td>
                                        <td>
                                            السائق
                                            : {{ $item->driver }} <br>
                                            ملاحظات: {{ $item->notes }}
                                        </td>
                                        <td><a class="btn btn-sm btn-block p-1 mb-1 bg-secondary"
                                                href="{{ route('contract.view', [$item->contract_id, 5]) }}"
                                                data-bs-toggle="tooltip" data-bs-title="رؤية العقد">العقد:
                                                {{ $item->contractSerialNumber }}</a>

                                            <a class="btn btn-sm btn-block p-1 bg-secondary"
                                                href="{{ route('clients.view', [$item->client_id]) }}"
                                                data-bs-toggle="tooltip" data-bs-title="رؤية العميل"> العميل:
                                                {{ $item->clientName }}</a>
                                        </td>
                                        <td>{{ $item->total_outputs }}</td>
                                        <td>

                                            <a href="{{ route('delivery.entries.create', [$item->id, 0]) }}"><i
                                                    class="fa fa-sign-in-alt text-info" data-bs-toggle="tooltip"
                                                    data-bs-title="استلام بضاعة على السند"></i></a>

                                            <a href="{{ route('delivery.approve', [$item->id]) }}"><i
                                                    class="fa fa-check text-success" data-bs-toggle="tooltip"
                                                    data-bs-title="اعتماد السند"></i></a>

                                            <a href="{{ route('delivery.edit', [$item->id]) }}"><i
                                                    class="fa fa-edit text-primary" data-bs-toggle="tooltip"
                                                    data-bs-title="تعديل بيانات السند"></i></a>
                                            <a class="" href="{{ route('stores.table.position', [$item->id]) }}"
                                                data-tab="1"><i class="fa fa-th text-primary" data-bs-toggle="tooltip"
                                                    data-bs-title="تسكين طبالى السند"></i></a>

                                            <a href="{{ route('delivery.destroy', [$item->id]) }}"
                                                onclick="if (!confirm('انت على وشك القيام بعملية لا يمكن الرجوع نها، هل أنت متأكد؟')) return false"><i
                                                    class="fa fa-trash text-danger"data-bs-toggle="tooltip"
                                                    data-bs-title="حذف السند"></i></a>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                @endif

            @endif
        </div>
        <div class="hidden" id="contracts_list" style="display: none">{{ $contracts }}</div>
    </div>



@endsection
@section('script')
    <script>
        showLoader()
        window.addEventListener('load', function() {
            removeLoader()

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
                return '4515' + zero_filled_sn
            }
            document.getElementById('s_number_input').value = gen_sn()
        })






        let contracts = JSON.parse($('#contracts_list').html());
        // console.log(contracts)

        $(document).on('keyup', '#searchClients', function() {
            let v = $('#searchClients').val();
            let options = []
            contracts.forEach(i => {
                if (i.clientAName.indexOf(v) > -1) {
                    options.push('<option value="' + i.id + '">' + i.clientAName +
                        ' - ' + i.s_number +
                        '</option>');
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

        function showLoader() {
            $('#loader').css({
                display: 'block',
                height: '100vh'
            });
        }

        function removeLoader() {
            $('#loader').css({
                display: 'none'
            })
        }
    </script>
@endsection
