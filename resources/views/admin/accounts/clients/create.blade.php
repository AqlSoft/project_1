@extends('layouts.admin')

@section('title') Clients - Create @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Accounts / Clients @endsection
@section('homeLinkActive') Create @endsection
@section('links')
<button class="btn btn-sm btn-primary"><a href="{{ route('clients.home') }}"><span class="btn-title">Back To Sales Categories</span><i class="fa fa-home text-light"></i></a></button>
@endsection

@section('content')

<div class="container">
  <form action="{{route('clients.store') }}" method="post">
    @csrf
    <div class="input-group mb-3">
      <label for="a_name" class="input-group-text">Client Name</label >
      <input type="text" value="{{ old('a_name') }}" placeholder="Arabic Name" class="form-control" id="a_name" name="a_name">
      <input type="text" value="{{ old('e_name') }}" placeholder="Latin Name" class="form-control" id="e_name" name="e_name">
    </div>
    @error('a_name')
      <div class="error text-danger">{{ $message }}</div>
    @enderror
    @error('e_name')
      <div class="error text-danger">{{ $message }}</div>
    @enderror

    <div class="input-group mb-3">
      <label for="phone" class="input-group-text">Contact Info</label >
      <select name="country_code" id="country" class="form-select">
        <option>Select Code</option>
      @foreach($countries as $id => $country)
      <option value="{{ $country->id }}" > {{ $country->e_name . ' - ' . $country->code  }} </option>
      @endforeach
      </select>
      {{-- <input type="text" value="{{ old('phone') }}" class="form-control" placeholder="Phone" id="phone" name="phone"> --}}
      <input type="text" value="{{ old('fax') }}" class="form-control" placeholder="FAX Number" id="fax" name="fax">
      <input type="text" value="{{ old('mobile') }}" class="form-control" placeholder="Mobile Number" id="mobile" name="mobile">
    </div>
    <div class="input-group mb-3">
      <input type="email" value="{{ old('email') }}" class="form-control" placeholder="Email" id="email" name="email">
      <input type="url" value="{{ old('website') }}" class="form-control" placeholder="Website" id="website" name="website">
    </div>

    <div class="input-group mb-3">
      <label for="country" class="input-group-text">Address</label >
      <select name="country" id="country" class="form-select">
        <option> Select Country </option>
      @foreach($countries as $index => $country)
        <option value="{{ $country->id }}" > {{ $country->e_name}} - {{ $country->iso }} </option>
      @endforeach
      </select>
      <input type="text" value="{{ old('state') }}" class="form-control" placeholder="State / Region" id="State" name="state">
      <input type="text" value="{{ old('city') }}" class="form-control" placeholder="City Name" id="city" name="city">
    </div>
    @error('country')
      <div class="error text-danger">{{ $message }}</div>
    @enderror
    <div class="input-group mb-3">
      <input type="text" value="{{ old('street') }}" class="form-control" placeholder="The detailed address" id="street" name="street">
    </div>
    <div class="input-group mb-3">
      <label for="mail_box" class="input-group-text">Mail Box Number</label >
      <input type="text" value="{{ old('mail_box') }}" class="form-control" id="street" name="street">
      <label for="postal_code" class="input-group-text">Postal Code</label >
        <input type="text" value="{{ old('postal_code') }}" class="form-control" id="postal_code" name="postal_code">
    </div>

    <div class="input-group mb-3">
      <label for="name" class="input-group-text">Registry</label >
      <input type="text" value="{{ $lastClient->s_number +1}}" class="form-control" placeholder="Serial Number" id="s_number" name="s_number">
      <input type="text" value="{{ old('vat') }}" class="form-control" placeholder="Valued Amoount Tax Number" id="vat" name="vat">
      <input type="text" value="{{ old('cr') }}" class="form-control" placeholder="Commercial Registry" id="cr" name="cr">
    </div>

      {{ $lastClient->s_number }}

    <input type="submit" value="Save Client" class="btn btn-primary" placeholder="The detailed address" id="street" name="street">



  </form>
</div>

@endsection
@section('script')
{{-- <script type="text/javascript" src="{{ asset('assets/admin/js/accounts/countries.js') }}"></script> --}}
@endsection
