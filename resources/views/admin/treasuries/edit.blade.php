@extends('layouts.admin')
@section('title') Treasuries @endsection
@section('homePage') Inventory @endsection
@section('homeLink') Treasuries @endsection
@section('homeLinkActive') Settings @endsection
@section('links')
<button class="btn btn-sm btn-primary"><a href="{{ route('treasuries.home')}}" as-title="Back To Treasuries"><i class="fa fa-ban text-light"></i></a></button>
@endsection
@section('content')


<form action="{{ route('treasuries.update', $treasury->id) }}" method="post">
  @csrf

  @error('success')
    <div class="success text-success">{{ $message }}</div>
  @enderror


  <input type="hidden" name="id" value="{{ $treasury->id }}">
  <div class="row" style="width: 50%">
    <div class="col col-12">
      <div class="input-group mb-3">
        <label class="input-group-text" for="name">Treasury Name</label>
        <input type="text" name="name" class="form-control" id="name" value="{{ $treasury->name }}">
      </div>
    @error('name')
      <div class="error text-danger">{{ $message }}</div>
    @enderror
    </div>{{-- Column Name --}}
    <div class="col col-12">
      {{ $treasury->type }}
      <div class="input-group mb-3">
        <label for="type" class="input-group-text">Treasury Type is: </label>
        <select class="form-control" name="type">
          <option value="">Treasury Type</option>
          <option {{ $treasury->type == 2 ? 'selected' : '' }} value="2">Branche</option>
          <option {{ $treasury->type == 3 ? 'selected' : '' }} value="3">P.O.S</option>
        </select>
      </div>
    @error('type')
      <div class="error text-danger">{{ $message }}</div>
    @enderror
    </div>{{-- Column Is Master ? --}}

    <div class="col col-12">
      {{ $treasury->status }}
      <div class="input-group mb-3">
        <label for="status" class="input-group-text">Treasury Status is: </label>
        <select class="form-control" name="status">
          <option value="">Treasury Type</option>
          <option {{ $treasury->status == 1 ? 'selected' : '' }} value="1">Active</option>
          <option {{ $treasury->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
        </select>
      </div>
    @error('status')
      <div class="error text-danger">{{ $message }}</div>
    @enderror
    </div>{{--  --}}

    <div class="col col-12">
      <div class="input-group mb-3">
        <label for="cashier" class="input-group-text">Treasury Cashier is: </label>
        <select class="form-control" name="cashier">
          <option value="">Select Cashier</option>
          @foreach($admins as $i => $admin)
          <option {{ $treasury->cashier == $i ? 'selected' : '' }} value="{{ $i }}">{{ $admin }}</option>
          @endforeach
        </select>
      </div>
    @error('cashier')
      <div class="error text-danger">{{ $message }}</div>
    @enderror
    
    </div>{{-- Column Select Cashier ? --}}
    <div class="col col-12">
      <button type="submit" class="btn btn-success btn-sm">Update</button>
    </div>{{-- Column Submit ? --}}
  </div> {{-- Row --}}  
</form>

@endsection


{{-- oninput="this.value=this.value.replace('/^[0-9.]/g', '')" --}}