@extends('layouts.admin')
@section('title') Sales - Categories @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Sales @endsection
@section('homeLinkActive') Home @endsection
@section('links')
<button class="btn btn-sm btn-primary"><a href="{{ route('sales.cats.create') }}"><span class="btn-title">Add New Sales Category</span><i class="fa fa-plus text-light"></i></a></button>
<button class="btn btn-sm btn-primary"><a href="{{ route('sales.cats.home') }}"><span class="btn-title">Back To Sales Categories</span><i class="fa fa-home text-light"></i></a></button>
@endsection
@section('content')
<div class="container">
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
          <th>Manage</th>
        </tr>
      </thead>
      <tbody>
        
      @php $i = 1 @endphp
      @if(count($cats))
      @if(isset($cats) &&!empty($cats)) @foreach ($cats as $cat)
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $cat->name }}</td>
          <td>
            <button class="btn btn-sm btn-success" ><a href="/admin/sales/cats/view/{{ $cat->id }}"><span class="btn-title">View Treasury {{ $cat->name }}</span><i class="fa fa-eye text-light"></i></a></button>
            <button class="btn btn-sm btn-primary" ><a href="/admin/sales/cats/edit/{{ $cat->id }}"><span class="btn-title">Edit Treasury {{ $cat->name }}</span><i class="fa fa-edit text-light"></i></a></button>
            <button class="btn btn-sm btn-danger"><a href="/admin/sales/cats/delete/{{ $cat->id }}"><span class="btn-title">Delete Treasury {{ $cat->name }}</span><i class="fa fa-trash text-light"></i></a></button>
            @if(!$cat->status)
            <button class="btn btn-sm btn-primary"><a href="/admin/sales/cats/status/{{ $cat->id }}"><span class="btn-title">Activate Treasury {{ $cat->name }}</span><i class="fa fa-check text-light"></i></a></button>
            @endif
          </td>
        </tr>
        @php $i++ @endphp
      @endforeach 
      @endif
      @else
      <tr>
        <td colspan="5">No data to display</td>
      </tr>
      @endif
      </tbody>
    </table>
    {{ $cats->links() }}
  </div>

</div>

@endsection


@section('script')
<script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection 