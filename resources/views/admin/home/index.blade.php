@extends('layouts.admin')
@section('title')
    الاحصائيات
@endsection
@section('content')
    <style>

    </style>
    <div class="container pt-5">
        <div class="card mt-5">
            <div class="card-header ">
                <h4>Human Resources</h4>
            </div>
            <div class="card-body">
                <div class="dashboard-items px-4">
                    <div class="row">

                        <a href="{{ route('display-admins-list') }}" class="item-link col col-12 col-sm-6 col-lg-4">
                            <span class="item-icon">
                                <i class="fa fa-users"></i>
                            </span>
                            <span>Users List</span>
                        </a>
                        <a href="{{ route('display-roles-list') }}" class="item-link col col-12 col-sm-6 col-lg-4">
                            <span class="item-icon">
                                <i class="fas fa-network-wired"></i>
                            </span>
                            <span>Users Roles</span>
                        </a>
                        <a href="{{ route('display-permissions-list') }}" class="item-link col col-12 col-sm-6 col-lg-4">
                            <span class="item-icon">
                                <i class="fas fa-clipboard-check"></i>
                            </span>
                            <span>Permissions</span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
