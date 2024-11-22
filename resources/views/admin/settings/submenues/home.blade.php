@extends('layouts.admin')
@section('title')
    الإعدادات العامة
@endsection
@section('homeLink')
    الأدوار
@endsection
@section('homeLinkActive')
    الرئيسية
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('submenues.create', [0]) }}">
            <span class="btn-title"> إضافة قائمة جديدة </span>
            <i class="fas fa-plus-circle text-light"></i></a>
    </button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('users.home') }}">
            <span class="btn-title">العودة للمستخدمين</span>
            <i class="fa fa-users text-light"></i></a></button>
@endsection
@section('content')
    <style>

    </style>
    <div class="container pt-4" style="min-height: 100vh">
        <fieldset class="pt-3">
            <legend> القوائم الفرعية </legend>
            <table dir="rtl" class="striped mt-4" style="width: 100%">
                <thead>
                    <tr class="text-center">
                        <th>مسلسل</th>
                        <th> القائمة الرئيسية </th>
                        <th> اسم القائمة </th>
                        <th> الإجراءات </th>
                        <th> الحالة </th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($submenues))
                        @php $i=0 @endphp @foreach ($submenues as $sm => $menu)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $menu->parent }}</td>
                                <td>
                                    {{ $menu->name }} <br>
                                    {{ $menu->menu_link }}
                                </td>
                                <td>
                                    <ul class="row" style="list-style:none; font-size: 12px">
                                        @foreach ($menu->actions as $sm => $action)
                                            <li class="col-md-12 mb-1 col-lg-6 py-0 text-right">
                                                <div class="submenu m-0 px-1 position-relative border">
                                                    <span class="fw-normal fs-6">{{ $action->name }}</span>
                                                    <span class="buttons position-absolute start-0" style="top:-10px">
                                                        <a data-bs-toggle="tooltip" data-bs-title="عرض القائمة الفرعية"
                                                            href="{{ route('submenues.show', [$action->id]) }}"><i
                                                                class="text-primary fa fa-eye"></i></a>
                                                        <a data-bs-toggle="tooltip" data-bs-title="حذف القائمة الفرعية"
                                                            href="{{ route('submenues.destroy', [$action->id]) }}"><i
                                                                class="text-danger fa fa-trash"></i></a>
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>

                                </td>
                                <td>{{ $menu->status ? 'مفعل' : 'معطل' }}</td>
                                <td>
                                    <button type="button" class="btn text-primary ediMenuBtn" data-bs-toggle="modal"
                                        data-bs-target="#editMenu" data-bs-id="{{ $menu->id }}"
                                        data-bs-name="{{ $menu->name }}" data-bs-link="{{ $menu->menu_link }}"
                                        data-bs-status="{{ $menu->status }}" data-bs-menu="{{ $menu->main_menu }}">
                                        <i data-bs-toggle="tooltip" data-bs-title="تعديل بيانات القائمة"
                                            class="fa fa-edit"></i>
                                    </button>
                                    <a class="px-2"
                                        href="{{ route('permissions.create', [$menu->main_menu, $menu->id]) }}">
                                        <i data-bs-toggle="tooltip" data-bs-title="إضافة إجراءات للقائمة"
                                            class="text-success fas fa-caret-square-down">
                                        </i>
                                    </a>
                                    <a onclick="return confirm('هل تريد حذف هذه القائمة بالفعل؟، هذه الحركة لا يمكن الرجوع عنها.')"
                                        class="px-2" href="{{ route('submenues.destroy', [$menu->id]) }}">
                                        <i data-bs-toggle="tooltip" data-bs-title="إزالة القائمة"
                                            class="text-danger fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">لم يتم بعد تسجيل أية قوائم حتى الان <a
                                    href="{{ route('mainmenues.create') }}"> قم بإضافة أول القوائم الرئيسية فى هذا التطبيق!
                                </a></td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{ $submenues->links() }}
        </fieldset>

        {{-- Modals --}}

        <div class="modal fade" id="editMenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input type="hidden" name="menuId" id="hiddenInputId">

                            <div class="input-group mt-3">
                                <label for="menuName" class="input-group-text required">اسم القائمة:</label>
                                <input type="text" name="name" id="menuName" class="form-control" required
                                    value="">
                            </div>

                            <div class="input-group mt-3">
                                <label for="menu_link" class="input-group-text required">رابط القائمة:</label>
                                <input type="text" name="menu_link" id="menu_link" class="form-control" required
                                    value="">
                            </div>

                            <div class="input-group mt-3">
                                <label for="menuStatus" class="input-group-text required"> حالة التفعيل: </label>
                                <select name="status" id="menuStatus" class="form-control" value="">
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

    </div>
@endsection


@section('script')
    <script>
        $('.ediMenuBtn').click(function() {
            $('#menuName').attr('value', $(this).attr('data-bs-name'))
            $('#hiddenInputId').attr('value', $(this).attr('data-bs-id'))
            $('#menu_link').attr('value', $(this).attr('data-bs-link'))
            $('#menuStatus option').removeAttr('selected')
            $('#menuStatus option[value=' + $(this).attr('data-bs-status') + ']').attr('selected', '')
        });
    </script>
@endsection
