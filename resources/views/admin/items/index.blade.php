@extends('layouts.admin')
@section('header-links')
    <li class="breadcrumb-item"><a href="/admin/items/home">Items</a></li>
    <li class="breadcrumb-item active" aria-current="page">Home</li>
@endsection
@section('contents')
    <h1 class="mt-3 pb-2" style="border-bottom: 2px solid #dedede">Items Home

        <a class="btn btn-sm btn-outline-primary ms-3" data-bs-toggle="collapse" data-bs-target="#addItemCategoryForm"
            aria-expanded="false" aria-controls="addItemCategoryForm"><i class="fa fa-folder-plus"></i></a>
        <a class="btn btn-sm btn-outline-primary"><i class="fa fa-square-plus"></i></a>
    </h1>


    <div class="row">
        <div class="col col-12 collapse" id="addItemCategoryForm">
            <div class="card card-body">
                <form action="/admin/items/categories/store" method="POST">
                    @csrf
                    <div class="input-group">
                        <label class="input-group-text" for="parent_cat">Parent Category</label>
                        <select class="form-select" name="parent" id="parent_cat">
                            <option value="1">Root</option>
                            @foreach ($cats as $cat)
                                @if ($cat->id === 1)
                                    @continue
                                @endif
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @foreach ($cat->children as $cc)
                                    <option value="{{ $cc->id }}">{{ $cat->name }} - {{ $cc->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                        <label class="input-group-text" for="cat_name">Name</label>
                        <input type="text" class="form-control" name="name" id="cat_name">
                    </div>

                    <div class="input-group  mt-2">
                        <label class="input-group-text" for="brief">Description</label>
                        <input type="text" class="form-control" name="brief" id="brief">
                    </div>

                    <div class="input-group mt-2">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" name="status" type="checkbox" value="1"
                                aria-label="Checkbox for following text input">
                        </div>
                        <button type="button" class="input-group-text text-start">Active</button>
                        <button type="submit" class="form-control btn btn-outline-primary">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-3">Root
            <ul>
                @foreach ($cats as $item)
                    @if ($item->id === 1)
                        @continue
                    @endif
                    <li>{{ $item->name }}</li>
                    @if ($item->children)
                        <ul>
                            @foreach ($item->children as $child)
                                <li>{{ $child->name }}</li>
                                @if ($child->children)
                                    <ul>
                                        @foreach ($child->children as $grandchild)
                                            <li>{{ $grandchild->name }}
                                                <i class="fa fa-ellipsis-vertical"></i>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="col col-9">Products</div>
    </div>
@endsection
