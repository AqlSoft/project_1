@extends('layouts.admin')
@section('title') Accounts - Clients @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Accounts / Clients @endsection
@section('homeLinkActive') Home @endsection
@section('links')
<button class="btn btn-sm btn-primary"><a href="{{ route('clients.create') }}"><span class="btn-title">Add New Client</span><i class="fa fa-plus text-light"></i></a></button>
<button class="btn btn-sm btn-primary" title="Back To Treasuries"><a href="{{ route('sales.home') }}"><span class="btn-title">Back To Treasuries</span><i class="fa fa-home text-light"></i></a></button>
@endsection
@section('content')
<form action="{{ route('accounts.store') }}" method="POST">
</form>

<table id="data" class="table table-striped table-bordered" style="width:100%">
  <thead>
    <tr>
      <th>No</th>
      <th>Client Name</th>
      <th>Status</th>
      <th>Phone</th>
      <th>Manage</th>
    </tr>
  </thead>
  <tbody>
  @php $i = 1 @endphp
  @if(count($clients)) @foreach ($clients as $client)
    <tr>
      <td>{{ $i }}</td>
      <td><div>{{ $client->a_name }}</div><div>{{ $client->e_name }}</div></td>
      <td>{{ $client->status == 1 ? 'Active' : 'Inactive' }}</td>
      <td>{{ $client->phone }}</td>
      <td>
        <button class="btn btn-sm btn-success" ><a href="/admin/clients/view/{{ $client->id }}"><span class="btn-title">View client {{ $client->a_name }}</span><i class="fa fa-eye text-light"></i></a></button>
        <button class="btn btn-sm btn-primary" ><a href="/admin/clients/edit/{{ $client->id }}"><span class="btn-title">Edit client {{ $client->a_name }}</span><i class="fa fa-edit text-light"></i></a></button>
        <button class="btn btn-sm btn-danger"><a href="/admin/clients/delete/{{ $client->id }}"><span class="btn-title">Delete client {{ $client->a_name }}</span><i class="fa fa-trash text-light"></i></a></button>
        @if(!$client->status)
        <button class="btn btn-sm btn-primary"><a href="/admin/clients/status/{{ $client->id }}"><span class="btn-title">Activate client {{ $client->a_name }}</span><i class="fa fa-check text-light"></i></a></button>
        @endif
      </td>
    </tr>
    @php $i++ @endphp
  @endforeach @else 
    <tr>
      <td colspan="5">No clients to display <a href="{{ route('clients.create') }}">Create New Client</a> </td>
    </tr>
  @endif
  </tbody>
</table>


{{ $clients->links() }}

@endsection


@section('script')
<script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection 

