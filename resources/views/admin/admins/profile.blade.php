@extends('layouts.admin')
@section('title')
    {{ $admin->userName }}
@endsection

@section('content')
    <div class="container" style="min-height: 100vh">

        @include('admin.admins.profile-top')
        <div class="card card-default">
            <div class="card-header">
                <h2>الملف الشخصى</h2>
                
            </div>
            <div class="card-body">

            </div>
        </div>
    @endsection


    @section('script')
    @endsection
