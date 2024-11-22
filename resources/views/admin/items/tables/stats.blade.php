@extends('layouts.admin')
@section('title')
    التخزين
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    الطبالي
@endsection
@section('homeLinkActive')
    الرئيسية
@endsection

@section('content')
    <div class="container">

        <div class="buttons">
            <button type=button class="btn btn-sm px-2  btn-success">
                <i class="fa fa-chart-line"></i>
                احصائيات </button>
            <button type=button class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('tables.home') }}">
                    <i class="fa fa-list"></i>
                    الطبالى</a></button>
            <button type=button class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('table.create') }}">
                    <i class="fa fa-plus"></i>
                    إضافة
                </a></button>
        </div>
        <div id="data_show">

            <fieldset>
                <legend>احصائيات عامة</legend>
                <br>
                <div class="row mb-3">
                    <div class="col col-12 col-md-6">
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <th colspan="3"
                                        style="border-bottom: 2px solid; font: bold 16px /2 Cairo;border-left: 0">عدد
                                        الطبالى الموجودة بالثلاجة</th>
                                </tr>
                                <tr>
                                    <th>بيان</th>
                                    <th>حسب المخازن</th>
                                    <th>حسب النظام</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>الطبالى الصغيرة</th>
                                    <td>1500</td>
                                    <td>{{ $small }}</td>
                                </tr>
                                <tr>
                                    <th>الطبالى الكبيرة</th>
                                    <td>1500</td>
                                    <td>{{ $large }}</td>
                                </tr>
                                <tr>
                                    <th>اجمالى الطبالى </th>
                                    <td>3000</td>
                                    <td>{{ $small + $large }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    {{-- {{ $smallTables[0] }}
                    {{ $smallTables[1] }} --}}
                    <div class="col col-12 col-md-6">
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <th colspan="4"
                                        style="border-bottom: 2px solid; font: bold 16px /2 Cairo;border-left: 0">رصيد
                                        الطبالى المحجوزة
                                    </th>
                                </tr>
                                <tr>
                                    <th>بيان</th>
                                    <th>حسب العقد</th>
                                    <th>المتبقي</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>الطبالى الصغيرة</th>

                                    <td>{{ $smallBook }}</td>
                                    <td>{{ $small - $smallBook }}</td>
                                </tr>
                                <tr>
                                    <th>الطبالى الكبيرة</th>

                                    <td>{{ $largeBook }}</td>
                                    <td>{{ $large - $largeBook }}</td>
                                </tr>
                                <tr>
                                    <th>اجمالى الطبالى </th>

                                    <td>{{ $book = $smallBook + $largeBook }}</td>
                                    <td>{{ $small + $large - $book }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-12 col-md-6">
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <th colspan="4"
                                        style="border-bottom: 2px solid; font: bold 16px /2 Cairo;border-left: 0">رصيد
                                        الطبالى المحجوزة
                                    </th>
                                </tr>
                                <tr>
                                    <th>بيان</th>
                                    <th>حسب العقد</th>
                                    <th>المتبقي</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>الطبالى الصغيرة</th>

                                    <td>{{ $smallOccu }}</td>
                                    <td>{{ $small - $smallOccu }}</td>
                                </tr>
                                <tr>
                                    <th>الطبالى الكبيرة</th>

                                    <td>{{ $largeOccu }}</td>
                                    <td>{{ $large - $largeOccu }}</td>
                                </tr>
                                <tr>
                                    <th>اجمالى الطبالى </th>

                                    <td>{{ $occu = $smallOccu + $largeOccu }}</td>
                                    <td>{{ $small + $large - $occu }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </fieldset>

        </div>

    </div>
@endsection



@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
    <script>
        $('.accordion-button i').click(function() {
            $(this).toggleClass('fa-folder-open fa-folder')
        })
        const cm = $('.alterContext');
        const ci = $('.catItem');
        ci.on('contextmenu', (e) => {
            e.preventDefault();
            showContextMenu();
            let c_id = e.target.getAttribute('data-id'),
                c_lvl = e.target.getAttribute('data-level')
            let cm_top = e.clientY + cm.offsetHeight > window.innerHeight ? window.innerHeight - cm.offsetHeight : e
                .clientY + 'px';
            let cm_left = e.clientX + cm.offsetWidth > window.innerWidth ? window.innerWidth - cm.offsetWidth : e
                .clientX + 'px';
            let al = $('#addLink'),
                el = $('#editLink'),
                dl = $('#deleteLink');
            cm.css({
                top: cm_top,
                left: cm_left
            })

            if (c_lvl == 3) {
                al.text('Add New Item');
                al.attr('href', al.attr('data-add-item').replace(/1/g, c_id));
            } else {
                al.text('Add New Category');
                al.attr('href', al.attr('data-url').replace(/0/g, c_id));
            }
            el.attr('href', el.attr('data-url').replace(/0/g, c_id));
            dl.attr('href', dl.attr('data-url').replace(/0/g, c_id));

        })
        $(window).on('click', () => {
            showContextMenu(false);
        })

        function showContextMenu(show = true) {
            cm.css({
                height: show ? 'auto' : 0,
            })
        }
    </script>
@endsection
