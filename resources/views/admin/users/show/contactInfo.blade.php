@extends('layouts.admin')
@section('title')
    بيانات تسجيل الدخول
@endsection

@section('pageHeading')
    بيانات تسجيل الدخول
@endsection

@section('content')
    <style>

    </style>
    <div class="container pt-3" style="min-height: 100vh">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a href="{{ route('users.home') }}"> الموارد البشرية </a>
                </button>
                <button class="nav-link " id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a href="{{ route('users.show.basic.info', [$user->id]) }}"> البيانات الأساسية </a>
                </button>
                <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <a> بيانات تسجيل الدخول</a>
                </button>
                <button class="nav-link " id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <a href="{{ route('see.own.permissions', [0]) }}"> الصلاحيات </a>
                </button>
                <button class="nav-link " id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled"
                    type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">
                    <a href="{{ route('users.show', [$user->id, 4]) }}"> أيام العمل </a>
                </button>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent" style="">

            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                tabindex="0">
                <fieldset dir="rtl" class="m-3">
                    <h4 style="right: 20px; left: auto"> بيانات المستخدم / الموظف </h4>

                    @php
                        $theUserName = null != old('userName') ? old('userName') : $user->userName;
                        $theEmail = null != old('email') ? old('email') : $user->email;
                        $thePassword = null != old('password') ? old('password') : '';
                    @endphp

                    <fieldset class="m-3">
                        <form action="{{ route('users.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="input-group mt-3 px-3">
                                <label for="userName" class="input-group-text required">اسم المستخدم</label>
                                <input type="text" name="userName" id="userName" class="form-control" required
                                    value="{{ $user->userName }}">
                            </div>
                            <div class="input-group mt-1 px-3">
                                <label for="email" class="input-group-text required required">البريد
                                    الالكترونى</label>
                                <input type="text" name="email" id="email" class="form-control"
                                    value="{{ $user->email }}" required>
                            </div>

                            <br>
                            <div class="buttons p-0 mx-3 justify-content-end">
                                <button class="btn btn-success" type="submit" id="submitBtn">تحديث بياناتى</button>
                            </div>
                        </form>
                    </fieldset>

                    <h4>تغيير كلمة المرور</h4>
                    <fieldset class="m-3">
                        <form action="{{ route('users.change.password') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="input-group mt-3 px-3">
                                <label for="old_password" class="input-group-text required"> كلمة المرور القديمة</label>
                                <input type="password" name="old_password" id="old_password" class="form-control" required
                                    value="{{ old('old_password') }}"
                                    placeholder="يجب تقديم كلمة المرور القديمة لتتمكن من تغييرها">
                            </div>
                            <div class="input-group mt-1 px-3">
                                <label for="new_password" class="input-group-text required required"> كلمة المرور الجديدة
                                </label>
                                <input type="password" name="password" id="new_password" class="form-control"
                                    placeholder="اكتب كلمة مرور قوية" value="{{ old('password') }}" required>
                            </div>
                            <div class="input-group mt-1 px-3">
                                <label for="confirm_password" class="input-group-text required">تأكيد كلمة المرور</label>
                                <input type="password" name="confirm_password" id="confirm_password"
                                    value="{{ old('confirm_password') }}" class="form-control"
                                    placeholder="يرجى تأكيد كلمة المرور" required>
                            </div>
                            <br>
                            <div class="buttons p-0 mx-3 justify-content-end">
                                <button class="btn btn-success" type="submit" id="submitBtn">تغيير كلمة المرور</button>
                            </div>
                        </form>
                    </fieldset>

                </fieldset>
            </div>


        </div>






    </div>


    {{-- Modals --}}


    <!-- Modal -->
    <div class="modal fade" id="addNewRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header mx-0 bg-secondary" style="background-color: #777">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">إضافة أدوار</h1>
                    <button type="button" class="button-close ml-1 my-1 p-1" data-bs-dismiss="modal"
                        aria-label="Close"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('assign.role.to.user') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="input-group">
                            <label class="input-group-text" for="userRole">اختر الدور</label>
                            <select name="role_id" id="userRole" class="form-control">
                                @foreach ($user->roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
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
