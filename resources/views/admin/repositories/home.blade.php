@extends('layouts.admin')
@section('title') Repositories @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Repositories @endsection
@section('homeLinkActive') Home @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('repositories.create') }}"><span class="btn-title">Create New</span><i class="fa fa-plus text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('repositories.home') }}"><span class="btn-title">Settings</span><i class="fa fa-cogs text-light"></i></a></button>
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
        <div>
            <style>
                table {
                    border-top: 2px solid #555;
                    border-bottom: 2px solid #555;
                }
                table tr th {
                    background-color: #ddd;
                    text-align: center;
                    padding: .4em 0;
                }
                table tr td {
                    text-align: center;
                    padding: .2em 0;
                }
                table tr:nth-child(even) {
                    background-color: #eee;
                }
                table tr {
                    border-bottom: 1pt solid #ccc
                }
                table tr th + th {
                    border-left: 0.5pt solid #aaa;
                }
                table tr td + td {
                    border-left: 0.5pt solid #aaa
                }
            </style>
            <h4>Repositories</h4>
            <hr>
            <table class="striped" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Arabic Name</th>
                        <th>Latin Name</th>
                        <th>Description</th>
                        <th>Admin</th>
                        <th>Control</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($repos as $in => $repo)
                <tr>
                    <td>{{$in + 1}}</td>
                    <td>{{ $repo->a_name }}</td>
                    <td>{{ $repo->e_name }}</td>
                    <td>{{ $repo->brief }}</td>
                    <td>{{ isset($admins[$repo->admin]) ? $admins[$repo->admin]->name : 'Undefined' }}</td>
                    <td>
                        <a href="{{ route('items.create', $repo->id) }}"><i class="fa fa-cart-plus"></i></a>
                        <a href="{{ route('repositories.create', $repo->id) }}"><i class="fa fa-folder-plus"></i></a>
                        <a href="{{ route('repositories.view', $repo->id) }}"><i class="fa fa-eye"></i></a>
                        <a href="{{ route('repositories.edit', $repo->id) }}"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('repositories.delete', $repo->id) }}"><i class="fa fa-trash"></i></a>

                </tr>
                @endforeach
                </tbody>

            </table>

        </div>


    </div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection

