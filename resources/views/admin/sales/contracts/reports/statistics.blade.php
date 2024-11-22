<style>
    tr th {
        border-left: 1px solid #777;
        height: 40px;
    }

    tr th:last-child {
        border-left: 0;
    }

    h4 {
        text-align: right
    }
</style>
<div class="container bg-light  px-4 py-3" style="max-height: 80vh; overflow-y: scroll;" dir="rtl">
    <h1 class="text-right">سجل العمليات على الصنف</h1>

    <h4>{{ $item->name }}</h4>
    <h4>{{ $box->name }}</h4>
    <table class="w-100 mb-3">
        <thead>
            <tr style="height: 2em">
                <th rowspan="2">#</th>
                <th rowspan="2">التاريخ</th>
                <th rowspan="2">السند</th>
                <th colspan="2">نوع العملية</th>
                <th colspan="3">الكميات</th>
            </tr style="height: 2em">
            <tr>
                <th>استلام</th>
                <th>إخراج</th>
                <th>مدخلات</th>
                <th>مخرجات</th>
                <th>رصيد</th>
            </tr>
            @php
                $credit = 0;
            @endphp
            @foreach ($items as $in => $item)
                <tr>
                    <td>{{ ++$in }}</td>
                    <td>{{ $item->created_at }}</td>

                    <td>{{ $item->receipt_id }}</td>
                    @if ($item->type == 1)
                        <td><i class="fa fa-check text-success"></i></td>
                        <td><i class="fa fa-minus text-primary"></i></td>
                        <td>{{ $item->inputs }}</td>
                        @php
                            $credit += $item->inputs;
                        @endphp
                        <td><i class="fa fa-minus text-primary"></i></td>
                    @else
                        <td><i class="fa fa-minus text-primary"></i></td>
                        <td><i class="fa fa-check text-success"></i></td>
                        <td><i class="fa fa-minus text-primary"></i></td>
                        <td>{{ $item->outputs }}</td>
                        @php
                            $credit -= $item->outputs;
                        @endphp
                    @endif

                    <td>{{ $credit }}</td>
                </tr>
            @endforeach
        </thead>
    </table>
    <button data-target="itemsLook" class="py-2 px-3"
        onclick="document.getElementById(this.getAttribute('data-target')).style.display='none'">إغلاق</button>
</div>

</div>
