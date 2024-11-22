@extends('layouts.admin')

@section('title')
    الأقسام
@endsection

@section('pageHeading')
    عرض جميع الأقسام
@endsection
@section('content')
    <div class="container">
        <style>
            .rooms .room button a {
                display: block;
                font-weight: bold;
                height: 100%;
                text-align: center;
                font-size: 90px;
                line-height: 200px;
                background-size: 100% 100%;
                background-position: top left;
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
                <button class="nav-link active">
                    <a>
                        عرض معلومات القسم
                    </a>
                </button>

            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background-color: #fff">


            <fieldset class="mt-5 m-3">
                <legend>البيانات الأساسية</legend>
                <div class="input-group mt-3">
                    <label for="" class="input-group-text">الاسم</label><input type="text" class="form-control"
                        value="{{ $section->a_name }} - {{ $section->e_name }}" disabled>
                    <label for="" class="input-group-text">الفرع</label><input type="text" class="form-control"
                        value="{{ $branches[$section->branch] }}" disabled>
                </div>
                <div class="input-group my-2">
                    <label for="" class="input-group-text">الأمين</label><input type="text" class="form-control"
                        value="{{ $section->keeper }}" disabled>
                    <label for="" class="input-group-text">الحالة</label><input type="text" class="form-control"
                        value="{{ $section->status == 0 ? 'معطل' : 'مفعل' }}" disabled>
                    <label for="" class="input-group-text">الكود</label><input type="text" class="form-control"
                        value="{{ $section->code }}" disabled>
                </div>
            </fieldset>

            <fieldset class="mt-5 m-3">
                <legend>الغرف فى القسم</legend>

                <div class="row rooms">
                    @foreach ($section->rooms as $i => $room)
                        <div class="col col-6">
                            <div class="bg-light room">
                                <button style="height: 200px;" class="btn btn-block btn-outline-primary my-2">
                                    <a href="{{ route('rooms.view', $room->id) }}"
                                        data-background-url="{{ asset('assets/admin/uploads/images/room_' . $room->scheme . '_schema.png') }}">{{ $room->code }}</a>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </fieldset>




        </div>

    </div>
@endsection

@section('script')
    <script>
        const rooms = document.querySelectorAll('.rooms button a')
        rooms.forEach((room) => {
            room.style.backgroundImage = 'url("' + room.getAttribute('data-background-url') + '")'
        })
    </script>
@endsection
