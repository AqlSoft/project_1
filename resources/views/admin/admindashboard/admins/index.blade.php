@extends('layouts.admin')
@section('title')
    المديرين
@endsection
@section('homeLink')
    المديرين
@endsection


@section('content')

    <div class="container" style="min-height: 100vh">
        <fieldset>
            <legend>قائمة المستخدمين</legend>
            <table dir="rtl" class="striped mt-4" style="width: 100%">
                <thead>
                    <tr class="text-center">
                        <th>مسلسل</th>
                        <th>الاسم</th>
                        <th>البريد</th>
                        <th>مسجل منذ</th>
                        <th>الوظيفة</th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($users))
                        @php $i=0 @endphp @foreach ($users as $ui => $user)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $user->profile->firstName }} {{ $user->profile->lastName }} [
                                    {{ $user->profile->title }} ] </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->profile->profession }}{{-- $professions[$user->profile->profession][1] --}}</td>
                                <td>
                                    <a href="{{ route('users.show.basic.info', [$user->id]) }}"><i class="fa fa-eye"
                                            data-bs-toggle="tooltip" data-bs-title="عرض بيانات العميل"></i></a>
                                    <a href="{{ route('admins.delete', $user->id) }}" data-bs-toggle="tooltip"
                                        data-bs-title="حذف العميل"
                                        onclick="return confirm('هل تريد حذف هذا العميل بالفعل؟، هذه الحركة لا يمكن الرجوع عنها.')"><i
                                            class="fa fa-trash" title="حذف العميل"></i></a>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">لم يتم بعد تسجيل عملاء حتى الان <a href="{{ route('user.create') }}">أدخل
                                    عميلك الأول!</a></td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{ $users->links() }}
        </fieldset>

        {{-- Modals --}}


        <!-- Modal -->


    </div>
@endsection


@section('script')
@endsection
