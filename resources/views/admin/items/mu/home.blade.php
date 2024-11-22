@extends('layouts.admin')
@section('title') Repositories @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Repositories @endsection
@section('homeLinkActive') Items / Measuring Units / Home @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.mu.create') }}"><span class="btn-title">Add New Measuring Unit</span><i class="fa fa-plus text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.home') }}"><span class="btn-title">Go Back for Items Home</span><i class="fa fa-home text-light"></i></a></button>
@endsection
@section('content')
    <style>
        /*tr th {font: bolder 14px/1em "Cairo"; padding: 0;*/
        /*    background-color: #eee;}*/
        /*tr td, tr th {border-right: 1px solid #ccc;}*/
        /*tr td:last-child, tr th:last-child {border-right: none; border-left: 1px solid #ccc}*/
    </style>

    <div class="container">
        <div class="search">
            <form method="POST">
                <div class="row mb-3">
                    <div class="col col-5">
                        <div class="input-group">
                            <label for="aj_search" class="input-group-text"><i class="fa fa-search"></i></label>
                            <input type="text" data-search-token="{{ csrf_token() }}" data-search-url="{{ route('treasuries.aj') }}" class="form-control" name="search" id="aj_search">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <table class="striped" style="width: 100%">
            <thead>
            <tr class="text-center">
                <th rowspan="2">id</th>
                <th colspan="2">Unit Name</th>
                <th rowspan="2">Type</th>
                <th colspan="2">Label</th>
                <th rowspan="2">Controls</th>
            </tr>
            <tr>
                <th>Arabic Name</th>
                <th>English Name</th>
                <th>Arabic Label</th>
                <th>English Label</th>
            </tr>
            </thead>
            <tbody>
            @if (count($master_units)) @foreach($master_units as $in => $mu)
            <tr>
                <td>{{ $mu->id }}</td>
                <td>{{ $mu->a_name }}</td>
                <td>{{ $mu->e_name }}</td>
                <td>{{ $mu->is_master ? 'Master Unit' : 'Division Unit' }}</td>
                <td>{{ $mu->a_label }}</td>
                <td>{{ $mu->e_label }}</td>
                <td>
                    <a href="{{route('items.mu.edit', $mu->id)}}"><i class="fa fa-edit"></i></a>
                    <a href="{{route('items.mu.destroy', $mu->id)}}"><i class="fa fa-trash"></i></a>
                </td>
            </tr>

            @endforeach
            @else
                <tr>
                    <td colspan="7">No measuring units inserted yet</td>
                </tr>
            @endif
            </tbody>
        </table>


    </div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection

