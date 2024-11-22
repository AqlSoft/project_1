@extends('layouts.admin')
@section('title')
    التقارير | عقود العملاء
@endsection

@section('pageHeading')
    العملاء
@endsection

@section('content')
    <style>
        table.subtable {

            border: none;
            border-top: 2px solid #3953e7;
            border-bottom: 2px solid #3953e7;
            font: normal 13px / 1.2 Cairo;
        }

        table.subtable+.subtable {
            margin-top: 6px;
        }

        table.subtable tr td {
            background-color: #fff;
            color: #3953e7;
        }

        table.subtable tr th,
        table.subtable tr td {


            border-right: 1px solid #777;
        }

        table.subtable tr th {
            font-weight: bold;
            background-color: rgba(104, 194, 221, 0.1);
        }

        table.subtable tr td:first-child,
        table.subtable tr th:first-child {
            border-right: none;
        }
    </style>
    <div class="container pt-5" style="min-height: 100vh">




        <div class="search">
            <div class="row mb-3">
                <div class="col col-5">
                    <h4 class="text-right"> جمــــــيع العقـــــود </h4>
                </div>
                <div class="col col-5">
                    <div class="input-group">
                        <label for="aj_search" class="input-group-text"><i class="fa fa-search"></i></label>
                        <input type="text" data-search-token="{{ csrf_token() }}"
                            data-search-url="{{ route('clients.reports.contracts.search') }}" class="form-control"
                            name="search" id="aj_search" placeholder="بحث العقود">
                    </div>
                </div>
            </div>
        </div>
        <style>
            table tr td:not(:first-child) {
                padding: 0
            }

            table tr td:nth-child(2),
            table tr td:nth-child(3) {
                padding: 0 1rem
            }
        </style>
        <table class="w-100">
            <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">رقم العقد</th>
                    <th rowspan="2">اسم العميل</th>
                    <th colspan="6">الاحصائيات</th>
                </tr>
                <tr>
                    <th>بيان</th>
                    <th>محجوز</th>
                    <th>مستخدم</th>
                    <th>مشغول</th>
                    <th>مخرجة</th>
                    <th>متاح</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalSmallBooked = 0;
                    $totalLargeBooked = 0;
                    $totalSmallUsed = 0;
                    $totalLargeUsed = 0;
                    $totalSmallOccupied = 0;
                    $totalLargeOccupied = 0;
                @endphp
                @foreach ($contracts as $_ => $item)
                    @php
                        $contractSmallBooked = 0;
                        $contractLargeBooked = 0;
                        $totalContractBooked = 0;

                        $contractSmallUsed = 0;
                        $contractLargeUsed = 0;
                        $totalContractUseded = 0;

                        $contractSmallOccupied = 0;
                        $contractLargeOccupied = 0;
                        $totalContractOccupied = 0;
                    @endphp
                    <tr>
                        <td>{{ ++$_ }}</td>
                        <td>
                            <div class="alert alert-primary py-1"> عقد رقم:
                                {{ substr($item->s_number, 4) }}</div>
                            <a class="btn btn-outline-success btn-sm py-1" target="_blank"
                                href="{{ route('contract.view', [$item->id, 4]) }}">
                                <i class="fa fa-eye"></i></a>
                            <a class="btn btn-outline-danger btn-sm py-1"
                                href="{{ route('contract.park', [$item->id]) }}"><i class="fa fa-times"></i></a>
                            <a class="btn btn-outline-primary btn-sm py-1" target="_blank"
                                href="{{ route('contract.edit', [$item->id, 2]) }}"><i class="fa fa-edit"></i></a>
                        </td>
                        <td>
                            <div class="alert alert-primary py-1">{{ $item->clientName }}</div>
                            <a class="btn btn-outline-success btn-sm py-1" target="_blank"
                                href="{{ route('clients.view', [$item->client]) }}">
                                <i class="fa fa-eye"></i></a>

                            <a class="btn btn-outline-primary btn-sm py-1" target="_blank"
                                href="{{ route('client.edit', [$item->client]) }}"><i class="fa fa-edit"></i></a>
                        </td>
                        <td>
                            <div class="border-bottom py-1">صغيرة:</div>
                            <div class="border-bottom py-1">كبيرة:</div>
                            <div class="border-bottom py-1">اجمالى:</div>
                        </td>
                        {{-- الطبالى المحجوزة على العقد --}}
                        @php
                            $totalSmallBooked += $contractSmallBooked = $item->bookedTables['small'];
                            $totalLargeBooked += $contractLargeBooked = $item->bookedTables['large'];
                            $totalContractBooked = $contractSmallBooked + $contractLargeBooked;
                        @endphp
                        <td data-bs-toggle="tooltip" title="الطبالى المحجوزة على العقد">
                            <div class="border-bottom py-1">
                                {{ $contractSmallBooked }}</div>
                            <div class="border-bottom py-1">
                                {{ $contractLargeBooked }}</div>
                            <div class="border-bottom py-1">
                                {{ $totalContractBooked }}</div>
                        </td>
                        {{-- الطبالى المستخدمة بالعمليات وهى كل الطبليات التى دخلت فى كميات العقد --}}
                        @php
                            $totalSmallUsed += $contractSmallUsed = $item->consumedTables['small'];
                            $totalLargeUsed += $contractLargeUsed = $item->consumedTables['large'];
                            $totalContractUsed = $contractSmallUsed + $contractLargeUsed;
                        @endphp
                        <td data-bs-toggle="tooltip" title="الطبالى المستخدمة بالعمليات">
                            <div class="border-bottom py-1">
                                {{ $contractSmallUsed }}</div>
                            <div class="border-bottom py-1">
                                {{ $contractLargeUsed }}</div>
                            <div class="border-bottom py-1">
                                {{ $totalContractUsed }}</div>
                        </td>

                        {{-- الطبالى المشغولة بالمخزن وهى كل الطبالى التى تحمل كرتونة واحدة على الأقل --}}
                        @php
                            $totalSmallOccupied += $contractSmallOccupied = $item->occupiedTables['small'];
                            $totalLargeOccupied += $contractLargeOccupied = $item->occupiedTables['large'];
                            $totalContractOccupied = $contractSmallOccupied + $contractLargeOccupied;
                        @endphp
                        <td data-bs-toggle="tooltip" title="الطبالى المشغولة بالمخزن">
                            <div
                                class="border-bottom py-1 {{ $contractSmallOccupied > $contractSmallBooked ? 'bg-danger text-light' : '' }}">
                                {{ $contractSmallOccupied }}</div>
                            <div
                                class="border-bottom py-1 {{ $contractLargeOccupied > $contractLargeBooked ? 'bg-danger text-light' : '' }}">
                                {{ $contractLargeOccupied }}</div>
                            <div
                                class="border-bottom py-1 {{ $totalContractOccupied > $totalContractBooked ? 'bg-danger text-light' : '' }}">
                                {{ $totalContractOccupied }}</div>
                        </td>

                        {{-- الطبالى الخارجة من المخزن وهى الفرق بين ما المستخدم والمشغول من الطبالى --}}
                        @php
                            $contractSmallOut = $contractSmallUsed - $contractSmallOccupied;
                            $contractLargeOut = $contractLargeUsed - $contractLargeOccupied;
                            $totalContractOut = $contractSmallOut + $contractLargeOut;
                        @endphp
                        <td data-bs-toggle="tooltip" title="الطبالى الخارجة من المخزن">
                            <div class="border-bottom py-1">
                                {{ $contractSmallOut }}</div>
                            <div class="border-bottom py-1">
                                {{ $contractLargeOut }}</div>
                            <div class="border-bottom py-1">
                                {{ $totalContractOut }}</div>
                        </td>


                        {{-- الطبالى المتاحة للاستخدام وهى الفرق بين الطبالى المحجوزة والمشغولة --}}
                        @php
                            $contractSmallRemain = $contractSmallBooked - $contractSmallOccupied;
                            $contractLargeRemain = $contractLargeBooked - $contractLargeOccupied;
                            $totalContractRemain = $contractSmallRemain + $contractLargeRemain;
                        @endphp
                        <td data-bs-toggle="tooltip" title="الطبالى المتاحة للاستخدام">
                            <div class="border-bottom py-1 {{ $contractSmallRemain < 0 ? 'bg-danger text-light' : '' }}">
                                {{ $contractSmallRemain }}</div>
                            <div class="border-bottom py-1 {{ $contractLargeRemain < 0 ? 'bg-danger text-light' : '' }}">
                                {{ $contractLargeRemain }}</div>
                            <div class="border-bottom py-1 {{ $totalContractRemain < 0 ? 'bg-danger text-light' : '' }}">
                                {{ $totalContractRemain }}</div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">الاجمــــــــــــــــــــالى</th>
                    <th>
                        <div class="border-bottom">صغيرة:</div>
                        <div class="border-bottom">كبيرة:</div>
                        <div class="border-bottom">اجمالى:</div>
                    </th>
                    <th>
                        <div class="border-bottom">{{ $totalSmallBooked }}</div>
                        <div class="border-bottom">{{ $totalLargeBooked }}</div>
                        <div class="border-bottom">{{ $totalSmallBooked + $totalLargeBooked }}</div>
                    </th>
                    <th>
                        <div class="border-bottom">{{ $totalSmallUsed }}</div>
                        <div class="border-bottom">{{ $totalLargeUsed }}</div>
                        <div class="border-bottom">{{ $totalSmallUsed + $totalLargeUsed }}</div>
                    </th>
                    <th>
                        <div class="border-bottom">{{ $totalSmallOccupied }}</div>
                        <div class="border-bottom">{{ $totalLargeOccupied }}</div>
                        <div class="border-bottom">{{ $totalSmallOccupied + $totalLargeOccupied }}</div>
                    </th>
                    <th>
                        <div class="border-bottom">{{ $totalSmallOut = $totalSmallUsed - $totalSmallOccupied }}</div>
                        <div class="border-bottom">{{ $totalLargeOut = $totalLargeUsed - $totalLargeOccupied }}</div>
                        <div class="border-bottom">{{ $totalSmallOut + $totalLargeOut }}</div>
                    </th>
                    <th>
                        <div class="border-bottom">{{ $totalSmallRemain = $totalSmallBooked - $totalSmallOccupied }}</div>
                        <div class="border-bottom">{{ $totalLargeRemain = $totalLargeBooked - $totalLargeOccupied }}</div>
                        <div class="border-bottom">{{ $totalSmallRemain + $totalLargeRemain }}</div>
                    </th>

                </tr>
            </tfoot>
        </table>
    </div>








    {{-- <div class="card w-100 px-3" id="clients_data">
            <table class="w-100 my-5">

                <thead>

                    <tr>
                        <th>#</th>
                        <th>اسم العميل</th>
                        <th>نوع العميل</th>
                        <th>العقود</th>
                        <th><i class="fa fa-cogs"></i></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($clients as $c => $client)
                        @if (!empty($clients))
                            <tr>
                                <td>{{ isset($_GET['page']) ? ++$c + ($_GET['page'] - 1) * 10 : ++$c }}</td>
                                <td>{{ $client->a_name }}</td>
                                <td>{{ $scopes[$client->industry] }}</td>
                                <td>
                                    @if (0 == count($client->contracts))
                                        <table class="w-100 subtable">

                                            <tr>
                                                <th>
                                                    لم نحصل على أى عقود للعميل
                                                </th>
                                            </tr>
                                        </table>
                                    @endif
                                    @foreach ($client->contracts as $cc => $item)
                                        <table class="w-100 subtable">

                                            <tr>
                                                <th>الرقم المسلسل:</th>
                                                <td><a
                                                        href="{{ route('contract.view', [$item->id, 1]) }}">{{ $item->s_number }}</a>
                                                </td>
                                                <th>البداية من:</th>
                                                <td>{{ $item->starts_in_hij }}</td>
                                                <th>النهاية فى:</th>
                                                <td>{{ $item->ends_in_hij }}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">طبالى العقد</th>
                                                <th colspan="2">الطبالى المشغولة</th>
                                                <th colspan="2">رصيد الطبالى</th>
                                            </tr>
                                            <tr>
                                                <th>كبيرة</th>
                                                <th>صغيرة</th>
                                                <th>كبيرة</th>
                                                <th>صغيرة</th>
                                                <th>كبيرة</th>
                                                <th>صغيرة</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $cl = $item->largePallets }}</td>
                                                <td>{{ $cs = $item->smallPallets }}</td>
                                                <td class="{{ $cl < $item->largeFilled ? 'bg-danger' : '' }}">
                                                    {{ $fl = $item->largeFilled }}</td>
                                                <td class="{{ $cs < $item->smallFilled ? 'bg-danger' : '' }}">
                                                    {{ $fs = $item->smallFilled }}</td>
                                                <td class="{{ $cl - $fl < 0 ? 'bg-danger' : '' }}">{{ $cl - $fl }}
                                                </td>
                                                <td class="{{ $cs - $fs < 0 ? 'bg-danger' : '' }}">{{ $cs - $fs }}
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach

                                </td>

                                <td>More...</td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="5">لا يوجد عملاء مضافين حتى الان</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            {{ $clients->links() }}
        </div> --}}

    </div>

    <br>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('keyup', '#aj_search', function() {
                console.log('excuted')
                let ajax_search_url = $('#aj_search').attr('data-search-url');
                let ajax_search_token = $('#aj_search').attr('data-search-token');
                let ajax_search_query = $('#aj_search').val();

                jQuery.ajax({
                    url: ajax_search_url,
                    type: 'post',
                    dataType: 'html',
                    data: {
                        search: ajax_search_query,
                        '_token': ajax_search_token,
                        ajax_search_url: ajax_search_url
                    },
                    cash: false,
                    success: function(data) {
                        $('#clients_data').html(data);
                    },
                    error: function() {

                    }
                });
            });

            $(document).on('click', '#links ul.pagination li a', function(e) {
                e.preventDefault();
                let ajax_search_url = $(this).attr('href');
                let ajax_search_token = $('#aj_search').attr('data-search-token');
                let ajax_search_query = $('#aj_search').val();

                console.log(ajax_search_token);
                jQuery.ajax({
                    url: ajax_search_url,
                    type: 'post',
                    dataType: 'html',
                    data: {
                        search: ajax_search_query,
                        '_token': ajax_search_token
                    },
                    cash: false,
                    success: function(data) {
                        $('#clients_data').html(data);
                    },
                    error: function() {
                        console.log('error happened')
                    }
                });
            });

        });
    </script>
@endsection
