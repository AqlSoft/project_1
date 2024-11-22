@extends('layouts.admin')
@section('title')
    صلاحيات المستخدمين
@endsection

@section('pageHeading')
    صلاحيات المستخدمين
@endsection
@section('content')
    <style>
        fieldset {
            background-color: rgb(233, 245, 233);
        }

        input.form-control,
        select.form-control,
        form textarea.form-control {
            background-color: #ccc3;
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


        .permissions .permission .controls a,
        .permissions .permission .controls i.fa {
            display: block;
            line-height: 1;
            padding: 0;
        }

        .permissions .permission .controls>div {
            height: 50%;
            padding: 4px 1px;
        }

        .permissions .permission .col:first-child {
            font-size: 1.5rem;
            line-height: 3rem;
            text-align: center;
            font-weight: bolder;
            background-color: #222;
            color: #ddd
        }

        .permissions .permission .col {
            overflow: hidden;
            padding: 0;
            border-top: 1px solid #777;
            border-bottom: 1px solid #777
        }

        .permissions .permission .col:last-child {
            text-align: center;
        }
    </style>
    <div class="container" style="min-height: 100vh">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a href="{{ route('users.home') }}"> الموظفين </a>
                </button>
                <button class="nav-link " id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a href="{{ route('users.show', [0]) }}"> البيانات الأساسية </a>
                </button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <a href="{{ route('see.own.login.info', [0]) }}"> بيانات تسجيل الدخول</a>
                </button>
                <button class="nav-link active" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <a> الصلاحيات </a>
                </button>
                <button class="nav-link " id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled"
                    type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">
                    <a href="{{ route('see.user.diaries', [$user->id]) }}"> أيام العمل </a>
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                tabindex="0">

                <fieldset class="m-3">
                    <h4>جميع الصلاحيات &nbsp; &nbsp;
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#addNewPermission">
                            <div data-bs-toggle="tooltip" title="إضافة صلاحيات جديدة"><i class="fa fa-plus"></i></div>
                        </button>
                    </h4>
                    <form>
                        <fieldset style="background-color: #fff">
                            @if (count($menues))
                                <div class="accordion" id="Permissions">
                                    @foreach ($menues as $item)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header ">
                                                <button class="accordion-button bg-secondary" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse_{{ $item->id }}"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                    {{ $item->display_name_ar }}
                                                </button>
                                            </h2>

                                            <div id="collapse_{{ $item->id }}" class="accordion-collapse collapse"
                                                data-bs-parent="#Permissions">
                                                <div class="accordion-body">
                                                    <div class="permissions row">
                                                        @if (count($item->permissions) > 0)
                                                            @php
                                                                $c = 0;
                                                            @endphp
                                                            @foreach ($item->permissions as $permit)
                                                                <div class="col col-lg-6 col-md-12">
                                                                    <div class="permission row mb-2 border mx-1">
                                                                        <div class="number col col-1">{{ ++$c }}
                                                                        </div>
                                                                        <div class="col col-8 py-2 px-3">
                                                                            {{ $permit->display_name_ar }} <br>
                                                                            {{ $permit->display_name_en }}
                                                                        </div>
                                                                        <div class="col col-2">
                                                                            <div
                                                                                style="text-align: center; height: 50%;background-color:{{ $permit->status == 1 ? '#393' : '#933' }}; color: #fff">
                                                                                {{ $permit->status == 1 ? 'مفعلة' : 'موقوفة' }}
                                                                            </div>
                                                                            <div
                                                                                style="text-align: center; height: 50%;background-color:{{ $permit->type == 'view' ? '#339' : '#369' }}; color: #fff">
                                                                                {{ $permit->type == 'view' ? 'عرض' : 'حدث' }}
                                                                            </div>
                                                                        </div>

                                                                        <div class="controls col col-1">
                                                                            <div class="bg-primary"><a
                                                                                    href="{{ route('permissions.edit', [$permit->id]) }}"><i
                                                                                        class="fa fa-edit"></i></a></div>
                                                                            <div class="bg-danger"><a
                                                                                    href="{{ route('permissions.destroy', [$permit->id]) }}">
                                                                                    <i class="fa fa-trash"></i></a>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div>No Permissions found in this group</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="col col-12">No permissions found yet</div>
                            @endif
                        </fieldset>
                    </form>
                </fieldset>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="addNewPermission" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width: 800px">
                    <div class="modal-header mx-0 bg-secondary" style="background-color: #777">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">إضافة صلاحيات جديدة</h1>
                        <button type="button" class="button-close ml-1 my-1 p-1" data-bs-dismiss="modal"
                            aria-label="Close"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('permissions.store') }}" method="post">

                            @csrf

                            <div class="input-group mt-3">
                                <label for="name" class="input-group-text required">اسم الصلاحية:</label>
                                <input type="text" name="name" id="name" class="form-control" required
                                    value="{{ old('name') }}">

                                <label for="url" class="input-group-text required"> رابط الصلاحية: </label>
                                <input type="text" name="url" id="url" class="form-control" required
                                    value="{{ old('url') }}">

                            </div>

                            <div class="input-group mt-3">
                                <label for="display_name_ar" class="input-group-text required">الاسم الظاهر:</label>
                                <input type="text" name="display_name_ar" id="display_name_ar" class="form-control"
                                    required value="{{ old('display_name_ar') }}" placeholder="الاسم العربى">
                                <input type="text" name="display_name_en" id="display_name_en" class="form-control"
                                    required value="{{ old('display_name_en') }}" placeholder="الاسم اللاتينى">

                            </div>
                            <div class="input-group mt-3">
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

                            <div class="input-group mt-3">

                                <label for="menu_id" class="input-group-text required"> المجموعة: </label>
                                <select name="menu_id" id="menu_id" class="form-control text-right">>
                                    <option hidden>اختر المجموعة</option>
                                    @foreach ($menues as $i => $menu)
                                        <option {{ old('menu_id') == $menu->id ? 'selected' : '' }}
                                            value="{{ $menu->id }}">
                                            {{ $menu->name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-success input-group-text" type="submit">تسجيل صلاحية
                                    جديدة</button>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
    @endsection
