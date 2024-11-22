@extends('layouts.admin')
@section('title')
    Items Categories
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    Items Categories
@endsection
@section('homeLinkActive')
    Create New
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('accounts.home') }}"><span class="btn-title">Go Home</span><i
                class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('accounts.setting') }}"><span class="btn-title">Settings</span><i
                class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')
    <style>

    </style>
    <div class="container">
        <div class="row">
            <div class="col col-2"></div>
            <div class="col col-8 border">
                <fieldset>
                    <legend>Add New Item Category</legend>
                    <form class="p-3" id="regForm" action="{{ route('items.cats.store') }}" method="post">
                        @csrf
                        <div class="input-group mt-5 m-auto mb-3">
                            <label for="a_name" class="input-group-text">Account Name</label>
                            <input type="text" id="a_name" name="a_name" required class="form-control"
                                placeholder="Arabic Name">
                            <input type="text" id="e_name" name="e_name" required class="form-control"
                                placeholder="Latin Name">
                        </div>
                        <br>
                        <div class="input-group m-auto">
                            <label for="parent_cat" class="input-group-text">Account Type</label>

                            <select id="type" class="form-control" name="parent_cat">
                                <option type="hidden" value="">Select Type:</option>
                                @foreach ($types as $in => $type)
                                    <option class="" {{ $theType == $in ? 'selected' : '' }}
                                        value="{{ $in }}">{{ $type }}</option>
                                @endforeach
                            </select>
                            @if ($theType)
                                <label for="code" class="input-group-text">Root</label>
                                <select id="root" class="form-control" name="parent_cat">
                                    <option type="hidden" value="">Select Root:</option>
                                    @foreach ($roots as $ind => $root)
                                        <option class="" {{ old('root') == $ind ? 'selected' : '' }}
                                            value="{{ $ind }}">{{ $root }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>



                        <!-- One "tab" for each step in the form: -->
                        <br>

                        <br>
                        <div class="input-group mt-5 m-auto mb-3">
                            <label for="brief" class="input-group-text">Description</label>
                            <input type="text" id="brief" name="brief" required class="form-control"
                                placeholder="Category Description">
                        </div>

                        <div class="buttons" style="overflow:auto;">
                            <div style="float:right;">
                                <button id="dismiss_btn" class="btn btn-submit"
                                    data-goto="{{ isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : route('items.cats.home') }}"
                                    onclick="window.location=this.getAttribute('data-goto')" type="submit"
                                    id="submitBtn">Cancel</button>
                                <button class="btn btn-submit" type="submit" id="submitBtn">Submit</button>
                            </div>
                        </div>

                    </form>
                </fieldset>
            </div>
        </div>
        <div class="alterContext">
            <ul class="menu-items">
                <li class="context-menu-item">
                    Vew Category Items
                </li>
                <li class="context-menu-item">
                    Add New Category
                </li>
                <li class="context-menu-item">
                    Edit Category
                </li>
                <li class="context-menu-item">
                    Delete Category
                </li>
            </ul>
        </div>

    </div>

@endsection


@section('script')
    <script>
        $('.accordion-button i').click(function() {
            $(this).toggleClass('fa-folder-open fa-folder')
        })

        $('#Type').change(function() {
            if ($(this).val() == 1) {

            } else if ($(this).val() == 1) {

            }
        });
    </script>
@endsection
