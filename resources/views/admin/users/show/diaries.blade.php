@extends('layouts.admin')
@section('title')
    مستخدم
@endsection

@section('pageHeading')
    بيانات المستخدم
@endsection

@section('content')
    <div class="container pt-3" style="min-height: 100vh">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a href="{{ route('users.home') }}"> الموظفين </a>
                </button>
                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a href="{{ route('users.show.basic.info', [$user->id]) }}"> البيانات الأساسية </a>
                </button>
                <button class="nav-link " id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <a href="{{ route('see.own.login.info', [0]) }}"> بيانات تسجيل الدخول </a>
                </button>
                <button class="nav-link " id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <a href="{{ route('see.own.permissions', [0]) }}"> الصلاحيات </a>
                </button>
                <button class="nav-link active" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled"
                    type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">
                    <a> أيام العمل </a>
                </button>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent" style="">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                tabindex="0">
                <fieldset dir="rtl" class="m-3">
                    <h4 style="right: 20px; left: auto"> تعديل بيانات المستخدم </h4>
                    <fieldset dir="rtl" class="bg-light">

                    </fieldset>
                    <h4>الأدوار &nbsp; &nbsp;
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addNewRole">
                            <div data-bs-toggle="tooltip" title="إضافة أدوار جديدة"><i class="fa fa-plus"></i></div>
                        </button>
                    </h4>
                    <fieldset>


                    </fieldset>
                </fieldset>
            </div>
        </div>
    </div>




    </div>
@endsection


@section('script')
@endsection
