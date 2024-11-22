@extends('layouts.admin')
@section('title') Sales - Add Invoice @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Sales / Invoices @endsection
@section('homeLinkActive') Create @endsection
@section('links')
<button class="btn btn-sm btn-primary"><a href="{{ route('sales.invoice.create') }}"><span class="btn-title">Add New Invoice</span><i class="fa fa-plus text-light"></i></a></button>
<button class="btn btn-sm btn-primary" title="Back To Treasuries"><a href="{{ route('sales.home') }}"><span class="btn-title">Back To Treasuries</span><i class="fa fa-home text-light"></i></a></button>
@endsection
@section('content')
<div class="container">
  <div class="row">
    <div class="col col-md-6 col-sm-12">
      <div class="card">
        <div class="card-header">Client</div>
      </div>
    </div>

    <div class="col col-md-6 col-sm-12">
      <div class="card">
        <div class="card-header">Client</div>
      </div>
    </div>
  </div>
</div>

{{ $invoiceNumber }}
@endsection


@section('script')
<script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection 