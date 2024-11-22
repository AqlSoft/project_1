@extends('layouts.admin')

@section('title')
    الأقسام
@endsection

@section('pageHeading')
    انشاء قسم جديد
@endsection
@section('content')
    <div class="container pt-3">
        <style>
            section#sections button {
                font-size: 90px;
                font-weight: bold;
            }
        </style>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link">
                    <a href="{{ route('stores.home') }}">التخزين</a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('sections.home') }}">
                        الأقسام
                    </a>
                </button>
                <button class="nav-link active">
                    <a>انشاء قسم جديد</a>
                </button>

            </div>
        </nav>
        <div class="tab-content p-3" id="nav-tabContent" style="background-color: #fff">
            <fieldset>
                <legend>إضافة قسم جديد</legend>
                <form action="{{ route('sections.store') }}" method="POST">
                    @csrf
                    <div class="input-group mt-4 ">
                        <label for="a_name" class="input-group-text">الاسم بالعربى:</label>
                        <input type="text" name="a_name" id="a_name" class="form-control" value="{{ old('a_name') }}"
                            required>
                        <label for="e_name" class="input-group-text">الاسم باللغة الأخرى:</label>
                        <input type="text" name="e_name" id="e_name" class="form-control" value="{{ old('e_name') }}"
                            required>
                    </div>
                    <div class="input-group my-2">
                        <label for="keeper" class="input-group-text">أمين المخزن</label>
                        <select name="keeper" id="keeper" class="form-control" value="{{ old('keeper') }}" required>
                            <option hidden></option>
                            @foreach ($keepers as $keeper)
                                <option value="{{ $keeper->id }}">{{ $keeper->userName }}</option>
                            @endforeach
                        </select>
                        <label for="staus" class="input-group-text">الحالة</label>
                        <select name="status" id="status" class="form-control" value="{{ old('status') }}" required>
                            <option hidden></option>
                            <option value="1">مفعل</option>
                            <option value="0">معطل</option>
                        </select>
                    </div>
                    <div class="input-group my-2">
                        <label for="branch" class="input-group-text">المكان / الفرع:</label>
                        <select name="branch" id="branch" class="form-control" value="{{ old('branch') }}" required>
                            <option hidden></option>
                            <option value="1">القصيم - البصر - طريق الملك فهد</option>
                        </select>
                        <label for="code" class="input-group-text">الرمز</label>
                        <input type="text" name="code" id="code" class="form-control"
                            value="{{ old('code') }}" required>
                        <button type="submit" class="input-group-text">إضافة</button>
                    </div>
                </form>
            </fieldset>

        </div>

    </div>
@endsection

@section('script')
    <script></script>
@endsection
