@extends('layouts.admin')
@section('title')
    مديرى التطبيق
@endsection
@section('pageHeading')
    مديرى التطبيق
@endsection
@section('content')

    <div class="container" style="min-height: 100vh">
        <fieldset>
            <legend class="">
                قائمة المديرين &nbsp; &nbsp;
                
                    <a href="{{ route('create-new-admin') }}"><i class="fa fa-plus"></i></a>
                
            </legend>
            <table id="AdminsTable" class="table mt-4">
                <thead>
                    <tr class="bg-secondary">
                        <th class="bg-secondary">#</th>
                        <th>الاسم واسم المستخدم</th>
                        <th>البريد الالكترونى</th>
                        <th>تاريخ الانضمام</th>
                        <th>الوظيفة</th>
                        <th><i class="fa fa-cogs"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($users))
                        @php $i=0 @endphp
                        @foreach ($users as $ui => $user)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $user->profile ? $user->profile->first_name . ' ' . $user->profile->last_name : explode('@', $user->email)[0] }}
                                    [ {{ $user->userName }} ] </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>@php $c=0 @endphp
                                    @foreach ($user->roles as $role)
                                        <span data-bs-toggle="tooltip" data-bs-title="{{ $role->display_name }}"><a
                                                href="{{ route('edit-role-info', [$role->id]) }}"
                                                class="btn btn-outline-secondary py-0 px-2 m-1">{{ ++$c }}</a></span>
                                    @endforeach
                                </td>

                                <td>
                                    <a href="{{ route('display-admin', [$user->id]) }}"><i class="fa fa-eye"
                                            title="Display Admins info"></i></a>
                                    <a href="{{ route('edit-admin-info', $user->id) }}"><i class="fa fa-edit"
                                            title="Edit admin info"></i></a>

                                    <a href="{{ route('destroy-admin', $user->id) }}"
                                        onclick="return confirm('This action is one way, you will not able to undo this, are you sure.?')"><i
                                            class="fa fa-trash" title="Delete Admin"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">لم يتم بعد تسجيل مديرين حتى الان، بادر بـ  <a href="{{ route('user.create') }}">أدخل
                                إضافة أول مدير</a> للتطبيق</td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </fieldset>

    </div>
@endsection


@section('script')
@endsection
