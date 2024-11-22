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
    View Client
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('clients.home') }}"><span class="btn-title">العودة إلى
                الرئيسية</span><i class="fa fa-home text-light"></i></a></button>
@endsection

@section('content')
    <div class="container pt-3">
        <fieldset>
            <legend> تصنيفات العملاء </legend>
            <br>
            <table class="w-100">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>اسم التصنيف</td>
                        <td>الوصف</td>
                        <td><i class="fa fa-cogs"></i></td>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($scopes as $index => $item)
                        <tr>
                            <td>{{ $index }}</td>
                            <td>{{ $item }}</td>
                            <td>{{ $item }}</td>
                            <td><i class="fa fa-edit text-primary"></i><i class="fa fa-trash text-danger"></i></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </fieldset>
    </div>
@endsection
@section('script')
@endsection
