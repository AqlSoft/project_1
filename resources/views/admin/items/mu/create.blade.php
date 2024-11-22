@extends('layouts.admin')
@section('title') Repositories @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Repositories @endsection
@section('homeLinkActive') Items / Measuring Units / Add New Unit @endsection
@section('links')
    <button class="btn btn-sm btn-primary"> Items Home <a href="{{ route('items.home') }}"><span class="btn-title">Go Back for Items Home</span><i class="fa fa-home text-light"></i></a></button>
@endsection
@section('content')

    <div class="container">

        <div class="row">
            <div class="col col-2">

            </div>
            <div class="col col-8">
                <fieldset class="w-100">
                    <legend>Add New Measuring Unit</legend>
                    <form action="{{route('items.mu.insert')}}" method="post">
                        @csrf
                        <div class="input-group mt-3">
                            <label for="a_name" class="input-group-text">Name</label>
                            <input type="text" class="form-control" name="a_name" id="a_name" placeholder="Arabic Name" required>
                            <input type="text" class="form-control" name="e_name" id="e_name" placeholder="Latin Name" required>
                        </div>

                        <div class="input-group mt-3">
                            <label for="is_master" class="input-group-text">Unit Type</label>
                            <select class="form-control" name="is_master" id="parent" required>
                                <option value="1">Master Unit</option>
                                <option value="0">Division Unit</option>

                            </select>
                        </div>

                        <div class="input-group mt-3">
                            <label for="a_name" class="input-group-text">Label</label>
                            <input type="text" class="form-control" name="a_label" id="a_label" placeholder="Arabic Label" required>
                            <input type="text" class="form-control" name="e_label" id="e_label" placeholder="Latin Label" required>
                        </div>

                        <div class="buttons" style="overflow:auto;">
                            <div style="float:right;">
                                <button class="btn btn-delete" type="button" id="prevBtn"><a href="{{ route('items.home') }}">Cancel</a></button>
                                <button class="btn btn-submit" type="submit" id="submitBtn">Submit</button>
                            </div>
                        </div>

                    </form>
                </fieldset>

            </div>
        </div>


    </div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection

