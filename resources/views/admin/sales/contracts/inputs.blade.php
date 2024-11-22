@extends('layouts.admin')
@section('title')
    الأصناف المستلمة على العقد
@endsection

@section('pageHeading')
    الأصناف المستلمة على العقد
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
                    <a class="d-inline-block py-1 fs-6" href="{{ route('contract.inputs', [$contract->id, 2]) }}">
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
                <h4 class="btn btn-secondary btn-block text-right"><a
                        href="{{ route('clients.view', [$client->id]) }}">{{ $client->name }}</a>
                </h4>
                <br>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                        <button class="nav-link {{ $tab == 1 ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true"> <a href="{{ route('contract.view', [$contract->id, 1]) }}">العقد</a>
                        </button>
                        <button class="nav-link {{ $tab == 2 ? 'active' : '' }}" id="nav-profile-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false">
                            <a href="{{ route('contract.view', [$contract->id, 2]) }}">سندات الادخال</a>
                        </button>
                        <button class="nav-link {{ $tab == 5 ? 'active' : '' }}" id="nav-profile-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false">
                            <a href="{{ route('contract.view', [$contract->id, 5]) }}"> سندات الاخراج</a>
                        </button>
                        <button class="nav-link {{ $tab == 3 ? 'active' : '' }}" id="nav-contact-tab"
                            data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab"
                            aria-controls="nav-contact" aria-selected="false">
                            <a href="{{ route('contract.view', [$contract->id, 3]) }}">تقارير الأصناف</a>
                        </button>
                        <button class="nav-link {{ $tab == 4 ? 'active' : '' }}" id="nav-disabled-tab"
                            data-bs-toggle="tab" data-bs-target="#nav-disabled" type="button" role="tab"
                            aria-controls="nav-disabled" aria-selected="false">
                            <a href="{{ route('contract.view', [$contract->id, 4]) }}">تقارير الطبليات</a>
                        </button>
                        <button class="nav-link {{ $tab == 6 ? 'active' : '' }}" id="nav-disabled-tab"
                            data-bs-toggle="tab" data-bs-target="#nav-disabled" type="button" role="tab"
                            aria-controls="nav-disabled" aria-selected="false">
                            <a href="{{ route('contract.view', [$contract->id, 6]) }}">تقارير الطبليات - 2</a>
                        </button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent" style="">
                    @php $docNum = 0 @endphp
                    @if ($tab == 2)
                        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel"
                            aria-labelledby="nav-profile-tab" tabindex="1">
                            <h4 class=""> السندات التابعة للعقد </h4>

                            <h4 class="d-block">
                                سندات الادخال / السندات غير المعتمدة
                                <a href="{{ route('receipts.input.create', [1]) }}"><i class="fa fa-plus"></i></a>
                            </h4>
                            <table class="w-100">
                                <tr>
                                    <td>#</td>
                                    <td> مسلسل </td>
                                    <td> نوع السند </td>
                                    <td> تاريخ الادخال </td>
                                    <td> السائق </td>
                                    <td> اجمالى السند </td>
                                    <td> ملاحظات </td>
                                    <td> عمليات </td>
                                </tr>
                                @if (count($contract->inputs))
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($contract->inputs as $ii => $item)
                                        @if ($item->confirmation == 'inprogress')
                                            <tr>
                                                <td>{{ ++$docNum }}</td>
                                                <td>{{ $item->s_number }}</td>
                                                <td>{{ receiptType($item->type) }}</td>
                                                <td>{{ $item->hij_date }}</td>
                                                <td>{{ $item->driver }}</td>
                                                <td>{{ $item->totalQty }}</td>
                                                <td>{{ $item->notes }}</td>
                                                <td>
                                                    <a href="{{ route('receipts.editInputReceipt', [$item->id]) }}"><i
                                                            class="fa fa-edit text-primary"></i></a>
                                                    <a href="{{ route('input.entry.create', [$item->id, 0]) }}"><i
                                                            class="fa fa-sign-out-alt text-info"></i></a>
                                                    <a href="{{ route('receipts.input.view', [$item->id]) }}"><i
                                                            class="text-primary fas fa-eye"></i></a>
                                                    <a href="{{ route('receipt.approve', [$item->id]) }}"><i
                                                            class="fa fa-check text-success"></i></a>
                                                    <a href="{{ route('receipt.destroy', [$item->id]) }}"
                                                        onclick="if (!confirm('النت على وشك القيام بعملية لا يمكن الرجوع عنها، هل أنت متأكد؟')) return false"><i
                                                            class="text-danger fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            @php
                                                $total += $item->totalQty;
                                            @endphp
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">لم يتم ادخال بضاعة بعد</td>
                                    </tr>
                                @endif
                            </table>

                            <h4 class="d-block">

                                سندات الادخال / السندات المعتمدة
                            </h4>

                            <table class="w-100">
                                <tr>
                                    <td>#</td>
                                    <td> مسلسل </td>
                                    <td> نوع السند </td>
                                    <td> تاريخ الادخال </td>
                                    <td> السائق </td>
                                    <td> اجمالى السند </td>
                                    <td> ملاحظات </td>
                                    <td> عمليات </td>
                                </tr>
                                @php
                                    $total = 0;
                                @endphp
                                @if (count($contract->inputs))
                                    @foreach ($contract->inputs as $ii => $item)
                                        @if ($item->confirmation == 'approved')
                                            <tr>
                                                <td>{{ ++$docNum }}</td>
                                                <td>{{ $item->s_number }}</td>
                                                <td>{{ receiptType($item->type) }}</td>
                                                <td>{{ $item->hij_date }}</td>
                                                <td>{{ $item->driver }}</td>
                                                <td>{{ $item->totalQty }}</td>
                                                @php
                                                    $total += $item->totalQty;
                                                @endphp
                                                <td>{{ $item->notes }}</td>
                                                <td>
                                                    <a href="{{ route('receipts.input.view', [$item->id]) }}"><i
                                                            class="text-primary fas fa-eye"></i></a>
                                                    <a href="{{ route('receipt.park', [$item->id]) }}"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="Park Receipt for editing"><i
                                                            class="text-primary fas fa-ban"></i></a>
                                                    <a href="{{ route('receipt.destroy', [$item->id]) }}"
                                                        onclick="if (!confirm('النت على وشك القيام بعملية لا يمكن الرجوع عنها، هل أنت متأكد؟')) return false"><i
                                                            class="text-danger fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">لم يتم ادخال بضاعة بعد</td>
                                    </tr>
                                @endif
                            </table>
                            <div class="row">
                                <div class="col col-10">اجمالى الادخالات </div>
                                <div class="col col-2">{{ $total }}</div>
                            </div>
                        </div>
                    @endif

                </div>

            </fieldset>
            <div id="tableLook"
                style="padding: 100px 0; display: none !important; position: fixed; z-index: 99999; top: 0; left: 0; width: 100vw; display: block; height: 100vh; background-color: #000c">
            </div>

            <div id="itemsLook"
                style="padding: 100px 0; display: none !important; position: fixed; z-index: 99999; top: 0; left: 0; width: 100vw; display: block; height: 100vh; background-color: #000c">
            </div>

            <div id="reportPrint"
                style="padding: 100px 0; display: none !important; position: fixed; z-index: 99999; top: 0; left: 0; width: 100vw; display: block; height: 100vh; background-color: #000c">
            </div>
        </div>
    </div>


@endsection


@section('script')
    <script>
        let buttons = document.querySelectorAll('nav div button');
        buttons.forEach(element => {
            element.addEventListener('click', function() {
                document.querySelector('nav button.active').classList.remove('active');
                this.classList.add('active')
                document.querySelector('.tab-pane.active').classList.remove('show')
                document.querySelector('.tab-pane.active').classList.remove('active')
                document.querySelector(this.getAttribute('data-bs-target')).classList.add('active');
                document.querySelector(this.getAttribute('data-bs-target')).classList.add('show');
            })
        });

        $(document).ready(function() {
            $(document).on('click', '.seeTableContents', function() {
                let ajax_search_url = $(this).attr('data-href');
                let ajax_search_token = $(this).attr('data-token');
                let ajax_table_id = $(this).attr('data-id');
                let ajax_contract_id = $(this).attr('data-contract');

                jQuery.ajax({
                    url: ajax_search_url,
                    type: 'POST',
                    dataType: 'html',
                    data: {
                        table_id: ajax_table_id,
                        '_token': ajax_search_token,
                        ajax_search_url: ajax_search_url,
                        contract: ajax_contract_id
                    },
                    cash: false,
                    success: function(data) {
                        $('#tableLook').html(data);
                    },
                    error: function() {

                    }
                }).then(
                    function() {
                        $('#tableLook').css({
                            display: 'block'
                        });
                    }
                );

            });

        });

        $(document).on('click', '#history', function() {
            let ajax_search_url = $(this).attr('data-search-url');
            let ajax_search_token = $(this).attr('data-search-token');
            let ajax_item_id = $(this).attr('data-item-id');
            let ajax_box_id = $(this).attr('data-box-id');
            let ajax_contract_id = $(this).attr('data-contract-id');

            jQuery.ajax({
                url: ajax_search_url,
                type: 'POST',
                dataType: 'html',
                data: {
                    '_token': ajax_search_token,
                    ajax_search_url: ajax_search_url,
                    contract: ajax_contract_id,
                    box: ajax_box_id,
                    item: ajax_item_id,
                },
                cash: false,
                success: function(data) {
                    $('#itemsLook').html(data);
                },
                error: function() {

                }
            }).then(
                function() {
                    $('#itemsLook').css({
                        display: 'block'
                    });
                }
            );



        });
    </script>
    <script src="{{ asset('resources\js\datatablesar.js') }}"></script>
@endsection
