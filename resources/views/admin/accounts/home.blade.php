@extends('layouts.admin')
@section('title')
    Accounts
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    Accounts
@endsection
@section('homeLinkActive')
    Home
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('accounts.create', 1) }}"><span class="btn-title">add
                item</span><i class="fa fa-plus text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('accounts.setting') }}"><span class="btn-title">Settings</span><i
                class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')
    <div class="container">

        <div class="row">
            <div class="col col-4 border">
                <fieldset class="">
                    <legend>
                        Root Account
                        <button class="form-trigger" data-target="#addRoot" {{-- route('accounts.create', 0) --}}>
                            <i class="fa fa-plus"></i></button>
                    </legend>
                    <div class="accordion" id="rootLevel" style="position:relative;">
                        <div class="vLine" style="top: -16px; bottom: 10px"></div>
                        @foreach ($roots as $i => $root)
                            <div class="accordion-item">
                                <div class="accordion-header">
                                    <span class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#root{{ $root->code }}" aria-expanded="true"
                                        aria-controls="root{{ $root->code }}">
                                        &#8211;<i class="fa fa-folder"></i></span>&#8211;<span data-id="{{ $root->id }}"
                                        data-level="{{ $root->level }}"
                                        class="ml-2 parent catItem">{{ $root->e_name }}</span>
                                </div>
                                <div id="root{{ $root->code }}" class="accordion-collapse collapse"
                                    data-bs-parent="#rootLevel">
                                    <div class="accordion-body">
                                        <div class="vLine" style="left: 19px"></div>
                                        {{--                                Level 2 --}}
                                        <div class="accordion" style="margin-left: 20px;" id="catsLevel">
                                            @foreach ($root->cats as $ii => $cat)
                                                <div class="accordion-item">
                                                    <div class="accordion-header">
                                                        <span class="accordion-button" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#cat{{ $cat->code }}" aria-expanded="true"
                                                            aria-controls="cat{{ $cat->code }}">
                                                            &#8211;<i class="fa fa-folder"></i></span>&#8211;<span
                                                            data-id="{{ $cat->id }}" data-level="{{ $cat->level }}"
                                                            class="ml-2 parent catItem">{{ $cat->e_name }}</span>
                                                    </div>
                                                    <div id="cat{{ $cat->code }}" class="accordion-collapse collapse"
                                                        data-bs-parent="#catsLevel">
                                                        <div class="accordion-body">
                                                            <div class="vLine" style="left: 16px"></div>
                                                            @foreach ($cat->children as $iii => $child)
                                                                <div class="ml-3 accordion-header">
                                                                    &#8212;<span data-id="{{ $child->id }}"
                                                                        data-level="{{ $child->level }}"
                                                                        class="ml-2 child catItem">{{ $child->e_name }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </fieldset>
            </div>
            <div class="col col-8 border">
                <fieldset>
                    <legend>Sub categories and products</legend>

                    <div id="forms">
                        <div class="form-container" id="addRoot">
                            <h3>Add Root</h3>
                            <form class="p-3" id="regForm" action="{{ route('accounts.store') }}" method="post">
                                @csrf
                                <div class="input-group mt-5">
                                    <label for="a_name" class="input-group-text">Account Name</label>
                                    <input type="text" id="a_name" name="a_name" required class="form-control"
                                        placeholder="Arabic Name">
                                    <input type="text" id="e_name" name="e_name" required class="form-control"
                                        placeholder="Latin Name">
                                </div>
                                <div class="input-group mt-3">
                                    <label for="parent_cat" class="input-group-text">Account Type</label>
                                    <select id="type" class="form-control" name="type">
                                        <option type="hidden" value="">Select Type:</option>
                                        @foreach ($types as $in => $type)
                                            <option class="" {{ old('type') == $in ? 'selected' : '' }}
                                                value="{{ $in }}">{{ $type }}</option>
                                        @endforeach
                                    </select>

                                    <label for="code" class="input-group-text">Root Type</label>
                                    <select id="root" class="form-control" name="root_type">
                                        <option type="hidden" value="">Select Root:</option>
                                        @foreach ($rootsTypes as $ind => $root)
                                            <option class="" {{ old('root') == $ind ? 'selected' : '' }}
                                                value="{{ $ind }}">{{ $root[0] }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <label class="mt-3">Show In Financial Reports</label>
                                <div class="input-group mt-3 mb-3">
                                    <span class="form-control"><input type="checkbox" name="fin_report[]"
                                            value="1">Financial Statement</span>
                                    <span class="form-control"><input type="checkbox" name="fin_report[]"
                                            value="2">Income Statement</span>
                                </div>
                                <div class="input-group mt-3 mb-3">
                                    <span class="form-control"><input type="checkbox" name="fin_report[]"
                                            value="3">Equity Statement</span>
                                    <span class="form-control"><input type="checkbox" name="fin_report[]"
                                            value="4">Cash Flow Statement</span>
                                </div>


                                <div class="input-group mt-3 mb-3">
                                    <label for="brief" class="input-group-text">Description</label>
                                    <input type="text" id="brief" name="brief" required class="form-control"
                                        placeholder="Category Description">
                                </div>

                                <div class="buttons" style="overflow:auto;">
                                    <div style="float:right;">
                                        <button id="dismiss_btn" class="btn btn-submit"
                                            data-goto="{{ isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : route('accounts.home') }}"
                                            onclick="window.location=this.getAttribute('data-goto')" type="submit"
                                            id="submitBtn">Cancel</button>
                                        <button class="btn btn-submit" type="submit" id="submitBtn">Submit</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                        <div class="form-container" id="addHelper">
                            <h3>Add Helper</h3>
                        </div>
                        <div class="form-container" id="addAccount">
                            <h3>Add Account</h3>
                        </div>
                        <div class="form-container" id="home">
                            <h3>Home Division</h3>
                            Welcome to accounts page
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

    </div>
    <div class="alterContext">
        <ul class="menu-items">
            <li class="context-menu-item">
                <a id="addLink" data-target="" class="addRoot" data-add-item="{{ route('accounts.create', 1) }}"
                    data-url="{{ route('accounts.create', 000) }}" href="">Add New Category</a>
            </li>
            <li class="context-menu-item">
                <a id="editLink" class="editRoot" data-url="{{ route('accounts.edit', 000) }}" href="">Edit
                    Category</a>
            </li>
            <li class="context-menu-item">
                <a id="deleteLink" data-url="{{ route('accounts.delete', 000) }}" href="">Delete Category</a>
            </li>
        </ul>
    </div>
@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
    <script>
        window.onload = function() {
            $('#forms .form-container').css('display', 'none')
            $('#forms #home').slideDown(400)


            $('.form-trigger').click(() => {
                $('#forms .form-container').slideUp(100)
                console.log($('.form-trigger').attr('data-target'))
                $($('.form-trigger').attr('data-target')).slideDown(400)
            })
        }
    </script>
@endsection
