@extends('layouts.admin')

@section('title')
    استلام بضاعة
@endsection
@section('pageHeading')
    تسكين طبالى السند بالغرف
@endsection


@section('content')

    <div class="container pt-3">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">

                <button class="nav-link">
                    <a href="{{ route('operating.home', [2]) }}">الرئيسية</a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('reception.home', [1]) }}">
                        السندات الجارية
                    </a>
                </button>
                <button class="nav-link active">
                    تسكين طبالى
                </button>

            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background:#fff">





            <fieldset class="mt-5 mx-3">
                <legend>
                    تسكين طبالى السند رقم " <span class="text-danger"> {{ $receipt->s_number }} </span> " بالغرف
                </legend>

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
                        <span id="current_client" data-client-id="{{ $client->id }}" class="label">العميل: </span>
                        <span class="data" data-bs-toggle="tooltip" title="عرض بيانات العميل"><a
                                href="{{ route('clients.view', [$client->id]) }}">{{ mb_substr($client->name, 0, 25) }}</a></span>
                    </div>
                    <div class="col col-4 text-center m-0 text-primary">
                        <h3>
                            سند استلام بضاعة</h3>
                    </div>
                    <div class="col col-4">
                        <span class="label"> المزرعة / المصدر: </span>
                        <span class="data">{{ $receipt->farm }}</span>
                    </div>
                    <div class="col col-8">
                        <span class="label"> أخرى: </span>
                        <span class="data">{{ $receipt->notes }}</span>
                    </div>
                    <div class="col col-4">
                        <span class="label"> العقد: </span>

                        <span class="data" data-bs-toggle="tooltip" title="الذهاب إلى العقد"><a
                                href="{{ route('contract.view', [$contract->id, 2]) }}">

                                {{ $contract->s_number }}</a></span>
                    </div>
                </div>
                @php $counter = 1 @endphp
                @if (count($entries))
                    @foreach ($entries as $index => $entry)
                        <form id="form_{{ $index }}" action="{{ route('stores.save.table.position') }}"
                            method="POST" class="mt-1">
                            @csrf
                            <input type="hidden" name="entry_id" value="{{ $entry->id }}">
                            <input type="hidden" name="receipt_id" value="{{ $entry->receipt_id }}">
                            <div class="input-group">
                                <label class="input-group-text">{{ str_pad($counter++, 2, '0', STR_PAD_LEFT) }}</label>
                                <label class="input-group-text">طبلية رقم:</label>
                                <label class="input-group-text">
                                    <input type="hidden" name="table_id" value="{{ $entry->table_id }}">
                                    {{ str_pad($entry->table_name, 5, '00000', STR_PAD_LEFT) }}
                                </label>
                                <label class="input-group-text"> الصنف </label>
                                <label class="input-group-text" style="width: 8rem">{{ $entry->item_name }}</label>
                                <label class="input-group-text"> المحتويات </label>
                                <label class="input-group-text" style="width: 3rem"
                                    value="">{{ $entry->inputs }}</label>
                                <label class="input-group-text"> الغرفة </label>
                                <select class="form-control" name="room" id="">
                                    @foreach ($rooms as $room)
                                        <option
                                            {{ $entry->storingRecord ? ($entry->storingRecord->room == $room->id ? 'selected' : '') : null }}
                                            value="{{ $room->id }}">{{ $room->code }}</option>
                                    @endforeach
                                </select>
                                <label class="input-group-text"> المكان </label>
                                <select class="form-control" name="partition" id="">
                                    <option
                                        {{ $entry->storingRecord ? ($entry->storingRecord->partition == 'L' ? 'selected' : '') : null }}
                                        value="L">Left</option>
                                    <option
                                        {{ $entry->storingRecord ? ($entry->storingRecord->partition == 'R' ? 'selected' : '') : null }}
                                        value="R">Right</option>
                                    <option
                                        {{ $entry->storingRecord ? ($entry->storingRecord->partition == 'F' ? 'selected' : '') : null }}
                                        value="F">Front</option>
                                </select>
                                <input type="number" class="form-control" name="position" required
                                    value="{{ $entry->storingRecord ? $entry->storingRecord->position : old('position') }}">
                                <select class="form-control" name="rack" id="">
                                    <option
                                        {{ $entry->storingRecord ? ($entry->storingRecord->rack == 'A' ? 'selected' : '') : null }}
                                        value="A">A</option>
                                    <option
                                        {{ $entry->storingRecord ? ($entry->storingRecord->rack == 'B' ? 'selected' : '') : null }}
                                        value="B">B</option>
                                    <option
                                        {{ $entry->storingRecord ? ($entry->storingRecord->rack == 'C' ? 'selected' : '') : null }}
                                        value="C">C</option>
                                    <option
                                        {{ $entry->storingRecord ? ($entry->storingRecord->rack == 'D' ? 'selected' : '') : null }}
                                        value="D">D</option>
                                </select>
                                <label class="input-group-text"> <a href="{{ route('receipt.entry.delete', $entry) }}"><i
                                            class="fa fa-trash text-danger" style="border-radius: opx"></i></a>
                                </label>
                                <button type="submit" id="button_{{ $index }}"
                                    class="input-group-text text-primary">تحديث</button>


                            </div>

                        </form>
                    @endforeach
                @else
                    <div class="text-right">لم يتم بعد إضافة أى إدخالات على هذا السند</div>
                @endif
                <div class="buttons">
                    <button class="btn btn-outline-primary btn-sm">
                        <a href="{{ route('reception.home', [1]) }}"> العودة لسندات الاستلام </a>
                    </button>
                    @if (count($entries))
                        @if ($receipt->confirmation == 'approved')
                            <button class="btn btn-outline-primary btn-sm"><a
                                    href="{{ route('reception.park', $receipt->id) }}">
                                    فك الاعتماد
                                </a></button>
                        @else
                            <button class="btn btn-outline-primary btn-sm"><a
                                    href="{{ route('reception.approve', $receipt->id) }}">اعتماد

                                </a></button>
                        @endif
                        <button class="btn btn-outline-primary btn-sm"><a
                                href="{{ route('reception.print', $receipt->id) }}">
                                عرض
                            </a></button>
                    @endif
                    <button class="btn btn-outline-primary btn-sm"><a
                            href="{{ route('contract.view', [$contract->id, 2]) }}">
                            الذهاب للعقد
                        </a></button>
                </div>


            </fieldset>
        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table').focus();
            $('#table').select();
        })
        $(document).on('change', '#table', function() {
            if ($('#table').val() < 3000) {
                $('#table_size').val(1)
                $('#table_size_display').text("صغيرة")
                console.log($('#table_size').attr('value'))
            } else {
                $('#table_size').val(2)
                $('#table_size_display').text('كبيــرة')
                console.log($('#table_size').attr('value'))
            }
        })
    </script>
@endsection
