@extends('layouts.admin')
@section('title')
    اضافة قائمة فرعية
@endsection
@section('pageHeading')
    اضافة قائمة فرعية
@endsection
@section('content')
    <div class="container" style="min-height: 100vh">
        <fieldset>
            <legend>اضافة قائمة فرعية &nbsp;
            </legend>
         
            <form action="{{ route('store-menu-info') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="input-group mt-3">
                        <label for="sub_name" class="input-group-text">كود</label>
                        <input type="text" name="label" id="sub_name" class="form-control" required
                            value="{{ old('name') }}">
                        <label for="sub_display_name" class="input-group-text">الاسم</label>
                        <input type="text" name="display_name" id="sub_display_name" class="form-control"
                            required value="{{ old('display_name_') }}">
                            <label for="sub_display_name_ar" class="input-group-text">الاسم العربى</label>
                        <input type="text" name="display_name_ar" id="sub_display_name_ar" class="form-control" required
                            value="{{ old('display_name_ar') }}">
                    </div>
                    <div class="input-group mt-3">
                        <label for="sub_brief" class="input-group-text">الوصف</label>
                        <input type="text" name="brief" id="sub_brief" class="form-control" required
                            value="{{ old('brief') }}">
                    </div>
                    <div class="input-group mt-3">
                        <label for="sub_icon" class="input-group-text">ايقونة</label>
                        <input type="text" name="icon" id="sub_icon" class="form-control" required
                            value="{{ old('icon') }}">
                        <label for="sub_url" class="input-group-text">الرابط</label>
                        <input type="text" name="url" id="sub_url" class="form-control"
                            value="{{ old('url') }}">
                    </div>
                    <div class="input-group mt-3">
                        <label for="sub_menu_id" class="input-group-text">القائمة الرئيسية</label>
                        <select name="menu_id" id="sub_menu_id" class="form-control" value="{{ old('menu_id') }}">
                            <option value="{{ $root->id }}">{{ $root->display_name_ar }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer p-0">
                    <div class="buttons m-0">
                        <button type="button" class="btn btn-sm py-1 btn-danger"
                            data-bs-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-sm py-1 btn-primary">أضافة القائمة</button>
                    </div>
                </div>
            </form>
            
        </fieldset>

    </div>
@endsection

