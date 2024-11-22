<fieldset class="my-5 py-5">
    <legend class="p-0" style="background-clip: transparent; box-shadow: none">
        <div class="legend-item d-inline-block {{ $type == 1 ? 'active' : '' }}" style="">
            <a href="{{ route('receipts.output_receipts', [1]) }}"> سندات جارية </a>
            <a data-bs-toggle="tooltip" data-bs-title="إضافة سند جديد" href="{{ route('receipts.output.create', [1]) }}"><i
                    class="fa fa-plus"></i></a>
        </div>
        <div class="legend-item d-inline-block {{ $type == 2 ? 'active' : '' }}">
            <a href="{{ route('receipts.output_receipts', [2]) }}"> سندات معتمدة </a>
        </div>
    </legend>
    @if ($type != 2)
        <table class="w-100">
            <thead>
                <tr>
                    <td>#</td>
                    <td>التاريخ</td>
                    <td>رقم السند</td>
                    <td>السائق</td>
                    <td>العقد</td>
                    <td>العميل</td>
                    <td>تحكم</td>
                </tr>
            </thead>
            <tbody>
                @if (count($receipts))
                    @foreach ($receipts as $in => $item)
                        <tr>
                            <td>{{ ++$in }}</td>
                            <td>{{ $item->hij_date }}</td>
                            <td>{{ $item->s_number }}</td>
                            <td>{{ $item->driver }}</td>
                            <td>{{ $item->the_contract }}</td>
                            <td>{{ $item->the_client }}</td>
                            <td>
                                <a href="{{ route('receipts.editOutputReceipt', [$item->id]) }}"><i
                                        class="fa fa-edit text-primary" data-bs-toggle="tooltip"
                                        data-bs-title="تعديل بيانات السند"></i></a>

                                <a class="displayReceipt" data-receipt-id="{{ $item->id }}"
                                    data-search-token="{{ csrf_token() }}"
                                    data-search-url="{{ route('receipts.displayReceiptInfo') }}" data-tab="1"><i
                                        class="fa fa-eye text-primary" data-bs-toggle="tooltip"
                                        data-bs-title="عرض محتويات السند"></i></a>

                                <a href="{{ route('output.entry.create', [$item->id, 0]) }}"><i
                                        class="fa fa-sign-out-alt text-info" data-bs-toggle="tooltip"
                                        data-bs-title="إخراج بضاعة بموجب السند"></i></a>

                                <a href="{{ route('receipt.destroy', [$item->id]) }}"><i
                                        class="fa fa-trash text-danger"data-bs-toggle="tooltip"
                                        data-bs-title="حذف السند"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5"> لا يوجد سندات قيد التشغيل</td>
                    </tr>
                @endif
            </tbody>
        </table>
    @elseif ($type == 2)
        <table class="w-100">
            <thead>
                <tr>
                    <td>#</td>
                    <td>التاريخ</td>
                    <td>رقم السند</td>
                    <td>السائق</td>
                    <td>العقد</td>
                    <td>العميل</td>
                    <td>تحكم</td>
                </tr>
            </thead>
            <tbody>
                @if (count($receipts))
                    @foreach ($receipts as $in => $item)
                        <tr>
                            <td>{{ ++$in }}</td>
                            <td>{{ $item->hij_date }}</td>
                            <td>{{ $item->s_number }}</td>
                            <td>{{ $item->driver }}</td>
                            <td>{{ $item->the_contract }}</td>
                            <td><a href="{{ route('clients.view', [$item->client_id]) }}">{{ $item->the_client }}</a>
                            </td>
                            <td>
                                <a class="displayReceipt" data-receipt-id="{{ $item->id }}"
                                    data-search-token="{{ csrf_token() }}"
                                    data-search-url="{{ route('receipts.displayReceiptInfo') }}" data-tab="1"><i
                                        class="fa fa-eye text-primary" data-bs-toggle="tooltip"
                                        data-bs-title="عرض محتويات السند"></i></a>
                                <a href="{{ route('receipts.output.print', [$item->id]) }}"><i
                                        class="fa fa-print text-primary px-1" data-bs-toggle="tooltip"
                                        data-bs-title="طباعة السند"></i></a>

                                <a href="{{ route('receipt.park', [$item->id, 0]) }}"><i
                                        class="fa fa-hourglass-end text-info px-1" data-bs-toggle="tooltip"
                                        data-bs-title="إلغاء تفعيل السند"></i></a>
                            </td>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5"> لا يوجد سندات معتمدة حتى الان</td>
                    </tr>
                @endif
            </tbody>
        </table>
    @endif
</fieldset>
<div id="search">
    {{ $receipts->links() }}
</div>
