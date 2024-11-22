@extends('layouts.admin')
@section('title')
    عرض بيانات الدور
@endsection

@section('pageHeading')
    عرض بيانات الدور
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
                    <a href="{{ route('rules.home') }}"> كل الأدوار </a>

                </button>

                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                    <a> عرض الدور </a>

                </button>
                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a href="{{ route('permissions.home') }}"> الصلاحيات </a>

                </button>

                <button class="nav-link " id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <a href="{{ route('rules.setting', [$user->id]) }}"> الاعدادات </a>
                </button>
            </div>
        </nav>


        <div class="tab-content" id="nav-tabContent" style="">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                tabindex="0">
                <fieldset dir="rtl" class="m-3">
                    <h4>{{ $rule->display_name_ar }}</h4>
                    <div class="row bg-light p-3 m-3" style="box-shadow: 0 0 6px 2px #ccc inset">

                        <div class="col col-3 text-left">اسم الدور:</div>
                        <div class="col col-9">{{ $rule->display_name_ar }}</div>
                        <div class="col col-3 text-left">اسم الدور:</div>
                        <div class="col col-9">{{ $rule->display_name_en }}</div>
                        <div class="col col-3 text-left">الكــود:</div>
                        <div class="col col-9">{{ $rule->name }}</div>
                        <div class="col col-3 text-left">الحالة:</div>
                        <div class="col col-9">{{ $rule->status ? 'نشط' : 'غير نشط' }}</div>

                    </div>
                </fieldset>
                <fieldset dir="rtl" class="m-3">
                    <h4>الصلاحيات&nbsp; &nbsp;
                        <button type="button" class="btn btn-sm btn-primary py-1" style="border-radius: 0"
                            data-bs-toggle="modal" data-bs-target="#addPermission"><i data-bs-toggle="tooltip"
                                title="تعيين صلاحيات جديدة للدور" class="fa fa-plus"></i></button>
                    </h4>
                    <div class="row bg-light p-3 m-3" style="box-shadow: 0 0 6px 2px #ccc inset">

                        @foreach ($rule->permissions as $permission)
                            <div>{{ $permission->rule_id }} - {{ $permission->permission_id }}</div>
                        @endforeach

                    </div>
                </fieldset>
            </div>

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
