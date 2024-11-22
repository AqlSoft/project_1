@extends('layouts.admin')

@section('title')
    تقارير الأصناف
@endsection

@section('pageHeading')
    عرض الموجود من كل صنف لدى جميع العملاء
@endsection

@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('clients.home') }}"><i data-bs-title="العودة للعقود"
                data-bs-toggle="tooltip" class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ '' }}"><i class="fa fa-print fa-fw"
                data-bs-title="طباعة العقد" data-bs-toggle="tooltip"></i></a></button>
@endsection
@section('content')
    <div class="container py-4">
        <nav>
            <div class="nav nav-tabs " id="nav-tab" role="tablist" style="border: 0;">
                <button class="nav-link ">
                    <a class="px-3" href="{{ route('clients.home', [2]) }}">العملاء</a>
                </button>
                <button class="nav-link  active">
                    <a class="px-3">
                        تقرير كميات صنف
                    </a>
                </button>

                <button class="nav-link">
                    <form action="{{ route('clients.items.stats') }}" id="stats" method="post">
                        @csrf
                        <input type="hidden" name="searchQuery">
                        <input type="submit" value="تقرير كميات الأصناف"
                            style="background-color: transparent; border: none; color: #fff; font-weight: bold" />
                    </form>
                </button>

            </div>
        </nav>
        <div class="tab-content p-3" id="nav-tabContent" style="background-color: #fff">



            <fieldset dir="rtl" class="py-4">
                <legend style="right: 20px; left: auto">
                    البيانات
                </legend>
                <div class="search">
                    <div class="row">
                        <div class="col col-5">
                            <div class="input-group">
                                <label for="aj_search" class="input-group-text">الفلترة حسب الصنف</label>
                                <input type="hidden" name="token" id="csrfToken" value="{{ csrf_token() }}">
                                <input type="hidden" name="token" id="url"
                                    value="{{ route('clients.search.items') }}">
                                <select name="store_items" id="storeItem" class="form-control" placeholder="بحث العقود">
                                    <option hidden> الكـــــــــــل </option>
                                    @foreach ($storeItems as $id => $item)
                                        <option value="{{ $id }}"> {{ $item }} </option>
                                    @endforeach
                                </select>
                                <button name="search" id="aj_search" class="input-group-text"><i
                                        class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="item-stats-top"
                    style="position: absolute; top: 16px; left: 16px; border: 1px solid #333; padding: 8px 16px;">
                    عدد النتائج :
                    <span class="clients-count">0</span>
                    عدد الكراتين الاجمالى:
                    <span class="box-count">0</span>
                    <div>
                        هناك <span class="ignored">0</span> من عناصر البحث تم تجاهلها لأنها تحتوى على رصيد صفرى.
                    </div>
                </div>
                <div class="buttons">
                    <button class="btn btn-sm btn-outline-primary" id="displayAll"> <i class="fa fa-list-ul"></i> &nbsp;
                        الكل</button>
                    <button class="btn btn-sm btn-outline-primary" id="displayInv"> <i class="fa fa-tasks"></i> &nbsp; عكس
                        العرض</button>
                    <button class="btn btn-sm btn-outline-primary" id="displayNone"> <i class="fa fa-bars"></i> &nbsp; اغلاق
                        الكل</button>
                </div>
                <div id="searchItems" class="mt-2">


                    @php
                        $clients_counter = 0;
                    @endphp
                    <div class="accordion" id="accordionExample">
                        @foreach ($clients as $client => $data)
                            <div class="accordion-item" id="client_{{ $client }}">
                                <h2 class="accordion-header  border-secondary">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse_{{ $client }}" aria-expanded="false"
                                        aria-controls="collapse_{{ $client }}">
                                        {{ ++$clients_counter }} - {{ $clientsNames[$client] }}
                                        <span id="itemQty_{{ $client }}"
                                            style="position: absolute; left: 4em">Sum</span>
                                    </button>
                                </h2>

                                <div id="collapse_{{ $client }}" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body" style="overflow-x: scroll;">
                                        <div class="d-flex" style="overflow-wrap: nowrap;">
                                            @php
                                                $inputs = 0;
                                                $outputs = 0;
                                                $items_counter = 0;
                                            @endphp
                                            <div class="col col-auto d-grid gap-0 p-0"
                                                style="border-top: 2px solid #333; border-bottom: 2px solid #333; border-left: 1px solid #333;">
                                                <div class="py-1 px-3 bg-secondary text-light">اسم الصنف</div>
                                                <div class="py-1 px-3" style="border-bottom: 1px solid #ccc">حجم
                                                    الكرتون
                                                </div>
                                                <div class="py-1 px-3" style="border-bottom: 1px solid #ccc">اجمالى
                                                    المدخلات
                                                </div>
                                                <div class="py-1 px-3" style="border-bottom: 1px solid #ccc">اجمالى
                                                    المخرجات
                                                </div>
                                                <div class="py-1 px-3">اجمالى الكمية</div>
                                            </div>

                                            @if ($data != null)
                                                @foreach ($data as $key => $info)
                                                    {{ $info }}
                                                    <div class="col col-auto d-grid gap-0 p-0"
                                                        style="border-top: 2px solid #333; border-bottom: 2px solid #333; border-left: 1px solid #333;">
                                                        <div class="py-1 px-1 text-center bg-secondary text-ligh"
                                                            style="border-bottom: 1px solid #ccc">
                                                            {{ $info->item_id == '' ? 'unknown' : '' }}
                                                            {{-- /*$storeItems[$info->item_id]*/ --}}
                                                        </div>
                                                        <div class="py-1 px-1 text-center"
                                                            style="border-bottom: 1px solid #ccc">
                                                            {{ $info->box_size == '' ? 'unknown' : $storeBoxes[$info->box_size] }}

                                                        </div>
                                                        <div class="py-1 px-1 text-center"
                                                            style="border-bottom: 1px solid #ccc">
                                                            {{ $info->totalInputs }}</div>
                                                        <div class="py-1 px-1 text-center"
                                                            style="border-bottom: 1px solid #ccc">
                                                            {{ $info->totalOutputs }}</div>
                                                        <div class="py-1 px-1 text-center">
                                                            {{ $info->totalInputs - $info->totalOutputs }}</div>
                                                        @php ++$items_counter @endphp
                                                    </div>
                                                    @php
                                                        $inputs += $info->totalInputs;
                                                        $outputs += $info->totalOutputs;
                                                    @endphp
                                                @endforeach
                                            @endif
                                            <div class="col col-auto d-grid gap-0 p-0"
                                                style="border-top: 2px solid #333; border-bottom: 2px solid #333;">
                                                <div class="py-1 px-3 bg-secondary text-light">الاجمالى</div>
                                                <div class="py-1 px-3" style="border-bottom: 1px solid #ccc">
                                                    {{ $items_counter }}</div>
                                                <div class="py-1 px-3" style="border-bottom: 1px solid #ccc">
                                                    {{ $inputs }}</div>
                                                <div class="py-1 px-3" style="border-bottom: 1px solid #ccc">
                                                    {{ $outputs }}</div>
                                                <div data-id="itemQty_{{ $client }}"
                                                    data-close="client_{{ $client }}"
                                                    class="client-total-qty py-1 px-3">
                                                    {{ $inputs - $outputs }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="items-stats"
                    style="position: absolute; bottom: 16px; left: 16px; border: 1px solid #333; padding: 8px 16px;">
                    عدد النتائج:
                    <span class="clients-count">0</span>
                    عدد الكراتين الاجمالى:
                    <span class="box-count">0</span>
                    <div>
                        هناك <span class="ignored">0</span> من عناصر البحث تم تجاهلها لأنها تحتوى على رصيد صفرى.
                    </div>
                </div>
                <br><br><br>
            </fieldset>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#displayAll').click(() => {
            $('.accordion-button').removeClass('collapsed')
            $('.accordion-button').attr('aria-expanded', 'true')
            $('.accordion-collapse').addClass('show')
        })
        $('#displayNone').click(() => {
            $('.accordion-button').addClass('collapsed')
            $('.accordion-button').attr('aria-expanded', 'false')
            $('.accordion-button').attr('aria-expanded', !$('.accordion-button').attr('aria-expanded'))
            $('.accordion-collapse').removeClass('show')
        })
        $('#displayInv').click(() => {
            $('.accordion-button').toggleClass('collapsed')
            $('.accordion-button').attr('aria-expanded', !$('.accordion-button').attr('aria-expanded'))
            $('.accordion-collapse').toggleClass('show')
        })

        $(document).ready(function() {
            calcTotals()
            $(document).on('click', '#aj_search', function() {
                let ajax_search_url = $('#url').val();
                let ajax_search_token = $('#csrfToken').val();
                let ajax_store_item = $('#storeItem').val();

                jQuery.ajax({
                    url: ajax_search_url,
                    type: 'POST',
                    dataType: 'html',
                    data: {
                        storeItem: ajax_store_item,
                        '_token': ajax_search_token,
                        ajax_search_url: ajax_search_url,
                    },
                    cash: false,
                    success: function(data) {

                        $('#searchItems').html(data);
                        calcTotals()
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

        function calcTotals() {
            const results = document.querySelectorAll('.client-total-qty')
            const collect = []
            let ignoredItems = 0
            results.forEach((item) => {
                if (+(item.innerHTML) <= 0) {
                    document.getElementById(item.getAttribute('data-close')).remove();
                    ignoredItems++
                } else {
                    document.getElementById(item.getAttribute('data-id')).innerHTML = item.innerHTML
                    collect.push(+(item.innerHTML))
                }
            })
            document.querySelector('#item-stats-top .clients-count').innerHTML = collect.length;
            document.querySelector('.items-stats .clients-count').innerHTML = collect.length;
            document.querySelector('#item-stats-top .box-count').innerHTML = collect.reduce((a, b) => a + b, 0);
            document.querySelector('.items-stats .box-count').innerHTML = collect.reduce((a, b) => a + b, 0);
            document.querySelector('#item-stats-top .ignored').innerHTML = ignoredItems;
            document.querySelector('.items-stats .ignored').innerHTML = ignoredItems;
            let searchResults = document.getElementById('accordionExample')
            if (searchResults.innerHTML.length <= 10) {
                searchResults.innerHTML = `<h4 class="text-center"> لم نعثر على نتائج تطابق فلاتر البحث التى حددتها </h4>`
            }



        }
    </script>
@endsection
