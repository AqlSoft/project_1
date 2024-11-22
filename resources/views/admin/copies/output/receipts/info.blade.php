<div class="receipt position-relative m-auto bg-light" dir="rtl" style="width: 21cm">


    <div class="row receipt_info p-1 w-100">
        <div class="col col-6">
            <span class="text-danger text-right fw-bold"> التاريخ: </span>
            <span class="px-2 "> {{ $receipt->greg_date }} </span>
        </div>

        <div class="col col-6">
            <span class="text-right text-danger fw-bold">مسلسل: </span>
            <span class="px-2 fw-bold ">{{ $receipt->s_number }}</span>
        </div>
        <div class="col col-6">
            <span class="text-danger text-right fw-bold">العميل: </span>
            <span class="px-2 ">{{ $receipt->theClient->name }}</span>
        </div>

        <div class="col col-4">
            <span class="text-danger text-right fw-bold"> العقد: </span>
            <span class="px-2 ">{{ $receipt->theContract->s_number }}</span>
        </div>
        <div class="col col-6">
            <span class="text-danger text-right fw-bold"> المزرعة / المصدر: </span>
            <span class="px-2 ">{{ $receipt->farm }}</span>
        </div>
        <div class="col col-6">
            <span class="text-danger text-right fw-bold"> المندوب / السائق: </span>
            <span class="px-2 ">{{ $receipt->drivere }}</span>
        </div>
        <div class="col col-12">
            <span class="text-danger text-right fw-bold"> أخرى: </span>
            <span class="px-2 ">{{ $receipt->notes }}</span>
        </div>
    </div>
    <table id="receipt_items_table" style="border-bottom-color: red; width: 100%">
        <thead>
            <tr class="">
                <th class="fw-bold bg-danger py-2 fs-6">#</th>
                <th class="fw-bold bg-danger py-2 fs-6">رقم الطبلية</th>
                <th class="fw-bold bg-danger py-2 fs-6">حجم الطبلية</th>
                <th class="fw-bold bg-danger py-2 fs-6">الأصناف</th>
                <th class="fw-bold bg-danger py-2 fs-6">حجم الكرتون</th>
                <th class="fw-bold bg-danger py-2 fs-6">الكمية</th>
            </tr>
        </thead>
        <tbody>
            @if (count($entries))
                @foreach ($entries as $index => $entry)
                    <tr>
                        <td class="fw-normal border-left">{{ ++$index }}</td>
                        <td class="fw-normal border-left">{{ $entry->tableName }}</td>
                        <td class="fw-normal border-left">{{ $entry->table_size == 1 ? 'صغيرة' : 'كبيرة' }}
                        </td>
                        <td class="fw-normal border-left">{{ $entry->itemName }}</td>
                        <td class="fw-normal border-left">{{ $entry->boxName }}</td>
                        <td class="fw-normal">{{ $entry->tableItemQty }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-right">لم يتم بعد إضافة أى إدخالات على هذا السند</td>
                </tr>

            @endif
        </tbody>
    </table>

    <button class="closeBtn bg-danger" id="closeBtn" data-bs-close="#receitInfo ">
        اغلاق
    </button>
</div>

<script>
    $('#closeBtn').click(
        function() {
            $($(this).attr('data-bs-close')).removeClass('show')
        }
    )
</script>
