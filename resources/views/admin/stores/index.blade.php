@extends('layouts.admin')
@section('header-links')
    <li class="breadcrumb-item"><a href="/admin/stores/home">Stores</a></li>
    <li class="breadcrumb-item active" aria-current="page">Home</li>
@endsection
@section('contents')
    <h1 class="mt-3 pb-2" style="border-bottom: 2px solid #dedede">Display Stores List
        <a data-bs-toggle="collapse" data-bs-target="#addItemCategoryForm" class="float-right"><i class="fa fa-plus"></i> Add
            New Store</a>
    </h1>

    <div class="row">
        <div class="col col-12 collapse" id="addItemCategoryForm">
            <div class="card card-body">
                <form action="/admin/stores/store" method="POST">
                    @csrf
                    <div class="input-group">
                        <label class="input-group-text" for="parent_store">Parent Store</label>
                        <select class="form-select" name="atore_id" id="parent_store">
                            <option value="1">Root</option>
                            @foreach ($stores as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <label class="input-group-text" for="branch">Branch</label>
                        <select class="form-select" name="branch_id" id="branch">
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text" for="store_name">Name</label>
                        <input type="text" class="form-control" name="name" id="store_name">
                        <label class="input-group-text" for="store_code">Code</label>
                        <input type="text" class="form-control" name="store_code" id="store_code">
                    </div>

                    <div class="input-group mt-2">
                        <label class="input-group-text" for="brief">Description</label>
                        <input type="text" class="form-control" name="brief" id="brief">
                    </div>

                    <div class="input-group mt-2">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" name="status" type="checkbox" value="1"
                                aria-label="Checkbox for following text input" id="status">
                        </div>
                        <label for="status" class="input-group-text text-start">Active</label>

                        <div class="input-group-text">
                            <input class="form-check-input mt-0" name="ismovable" type="checkbox" value="1"
                                aria-label="Checkbox for following text input" id="ismovable">
                        </div>
                        <label for="ismovable" class="input-group-text text-start">Is Movable</label>
                        <button type="submit" class="btn btn-outline-primary">Save Store Info</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Code</th>
                <th>Store Name</th>
                <th>Branch</th>
                <th>Admin</th>
                <th>Status</th>
                <th>Control</th>
            </tr>
        </thead>
        <tbody>
            @if (count($stores))
                @foreach ($stores as $store)
                    <tr>
                        <td>{{ $store->store_code }}</td>
                        <td>{{ $store->name }}</td>
                        <td>{{ $store->branch_id }}</td>
                        <td>{{ $store->admin }}</td>
                        <td>{{ $store->staus }}</td>
                        <td>{{ $store->code }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">No stores has beenadded yet, Add your <a class="" data-bs-toggle="collapse"
                            data-bs-target="#addNewStore">first store</a>.</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection

{{-- @extends('layouts.admin')
@section('contents')
    <h2>Settings</h2>
    <style>
        .input-group.sm label.input-group-text,
        .input-group.sm input.form-control,
        .input-group.sm select.form-control,
        .input-group.sm .form-control,
        .input-group.sm .input-group-text,
        .input-group.sm button.form-control {
            padding: 0 0.5rem;
            height: 28px;
        }
    </style>
    <div class="input-group">
        <button class="py-0 btn btn-primary">Branches
            <span class="btn text-light btn-sm" data-bs-toggle="collapse" data-bs-target="#addNewBranch"><i
                    data-bs-toggle="tooltip" data-bs-title="Add New Branch" class="fa fa-plus-square"></i></span>
        </button>
        <button class="py-0 btn btn-outline-secondary">Address</button>
        <button class="py-0 btn btn-outline-secondary">Registery</button>
    </div>
    <div id="body">
        <div class="collapse" id="addNewBranch">
            <form action="{{ route('store-new-branches') }}" method="POST">
                @csrf
                <div class="input-group sm mt-1">
                    <label class="input-group-text" for="branch_name">branch Name</label>
                    <input type="text" class="form-control" id="branch_name" name="name" autocomplete="name"
                        value="{{ old('name') }}" />
                    <label class="input-group-text" for="branch_code">Code</label>
                    <input type="text" class="form-control" id="branch_code" name="branch_code"
                        autocomplete="branch-code" value="{{ old('branch_code') }}" />
                    <label class="input-group-text" for="ismain">
                        <input type="checkbox" id="ismain" name="ismain" />
                    </label>
                    <label class="input-group-text" for="ismain">Main Branch ?</label>
                </div>
                <div class="input-group sm mt-1">
                    <label class="input-group-text" for="branch_address">Branch Address</label>
                    <input type="text" class="form-control" id="branch_address" name="address" autocomplete="address"
                        value="{{ old('address') }}" />
                </div>
                <div class="input-group sm my-1">
                    <label class="input-group-text" for="branch_phone">Phone</label>
                    <input type="text" class="form-control" id="branch_phone" name="phone" autocomplete="phone"
                        value="{{ old('phone') }}" />
                    <label class="input-group-text" for="branch_email">Email</label>
                    <input type="text" class="form-control" id="branch_email" name="email" autocomplete="email"
                        value="{{ old('email') }}" />
                </div>
                <button class="form-control btn btn-primary btn-sm" type="submit">Save Branch</button>
            </form>
        </div>
        <div class="collapse" id="editBranchInfo">
            <form action="{{ route('update-branch-info') }}" method="POST">
                @csrf
                <input type="hidden" id="branch_id" name="id" value="">
                <div class="input-group sm mt-1">
                    <label class="input-group-text" for="edit_branch_name">branch Name</label>
                    <input type="text" class="form-control" id="edit_branch_name" name="name"
                        value="{{ old('name') }}" />
                    <label class="input-group-text" for="edit_branch_code">Code</label>
                    <input type="text" class="form-control" id="edit_branch_code" name="branch_code"
                        value="{{ old('branch_code') }}" />

                </div>
                <div class="input-group sm mt-1">
                    <label class="input-group-text" for="edit_branch_address">Branch Address</label>
                    <input type="text" class="form-control" id="edit_branch_address" name="address"
                        value="{{ old('address') }}" />
                </div>
                <div class="input-group sm my-1">
                    <label class="input-group-text" for="edit_branch_phone">Phone</label>
                    <input type="text" class="form-control" id="edit_branch_phone" name="phone"
                        value="{{ old('phone') }}" />
                    <label class="input-group-text" for="edit_branch_email">Email</label>
                    <input type="text" class="form-control" id="edit_branch_email" name="email"
                        value="{{ old('email') }}" />
                </div>
                <button class="form-control btn btn-primary btn-sm" type="submit">Update Branch Info</button>
            </form>
        </div>
        <table class="table mt-3">
            <thead>
                <tr class="bg-primary">
                    <th>The Code</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Main</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody class="table-hover">
                @if (count($branches))
                    @foreach ($branches as $item)
                        <tr>
                            <td>{{ $item->branch_code }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->address }}</td>
                            <td>{{ $item->ismain === 1 ? 'Yes' : 'No' }}</td>
                            <td>
                                <button data-item="{{ $item }}" class="btn btn-sm edit-form-trigger"
                                    data-bs-toggle="collapse" data-bs-target="#editBranchInfo">
                                    <i data-bs-toggle="tooltip" data-bs-title="Tooltip on top" class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm" data-bs-toggle="collapse" data-bs-target="#editBranchInfo">
                                    <i data-bs-toggle="tooltip" data-bs-title="Tooltip on top" class="fa fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                @endif
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {

            $('.edit-form-trigger').click(function() {
                let item = $(this).data('item');
                $('#addNewBranch').slideUp(300);
                $('#editBranchInfo').slideDown(300);

                $('#branch_id').val(item.id)
                $('#edit_branch_name').val(item.name)
                $('#edit_branch_code').val(item.branch_code)
                $('#edit_branch_address').val(item.address)
                $('#edit_branch_email').val(item.email)
                $('#edit_branch_phone').val(item.phone)
            })
        })
    </script>
@endsection --}}
