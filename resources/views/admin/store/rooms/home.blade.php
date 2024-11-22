@extends('layouts.admin')
@section('title')
    التخزين
@endsection

@section('pageHeading')
    عرض جميع الغرف
@endsection

@section('content')
    <div class="container pt-5">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link">
                    <a href="{{ route('stores.home') }}">التخزين</a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('sections.home') }}">
                        الأقسام
                    </a> &nbsp;
                </button>
                <button class="nav-link active">
                    <a>الغرف</a> &nbsp;
                    <a href="{{ route('rooms.create') }}"><i class="fa fa-plus"></i></a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('store.storeArray') }}">مصفوفة التخزين</a>
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background-color: #fff">

            <table dir="rtl" id="data" style="width:100%">
                <thead>
                    <tr>
                        <th>مسلسل</th>
                        <th>المخزن</th>
                        <th>رقم الغرقة</th>
                        <th>الحجــــم</th>
                        <th>الكــــود</th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>

                    @php $i = 1 @endphp
                    @if (count($rooms))
                        @if (isset($rooms) && !empty($rooms))
                            @foreach ($rooms as $room)
                                <tr>
                                    <td>{{ $room->serial }}</td>
                                    <td>{{ $room->the_section }}</td>
                                    <td>{{ $room->e_name }}</td>
                                    <td>{{ $sizes[$room->size] }}</td>
                                    <td>{{ $room->code }}</td>
                                    <td>
                                        <button class="btn p-0"><a href="{{ route('rooms.view', $room->id) }}"
                                                data-bs-toggle="tooltip" title="عرض بيانات الغرفة {{ $room->e_name }}"><i
                                                    class="fa fa-eye text-primary"></i></a></button>
                                        <button class="btn p-0"><a href="{{ route('rooms.edit', $room->id) }}"
                                                data-bs-toggle="tooltip"
                                                title="تعديل بيانات الغرفة  {{ $room->a_name }}"><i
                                                    class="fa fa-edit text-info"></i></a></button>
                                        <button class="btn p-0"><a href="{{ route('rooms.delete', $room->id) }}"
                                                data-bs-toggle="tooltip" title="حذف بيانات الغرفة  {{ $room->a_name }}"><i
                                                    class="fa fa-trash text-danger"></i></a></button>

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @else
                        <tr>
                            <td colspan="5">No data to display</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{-- $rooms->links() --}}
        </div>

    </div>

@endsection



@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
    <script>
        $('.accordion-button i').click(function() {
            $(this).toggleClass('fa-folder-open fa-folder')
        })
        const cm = $('.alterContext');
        const ci = $('.catItem');
        ci.on('contextmenu', (e) => {
            e.preventDefault();
            showContextMenu();
            let c_id = e.target.getAttribute('data-id'),
                c_lvl = e.target.getAttribute('data-level')
            let cm_top = e.clientY + cm.offsetHeight > window.innerHeight ? window.innerHeight - cm.offsetHeight : e
                .clientY + 'px';
            let cm_left = e.clientX + cm.offsetWidth > window.innerWidth ? window.innerWidth - cm.offsetWidth : e
                .clientX + 'px';
            let al = $('#addLink'),
                el = $('#editLink'),
                dl = $('#deleteLink');
            cm.css({
                top: cm_top,
                left: cm_left
            })

            if (c_lvl == 3) {
                al.text('Add New Item');
                al.attr('href', al.attr('data-add-item').replace(/1/g, c_id));
            } else {
                al.text('Add New Category');
                al.attr('href', al.attr('data-url').replace(/0/g, c_id));
            }
            el.attr('href', el.attr('data-url').replace(/0/g, c_id));
            dl.attr('href', dl.attr('data-url').replace(/0/g, c_id));

        })
        $(window).on('click', () => {
            showContextMenu(false);
        })

        function showContextMenu(show = true) {
            cm.css({
                height: show ? 'auto' : 0,
            })
        }
    </script>
@endsection
