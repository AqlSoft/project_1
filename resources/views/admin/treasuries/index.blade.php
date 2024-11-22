@extends('layouts.admin')
@section('title') Treasuries @endsection
@section('homePage') Inventory @endsection
@section('homeLink') Treasuries @endsection
@section('homeLinkActive') Home @endsection
@section('links')
<button class="btn btn-sm btn-primary" title="Add New Treasury"><a href="{{ route('treasuries.add') }}"><span class="btn-title">Add New Treasury</span><i class="fa fa-plus text-light"></i></a></button>
<button class="btn btn-sm btn-primary" title="Back To Treasuries"><a href="{{ route('treasuries.home') }}"><span class="btn-title">Back To Treasuries</span><i class="fa fa-home text-light"></i></a></button>
@endsection
@section('content')
<div class="search">
  <form method="POST">
    <div class="row mb-3">
      <div class="col col-5">
        <div class="input-group">
          <label for="aj_search" class="input-group-text"><i class="fa fa-search"></i></label>
          <input type="text" data-search-token="{{ csrf_token() }}" data-search-url="{{ route('treasuries.aj') }}" class="form-control" name="search" id="aj_search">
        </div>
      </div>
    </div>
  </form>
</div>
<div id="data_show">
  <table id="data" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th>No</th>
        <th>Name</th>
        <th>Type</th>
        <th>Cashier</th>
        <th>Manage</th>
      </tr>
    </thead>
    <tbody>
    @if(isset($treasuries)&&!empty($treasuries)) @foreach ($treasuries as $id => $treasury)
      <tr>
        <td>{{ $treasury->id }}</td>
        <td>{{ $treasury->name }}</td>
        <td>{{ $treasury->type == 1 ? 'Master' : 'Branche' }}</td>
        <td>{{ $admins[$treasury->cashier] }}</td>
        <td>
          <button class="btn btn-sm btn-success" ><a href="/admin/treasuries/view/{{ $treasury->id }}"><span class="btn-title">View Treasury {{ $treasury->name }}</span><i class="fa fa-eye text-light"></i></a></button>
          <button class="btn btn-sm btn-primary" ><a href="/admin/treasuries/edit/{{ $treasury->id }}"><span class="btn-title">Edit Treasury {{ $treasury->name }}</span><i class="fa fa-edit text-light"></i></a></button>
          <button class="btn btn-sm btn-danger"><a href="/admin/treasuries/delete/{{ $treasury->id }}"><span class="btn-title">Delete Treasury {{ $treasury->name }}</span><i class="fa fa-trash text-light"></i></a></button>
          @if(!$treasury->status)
          <button class="btn btn-sm btn-primary"><a href="/admin/treasuries/status/{{ $treasury->id }}"><span class="btn-title">Activate Treasury {{ $treasury->name }}</span><i class="fa fa-check text-light"></i></a></button>
          @endif
        </td>
      </tr>

    @endforeach @endif
    </tbody>
  </table>
  {{ $treasuries->links() }}
</div>



@endsection


@section('script')
<script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection
