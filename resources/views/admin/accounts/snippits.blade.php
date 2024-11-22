<div class="buttons">
    <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('tables.stats') }}"> <i
                class="fa fa-chart-line"></i> احصائيات
        </a></button>
    <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('tables.home') }}"> <i
                class="fa fa-list"></i>
            الطبالى</button>
    <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('table.edit', [$table->id]) }}">
            <i class="fa fa-edit"></i>
            تعديل</a></button>
    <button type="button" class="btn btn-sm px-2 btn-success"><a>
            <i class="fa fa-eye"></i>
            عرض</a></button>
    <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('table.create') }}"> <i
                class="fa fa-plus"></i>
            إضافة </a></button>
</div>
