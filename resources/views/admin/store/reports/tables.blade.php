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
    <button class="btn btn-sm btn-primary"><a href="{{ route('contract.print', [2]) }}"><i class="fa fa-print fa-fw"
                data-bs-title="طباعة العقد" data-bs-toggle="tooltip"></i></a></button>
@endsection
@section('content')
    <div class="container pt-4">
        <div class="border p-3">

            <fieldset dir="rtl" class="m-3">
                <legend style="right: 20px; left: auto">
                    تقرير الطبالى - حمولة وارتباط
                </legend>

                <div class="row">
                    @if (count($cTables) > 0)
                        @php
                            $start = 1;
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $counter = $start + ($page - 1) * 24;
                            $cTables->used_tables = 0;
                        @endphp
                        @foreach ($cTables as $cTable)
                            <div class="col col-4 py-1">
                                <div class="px-3 py-2"
                                    style="border-radius: 16px; border: 5px solid #444; height: 300px; margin: 0 0px; position: relative">
                                    <span class="table_index"
                                        style="border-top-right-radius: 8px; position: absolute; top: 5px; right: 5px;; display: block; padding: 0.15em 1em; border: 1px solid #333">
                                        {{ $counter++ }} </span>
                                    <span class="seeTableContents btn btn-outline-primary" data-token="{{ csrf_token() }}"
                                        data-id="{{ $cTable->tableName }}" data-contract="{{ 2 }}"
                                        data-href="{{ route('table.getInfo') }}"
                                        style="border-bottom-left-radius: 8px;cursor: pointer; position: absolute; bottom: 5px; left: 5px;; display: block; padding: 0.15em 1em;">
                                        المزيد </span>
                                    <h2 class="text-center" style=" font-size: 54px;">
                                        {{ $cTable->tableName }}</h2>


                                    <table class="w-100 mb-3">
                                        <thead>
                                            <tr>
                                                <th>وارد</th>
                                                <th>صادر</th>
                                                <th>باقي</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-primary">
                                                <td>{{ $cTable->load['inputs'] }}</td>
                                                <td>{{ $cTable->load['outputs'] }}</td>
                                                <td>{{ $cTable->load['total'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    @if ($cTable->load['total'] > 0)
                                        <a href="" class="d-block text-center mb-2 btn btn-outline-info btn-sm">
                                            <div>[ {{ $cTable->contract }} ]</div>
                                        </a>
                                        <a href="" class="d-block text-center mb-2 btn btn-outline-info btn-sm">
                                            <div>[ {{ $cTable->client }} ]</div>
                                        </a>

                                        @php
                                            $tableItems = array_unique(explode(',', $cTable->items));
                                        @endphp
                                        <div class="row text-end">
                                            @foreach ($tableItems as $tii => $tsid)
                                                <span class="col col-auto m-1 badge btn btn-outline-primary">
                                                    {{ $storeItems[$tsid] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <div>الطبلية فارغة</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div>
                            لم يتم اجراء أى عمليات على الطبالى
                        </div>
                    @endif
                </div>

            </fieldset>
            {{ $cTables->links() }}
            <div id="tableLook"
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
    </script>
    <script src="{{ asset('resources\js\datatablesar.js') }}"></script>
@endsection
