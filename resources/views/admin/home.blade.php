@extends('layouts.admin')
@section('title', 'Dashboard')


@section('contents')
    <style>
        #dashboard .card a span.link-item {
            color: #474747;
            font: normal 1rem / 1.2 'Cairo';
            text-decoration: none;
            font-weight: bold;
        }
    </style>
    <div class="row" id="dashboard">
        <div class="col-lg-9">
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title">General Setting</h5>
                </div>
                <div class="card-body">
                    <div class="row" style="justify-content: space-between">
                        <div class="col col-3">
                            <a id="branches" class="dashboard-item" href="/admin/branches/home">
                                <i class="fa fa-code-branch fs-3"></i>
                                <span class="link-item">Branches</span>
                            </a>
                        </div>
                        <div class="col col-3">
                            <a id="branches" class="dashboard-item" href="/admin/branches/home">
                                <i class="fa fa-code-branch fs-3"></i>
                                <span class="link-item">Branches</span>
                            </a>
                        </div>
                        <div class="col col-3">
                            <a id="branches" class="dashboard-item" href="/admin/branches/home">
                                <i class="fa fa-code-branch fs-3"></i>
                                <span class="link-item">Branches</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title">Card 2 title</h5>
                </div>
                <div class="card-body">

                    <p class="card-text">
                        Some quick example text to build on the card title and make up the bulk of the card's
                        content.
                    </p>
                </div>

            </div>{{-- /.card --}}
        </div>

    </div>
    {{-- /.row --}}
@endsection
