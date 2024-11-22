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
                    <a href="{{ route('rooms.home') }}">الغرف</a>

                </button>
                <button class="nav-link active">
                    <a> إضافة غرفة جديدة </a>
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background-color: #fff">

            <fieldset dir="rtl" class="m-3 mt-5">
                <legend class="">إضافة غرفة جديدة</legend>
                <form class="" id="regForm" action="{{ route('rooms.store') }}" method="post">
                    @csrf

                    <div class="input-group mb-2">
                        <label for="branch" class="input-group-text"> الفرع </label>
                        <select name="branch" id="branch" class="form-control">
                            <option hidden>اختر الفرع</option>
                            @foreach ($branches as $in => $branch)
                                <option dir="rtl" {{ old('branch') == 1 ? 'selected' : '' }}
                                    value="{{ $in }}"> {{ $branch }}
                                </option>
                            @endforeach
                        </select>
                        <label for="section" class="input-group-text"> القسم </label>
                        <select name="section" id="section" class="form-control">
                            <option hidden>اختر القسم</option>
                            @foreach ($sections as $in => $section)
                                <option dir="rtl" {{ old('section') == 1 ? 'selected' : '' }}
                                    value="{{ $section->id }}"> [{{ $section->e_name }}] - {{ $section->a_name }}
                                </option>
                            @endforeach
                        </select>
                        <label data-bs-toggle="tooltip" title="إضافة قسم جديد" class="input-group-text px-3"><a
                                href="{{ route('sections.create') }}"><i class="fa fa-plus"></i></a></label>
                    </div>
                    <div class="input-group mb-2">
                        <label for="a_name" class="input-group-text"> الاسم العربى: </label>
                        <input class="form-control" type="text" name="a_name" id="a_name"
                            value="{{ old('a_name') }}" placeholder="الغرفة ج">
                        <label for="size" class="input-group-text"> الاسم اللاتينى: </label>
                        <input class="form-control" type="text" name="e_name" id="e_name"
                            value="{{ old('e_name') }}" placeholder="Room C">
                    </div>
                    <div class="input-group mb-2">
                        <label for="size" class="input-group-text"> حجم الغرفة: </label>
                        <select class="form-control" name="size" id="">
                            <option hidden>اختر حجم الغرفة</option>
                            <option {{ old('size') == 1 ? 'selected' : '' }} value="1">صغيرة</option>
                            <option {{ old('size') == 2 ? 'selected' : '' }} value="2">كبيرة</option>
                            <option {{ old('size') == 3 ? 'selected' : '' }} value="3">مخصصة</option>
                        </select>
                        <label for="scheme" class="input-group-text"> التقسيمة </label>
                        <select name="scheme" id="scheme" class="form-control">
                            <option hidden>اختر تقسيمة الغرفة</option>
                            @for ($scheme = 1; $scheme <= 8; $scheme++)
                                <option dir="rtl" {{ old('scheme') == $scheme ? 'selected' : '' }}
                                    value="{{ $scheme }}"> Room_{{ $scheme }}_schema
                                </option>
                            @endfor
                        </select>
                        <label data-bs-toggle="tooltip" title="إضافة تقسيمة جديدة" class="input-group-text px-3"><a><i
                                    class="fa fa-plus"></i></a></label>
                    </div>
                    <div class="input-group">
                        <label for="serial" class="input-group-text"> الرقم المسلسل </label>
                        <input class="form-control" type="text" name="serial" id="serial"
                            value="{{ old('serial') ? old('serial') : $lir }}">
                        <label for="code" class="input-group-text"> الكـــود </label>
                        <input class="form-control" type="text" name="code" id=""
                            value="{{ old('code') }}">
                        <button class="input-group-text">إضافةالغرفة</button>
                    </div>

                    @error('a_name')
                        <div class="alert alert-danger text-right">{{ $message }}</div>
                    @enderror
                    @error('e_name')
                        <div class="alert alert-danger text-right">{{ $message }}</div>
                    @enderror
                    @error('serial')
                        <div class="alert alert-danger text-right">{{ $message }}</div>
                    @enderror
                    @error('code')
                        <div class="alert alert-danger text-right">{{ $message }}</div>
                    @enderror


                </form>
            </fieldset>
            <fieldset class="mx-3">
                <legend>تقسيمة الغرفة</legend>
                <br>
                <div class="room-scheme" style="width: 50vw; text-align: center; margin: auto">
                    <img data-bg-url="" class="room-scheme-img" alt="" width="100%">
                </div>
            </fieldset>
        </div>

    </div>
@endsection


@section('script')
    <script>
        $('#scheme').on('change', function() {
            console.log('schema changed')
            const sch = $('#scheme').val();
            $('.room-scheme-img').attr('src', `/assets/admin/uploads/images/Room_${sch}_Schema.png`)

        })
    </script>
@endsection
