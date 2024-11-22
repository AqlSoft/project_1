@extends('layouts.admin')
@section('title')
    العمليات
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    العمليات
@endsection
@section('homeLinkActive')
    سجل النشاط
@endsection

@section('content')

    <div class="container pt-5">
        <div class="search">
            <form method="POST">
                <div class="row mb-3">
                    <div class="col col-5">
                        <div class="input-group">
                            <label for="aj_search" class="input-group-text"><i class="fa fa-search"></i></label>
                            <input type="text" data-search-token="{{ csrf_token() }}"
                                data-search-url="{{ route('treasuries.aj') }}" class="form-control" name="search"
                                id="aj_search">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="border">
            <table class="striped" dir="rtl" id="data" style="width: 100%">
                <thead>
                    <tr class="text-center">
                        <th>م</th>
                        <th>العملية</th>
                        <th>الوقت</th>
                        <th>المزيد</th>
                    </tr>
                </thead>
                @php
                    $counter = 0;
                @endphp
                <tbody>
                    @if (count($log))
                        @foreach ($log as $in => $item)
                            <tr>
                                <td>{{ ++$counter }}</td>
                                <td>{{ str_replace('%s', $item->admin, $item->action) . ' ' . $item->subject }}</td>

                                <td>{{ $item->created_at }}</td>

                                <td>
                                    <a href="{{ route($item->link, $item->item_id) }}"><i class="fa fa-eye"></i></a>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">لا يوجد أى اجراءات حتى الان</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div id="pagination">

                {{ $log->links() }}
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
    <script></script>
@endsection
