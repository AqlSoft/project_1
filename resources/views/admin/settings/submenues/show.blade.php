@extends('layouts.admin')
@section('title')
    الإعدادات العامة
@endsection
@section('homeLink')
    القوائم الفرعية
@endsection
@section('homeLinkActive')
    عرض بيانات قائمة فرعية
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('mainmenues.home') }}">
            <span class="btn-title">العودة إلى القوائم الرئيسية</span>
            <i class="fa fa-home text-light"></i></a>
    </button>
@endsection
@section('content')

    <div class="container pt-5" style="min-height: 100vh">
        <fieldset>
            <legend style="padding: 8px 16px">عرض بيانات القائمة الفرعية
                <a id="editMenuBtn" class="text-primary" data-bs-toggle="modal" data-bs-target="#editMenuInfo">
                    <i data-bs-toggle="tooltip" data-bs-title="تعديل بيانات القائمة" class="fa fa-edit"></i>
                </a>


            </legend>
            <div class="text-right mt-3 mx-3">
                <b>اسم القائمة:</b>
                <em>&nbsp; &nbsp; {{ $subMenu->name }}</em>
            </div>
            <div class="text-right mx-3">
                <b>اسم القائمة الرئيسية:</b>
                <em>&nbsp; &nbsp; {{ $subMenu->parentName }}</em>
            </div>
            <div class="text-right mx-3">
                <b>رابط القائمة:</b>
                <em>&nbsp; &nbsp; {{ $subMenu->menu_link }}</em>
            </div>
            <div class="text-right mx-3">
                <b>حالة تفعيل القائمة:</b>
                <em>&nbsp; &nbsp; {{ $subMenu->status ? 'مفعلة' : 'معطلة' }}</em>
            </div>
            <div class="text-right mx-3">
                <b> الإجراءات فى هذه القائمة </b>
                <a id="addNewActioBtn" class="text-success" data-bs-toggle="modal" data-bs-target="#addNewAction">
                    <i data-bs-toggle="tooltip" data-bs-title="إضافة إجراء" class="fa fa-plus-square"></i>
                </a>

                <table class="w-100 bordered">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>اسم الصلاحية</td>
                            <td>رابط الصلاحية</td>
                            <td><i class="fa fa-cogs"></i></td>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($subMenu->permissions))
                            @foreach ($subMenu->permissions as $p => $item)
                                <tr>
                                    <td> {{ ++$p }} </td>
                                    <td class="fw-normal"> {{ $item->name }} </td>
                                    <td class="fw-normal"> {{ $item->permission_link }} </td>
                                    <td>
                                        <a class="text-primary" href="{{ route('permissions.edit', [$item->id]) }}">
                                            <i data-bs-toggle="tooltip" data-bs-title="التعديل" class="fa fa-edit"></i>

                                            <a class="text-danger" href="{{ route('permissions.destroy', [$item->id]) }}">
                                                <i onclick="return confirm('هل تريد حذف هذه القائمة بالفعل؟، هذه الحركة لا يمكن الرجوع عنها.')"
                                                    data-bs-toggle="tooltip" data-bs-title="الحذف" class="fa fa-trash"></i>
                                            </a>

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">No permissiond added </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

            </div>


        </fieldset>

        {{-- Modals --}}

        <div class="modal fade" id="editMenuInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header mx-0 bg-secondary" style="background-color: #777">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"> تعديل بيانات القائمة </h1>
                        <button type="button" class="button-close ml-1 my-1 p-1" data-bs-dismiss="modal"
                            aria-label="Close"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form id="editMenuForm" action="{{ route('submenues.update') }}" method="post">

                            @csrf
                            <input type="hidden" name="menuId" id="hiddenInputId" value="{{ $subMenu->id }}">

                            <div class="input-group mt-3">
                                <label for="menuName" class="input-group-text required">اسم القائمة:</label>
                                <input type="text" name="name" id="menuName" class="form-control" required
                                    value="{{ $subMenu->name }}">
                            </div>

                            <div class="input-group mt-3">
                                <label for="menu_link" class="input-group-text required">رابط القائمة:</label>
                                <input type="text" name="menu_link" id="menu_link" class="form-control" required
                                    value="{{ $subMenu->menu_link }}">
                            </div>

                            <div class="input-group mt-3">
                                <label for="status" class="input-group-text required"> حالة التفعيل: </label>
                                <select name="status" id="menuStatus" class="form-control" value="{{ $subMenu->status }}">
                                    <option value="1">مفعلة</option>
                                    <option value="0">معطلة</option>
                                </select>
                            </div>

                            <div style="">
                                <br>
                                <button id="editMenuDismissBtn" type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">إغلاق</button>
                                <button class="btn btn-success" type="submit" id="submitBtn"> تحديث البيانات </button>
                            </div>
                            <div
                                class="alert alert-sm px-3 py-1 alert-secondary float-right d-inline-block text-info mt-3 text-right">
                                ( <span style="color: red">*</span> ) تشير إلى حقول مطلوبة.</div>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>

        {{-- Create New Action Modal Form --}}
        <div class="modal fade" id="addNewAction" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width: 50vw">
                    <div class="modal-header mx-0 bg-secondary" style="background-color: #777">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"> إضافة إجراء جديد على القائمة </h1>
                        <button type="button" class="button-close ml-1 my-1 p-1" data-bs-dismiss="modal"
                            aria-label="Close"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('permissions.store') }}" method="post">

                            @csrf
                            <input type="hidden" name="sub_menu" value="{{ $subMenu->id }}">
                            <input type="hidden" name="main_menu" value="{{ $subMenu->main_menu }}">

                            <div class="input-group mt-3">
                                <label for="main_menu" class="input-group-text required"> القائمة الرئيسية: </label>
                                <label class="form-control text-right">{{ $subMenu->parentName }}</label>
                                <label for="sub" class="input-group-text required"> القائمة الفرعية: </label>
                                <label class="form-control  text-right">{{ $subMenu->name }}</label>
                            </div>

                            <div class="input-group mt-3">
                                <label for="name" class="input-group-text required">اسم الصلاحية:</label>
                                <input type="text" name="name" id="name" class="form-control" required
                                    value="{{ old('name') }}">

                                <label for="link" class="input-group-text required"> رابط الصلاحية: </label>
                                <input type="text" name="link" id="link" class="form-control" required
                                    value="{{ old('link') }}">

                            </div>

                            <div class="input-group mt-3">
                                <label for="status" class="input-group-text required"> حالة التفعيل: </label>
                                <select name="status" id="status" class="form-control" value="{{ old('status') }}">
                                    <option value="1"> مفعلة </option>
                                    <option value="0"> معطلة </option>
                                </select>


                                <button class="btn btn-success input-group-text" type="submit">تسجيل إجراء جديد</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('script')
    <script>
        // $('#editMenuBtn').click(function () {
        //     $('#menuName').attr('value', $(this).attr('data-info-name'))
        //     $('#menuName').attr('value', $(this).attr('data-info-name'))
        //     $('#hiddenInputId').attr('value', $(this).attr('data-info-id'))
        //     $('#menuStatus option[value='+$(this).attr('data-info-status')+']').attr('selected', '')
        // });
    </script>
@endsection
