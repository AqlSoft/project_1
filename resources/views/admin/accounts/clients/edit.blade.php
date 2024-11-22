@extends('layouts.admin')

@section('title')
    Clients - Create
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    Accounts / Clients
@endsection
@section('homeLinkActive')
    Create
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('clients.home') }}"><span class="btn-title">Back To Sales
                Categories</span><i class="fa fa-home text-light"></i></a></button>
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('clients.store') }}" method="post">
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="fs-2">Main Information</div>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <label for="a_name" class="input-group-text">Arabic Name</label>
                        <input type="text" value="{{ $client->a_name }}" placeholder="Arabic Name" class="form-control"
                            id="a_name" name="a_name">
                    </div>
                    <div class="input-group">
                        <label for="a_name" class="input-group-text">Latin Name</label>
                        <input type="text" value="{{ $client->e_name }}" placeholder="Latin Name" class="form-control"
                            id="e_name" name="e_name">
                    </div>
                </div>
                <div class="card-footer">*
                    @error('a_name')
                        <div class="text-danger">Arabic Name:</div>
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                    @error('e_name')
                        <div class="text-danger">LatinName:</div>
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="fs-2">Address</div>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <label for="country" class="input-group-text">Country</label>
                        <select name="country" id="country" class="form-control">
                            <option> Select Country </option>
                            @foreach ($countries as $index => $country)
                                <option
                                    {{ $client->address != null && is_array($client->address) ? ($client->address['country'] == $country->id ? 'selected' : '') : '' }}
                                    value="{{ $country->id }}"> {{ $country->id }} - {{ $country->e_name }} -
                                    {{ $country->iso }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <label for="state" class="input-group-text">State</label>
                        <input type="text"
                            value="{{ isset($client->address['state']) ? $client->address['state'] : '' }}"
                            class="form-control" placeholder="State / Region" id="State" name="state">
                        <label for="city" class="input-group-text">City</label>
                        <input type="text" class="form-control" placeholder="City Name" id="city" name="city">
                    </div>
                    <div class="input-group mb-3">
                        <label for="street" class="input-group-text">Full Detailed Address</label>
                        <input type="text"
                            value="{{ $client->address != null && is_array($client->address) ? $client->address['street'] : '' }}"
                            class="form-control" placeholder="The detailed address" id="street" name="street">
                    </div>
                    <div class="input-group mb-3">
                        <label for="mail_box" class="input-group-text">Mail Box Number</label>
                        <input type="text" value="{{ old('mail_box') }}" class="form-control" id="street"
                            name="street" placeholder="12345">
                        <label for="postal_code" class="input-group-text">Postal Code</label>
                        <input type="text" value="{{ old('postal_code') }}" class="form-control" id="postal_code"
                            name="postal_code">
                    </div>
                </div>
                <div class="card-footer">*
                    @error('country')
                        <div class="text-danger">Country Errors:</div>
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="fs-2">Contact Info kkkk</div>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <label for="phone" class="input-group-text">Phone:</label>
                        <input type="text" value="{{ old('phone') }}" class="form-control" placeholder="Phone"
                            id="phone" name="phone">
                        <label for="phone" class="input-group-text">FAX:</label>
                        <input type="text" value="{{ old('fax') }}" class="form-control" placeholder="FAX Number"
                            id="fax" name="fax">
                        <label for="phone" class="input-group-text">Mobile:</label>
                        <input type="text" value="{{ old('mobile') }}" class="form-control"
                            placeholder="Mobile Number" id="mobile" name="mobile">
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" value="{{ $client->email }}" class="form-control" placeholder="Email"
                            id="email" name="email">
                        <input type="url" value="{{ $client->website }}" class="form-control" placeholder="Website"
                            id="website" name="website">
                    </div>
                </div>
                <div class="card-footer">*
                    @error('phone')
                        <div class="text-danger">Phone:</div>
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror

                    @error('fax')
                        <div class="text-danger">FAX:</div>
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                    @error('mobile')
                        <div class="text-danger">Mob ile:</div>
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>



            <div class="input-group mb-3">
                <label for="name" class="input-group-text">Registry</label>
                <input type="text" value="{{ old('s_number') }}" class="form-control" placeholder="Serial Number"
                    id="s_number" name="s_number">
                <input type="text" value="{{ old('vat') }}" class="form-control"
                    placeholder="Valued Amoount Tax Number" id="vat" name="vat">
                <input type="text" value="{{ old('cr') }}" class="form-control"
                    placeholder="Commercial Registry" id="cr" name="cr">
            </div>

            <input type="submit" value="Save Client" class="btn btn-primary" placeholder="The detailed address"
                id="street" name="street">



        </form>
    </div>
@endsection
@section('script')
    {{-- <script type="text/javascript" src="{{ asset('assets/admin/js/accounts/countries.js') }}"></script> --}}
@endsection
