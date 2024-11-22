@extends('layouts.admin')
@section('title') Treasuries @endsection
@section('homePage') Inventory @endsection
@section('homeLink') Treasuries @endsection
@section('homeLinkActive') Create New @endsection
@section('links')
<button class="btn btn-sm btn-primary"><a href="{{ route('treasuries.home') }}" as-title="Back To Treasuries"><i class="fa fa-ban text-light"></i></a></button>
@endsection
@section('content')
<form action="{{ route('treasuries.store') }}" method="POST">
  @csrf
  <div class="row">
    <div class="col col-4">
      <div class="input-group mb-3">
        <label class="input-group-text" for="name">Name:</label>
        <input type="text" name="name" maxlength="50" class="form-control" id="name" value="{{ old('name') }}">
      </div>
    @error('name')
      <div class="error text-danger">{{ $message }}</div>
    @enderror
    </div>{{-- Column Name --}}
    <div class="col col-4">
      <div class="input-group mb-3">
        <label for="type" class="input-group-text">Type: </label>
        <select class="form-control" name="type">
          <option value="">Treasury Type</option>
          <option {{ old('type') == 2 ? 'selected' : '' }} value="2">Branche</option>
          <option {{ old('type') == 3 ? 'selected' : '' }} value="3">P.O.S</option>
        </select>
      </div>
    @error('type')
      <div class="error text-danger">{{ $message }}</div>
    @enderror
    </div>{{-- Column Is Master ? --}}
    <div class="col col-4">
      <div class="input-group mb-3">
        <label for="cashier" class="input-group-text">Cashier: </label>
        <select class="form-control" name="cashier">
          <option value="">Select Cashier</option>
          @foreach($admins as $i => $admin)
          <option {{ old('cashier') == $i ? 'selected' : '' }} value="{{ $i }}">{{ $admin }}</option>
          @endforeach
        </select>
      </div>
    @error('cashier')
      <div class="error text-danger">{{ $message }}</div>
    @enderror
    </div>{{-- Column Select Cashier ? --}}

    <div class="col col-6">
      <div class="input-group mb-3">
        <label for="parent" class="input-group-text">Push Money To: </label>
        <select class="form-control" name="parent">
          <option value="">Select Treasury</option>
          @foreach($treasuries as $id => $treasury_name)
          <option {{ old('parent') == $id ? 'selected' : '' }} value="{{ $id }}">{{ $treasury_name }}</option>
          @endforeach
        </select>
        {{ old('parent') }}
      </div>
      @error('parent')
      <div class="error text-danger">{{ $message }}</div>
      @enderror
    </div>

    <div class="col col-1">
      <button type="submit" class="btn btn-success btn-md font-weight-bold">Create New Treasury</button>
    </div>{{-- Column Submit ? --}}
  </div> {{-- Row --}}  
</form>
@endsection

{{-- oninput="this.value=this.value.replace('/^[0-9.]/g', '')" --}}