@extends('layouts.admin')

@section('title')
    السندات
@endsection
@section('pageHeading')
    سندات ترتيب الطبالى
@endsection


@section('content')
    <div class="container pt-5">
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
                        <option value="3">ترتيب طبالى / مخزن</option>
                    </select>
                </div>
                {{-- {{ $contracts }} --}}
                <div class="input-group mt-1">
                    <label class="input-group-text" for="contract">اختر عميل آخر:</label>
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
                                    value="{{ $contract->id }}">{{ $contract->clientAName }} - رقم العقد
                                    {{ $contract->s_number }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="input-group mt-1">
                    <label class="input-group-text" for="contact">المندوب:</label>
                    <select class="form-control" id="contact" value="{{ old('contact') }}" name="contact"
                        placeholder="اختر ةوالمندوب">
                        <option value="no_client">----</option>
                        @foreach ($contacts as $item)
                            <option value="{{ $item->id }}">{{ $item->name . ' - ' . $item->rule }}</option>
                        @endforeach
                    </select>

                    <label class="input-group-text" for="reason">سبب الإخراج:</label>
                    <input class="form-control" type="text" value="{{ old('reason') }}" name="reason" id="reason" />
                </div>

                <div class="input-group mt-1">
                    <label class="input-group-text" for="notes">ملاحظات:</label>
                    <input class="form-control" type="text" id="notes" value="{{ old('notes') }}" name="notes"
                        placeholder="ملاحظات أخرى">
                    <label class="input-group-text" id="s_number_label"> الرقم
                        المسلسل:
                        <input type="number" name="s_number" id="s_number_input" value="{{ $receipt->s_number }}">
                        {{-- <span id="s_n_generated"></span> --}}
                    </label>
                    <button type="submit" class="input-group-text"> حفظ السند </button>
                    <button type="button" class="input-group-text"><a
                            href="{{ route('contract.view', [$receipt->contract_id, 3]) }}"> الذهاب للعقد </a></button>
                </div>
            </form>
        </div>
    </div>


    <div class="hidden" id="contracts_list" style="display: none">{{ $contracts }}</div>

@endsection
@section('script')
    <script>
        window.addEventListener('load', function() {

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
        })
    </script>
@endsection
