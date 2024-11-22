@extends('layouts.admin')
@section('title') Sales - Categories @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Store @endsection
@section('homeLinkActive') Home @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('store.create') }}"><span class="btn-title">Add New Repository</span><i class="fa fa-plus text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('store.settings') }}"><span class="btn-title">Stores Settings</span><i class="fa fa-home text-light"></i></a></button>
@endsection
@section('content')
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
        <div id="data_show">
            <div class="row">
                <div class="col col-4 border">
                    <fieldset class="">
                        <legend>
                            Root Account
                            <button class="form-trigger" data-target="#addRoot" {{--route('accounts.create', 0)--}}>
                                <i class="fa fa-plus"></i></button>
                        </legend>
                        <div class="accordion" id="rootLevel" style="position:relative;">
                            <div class="vLine" style="top: -16px; bottom: 10px"></div>
                            
                        </div>
                    </fieldset>
                </div>
            </div>
            <table id="data" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Manage</th>
                </tr>
                </thead>
                <tbody>

               
                </tbody>
            </table>
           
        </div>

    </div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection
