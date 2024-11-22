@extends('layouts.admin')
@section('title')
    الإعدادات العامة
@endsection
@section('homeLink')
    المستخدمين
@endsection
@section('homeLinkActive')
    بيانات المستخدم
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('users.home') }}">
            <span class="btn-title">العودة إلى الرئيسية</span>
            <i class="fa fa-home text-light"></i></a>
    </button>
@endsection
@section('content')
    <style>

    </style>
    <div class="container pt-3" style="min-height: 100vh">
        <fieldset dir="rtl" class="">
            <legend style="right: 20px; left: auto"> تعديل بيانات مستخدم </legend>
            <br>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                    <button class="nav-link {{ $tab == 1 ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                        aria-selected="true">
                        <a href="{{ route('admins.show', [$user->id, 1]) }}"> البيانات الأساسية </a>
                    </button>
                    <button class="nav-link {{ $tab == 2 ? 'active' : '' }}" id="nav-profile-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                        aria-selected="false">
                        <a href="{{ route('admins.show', [$user->id, 2]) }}"> بيانات تسجيل الدخول</a>
                    </button>
                    <button class="nav-link {{ $tab == 3 ? 'active' : '' }}" id="nav-contact-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                        aria-selected="false">
                        <a href="{{ route('admins.show', [$user->id, 3]) }}"> الصلاحيات </a>
                    </button>
                    <button class="nav-link {{ $tab == 4 ? 'active' : '' }}" id="nav-disabled-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-disabled" type="button" role="tab" aria-controls="nav-disabled"
                        aria-selected="false">
                        <a href="{{ route('admins.show', [$user->id, 4]) }}"> أيام العمل </a>
                    </button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent" style="">
                @if ($tab == 1)
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                        tabindex="0">

                        <form class="mx-4" action="{{ route('admins.profile.update') }}" method="post">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            @csrf
                            <div class="input-group mt-3">
                                <label for="firstName" class="input-group-text required">الاسم الأول</label>
                                <input type="text" name="firstName" id="firstName" class="form-control" required
                                    value="{{ $profile->firstName }}">
                                <label for="lastName" class="input-group-text required">اسم العائلة</label>
                                <input type="text" name="lastName" id="lastName" class="form-control" required
                                    value="{{ $profile->lastName }}">
                                <label for="title" class="input-group-text"> اللقب </label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ $profile->title }}">
                            </div>
                            <div class="input-group mt-3">

                                <label for="profession" class="input-group-text required">الوظيفة</label>
                                <select name="profession" id="profession" class="form-control" required
                                    value="{{ $profile->profession }}">

                                    <option hidden>حدد الوظيفة</option>

                                    @foreach ($professions as $p => $profession)
                                        <option {{ $profile->profession == $p ? 'selected' : '' }}
                                            value="{{ $p }}">{{ $profession[1] }}</option>
                                    @endforeach

                                </select>
                                <label for="gender" class="input-group-text">النوع</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option hidden>اختر الجنس</option>
                                    <option {{ $profile->gender == 1 ? 'selected' : '' }} value="1">ذكر</option>
                                    <option {{ $profile->gender == 0 ? 'selected' : '' }} value="0">أنثى</option>
                                </select>
                                <label for="dob" class="input-group-text required">تاريخ الميلاد</label>
                                <input type="date" name="dob" id="dob" class="form-control" required
                                    value="{{ $profile->dob }}">
                            </div>

                            <div class="input-group mt-3">
                                <label for="phone" class="input-group-text">رقم الهاتف</label>
                                <input type="text" name="phone" id="dob" class="form-control"
                                    value="{{ $profile->phone }}">
                                <label for="natId" class="input-group-text required">رقم الهوية</label>
                                <input type="text" name="natId" id="natId" class="form-control" required
                                    value="{{ $profile->natId }}">
                            </div>

                            <br>
                            <div style="display: flex; flex-direction: row-reverse">
                                <button class="btn btn-success" type="submit" id="submitBtn">تحديث بياناتى</button>
                            </div>

                        </form>


                    </div>
                @elseif ($tab == 2)
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel"
                        aria-labelledby="nav-profile-tab" tabindex="1" style="position: relative">
                        <form action="{{ route('admins.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="input-group mt-3">
                                <label for="userName" class="input-group-text required">اسم المستخدم</label>
                                <input type="text" name="userName" id="userName" class="form-control" required
                                    value="{{ $user->userName }}">
                                <label for="email" class="input-group-text required required">البريد الالكترونى</label>
                                <input type="text" name="email" id="email" class="form-control"
                                    value="{{ $user->email }}" required>
                                <label for="password" class="input-group-text required">كلمة المرور</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="اتركها فارغة اذا كنت لا تريد التغيير">
                            </div>
                            <br>
                            <div style="display: flex; flex-direction: row-reverse">
                                <button class="btn btn-success" type="submit" id="submitBtn">تحديث بياناتى</button>
                            </div>
                        </form>

                    </div>
                @elseif ($tab == 3)
                    <div class="tab-pane fade show active p-3" id="nav-contact" role="tabpanel"
                        aria-labelledby="nav-contact-tab" tabindex="1">

                        <form action="">

                            <div class="input-group">
                                <label class="input-group-text" for=""> الفلترة على أساس: </label>
                                <select class="form-control" name="rule" id="Rule">
                                    <option value="*">الكــــل</option>
                                    @foreach ($userRules as $r => $rule)
                                        <option value="{{ $rule->id }}">{{ $rule->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="input-group-text" data-bs-toggle="modal"
                                    data-bs-target="#addNewRule"><i class="fa fa-plus"></i></button>
                            </div>


                            صلاحيات المستخدم
                        </form>


                    </div>
                @elseif ($tab == 4)
                    <div class="tab-pane fade show active" id="nav-contact" role="tabpanel"
                        aria-labelledby="nav-contact-tab" tabindex="1">

                    </div>
                @endif

            </div>


        </fieldset>




    </div>


    {{-- Modals --}}


    <!-- Modal -->
    <div class="modal fade" id="addNewRule" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header mx-0 bg-secondary" style="background-color: #777">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">إضافة أدوار</h1>
                    <button type="button" class="button-close ml-1 my-1 p-1" data-bs-dismiss="modal"
                        aria-label="Close"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.add.rules') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="input-group">
                            <label class="input-group-text" for="userRule">اختر الدور</label>
                            <select name="rule_id" id="userRule" class="form-control">
                                @foreach ($rules as $rule)
                                    <option value="{{ $rule->id }}">{{ $rule->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="input-group-text" value=""><i
                                    class="fas fa-play flipped-horisontal"></i></button>
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
@endsection
