@extends('layouts.admin')
@section('title') Items Categories @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Category @endsection
@section('homeLinkActive') View Category Items @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.cats.home') }}"><span class="btn-title">Gp Home</span><i class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.cats.add', $cat->parent->id) }}"><span class="btn-title">Adfd New Category</span><i class="fa fa-plus text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.setting') }}"><span class="btn-title">Settings</span><i class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')
    <style type="text/css">
        .h3 {
            font: Bold 1.1em/1.3 "Cairo SemiBold";
            color: #2e6da4;
        }
    </style>

    <div class="container">
        <fieldset>
            <legend>Category Info</legend>
            <div class="card">
                <div class="card-header">
                    <b><br>{{ $cat->parent->id != 1 ? $cat->parent->e_name.' - ' : ''}}{{ $cat->e_name }}</b>
                    <a class="float_right ml-3" href="{{ route('items.cats.edit',  $cat->id) }}"><i class="fa fa-edit"></i></a>
                    <a class="float_right ml-3"  href="{{ route('items.cats.delete',  $cat->id) }}"><i class="fa fa-trash"></i></a>
                </div>
                <div class="card-body">
                    <div class="col col-12">{{ $cat->brief }}</div>
                    <div class="col col-12">
                    @if($cat->level <= 2)
                        <div class=""><b>Child Categories:</b></div>
                        <div class="tags">
                            @if (count($cat->children))
                            @foreach($cat->children as $in => $ccat)
                            <span class="tag-item bg-gradient-light">{{ $ccat->e_name }} <a href="{{ route('items.cats.view', $ccat->id) }}"><i class="fa fa-eye"></i></a></span>
                            @endforeach
                            @endif
                                <span class="tag-item bg-gradient-light"><a href="{{ route('items.cats.add', $cat->id) }}"><i class="fa fa-plus"></i></a></span>
                        </div>
                        @else
                            <div class=""><b>Related Products:</b></div>
                            <div class="tags">
                                @if (count($cat->children))
                                    <div class="row">
                                    @foreach($cat->children as $in => $cItem)
                                        <div class="col col-6 product" style="height: 150px;">
                                            <div class="product-image" style="width: 150px; display: inline-block;">
                                                <img src="{{ asset('assets/admin/uploads/images/'.$cItem->profileImage) }}" alt="">
                                            </div>
                                            <div style="display: inline-block">
                                                <div class="h3">{{ $cItem->e_name }}</div>
                                                <p class="">{{ $cItem->brief }}</p>
                                            </div>
                                            <div style="width: 10%; display: inline-block">
                                                <a href="{{ route('item.view', $cItem->id) }}"><i class="fa fa-eye"></i></a>
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                @endif
                                <span class="tag-item bg-gradient-light"><a href="{{ route('items.create', $cat->id) }}"><i class="fa fa-plus"></i></a></span>
                            </div>
                    @endif
                    </div>
                </div>
            </div>
        </fieldset>
    </div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection
