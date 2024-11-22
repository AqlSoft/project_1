@extends('layouts.admin')
@section('title')
    صلاحيات الأدوار
@endsection

@section('pageHeading')
    صلاحيات الأدوار
@endsection

@section('content')
    <style>
        fieldset {
            background-color: rgb(233, 245, 233);
        }

        form>fieldset {
            box-shadow: none;
            background-color: #ccc7;
            border-radius: .375rem;
        }

        .form-floating {
            position: relative;
        }

        .form-floating>textarea.form-control {
            border-radius: 1rem;
        }

        .form-floating>textarea.form-control:not(:empty),
        .form-floating>textarea.form-control:focus {
            padding-top: 2.5rem;

        }

        .form-floating>textarea.form-control:not(:empty)~label,
        .form-floating>textarea.form-control:focus~label {
            transform: scale(1);
            width: 100%;
            left: 8rem;
        }

        .form-floating>label {
            right: 2rem;
            margin: 0;
        }
    </style>
    <div class="container pt-3" style="min-height: 100vh">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a href="{{ route('roles.home', [$user->id]) }}"> كل الأدوار </a>

                </button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <a href="{{ route('roles.nonactive') }}"> أدوار غير مفعلة</a>
                </button>
                <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <a> صلاحيات الأدوار </a>
                </button>
                <button class="nav-link " id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <a href="{{ route('roles.setting', [$user->id]) }}"> الاعدادات </a>
                </button>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent" style="">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                tabindex="0">
                <fieldset dir="rtl" class="m-3">
                    <h4> الصلاحيات الموزعة على الأدوار &nbsp; &nbsp;
                        <button type="button" class="btn btn-sm btn-primary py-1" style="border-radius: 0"
                            data-bs-toggle="modal" data-bs-target="#addNewPermission"><i data-bs-toggle="tooltip"
                                title="إضافة صلاحية جديدة للتطبيق" class="fa fa-plus"></i></button>
                    </h4>

                    <div class="row bg-light p-3 m-3" style="box-shadow: 0 0 6px 2px #ccc inset">
                        <div class="hidden" id="roleAjaxFormData"
                            data-ajax-url="{{ route('get.role.permissions.by.ajax') }}"
                            data-ajax-token="{{ csrf_token() }}"></div>
                        @foreach ($roles as $num => $role)
                            <div class="col-lg-6 col-12 px-3">
                                <div class="row my-1 px-3 py-2" style="background-color: #3332">
                                    <div class="col col-1">{{ ++$num }}</div>
                                    <div class="col col-6" data-bs-toggle="tooltip" title="{{ $role->brief }}">
                                        {{ $role->display_name_ar }}</div>
                                    <div class="col col-5 text-left">
                                        <a class="btn btn-sm btn-outline-success px-1 py-0" data-bs-toggle="tooltip"
                                            title="عرض" href="{{ route('roles.view', $role->id) }}"><i
                                                class="fa fa-eye"></i></a>
                                        <a class="btn btn-sm btn-outline-info px-1 py-0" data-bs-toggle="tooltip"
                                            title="إضافة صلاحية للدور">
                                            <div data-role-id="{{ $role->id }}" class="assign_permission_toggler"
                                                data-bs-toggle="modal" data-bs-target="#assignPermission"><i
                                                    class="fa fa-shield"></i></div>
                                        </a>
                                        <a class="btn btn-sm btn-outline-primary px-1 py-0" data-bs-toggle="tooltip"
                                            title="تعديل" href="{{ route('roles.edit', $role->id) }}"><i
                                                class="fa fa-edit"></i></a>
                                        <a class="btn btn-sm btn-outline-success px-1 py-0" data-bs-toggle="tooltip"
                                            title="تفعيل" href="{{ route('roles.edit', $role->id) }}"><i
                                                class="fa fa-check"></i></a>
                                        <a class="btn btn-sm btn-outline-danger px-1 py-0" data-bs-toggle="tooltip"
                                            title="حذف" href="{{ '' }}"><i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </fieldset>
            </div>
        </div>
        </fieldset>
    </div>



    <!-- Modals -->


    <!-- Add New Permission Modal -->
    <div class="modal fade" id="addNewPermission" tabindex="-1" aria-labelledby="addNewPermissionHeading"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 800px">
                <div class="modal-header mx-0 bg-secondary" style="background-color: #777">
                    <h1 class="modal-title fs-5" id="addNewPermissionHeading">إضافة صلاحيات</h1>
                    <button type="button" class="button-close ml-1 my-1 p-1" data-bs-dismiss="modal"
                        aria-label="Close"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('roles.store') }}" method="post">

                        @csrf

                        <div class="input-group mt-3">
                            <label for="name" class="input-group-text required">اسم الصلاحية:</label>
                            <input type="text" name="name" id="name" class="form-control" required
                                value="{{ old('name') }}">

                            <label for="url" class="input-group-text required"> رابط الصلاحية: </label>
                            <input type="text" name="url" id="url" class="form-control" required
                                value="{{ old('url') }}">

                        </div>

                        <div class="input-group mt-1">
                            <label for="display_name_ar" class="input-group-text required">الاسم الظاهر:</label>
                            <input type="text" name="display_name_ar" id="display_name_ar" class="form-control"
                                required value="{{ old('display_name_ar') }}" placeholder="الاسم العربى">
                            <input type="text" name="display_name_en" id="display_name_en" class="form-control"
                                required value="{{ old('display_name_en') }}" placeholder="الاسم اللاتينى">

                        </div>
                        <div class="input-group mt-1">
                            <label for="type" class="input-group-text required"> نوع الصلاحية: </label>
                            <select name="type" id="type" class="form-control text-right">>
                                <option hidden>النوع</option>

                                <option {{ old('type') == 'action' ? 'selected' : '' }} value="action">حدث</option>
                                <option {{ old('type') == 'view' ? 'selected' : '' }} value="view">عرض</option>
                            </select>
                            <label for="status" class="input-group-text required"> حالة التفعيل: </label>
                            <select name="status" id="status" class="form-control">
                                <option {{ old('status') == 1 ? 'selected' : '' }} value="1"> مفعلة </option>
                                <option {{ old('status') == 0 ? 'selected' : '' }} value="0"> معطلة </option>
                            </select>
                        </div>

                        <div class="input-group mt-1">

                            <label for="menu_id" class="input-group-text required"> المجموعة: </label>
                            <select name="menu_id" id="menu_id" class="form-control text-right">>
                                <option hidden>اختر المجموعة</option>
                                @foreach ($menues as $i => $menu)
                                    <option {{ old('menu_id') == $menu->id ? 'selected' : '' }}
                                        value="{{ $menu->id }}">
                                        {{ $menu->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="buttons justify-content-end">
                            <button class="btn btn-success" type="submit">تحديث بيانات الصلاحية
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- Assign Permission Modal -->
    <div class="modal fade" id="assignPermission" tabindex="-1" aria-labelledby="addNewRolePermissionHeading"
        aria-hidden="true">
        <div class="modal-dialog" style=" position: relative; top: 50px; left: 10vw; right: 10%; margin: 0;">
            <div class="modal-content" style="width: 80vw">
                <div class="modal-header mx-0 bg-secondary" style="background-color: #777; margin: auto">
                    <h1 class="modal-title fs-5" id="addNewRolePermissionHeading">تحديث صلاحيات الدور</h1>
                    <button type="button" class="button-close ml-1 my-1 p-1" data-bs-dismiss="modal"
                        aria-label="Close"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('roles.permissions.assign') }}" method="post">

                        @csrf
                        <div id="formContent"> </div>

                        <div class="buttons justify-content-end">
                            <button class="btn btn-success" type="submit">تحديث صلاحيات الدور
                            </button>
                            <button class="btn btn-success" type="button" data-bs-dismiss="modal" area-label="Close">
                                إلغاء </button>
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
        $('#role_status').change(() => {
            $('#statusText').html(() => {
                return $('#role_status').is(':checked') ? 'مفعلة' : 'معطلة';
            })
        })

        $(document).on('click', '.assign_permission_toggler', function() {
            const clickedEl = $(this)
            const __url = $('#roleAjaxFormData').attr('data-ajax-url')
            const __token = $('#roleAjaxFormData').attr('data-ajax-token')
            const __id = clickedEl.attr('data-role-id')

            $('#rolePermission').val(clickedEl.attr('data-role-id'))
            console.log(__id)
            jQuery.ajax({
                url: __url,
                type: 'post',
                dataType: 'html',
                data: {
                    id: __id,
                    '_token': __token,
                },
                cash: false,
                success: function(data) {
                    $('#formContent').html(data);
                },
                error: function() {

                }
            });
        })
    </script>
@endsection
