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
            background-color: #e9f5e9;
        }

        input.form-control,
        select.form-control,
        form textarea.form-control {
            background-color: #ccc3;
        }

        .form-section h4 {
            color: #0051ff;
            font-size: 1rem;
            padding-bottom: 0;
            margin-bottom: 0;
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
                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a href="{{ route('rules.home') }}"> كل الأدوار </a>

                </button>
                <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <a> تعديل بيانات دور</a>
                </button>
                <button class="nav-link " id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <a href="{{ route('users.show.user.permissions', [$user->id]) }}"> الاعدادات </a>
                </button>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent" style="">
            <fieldset class="m-3">

                <form action="{{ route('rules.update') }}" method="post">

                    @csrf
                    <input type="hidden" name="id" required value="{{ $rule->id }}">
                    <div class="form-section row bg-light p-3 mx-3 my-2" style="box-shadow: 0 0 6px 2px #ccc inset">
                        <h4>اسم الدور:</h4>
                        <div class="input-group my-3">
                            <input type="text" name="name" id="name" class="form-control" required
                                placeholder="الاسم العربى" value="{{ $rule->name }}">

                            <input type="text" name="display_name_ar" id="display_name_ar" class="form-control" required
                                placeholder="الاسم العربى" value="{{ $rule->display_name_ar }}">

                            <input type="text" name="display_name_en" id="display_name_en" class="form-control" required
                                placeholder="الاسم اللاتيني" value="{{ $rule->display_name_en }}">
                        </div>
                    </div>

                    <div class="form-section row bg-light p-3 mx-3 mt-4" style="box-shadow: 0 0 6px 2px #ccc inset">
                        <h4> الوصف:</h4>
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
                    </div>

                    <div class="buttons pb-0" style="justify-content: flex-end">

                        <button id="dismiss_btn" class="btn btn-outline-info"
                            onclick="window.location='{{ route('rules.home') }}'" type="button"
                            id="submitBtn">إلغاء</button>
                        <button class="btn btn-outline-success" type="submit" id="submitBtn">تحديث بيانات الدور</button>
                    </div>

                </form>
            </fieldset>
            <fieldset class="m-3">
                ( <span style="color: red">*</span> ) تشير إلى حقول مطلوبة.

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
