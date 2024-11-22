@extends('layouts.admin')
@section('title') Store - Settings @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Store @endsection
@section('homeLinkActive') Settinges @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('store.create') }}"><span class="btn-title">Add New Repository</span><i class="fa fa-plus text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('store.settings') }}"><span class="btn-title">Stores Settings</span><i class="fa fa-home text-light"></i></a></button>
@endsection
@section('content')
    <div class="container">
        <div class="row pt-5"  >
            <div class="col col-3">
                <div class="card">
                    <img src="{{ asset('assets/admin/uploads/images/StoreItems.png') }}" class="card-header" alt="Sales Icon">
                    <div class="card-body h1 text-center font-weight-bold" style="background-color:darkcyan; color: #fff">15248</div>
                    <div class="card-footer text-center ">All Store Items</div>
                </div>
            </div>

            <div class="col col-3">
                <div class="card">
                    <img src="{{ asset('assets/admin/uploads/images/StoreIcon2.png') }}" class="card-header" alt="Sales Icon">
                    <div class="card-body h1 text-center font-weight-bold" style="background-color:rgb(196, 31, 168); color: #fff">6,284,325</div>
                    <div class="card-footer text-center ">Total Items-Out Movements</div>
                </div>
            </div>

            <div class="col col-3">
                <div class="card">
                    <img src="{{ asset('assets/admin/uploads/images/temp-icon.png') }}" class="card-header" alt="Sales Icon">
                    <div class="card-body h1 text-center font-weight-bold" style="background-color:rgb(0, 140, 255); color: #fff">6000</div>
                    <div class="card-footer text-center ">Delivery Notes</div>
                </div>
            </div>

            <div class="col col-3">
                <div class="card">
                    <img src="{{ asset('assets/admin/uploads/images/inspection_campaigns.png') }}" class="card-header" alt="Sales Icon">
                    <div class="card-body h1 text-center font-weight-bold" style="background-color:rgb(60, 231, 174); color: #fff">1,615,000</div>
                    <div class="card-footer text-center ">inspection campaigns</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col col-12">

                <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary"><i class="fa fa-cogs"></i></button>
                    <a href="{{ route('sales.invoice.home') }}" class="btn btn-primary text-light font-weight-bold">Inventory System</a>
                </div>

                <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary"><i class="fa fa-cogs"></i></button>
                    <a href="" class="btn btn-primary text-light font-weight-bold">Reverse Invoices</a>
                </div>

                <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary"><i class="fa fa-chart-line"></i></button>
                    <a href="" class="btn btn-primary text-light font-weight-bold">Sore Admin Templates</a>
                </div>

                <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary"><i class="fa fa-cogs"></i></button>
                    <a href="" class="btn btn-primary text-light font-weight-bold">Stores Actions</a>
                </div>

                <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary"><i class="fa fa-credit-card"></i></button>
                    <a href="" class="btn btn-primary text-light font-weight-bold">Create New Store</a>
                </div>

                <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary"><i class="fa fa-cogs"></i></button>
                    <a href="" class="btn btn-primary text-light font-weight-bold">Stores Document Control</a>
                </div>

                <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary"><i class="fa fa-credit-card"></i></button>
                    <a href="" class="btn btn-primary text-light font-weight-bold">Inventory Actions</a>
                </div>

                <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary"><i class="fa fa-credit-card"></i></button>
                    <a href="" class="btn btn-primary text-light font-weight-bold">Stores Reports</a>
                </div>

            </div>
        </div>



    </div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection
