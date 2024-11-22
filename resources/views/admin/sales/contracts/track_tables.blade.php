@extends('layouts.admin')
@section('title')
    العقود
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    العقود
@endsection
@section('homeLinkActive')
    عرض تفاصيل العقد
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('contracts.home') }}"><i data-bs-title="العودة للعقود"
                data-bs-toggle="tooltip" class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('contract.print', [$contract->id]) }}"><i
                class="fa fa-print fa-fw" data-bs-title="طباعة العقد" data-bs-toggle="tooltip"></i></a></button>
    @if ($contract->status)
        <button type="submit" class="btn btn-sm btn-primary">
            <form id="park" style="display: inline-block" action="{{ route('contract.park') }}" method="post"> @csrf
                <input type="hidden" name="id" value="{{ $contract->id }}">

                <i data-bs-title="ايقاف العقد" data-bs-toggle="tooltip" class="fa fa-box-open text-light"
                    onclick="$('#park').submit()"></i>
            </form>
        </button>
    @else
        <button type="submit" class="btn btn-sm btn-primary">
            <form id="approve" style="display: inline-block" action="{{ route('contract.approve') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $contract->id }}">

                <i data-bs-title="اعتماد العقد" data-bs-toggle="tooltip" class="fa fa-check text-light"
                    onclick="$('#approve').submit()"></i>
            </form>
        </button>
    @endif
    <button class="btn btn-sm btn-primary"><a href="{{ route('contracts.setting') }}"><i class="fa fa-cogs text-light"
                data-bs-title="اعدادات العقد" data-bs-toggle="tooltip"></i></a></button>
@endsection
@section('content')
    <style>
        .quick-nav {
            display: flex;
            flex-direction: row-reverse
        }

        .quick-nav span {
            border: 1px solid #ccc;
            border-left: 0;
            border-radius: 1em
        }

        .quick-nav span:first-child {
            border: 1px solid #ccc;

        }

        .quick-nav span:hover {
            background-color: #777;
            color: #fff;
        }
    </style>
    <div class="container pt-4">
        <div class="border p-3">

            <div class="quick-nav input-group py-2 w-100">

                <span class="text-center btn form-control">
                    <a class="d-inline-block py-1 fs-6" href="{{ route('contracts.track.tables', [$contract->id]) }}">
                        &nbsp;
                        أرصدة الطبليات &nbsp;
                    </a>
                </span>

                <span class="text-center btn form-control">
                    <a class="d-inline-block py-1 fs-6" href="{{ route('contract.view', [$contract->id, 6]) }}"> &nbsp;
                        تقارير الطبليات 2 &nbsp;
                    </a>
                </span>

                <span class="text-center btn form-control">
                    <a class="d-inline-block py-1 fs-6" href="{{ route('contract.view', [$contract->id, 4]) }}"> &nbsp;
                        تقارير الطبليات &nbsp;
                    </a>
                </span>
                <span class="text-center btn form-control">
                    <a class="d-inline-block py-1 fs-6" href="{{ route('contract.view', [$contract->id, 3]) }}"> &nbsp;
                        تقارير الأصناف &nbsp;
                    </a>
                </span>

                <span class="text-center btn form-control">
                    <a class="d-inline-block py-1 fs-6" href="{{ route('contract.view', [$contract->id, 5]) }}"> &nbsp;
                        سندات الاخراج &nbsp;
                    </a>
                </span>

                <span class="text-center btn form-control">
                    <a class="d-inline-block py-1 fs-6" href="{{ route('contract.view', [$contract->id, 2]) }}">
                        &nbsp; سندات الادخال &nbsp;
                    </a>
                </span>

                <span class="text-center btn form-control">
                    <a class="d-inline-block py-1 fs-6" href="{{ route('contract.view', [$contract->id, 1]) }}">
                        &nbsp; بيانات العقد &nbsp;
                    </a>
                </span>
            </div>
            <fieldset dir="rtl" class="m-3">
                <legend style="right: 20px; left: auto"> بيانات العقد
                    <a href="{{ route('contract.edit', [$contract->id, 1]) }}"><i class="fa fa-edit"></i></a>
                </legend>
                <br>

            </fieldset>

        </div>
    </div>
@endsection


@section('script')
    <script></script>
@endsection
