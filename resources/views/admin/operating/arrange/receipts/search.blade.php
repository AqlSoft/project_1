<table class="w-100">
    <thead>
        <tr>
            <th>#</th>
            <th>التاريخ</th>
            <th>رقم السند</th>
            <th>مرجعى</th>
            <th>العقد</th>
            <th>ادخالات</th>
            <th>اخراجات</th>
            <th><i class="fa fa-cogs"></i></th>
        </tr>
    </thead>
    <tbody>
        @if (count($receipts))
            @foreach ($receipts as $in => $item)
                <tr>
                    <td>{{ ++$in }}</td>
                    <td>
                        {{ $item->hij_date }} <br>
                        {{ $item->greg_date }}

                    </td>
                    <td>
                        <a class="btn btn-sm displayReceipt btn-block p-1 mb-1 bg-secondary"
                            data-receipt-id="{{ $item->id }}" data-search-token="{{ csrf_token() }}"
                            data-search-url="{{ route('reception.info') }}" data-tab="1" class="fa fa-eye text-primary"
                            data-bs-toggle="tooltip" data-bs-title="عرض محتويات السند">{{ $item->s_number }}</a>
                        <span class="btn btn-sm btn-block p-1 mb-1 bg-secondary">بواسطة:
                            {{ $item->admin }}</span>

                    </td>
                    <td>
                        السائق: {{ $item->driver_name }} <br>
                        ملاحظات: {{ $item->notes }}
                    </td>
                    <td><a class="btn btn-sm btn-block p-1 mb-1 bg-secondary"
                            href="{{ route('contract.view', [$item->contract_id, 1]) }}" data-bs-toggle="tooltip"
                            data-bs-title="رؤية العقد">العقد:
                            {{ $item->contract_serial }}</a>

                        <a class="btn btn-sm btn-block p-1 bg-secondary"
                            href="{{ route('clients.view', [$item->client_id]) }}" data-bs-toggle="tooltip"
                            data-bs-title="رؤية العميل"> العميل:
                            {{ $item->clientANname }}</a>
                    </td>
                    <td>{{ $item->total_inputs }}</td>
                    <td>{{ $item->total_outputs }}</td>
                    <td>
                        @if ($tab == 1)
                            <a href="{{ route('reception.entries.create', [$item->id, 0]) }}"><i
                                    class="fa fa-sign-in-alt text-info" data-bs-toggle="tooltip"
                                    data-bs-title="استلام بضاعة على السند"></i></a>

                            <a href="{{ route('reception.approve', [$item->id]) }}"><i class="fa fa-check text-success"
                                    data-bs-toggle="tooltip" data-bs-title="اعتماد السند"></i></a>

                            <a href="{{ route('reception.edit', [$item->id]) }}"><i class="fa fa-edit text-primary"
                                    data-bs-toggle="tooltip" data-bs-title="تعديل بيانات السند"></i></a>

                            <a class="displayReceipt" data-receipt-id="{{ $item->id }}"
                                data-search-token="{{ csrf_token() }}"
                                data-search-url="{{ route('reception.info') }}" data-tab="1"><i
                                    class="fa fa-eye text-primary" data-bs-toggle="tooltip"
                                    data-bs-title="عرض محتويات السند"></i></a>
                            <a href="{{ route('reception.destroy', [$item->id]) }}"
                                onclick="if (!confirm('انت على وشك القيام بعملية لا يمكن الرجوع نها، هل أنت متأكد؟')) return false"><i
                                    class="fa fa-trash text-danger"data-bs-toggle="tooltip"
                                    data-bs-title="حذف السند"></i></a>
                        @else
                            <a class="displayReceipt" data-receipt-id="{{ $item->id }}"
                                data-search-token="{{ csrf_token() }}"
                                data-search-url="{{ route('reception.info') }}" data-tab="1"><i
                                    class="fa fa-eye text-primary" data-bs-toggle="tooltip"
                                    data-bs-title="عرض محتويات السند"></i></a>

                            <a href="{{ route('reception.print', [$item->id]) }}"><i
                                    class="fa fa-print text-primary px-1" data-bs-toggle="tooltip"
                                    data-bs-title="طباعة السند"></i></a>

                            <a href="{{ route('reception.park', [$item->id, 0]) }}"
                                onclick="if(!confirm('are you sure?')return false)"><i class="fas fa-ban text-info px-1"
                                    data-bs-toggle="tooltip" data-bs-title="إتاحة السند للتعديل"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                @if ($tab == 1)
                    <td colspan="6"> لا يوجد سندات قيد التشغيل حتى الآن</td>
                @else
                    <td colspan="6"> لا يوجد سندات معتمدة حتى الان</td>
                @endif
            </tr>
        @endif
    </tbody>
</table>
<div id="search" class="mt-3">
    {{ $receipts->links() }}
</div>
