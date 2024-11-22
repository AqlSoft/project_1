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
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a> البيانات الأساسية </a>
                </button>
                <button class="nav-link " id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <a href="{{ route('see.own.login.info', [0]) }}"> بيانات تسجيل الدخول</a>
                </button>
                <button class="nav-link " id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <a href="{{ route('see.own.permissions', [0]) }}"> الصلاحيات </a>
                </button>
                <button class="nav-link " id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled"
                    type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">
                    <a href="{{ route('users.show', [$admin->id, 4]) }}"> أيام العمل </a>
                </button>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent" style="">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                tabindex="0">
                <fieldset dir="rtl" class="m-3">
                    <h4 style="right: 20px; left: auto"> تعديل بيانات المستخدم </h4>
                    <form class="m-3" action="{{ route('admins.profile.update') }}" method="post">
                        <fieldset dir="rtl" class="bg-light">
                            @csrf
                            <input type="hidden" name="id" value="{{ $admin->id }}">
                            <div class="input-group mt-3">
                                <label for="firstName" class="input-group-text required">الاسم الأول</label>
                                <input type="text" name="firstName" id="firstName" class="form-control" required
                                    value="{{ $admin->profile->firstName }}" />
                                <label for="lastName" class="input-group-text required">اسم العائلة</label>
                                <input type="text" name="lastName" id="lastName" class="form-control" required
                                    value="{{ $admin->profile->lastName }}" />
                                <label for="title" class="input-group-text"> اللقب </label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ $admin->profile->title }}" />
                            </div>

                            <div class="input-group mt-3">
                                <label for="gender" class="input-group-text">النوع</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option hidden>اختر الجنس</option>
                                    <option {{ $admin->profile->gender == 1 ? 'selected' : '' }} value="1">ذكر</option>
                                    <option {{ $admin->profile->gender == 0 ? 'selected' : '' }} value="0">أنثى
                                    </option>
                                </select>
                                <label for="dob" class="input-group-text required">تاريخ الميلاد</label>
                                <input type="date" name="dob" id="dob" class="form-control"
                                    placeholder="اسم المستخدم" required value="{{ $admin->profile->dob }}" />
                            </div>

                            <div class="input-group mt-3">
                                <label for="phone" class="input-group-text required">الهاتف</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    placeholder="اسم المستخدم" required value="{{ $admin->profile->phone }}" />
                                <label for="profession" class="input-group-text">Profession -
                                    {{ $admin->profession }}</label>
                                <select name="profession" id="profession" class="form-control">
                                    @foreach ($professions as $id => $p)
                                        <option {{ $admin->profession == $id ? 'selected' : '' }}
                                            value="{{ $id }}">{{ $p[1] }}</option>
                                    @endforeach
                                </select>
                                <label for="natId" class="input-group-text">رقم الهوية</label>
                                <input type="text" name="natId" id="natId" class="form-control"
                                    value="{{ $admin->profile->natId }}" />
                            </div>

                            <div style="display: flex; flex-direction: row-reverse">
                                <button class="btn btn-success" type="submit" id="submitBtn">تحديث بياناتى</button>
                            </div>
                        </fieldset>
                    </form>

                    <h4>الأدوار</h4>
                    <form class="m-3" action="{{ route('admins.add.roles') }}" method="post">
                        <fieldset>
                            @csrf
                            <input type="hidden" name="id" value="{{ $admin->id }}">
                            {{ $admin->roles }}
                            @if (count($roles) > 0)
                                <ul>
                                    @foreach ($roles as $role)
                                        <li class="form-check form-check-reverse">
                                            <input class="form-check-input" type="checkbox" name="roles[]"
                                                {{ $admin->hasRole($role->id) ? 'checked' : '' }}
                                                value="{{ $role->id }}" id="roles_{{ $role->id }}">
                                            <label class="form-check-label"
                                                for="roles_{{ $role->id }}">{{ $role->display_name_ar }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if ($admin->roles)
                                @if (count($admin->permissions) > 0)
                                    @foreach ($admin->permissions as $item)
                                        {{ print_r($item[0]) }}<br>
                                    @endforeach
                                @endif
                            @else
                                <div>No Permissions Found</div>
                            @endif
                            <div class="buttons">
                                <button class="btn btn-primary" type="submit">تحديث الأدوار</button>
                            </div>
                        </fieldset>
                    </form>
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
                    <form action="{{ route('users.add.roles') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $admin->id }}">
                        <div class="input-group">
                            <label class="input-group-text" for="userRole">اختر الدور</label>
                            <select name="role_id" id="userRole" class="form-control">
                                @foreach ($admin->roles as $role)
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
