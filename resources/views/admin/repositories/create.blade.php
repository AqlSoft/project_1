@extends('layouts.admin')
@section('title') Repositories @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Repositories @endsection
@section('homeLinkActive') Create @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('repositories.settings') }}"><span class="btn-title">Go Home</span><i class="fa fa-plus text-light"></i></a></button>
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
        <div class="row">
            <div class="col col-4">
                @foreach ($repos as $in => $repo)
                @if ($repo->id > 1)
                <div>({{ $repo->level }}) {{ $repo->e_name }}</div>
                @endif
                @endforeach
            </div>
            <div class="col col-8">
                <form action="{{ route('repositories.store') }}" method="post">
                    @csrf
                    <fieldset>
                        <legend>Add New Repository</legend>
                        <br>
                        <div class="input-group mb-3">
                            <label for="AName" class="input-group-text">Arabic Name</label>
                            <input class="form-control" type="text" name="a_name" id="AName" placeholder="Repository Arabic Name" required>
                            <label class="input-group-text bg-light text-danger">*</label>
                        </div>

                        <div class="input-group mb-3">
                            <label for="EName" class="input-group-text">Latin Name</label>
                            <input class="form-control" type="text" name="e_name" id="EName" placeholder="Repository Latin Name">
                        </div>

                        <div class="input-group mb-3">
                            <label for="Brief" class="input-group-text">Description</label>
                            <input class="form-control" type="text" name="brief" id="Brief" placeholder="Repository Description">
                        </div>

                        <div class="input-group mb-3">
                            <label for="Parent" class="input-group-text">Parent</label>
                            <select class="form-control" name="parent" id="Parent">
                                @if (count($repos))
                                    @foreach ($repos as $in => $repo)
                                        <option value="{{ $repo->level + 1 }} | {{ $repo->id }}">{{ $repo->a_name . " _ " . $repo->e_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label class="input-group-text bg-light text-danger">*</label>
                            <label for="Code" class="input-group-text">Code</label>
                            <input class="form-control" type="text" name="code" id="Code" placeholder="Repository Code">
                        </div>

                        <div class="input-group mb-3">
                            <label for="address" class="input-group-text">Place</label>
                            <input class="form-control" type="text" name="address" id="address" placeholder="Repository Place">
                        </div>

                        <div class="input-group mb-3">
                            <label for="Phone" class="input-group-text">Phone Number</label>
                            <input class="form-control" type="text" name="phone_number" id="Phone" placeholder="Repository Place">
                        </div>

                        <<div class="buttons" style="overflow:auto;">
                            <div style="float:right;">
                                <button id="dismiss_btn" class="btn btn-submit" data-goto="{{isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:route('repositories.home')}}" onclick="window.location=this.getAttribute('data-goto')" type="submit" id="submitBtn">Cancel</button>
                                <button class="btn btn-submit" type="submit" id="submitBtn">Submit</button>
                            </div>
                        </div>
                    </fieldset>

                </form>
            </div>
        </div>


    </div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection
