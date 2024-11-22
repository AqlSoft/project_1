@extends('layouts.admin')
@section('title') Sales - Home @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Sales @endsection
@section('homeLinkActive') Home @endsection
@section('links')
<button class="btn btn-sm btn-primary" title="Add New Treasury"><a href="{{ route('treasuries.add') }}"><span class="btn-title">Add New Treasury</span><i class="fa fa-plus text-light"></i></a></button>
<button class="btn btn-sm btn-primary" title="Back To Treasuries"><a href="{{ route('treasuries.home') }}"><span class="btn-title">Back To Treasuries</span><i class="fa fa-home text-light"></i></a></button>
@endsection
@section('content')
<div class="container">
  <div class="row">
    <div class="col col-3">
      <div class="card">
        <img src="{{ asset('assets/admin/uploads/images/transactions.webp') }}" class="card-header" alt="Sales Icon">
        <div class="card-body h1 text-center font-weight-bold" style="background-color:darkcyan; color: #fff">15248</div>
        <div class="card-footer text-center ">Contracts</div>
      </div>
    </div>

    <div class="col col-3">
      <div class="card">
        <img src="{{ asset('assets/admin/uploads/images/sales-icon.png') }}" class="card-header" alt="Sales Icon">
        <div class="card-body h1 text-center font-weight-bold" style="background-color:rgb(196, 31, 168); color: #fff">6,284,325</div>
        <div class="card-footer text-center ">Total Sales</div>
      </div>
    </div>

    <div class="col col-3">
      <div class="card">
        <img src="{{ asset('assets/admin/uploads/images/invoice.png') }}" class="card-header" alt="Sales Icon">
        <div class="card-body h1 text-center font-weight-bold" style="background-color:rgb(0, 140, 255); color: #fff">6000</div>
        <div class="card-footer text-center ">Invoices</div>
      </div>
    </div>

    <div class="col col-3">
      <div class="card">
        <img src="{{ asset('assets/admin/uploads/images/earnings.png') }}" class="card-header" alt="Sales Icon">
        <div class="card-body h1 text-center font-weight-bold" style="background-color:rgb(60, 231, 174); color: #fff">1,615,000</div>
        <div class="card-footer text-center ">Estimated Earnings</div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col col-12">

      <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary"><i class="fa fa-cogs"></i></button>
        <a href="{{ route('contracts.home') }}" class="btn btn-primary text-light font-weight-bold">العقود</a>
      </div>
    
      <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary"><i class="fa fa-cogs"></i></button>
        <a href="{{ route('items.home') }}" class="btn btn-primary text-light font-weight-bold">الأصناف</a>
      </div>
      
      <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary"><i class="fa fa-chart-line"></i></button>
        <a href="{{ route('services.home') }}" class="btn btn-primary text-light font-weight-bold">الخدمات</a>
      </div>
    
      <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary"><i class="fa fa-cogs"></i></button>
        <a href="" class="btn btn-primary text-light font-weight-bold">Invoices</a>
      </div>
    
      <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary"><i class="fa fa-cogs"></i></button>
        <a href="" class="btn btn-primary text-light font-weight-bold">Invoices</a>
      </div>

      <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary"><i class="fa fa-credit-card"></i></button>
        <a href="" class="btn btn-primary text-light font-weight-bold">hhh</a>
      </div>

      <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary"><i class="fa fa-credit-card"></i></button>
        <a href="" class="btn btn-primary text-light font-weight-bold">Clients Payment</a>
      </div>
      
      <div class="btn-group mb-3 ml-3" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary"><i class="fa fa-credit-card"></i></button>
        <a href="" class="btn btn-primary text-light font-weight-bold">Sales Setting</a>
      </div>

    </div>
  </div>
  

  
</div>
@endsection


@section('script')
<script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection 