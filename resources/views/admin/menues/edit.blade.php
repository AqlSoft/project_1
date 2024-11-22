@extends('layouts.admin')
@section('title')
    تحديث بيانات القائمة
@endsection
@section('pageHeading')
    تحديث بيانات القائمة
@endsection
@section('content')
    <div class="container" style="min-height: 100vh">
        <fieldset>
            <legend>تحديث بيانات القائمة &nbsp;

            </legend>
            <form action="{{ route('update-menu-info') }}" method="POST">
                <input type="hidden" name="id" value="{{ $menu->id }}">
                @csrf
                <div class="modal-body">
                    <div class="input-group mt-3">
                        <label for="label" class="input-group-text">كود</label>
                        <input type="text" name="label" id="label" class="form-control" required
                            value="{{ old('label', $menu->label) }}">
                        <label for="display_name_en" class="input-group-text">الاسم</label>
                        <input type="text" name="display_name_en" id="display_name_en" class="form-control" required
                            value="{{ old('display_name_en', $menu->display_name_en) }}">
                        <label for="display_name_ar" class="input-group-text">الاسم بالعربي</label>
                        <input type="text" name="display_name_ar" id="display_name_ar" class="form-control" required
                            value="{{ old('display_name_ar', $menu->display_name_ar) }}">
                    </div>
                    <div class="input-group mt-3">
                        <label for="brief" class="input-group-text">الوصف</label>
                        <input type="text" name="brief" id="brief" class="form-control" required
                            value="{{ old('brief', $menu->brief) }}">

                    </div>
                    <div class="input-group mt-3">
                        <label for="icon" class="input-group-text">أيقونة</label>
                        <input type="text" name="icon" id="icon" class="form-control" required
                            value="{{ old('icon', $menu->icon) }}">
                        <label for="url" class="input-group-text">رابط</label>
                        <input type="text" name="url" id="url" class="form-control"
                            value="{{ old('url', $menu->url_name) }}">

                    </div>
                    <div class="input-group mt-3">
                        <label for="menu_id" class="input-group-text">القائمة</label>
                        <select name="menu_id" id="menu_id" class="form-control">


                            @foreach ($roots as $r)
                                <option {{ $menu->parent == $r->id ? 'selected' : '' }} value="{{ $r->id }}">
                                    {{ $r->display_name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="buttons">
                        <button type="button" class="btn btn-sm py-1 btn-info"
                            onclick="window.location.href='{{ route('display-menues-list') }}'">العودة للقوائم</a></button>
                        <button type="submit" class="btn btn-sm py-1 btn-success">تحديث البيانات</button>
                    </div>
                </div>
            </form>



        </fieldset>

    </div>
@endsection
