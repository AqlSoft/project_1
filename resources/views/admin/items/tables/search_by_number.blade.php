<table dir="rtl" style="width:100%; margin-top: 20px">
    <thead>
        <tr>
            <th>#</th>
            <th>مسلسل</th>
            <th>رقم الطبلية</th>
            <th>حجم الطبلية</th>
            <th>المحتويات</th>
            <th>السعة القصوى</th>
            <th>التحكم</th>
        </tr>
    </thead>
    <tbody>


        @if (count($tables))
            @foreach ($tables as $i => $table)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $table->serial }}</td>
                    <td>{{ $table->name }}</td>
                    <td>{{ $tableSizes[$table->size] }}</td>
                    <td>{{ $table->the_load }}</td>
                    <td>{{ $table->capacity }}</td>
                    <td>
                        <button class="btn p-0" title="عرض بيانات الطبلية" data-bs-toggle="tooltip"><a
                                href="{{ route('table.view', $table->id) }}"><i
                                    class="fa fa-eye text-primary"></i></a></button>
                        <button class="btn p-0" title="تعديل بيانات الطبلية" data-bs-toggle="tooltip">
                            <a href="{{ route('table.edit', $table->id) }}"><i
                                    class="fa fa-edit text-info"></i></a></button>
                        <button class="btn p-0" title="حذف الطبلية بشكل نهائى" data-bs-toggle="tooltip"
                            onclick="if(!confirm('انت على وشك القيام بعملية لا يمكن التراجع عنها، هل أنت متأكد؟'))return false"><a
                                href="{{ route('table.delete', $table->id) }}">
                                <i class="fa fa-trash text-danger"></i></a></button>

                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5">لا يوجد طبالى مسجلة حتى الان</td>
            </tr>
        @endif
    </tbody>
</table>
<br>
<div id="search-links">
    {{ $tables->links() }}
</div>
