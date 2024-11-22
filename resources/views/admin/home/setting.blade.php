@extends('layouts.admin')
@section('title')
    الضط العام
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    الظبط العام
@endsection
@section('homeLinkActive')
    الصفحة الرئيسية
@endsection
@section('links')
@endsection
@section('header_includes')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/setting.css') }}">
@endsection
@section('content')
    <div class="container text-right pt-3" dir="rtl">
        <style>

        </style>
        <fieldset>
            <legend>
                الفترات التخزينية &nbsp;&nbsp;&nbsp;
                <span class="form-toggle" data-target="addNewPeriod">
                    أضف
                </span>
            </legend>

            <div class="">
                <div class="row my-4">

                    @if (null != $storingPeriods && count($storingPeriods))
                        @foreach ($storingPeriods as $sp)
                            <div class=" col col-12 col-lg-6">
                                <div class="priod-item" style="border: 1px solid {{ $sp->status ? '#383' : '#ccc' }}">
                                    <span class="h5"> الفترة: {{ $sp->data->save_name }}</span>
                                    <span class="h5"> تبدأ من: {{ $sp->data->starts_in }}</span>
                                    <span class="h5"> تنتهي في: {{ $sp->data->ends_in }}</span>
                                    @if ($sp->status == 1)
                                        <span class="active-period">
                                            <i class="fas fa-calendar-check"></i>
                                        </span>
                                    @else
                                        <span class="set-active-period btn btn-outline-primary"
                                            onclick="window.location.href='{{ route('set.period.active', [$sp->id]) }}'">
                                            <i class="fas fa-calendar-check"></i>
                                            ضبط كفترة نشطة
                                        </span>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert outlne-info">
                            لا يوجد فترات تخزينية حتى الان...
                            <button class="form-toggle btn btn-outline-success btn-sm" data-target="addNewPeriod"> أضف أول
                                فترة تخزينية
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </fieldset>

    </div>

    <div id="forms">
        <div class="overlay-form" id="addNewPeriod">
            <form action="{{ route('add.storing.period') }}" method="POST" class="addNewPeriod">
                @csrf

                <div class="form-header">
                    <h5>إضافة فترة تخزينية على الثلاجة</h5>
                    <span data-close="addNewPeriod" class="close-btn close">&times;</span>
                </div>

                <div class="form-body">
                    <div class="input-group mb-3">
                        <label for="" class="input-group-text">اسم الفترة</label>
                        <input type="text" class="form-control" name="save_name">
                    </div>

                    <div class="input-group mb-3">
                        <label for="" class="input-group-text">تبدأ فى</label>
                        <input type="date" class="form-control" name="starts_in">
                    </div>

                    <div class="input-group mb-3">
                        <label for="" class="input-group-text">تنتهى فى</label>
                        <input type="date" class="form-control" name="ends_in">
                    </div>

                    <div class="form-check text-right py-3">
                        <input class="form-check-input" type="checkbox" value="true" id="current_period"
                            name="current_period">
                        <label class="form-check-label mx-4" for="current_period">
                            اجعلها الفترة الحالية
                        </label>
                    </div>
                </div>

                <div class="buttons">
                    <button type="button" data-close="addNewPeriod" class="close-btn btn btn-outline-info">
                        اغلاق النموذج
                    </button>

                    <button type="submit" class="btn btn-outline-primary">
                        إضافة الفترة
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection


@section('script')
    <script>
        const formTogglers = document.querySelectorAll('.form-toggle')
        const closeButtons = document.querySelectorAll('.close-btn')

        formTogglers.forEach((toggler) => {
            toggler.addEventListener('click', (evt) => {
                target = document.getElementById(evt.target.getAttribute('data-target'))
                target.style.display = 'block'
            })
        })

        closeButtons.forEach((btn) => {
            btn.addEventListener('click', (evt) => {
                target = document.getElementById(evt.target.getAttribute('data-close'))
                target.style.display = 'none'
            })
        })
    </script>
@endsection
