@extends('layouts.admin')
@section('title')
    الأدوار
@endsection

@section('pageHeading')
    الأدوار فى التطبيق
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
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a> كل الأدوار </a>

                </button>
                <button class="nav-link " id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <a href="{{ route('roles.nonactive') }}"> أدوار غير مفعلة</a>
                </button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <a href="{{ route('roles.permissions', [$user->id]) }}"> صلاحيات الأدوار </a>
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
                    <h4> جميع الأدوار النشطة &nbsp; &nbsp;
                        <button type="button" class="btn btn-sm btn-primary py-1" style="border-radius: 0"
                            data-bs-toggle="modal" data-bs-target="#addNewRole"><i data-bs-toggle="tooltip"
                                title="إضافة دور جديد للتطبيق" class="fa fa-plus"></i></button>
                    </h4>


                    <div class="row bg-light p-3 m-3" style="box-shadow: 0 0 6px 2px #ccc inset">
                        @foreach ($roles as $num => $item)
                            <div class="col-lg-6 col-12 px-3 ">

                                <div class="row my-1 px-3 py-2" style="background-color: #3332">
                                    <div class="col col-1">{{ ++$num }}</div>
                                    <div class="col col-7" data-bs-toggle="tooltip" title="{{ $item->brief }}">
                                        {{ $item->display_name_ar }}</div>
                                    <div class="col col-4 text-left">
                                        <a class="btn btn-sm btn-outline-success px-1 py-0" data-bs-toggle="tooltip"
                                            title="عرض" href="{{ route('roles.view', $item->id) }}"><i
                                                class="fa fa-eye"></i></a>
                                        <a class="btn btn-sm btn-outline-primary px-1 py-0" data-bs-toggle="tooltip"
                                            title="تعديل" href="{{ route('roles.edit', $item->id) }}"><i
                                                class="fa fa-edit"></i></a>
                                        <a class="btn btn-sm btn-outline-info px-1 py-0" data-bs-toggle="tooltip"
                                            title="ايقاف" href="{{ route('roles.edit', $item->id) }}"><i
                                                class="fa fa-ban"></i></a>
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

    </div>


    {{-- Modals --}}


    <!-- Modal -->
    <div class="modal fade" id="addNewRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 800px">
                <div class="modal-header mx-0 bg-secondary" style="background-color: #777">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">إضافة أدوار</h1>
                    <button type="button" class="button-close ml-1 my-1 p-1" data-bs-dismiss="modal"
                        aria-label="Close"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('roles.store') }}" method="post">

                        @csrf

                        <fieldset style="box-shadow: none; border: 1px solid #777">
                            <legend>اسم الدور:</legend>
                            <div class="input-group mt-3">
                                <input type="text" name="name" id="name" class="form-control" required
                                    placeholder=" اسم الدور" value="{{ old('name') }}">

                                <input type="text" name="display_name_ar" id="display_name_ar" class="form-control"
                                    required placeholder="الاسم العربى" value="{{ old('display_name_ar') }}">

                                <input type="text" name="display_name_en" id="display_name_en" class="form-control"
                                    required placeholder="الاسم اللاتيني" value="{{ old('display_name_en') }}">
                            </div>
                        </fieldset>

                        <fieldset style="box-shadow: none; border: 1px solid #777; background: #ccc4">
                            <legend> الوصف:</legend>

                            <div class="form-floating mt-3">
                                <textarea style="height: 150px" class="form-control" name="brief" id="brief" placeholder="">{{ old('brief') }}</textarea>
                                <label for="brief">نبذة عن الدور:</label>
                            </div>

                            <div class="form-check form-switch form-check-reverse mt-3" dir="rtl">
                                <input class="form-check-input" type="checkbox" role="switch" name="status"
                                    id="role_status">
                                <label class="form-check-label" for="role_status"> الحالة: <span
                                        id="statusText">معطلة</span></label>
                            </div>
                        </fieldset>

                        <div class="buttons">

                            <button id="dismiss_btn" class="btn btn-info"
                                onclick="window.location='{{ route('roles.home') }}'" type="button"
                                id="submitBtn">إلغاء</button>
                            <button class="btn btn-success" type="submit" id="submitBtn">تحديث بيانات الدور</button>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
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
    </script>
@endsection
