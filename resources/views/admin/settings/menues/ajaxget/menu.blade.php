<form action="{{ route('menues.update') }}" method="post">
    @csrf
    <input type="hidden" name="menu_id" value="{{ $current->id }}">
    <div class="input-group mt-3">
        <label for="label" class="input-group-text required">كود:</label>
        <input type="text" name="label" id="label" class="form-control" required value="{{ $current->label }}">

        <label for="url_name" class="input-group-text required"> رابط القائمة:</label>
        <input type="text" name="url_name" id="url_name" class="form-control" required
            value="{{ $current->url_name }}">
    </div>
    <div class="input-group mt-3">
        <label for="display_name_ar" class="input-group-text required">اسم
            القائمة:</label>
        <input type="text" name="display_name_ar" id="display_name_ar" class="form-control" required
            value="{{ $current->display_name_ar }}">
    </div>

    <div class="input-group mt-3">
        <label for="display_name_en" class="input-group-text required"> الاسم بلغة
            أخرى:</label>
        <input type="text" name="display_name_en" id="display_name_en" class="form-control" required
            value="{{ $current->display_name_en }}">
    </div>

    <div class="input-group mt-3">
        <label for="parent" class="input-group-text required"> القائمة الرئيسية:
        </label>
        <select name="parent" id="parent" class="form-control text-right">
            @foreach ($menues as $parent)
                <option {{ $current->parent == $parent->id ? 'selected' : '' }} value="{{ $parent->id }}">
                    {{ $parent->display_name_ar }}</option>
            @endforeach
        </select>
    </div>

    <div class="input-group mt-3">
        <label for="menu_status" class="input-group-text required"> حالة التفعيل: </label>
        <select name="status" id="menu_status" class="form-control">
            <option value="1"> مفعلة </option>
            <option value="0"> معطلة </option>
        </select>

        <button class="btn btn-success input-group-text" type="submit">تحديث بيانات القائمة</button>
    </div>
</form>
