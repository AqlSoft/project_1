@extends('layouts.admin')
@section('title')
    تحديث بيانات صلاحيات التطبيق
@endsection
@section('content')
    <div class="container" style="min-height: 100vh">
        <fieldset>
            <legend>تحديث بيانات الصلاحية: [ {{ $permission->display_name_ar }} ]
            </legend>
            
            <form action="{{ route('update-permission-info') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $permission->id }}">
                <div class="modal-body">
                    <div class="input-group mt-3">
                        <label for="name" class="input-group-text required">الاسم</label>
                        <input type="text" name="name" id="name" class="form-control" required
                            value="{{ old('name', $permission->name) }}">
                        <label for="menu" class="input-group-text">القائمة </label>
                        <select name="menu_id" id="menu" class="form-control">
                            @foreach ($menues as $p)
                                <option value="{{ $p->id }}">{{ $p->parent_menu->display_name_ar }} - {{ $p->display_name_ar }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                    <div class="input-group mt-3">
                        <label for="display_name_en" class="input-group-text required">الاسم</label>
                        <input type="text" name="display_name_en" id="display_name_en" class="form-control" required
                            value="{{ old('display_name_en', $permission->display_name_en) }}">
                        <label for="display_name_ar" class="input-group-text required">الاسم العربي</label>
                        <input type="text" name="display_name_ar" id="display_name_ar" class="form-control" required
                            value="{{ old('display_name_ar', $permission->display_name_ar) }}">
                    </div>
                    <div class="input-group mt-3">
                        <label for="brief" class="input-group-text required">الوصف</label>
                        <input type="text" name="brief" id="brief" class="form-control" required
                            value="{{ old('brief', $permission->brief) }}">

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="buttons">
                        <button type="button" onclick="window.location.href='{{ route('display-permissions-list') }}'"
                            class="btn btn-sm py-1 btn-info" data-dismiss="modal">العودة</button>
                        <button type="submit" class="btn btn-sm py-1 btn-success">تحديث البيانات</button>
                    </div>

                </div>
            </form>


        </fieldset>

    </div>
@endsection
