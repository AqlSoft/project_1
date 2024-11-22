<table dir="rtl" style="width: 100%">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>اسم العميل</th>
            <th>الهاتف</th>
            <th>مجال العمل</th>
            <th>أدوات التحكم</th>
        </tr>
    </thead>
    <tbody>
        @if (count($clients2))
            @php $i=1;  @endphp
            @php
                $page = request()->query('page') ? request()->query('page') : 1;
            @endphp
            @foreach ($clients2 as $cl => $client)
                <tr>
                    <td>{{ ($page - 1) * 10 + $i }}</td>
                    <td>
                        <a href="{{ route('clients.view', [$client->id]) }}" data-bs-toggle="tooltip"
                            title="عرض بيانات العميل" class="client-info border  py-1 px-3"><span
                                class="badge badge-secondary py-1 px-3">{{ $client->s_number }}</span>
                            -
                            {{ $client->a_name }} - {{ $client->e_name }}
                        </a>
                        <div class="clients-contracts py-2">
                            @if (count($client->contracts))
                                @foreach ($client->contracts as $cc => $contract)
                                    <span class="badge badge-success py-1 px-3" style="text-align: right"><a
                                            data-bs-toggle="tooltip" title="عرض تفاصيل العقد"
                                            href="{{ route('contract.view', [$contract->id, 2]) }}">{{ $contract->s_number }}</a></span>
                                @endforeach
                            @else
                                <div class="buttons p-0">
                                    <button class="btn btn-warning btn-sm btn-block">
                                        لا يوجد عقود مسجلة لهذا العميل
                                    </button>


                                </div>
                            @endif

                    </td>

                    <td>{{ $client->phone }}</td>
                    <td>{{ $scopes[$client->industry] }}</td>
                    <td>
                        <div class="buttons">
                            <button class="btn btn-outline-success btn-sm"><a
                                    href="{{ route('contract.create', [$client->id]) }}"><i class="fa fa-plus"
                                        title="إضافة عقد  جديد"></i> عقد جديد </a>
                            </button>
                            <button class="btn btn-outline-danger btn-sm">
                                <a href="{{ route('clients.delete', [$client->id]) }}"
                                    onclick="return confirm('هل تريد حذف هذا العميل بالفعل؟، هذه الحركة لا يمكن الرجوع عنها.')"><i
                                        class="fa fa-trash" title="حذف العميل"></i> حذف </a>
                            </button>
                        </div>
                    </td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        @else
            <tr>
                <td colspan="7"> لا توجد نتائج للبحث </td>
            </tr>
        @endif
    </tbody>
</table>
<div class="mt-3" id="search">
    {{ $clients2->links() }}
</div>
