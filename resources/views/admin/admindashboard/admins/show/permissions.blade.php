@extends('layouts.admin')
@section('title')
    صلاحيات المستخدم
@endsection

@section('pageHeading')
    صلاحيات المستخدم
@endsection

@section('content')
    <style>

    </style>
    <div class="container pt-3" style="min-height: 100vh">

        <br>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link " id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a href="{{ route('admins.show', [0]) }}"> البيانات الأساسية </a>
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
                    <a href="{{ route('users.show', [$user->id, 4]) }}"> أيام العمل </a>
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="">
            <div class="tab-pane fade show active p-3" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab"
                tabindex="1">
                <fieldset dir="rtl" class="m-3">
                    <h4 style="right: 20px; left: auto"> صلاحيات المستخدم / الموظف </h4>
                    <form>
                        <fieldset>
                            <div class="input-group">
                                <label class="input-group-text" for=""> الفلترة على أساس: </label>
                                <select class="form-control" name="role" id="Role">
                                    <option value="*">الكــــل</option>
                                    @foreach ($roles as $r => $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="input-group-text" data-bs-toggle="modal"
                                    data-bs-target="#addNewRole"><i class="fa fa-plus"></i></button>
                            </div>
                        </fieldset>
                    </form>
                    @foreach ($user->roles as $item)
                        {{ $item->name }} <a class="btn btn-sm"
                            href="{{ route('delete.user.role', $item->id) }}">delete</a>
                        <br>
                    @endforeach
            </div>
            </fieldset>
        </div>

        {{-- Modals --}}

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
