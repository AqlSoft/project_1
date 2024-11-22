@extends('layouts.admin')
@section('title')
    العملاء
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    العملاء
@endsection
@section('homeLinkActive')
    إضافة عميل جديد
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('clients.home') }}"><span class="btn-title">Go Home</span><i
                class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.setting') }}"><span class="btn-title">Settings</span><i
                class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')
    <div class="container pt-3">

        <fieldset dir="rtl" onload="initWork()">
            <legend class="">إضافة عميل جديد</legend>
            <form class="pt-3" id="regForm" action="{{ route('clients.store') }}" method="post">
                @csrf

                <div class="input-group mb-3">
                    <label for="name" class="input-group-text required">اسم العميل / الشركة / المؤسسة</label>
                    <input type="text" class="form-control" name="name" required id="name"
                        value="{{ old('name') }}">
                </div>
                <div class="input-group mb-3">
                    <label for="scope" class="input-group-text required">نوع العميل</label>
                    <select type="text" class="form-control" name="scope" required id="scope"
                        value="{{ old('scope') }}">
                        @if (count($scopes))
                            @foreach ($scopes as $si => $item)
                                <option value="{{ $si }}">{{ $item }}</option>
                            @endforeach
                        @endif
                    </select>
                    <label for="s_number" class="input-group-text required">الرقم المسلسل</label>
                    <input type="text" class="form-control" name="s_number" required id="s_number"
                        value="{{ null != old('s_number') ? old('s_number') : $lastClient }}">
                </div>

                <div class="input-group mb-3">
                    <label for="website" class="input-group-text">الموقع الالكترونى</label>
                    <input type="url" class="form-control" name="website" id="website" value="{{ old('website') }}">

                    <label for="email" class="input-group-text">البريد الالكترونى</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                </div>

                <div class="input-group mb-3">
                    <label for="phone" class="input-group-text required">رقم الهاتف / الجوال</label>
                    <input type="phone" class="form-control" name="phone" id="phone" placeholder="966-5XXXXXXXX"
                        required value="{{ old('phone') }}">
                </div>

                <div class="input-group mb-3">
                    <label for="cr" class="input-group-text required">السجل التجارى</label>
                    <input type="number" class="form-control" name="cr" id="cr" placeholder="السجل التجارى"
                        required value="{{ old('cr') }}">
                    <label for="vat" class="input-group-text required">الرقم الضريبى</label>
                    <input type="number" class="form-control" name="vat" id="vat" placeholder="الرقم الضريبى"
                        required value="{{ old('vat') }}">
                </div>
                <!-- One "tab" for each step in the form: -->

                <div style="">
                    <br>
                    <button id="dismiss_btn" class="btn btn-success" onclick="window.location=ط{{ route('clients.home') }}"
                        type="submit" id="submitBtn">إلغاء</button>
                    <button class="btn btn-secondary" type="submit" id="submitBtn">إدراج</button>
                </div>
            </form>
        </fieldset>
    </div>
@endsection


@section('script')
    <script>
        $('.accordion-button i').click(function() {
            $(this).toggleClass('fa-folder-open fa-folder')
        })

        $('#Type').change(function() {
            if ($(this).val() == 1) {

            } else if ($(this).val() == 1) {

            }
        });
    </script>
@endsection
