@extends('layouts.admin')

@section('title') Sales @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Sales / Categories @endsection
@section('homeLinkActive') Create @endsection
@section('links')
<button class="btn btn-sm btn-primary"><a href="{{ route('sales.cats.create') }}"><span class="btn-title">Add New Sales Category</span><i class="fa fa-plus text-light"></i></a></button>
<button class="btn btn-sm btn-primary"><a href="{{ route('sales.cats.home') }}"><span class="btn-title">Back To Sales Categories</span><i class="fa fa-home text-light"></i></a></button>
@endsection

@section('content')
<div class="container">
  <form action="{{route('sales.cats.store') }}" method="post">
    @csrf
    <div class="input-group">
      <label for="name" class="input-group-text">Category Name</label >
      <input type="text" value="{{ old('name') }}" class="form-control" id="name" name="name">
      <input type="submit" class=" btn btn-success" value="save">
    </div>
    @error('name')
      <div class="error text-danger">{{ $message }}</div>
    @enderror
  </form>
</div>

@endsection
@section('script')
<script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection 