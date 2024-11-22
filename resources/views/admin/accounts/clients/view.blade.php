@extends('layouts.admin')

@section('title') Clients - Create @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Accounts / Clients @endsection
@section('homeLinkActive') View Client @endsection
@section('links')
<button class="btn btn-sm btn-primary"><a href="{{ route('clients.home') }}"><span class="btn-title">Back To Clients</span><i class="fa fa-home text-light"></i></a></button>
<button class="btn btn-sm btn-primary"><a href="{{ route('clients.delete', $client->id) }}"><span class="btn-title">Remove Client</span><i class="fa fa-trash text-light"></i></a></button>
<button class="btn btn-sm btn-primary"><a href="{{ route('clients.edit', $client->id) }}"><span class="btn-title">Edit Client Info</span><i class="fa fa-edit text-light"></i></a></button>
@endsection

@section('content')

<div class="container">

    {{$client}}
</div>

@endsection
@section('script')
{{-- <script type="text/javascript" src="{{ asset('assets/admin/js/accounts/countries.js') }}"></script> --}}
@endsection
