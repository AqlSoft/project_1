@extends('layouts.admin')
@section('title')
    العملاء
@endsection

@section('pageHeading')
    تعديل بيانات عميل
@endsection

@section('content')
    <div class="container pt-3">

        <fieldset dir="rtl" onload="initWork()">
            <legend class=""> تعديل بيانات عميل &nbsp; &nbsp;
                <button class="btn btn-sm btn-primary"><a href="{{ route('clients.view', $client->id) }}"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="عرض البيانات"><i
                            class="fa fa-eye text-light"></i></a></button>
            </legend>


            <form class="pt-3" id="regForm" action="{{ route('clients.update') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $client->id }}">
                <div class="input-group mb-3">
                    <label for="a_name" class="input-group-text required">اسم العميل / الشركة / المؤسسة</label>
                    <input type="text" class="form-control" name="a_name" required id="a_name"
                        value="{{ $client->a_name }}">

                    <input type="text" class="form-control" name="e_name" required id="e_name"
                        value="{{ $client->e_name }}" placeholder="الاسم اللاتينى">
                </div>
                @error('a_name')
                    <div class="btn btn-outline-danger btn-sm mb-3 float-right">{{ $message }}</div>
                @enderror
                @error('e_name')
                    <div class="btn btn-outline-danger btn-sm mb-3 float-right">{{ $message }}</div>
                @enderror
                <div class="input-group mb-3">
                    <label for="scope" class="input-group-text required">نوع العميل</label>
                    <select type="text" class="form-control" name="scope" required id="scope"
                        value="{{ old('scope') }}">
                        @if (count($scopes))
                            @foreach ($scopes as $si => $item)
                                <option {{ $client->scope == $si ? 'selected' : '' }} value="{{ $si }}">
                                    {{ $item }}</option>
                            @endforeach
                        @endif
                    </select>
                    <label for="s_number" class="input-group-text required">الرقم المسلسل</label>
                    <input type="text" class="form-control" name="s_number" required id="s_number"
                        value="{{ $client->s_number }}">
                </div>
                @error('s_number')
                    <div class="btn btn-outline-danger btn-sm mb-3 float-right">{{ $message }}</div>
                @enderror

                <div class="input-group mb-3">
                    <label for="website" class="input-group-text">الموقع الالكترونى</label>
                    <input type="url" class="form-control" name="website" id="website"
                        value="{{ $client->website }}">

                    <label for="email" class="input-group-text">البريد الالكترونى</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ $client->email }}">
                </div>

                <div class="input-group mb-3">
                    <label for="phone" class="input-group-text required">رقم الهاتف / الجوال</label>
                    <input type="phone" class="form-control" name="phone" id="phone" placeholder="966-5XXXXXXXX"
                        required value="{{ $client->phone }}">
                </div>
                @error('phone')
                    <div class="btn btn-outline-danger btn-sm mb-3 float-right">{{ $message }}</div>
                @enderror

                <div class="input-group mb-3">
                    <label for="cr" class="input-group-text">السجل التجارى</label>
                    <input type="number" class="form-control" name="cr" id="cr" placeholder="السجل التجارى"
                        value="{{ $client->cr }}">
                    <label for="vat" class="input-group-text">الرقم الضريبى</label>
                    <input type="number" class="form-control" name="vat" id="vat" placeholder="الرقم الضريبى"
                        value="{{ $client->vat }}">
                </div>
                {{ $location }}
                <div class="input-group mb-3">
                    <label for="country" class="input-group-text ">الدولة</label>
                    <select name="country" id="country" class="form-control">
                        <option hidden value="0">اختر الدولة </option>
                        @foreach ($countries as $i => $country)
                            <option
                                {{ ($client->country ? ($client->country == $country->id ? 'selected' : '') : $country->id == 401) ? 'selected' : '' }}
                                value="{{ $country->id }}">
                                {{ $country->a_name }}</option>
                        @endforeach
                    </select>
                    <label for="state" class="input-group-text">المنطقة</label>
                    <input type="text" class="form-control" name="state" id="state"
                        placeholder="المنطقة / القطاع" value="{{ $client->state }}">
                    <label for="city" class="input-group-text">المدينة</label>
                    <input type="text" class="form-control" name="city" id="city"
                        placeholder="اسم المدينة أو المحافظة" value="{{ $client->city }}">
                </div>
                <div class="input-group mb-3">
                    <label for="street" class="input-group-text">العنوان المفصل</label>
                    <input type="text" class="form-control" name="street" id="street"
                        placeholder="العنوان المفصل" value="{{ $client->street }}">
                </div>

                @error('cr')
                    <div class="btn btn-outline-danger btn-sm mb-3 float-right">{{ $message }}</div>
                @enderror
                @error('vat')
                    <div class="btn btn-outline-danger btn-sm mb-3 float-right">{{ $message }}</div>
                @enderror
                <!-- One "tab" for each step in the form: -->

                <div style="">
                    <br>
                    <button id="dismiss_btn" class="btn btn-outline-secondary"
                        onclick="window.location='{{ route('clients.home') }}'" type="button"
                        id="submitBtn">إلغاء</button>
                    <button class="btn btn-outline-primary" type="submit" id="submitBtn">تحديث البيانات</button>
                </div>
            </form>
        </fieldset>

        <fieldset>
            <legend>جهات الاتصال</legend>

            <table class="w-100 my-4">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>الاسم</td>
                        <td>المسؤولية</td>
                        <td>الهاتف</td>
                        <td>الاقامة</td>
                        <td>التحكم</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientContacts as $item)
                        <tr>
                            <td>1</td>
                            <td>{{ $item->person->name }}</td>
                            <td>{{ $roles[$item->role] }}</td>
                            <td>{{ $item->person->phone }}</td>
                            <td>{{ $item->person->iqama }}</td>

                            <td>1</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <form action="{{ route('clients.add.contact') }}" method="POST">

                @csrf
                <input type="hidden" name="client" value="{{ $client->id }}">
                <div class="input-group mb-3">

                    <label for="contact" class="input-group-text ">اختر جهة اتصال</label>

                    <button data-bs-toggle="tooltip" title="إضافة جهة اتصال جديدة" class="input-group-text"
                        type="button"><a href="{{ route('contacts.create') }}" style="font-weight: inherit"><i
                                class="fa fa-plus"></i></a></button>

                    <select name="contact" id="contact" class="form-control">
                        @foreach ($contacts as $i => $item)
                            <option {{ $client->person == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                                {{ $item->name }}</option>
                        @endforeach
                    </select>

                    <label for="role" class="input-group-text ">الدور</label>

                    <select name="role" id="role" class="form-control">
                        @foreach ($roles as $i => $item)
                            <option value="{{ $i }}">
                                {{ $item }}</option>
                        @endforeach
                    </select>

                    <button class="input-group-text" type="submit">إضافة</button>
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
