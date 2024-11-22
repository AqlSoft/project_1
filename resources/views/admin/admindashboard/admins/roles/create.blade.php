@extends('layouts.admin')
@section('title')
    الإعدادات العامة
@endsection
@section('pageHeading')
    الأدوار
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
    </style>
    <div class="container" style="min-height: 100vh">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a> كل الأدوار </a>

                </button>
                <button class="nav-link " id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <a href="{{ route('users.show.contact.info', [$user->id]) }}"> أدوار غير مفعلة</a>
                </button>
                <button class="nav-link " id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <a href="{{ route('users.show.user.permissions', [$user->id]) }}"> الاعدادات </a>
                </button>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent" style="">
            <fieldset>
                <legend>اضافة دور جديد</legend>

                <form action="{{ route('rules.update') }}" method="post">

                    @csrf
                    <input type="hidden" name="id" required value="{{ $rule->id }}">
                    <fieldset style="box-shadow: none; border: 1px solid #777">
                        <legend>اسم الدور:</legend>
                        <div class="input-group mt-3">
                            <input type="text" name="name" id="name" class="form-control" required
                                placeholder=" اسم الدور" value="{{ old('name') }}">

                            <input type="text" name="display_name_ar" id="display_name_ar" class="form-control" required
                                placeholder="الاسم العربى" value="{{ old('display_name_ar') }}">

                            <input type="text" name="display_name_en" id="display_name_en" class="form-control" required
                                placeholder="الاسم اللاتيني" value="{{ old('display_name_en') }}">
                        </div>
                    </fieldset>

                    <fieldset style="box-shadow: none; border: 1px solid #777; background: #ccc4">
                        <legend> الوصف:</legend>

                        <div class="form-floating mt-3">
                            <textarea style="height: 150px" class="form-control" name="brief" id="brief" placeholder="">{{ $rule->brief }}</textarea>
                            <label for="brief">نبذة عن الدور:</label>
                        </div>

                        <div class="form-check form-switch form-check-reverse mt-3" dir="rtl">
                            <input class="form-check-input" type="checkbox" role="switch" name="status" id="rule_status"
                                {{ $rule->status ? 'checked' : '' }}>
                            <label class="form-check-label" for="rule_status"> الحالة: <span
                                    id="statusText">{{ $rule->status ? 'مفعلة' : 'معطلة' }}</span></label>
                        </div>
                    </fieldset>

                    <div class="buttons text-left">

                        <button id="dismiss_btn" class="btn btn-info" onclick="window.location='{{ route('rules.home') }}'"
                            type="button" id="submitBtn">إلغاء</button>
                        <button class="btn btn-success" type="submit" id="submitBtn">تحديث بيانات الدور</button>
                    </div>

                </form>
                <div class="alert alert-sm px-3 py-1 alert-secondary float-right d-inline-block text-info mt-3 text-right">(
                    <span style="color: red">*</span> ) تشير إلى حقول مطلوبة.
                </div>
            </fieldset>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $('#rule_status').change(() => {
            $('#statusText').html(() => {
                return $('#rule_status').is(':checked') ? 'مفعلة' : 'معطلة';
            })
        })
    </script>
@endsection
