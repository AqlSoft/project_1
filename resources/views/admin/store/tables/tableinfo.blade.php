<div class="container bg-light  px-4 py-3" style="max-height: 80vh; overflow-y: scroll;">
    <h1 class="text-right">سجل العمليات على الطبلية</h1>

    <div class="row">
        <h5 class="col col-3">رقم الطبلية:</h5>
        <div class="col col-4">{{ $table->name }}</div>
    </div>
    <div class="row">
        <h5 class="col col-3">الرقم المسلسل:</h5>
        <div class="col col-4">{{ $table->serial }}</div>
    </div>
    <div class="row">
        <h5 class="col col-3">حجم الطبلية:</h5>
        <div class="col col-4">
            {{ $table->size == 1 ? 'صغيـــــــــــــــرة' : 'كبيــــــــــــرة' }}
        </div>
    </div>
    <div class="row">
        <h5 class="col col-3">الحمولة القصوى:</h5>
        <div class="col col-4 text-right">
            @for ($i = 0; $i < count($table->max_load); $i++)
                <div class="badge bg-success px-3 py-1">
                    {{ $table->max_load[$i][2] }} {{ $table->max_load[$i][3] }}
                </div>
            @endfor
        </div>
    </div>

    <div class="row">
        <h5 class="col col-3">الحمولة الحالية:</h5>
        <div class="col col-4">{{ $table->load }}</div>
    </div>

    <div class="row">
        <h5 class="col col-3">حالة الطبلية:</h5>
        <div class="col col-4">جيــــــــــــــدة</div>
    </div>

    @php $credit = 0 @endphp
    <table class="w-100">
        <thead style="border-bottom: 2px solid #333">
            <tr>
                <th class="fw-bold" rowspan="2">#</th>
                <th class="fw-bold" colspan="2">التسجيل</th>
                <th class="fw-bold" colspan="2">الأصناف</th>
                <th class="fw-bold" colspan="5">بيانات الكميات</th>
            </tr>
            <tr>
                <th class="fw-bold">تاريخ</th>
                <th class="fw-bold">بواسطة</th>
                <th class="fw-bold">اسم</th>
                <th class="fw-bold">حجم</th>
                <th class="fw-bold">SN</th>
                <th class="fw-bold">in/out</th>
                <th class="fw-bold">ادخال</th>
                <th class="fw-bold">اخراج</th>
                <th class="fw-bold">باق</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entries as $ie => $entry)
                <tr>
                    <td class="fw-normal">{{ ++$ie }}</td>
                    <td class="fw-normal">{{ $entry->created_at }}</td>
                    <td class="fw-normal">{{ $entry->admin }}</td>
                    <td class="fw-normal">{{ $entry->itemName }}</td>
                    <td class="fw-normal">{{ $entry->boxName }}</td>
                    <td class="fw-normal">{{ $entry->type == 1 ? 'In' : 'Out' }}</td>
                    <td class="fw-normal">{{ $entry->receipt_sn }}</td>
                    <td class="fw-normal">{{ $entry->inputs ? $entry->inputs : '0' }}</td>
                    <td class="fw-normal">{{ $entry->outputs ? $entry->outputs : '0' }}</td>
                    @php
                        $credit += $entry->inputs;
                        $credit -= $entry->outputs;
                    @endphp
                    <td class="fw-normal" style="{{ $credit < 0 ? 'background-color:#f003; color: #f55' : '' }}">
                        {{ $credit }}
                    </td>
                </tr>
            @endforeach

        </tbody>
        <tfoot style="border-top: 2px solid #333">
            <tr class="">
                <th class="fw-bold" colspan="7">الاجمالى</th>
                <th class="fw-bold">{{ $table->totalInputs }}</th>
                <th class="fw-bold">{{ $table->totalOutputs }}</th>
                <th class="fw-bold">{{ $table->load }}</th>
            </tr>
        </tfoot>
    </table>

    {{-- {{ var_dump($table) }} --}}


    <div class="text-right p-3">
        <button data-target="tableLook" class="py-2 px-3"
            onclick="document.getElementById(this.getAttribute('data-target')).style.display='none'">Close</button>
    </div>

</div>
