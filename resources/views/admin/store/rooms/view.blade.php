@extends('layouts.admin')

@section('title')
    الغرف
@endsection

@section('pageHeading')
    عرض بيانات غرفة
@endsection
@section('header_includes')
@endsection

@section('content')
    <div class="container">
        <style>
            section#sections button {
                font-size: 90px;
                font-weight: bold;
            }

            .room-scheme {
                width: 50vw;
                height: 20vw;
                margin: 1rem auto;
            }
        </style>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link">
                    <a href="{{ route('stores.home') }}">التخزين</a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('sections.home') }}">الأقسام</a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('rooms.home') }}">الغرف</a>
                </button>
                <button class="nav-link active">
                    <a>
                        عرض معلومات الغرفة
                    </a>
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background-color: #fff">
            <fieldset class="mt-5 m-3">
                <legend>البيانات الأساسية</legend>
                <div class="input-group mt-3">
                    <label for="" class="input-group-text">القسم</label><label class="form-control bdo-rtl">
                        <span> {{ $room->the_section->a_name }}</span> - <span>{{ $room->the_section->e_name }}</span>
                    </label>
                    <label for="" class="input-group-text">الاسم</label><label class="form-control">
                        <span>[{{ $room->a_name }}]</span> - <span> [ {{ $room->e_name }} ]</span>
                    </label>
                    <label for="" class="input-group-text">الفرع</label><input type="text" class="form-control"
                        value="{{ $room->the_branch }}" disabled>
                </div>
                <div class="input-group my-2">
                    <label for="" class="input-group-text">الأمين</label><input type="text" class="form-control"
                        value="{{ $room->the_keeper->userName }}" disabled>
                    <label for="" class="input-group-text">الحالة</label><input type="text" class="form-control"
                        value="{{ $room->status == 0 ? 'معطل' : 'مفعل' }}" disabled>
                    <label for="" class="input-group-text">الكود</label><input type="text" class="form-control"
                        value="{{ $room->code }}" disabled>
                </div>
                <div class="input-group my-2">
                    <label for="" class="input-group-text">طبالى كبيرة:</label>
                    <input type="text" class="form-control" value="{{ $room->large_tables }}" disabled>
                    <label for="" class="input-group-text">طبالى صغيرة:</label>
                    <input type="text" class="form-control" value="{{ $room->total_tables - $room->large_tables }}"
                        disabled>
                    <label for="" class="input-group-text">مجموع الطبالى:</label>
                    <input type="text" class="form-control" value="{{ $room->total_tables }}" disabled>
                </div>
            </fieldset>


            <fieldset class="mt-5 m-3">
                <legend> تقسيمة الغرفة </legend>
                <div class="room-scheme">
                    <img src="{{ asset('assets/admin/uploads/images/room_' . $room->scheme . '_schema.png') }}"
                        alt="" style="display: block; width: 100%">
                </div>
            </fieldset>

            <fieldset class="mt-5 m-3">
                <legend> محتويات الغرفة </legend>
                <div class="room-contents">
                    @foreach ($room->contents as $table)
                        <div class="border btn btn-outline-primary" style="width: 100px; height: 70px;">
                            {{ str_pad($table->table_name, 5, '0', STR_PAD_LEFT) }}<br>
                            {{ $table->code }}
                        </div>
                    @endforeach
                </div>
            </fieldset>
        </div>

    </div>
@endsection

@section('script')
    <script>
        const hello = 2
    </script>
@endsection
