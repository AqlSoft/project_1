@extends('layouts.admin')
@section('title') الخدمات @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') الخدمات @endsection
@section('homeLinkActive') الريئسية @endsection
@section('links')
<button class="btn btn-sm btn-primary" title="Add New Treasury"><a href="{{ route('services.create') }}"><span class="btn-title">Add New Treasury</span><i class="fa fa-plus text-light"></i></a></button>
<button class="btn btn-sm btn-primary" title="Back To Treasuries"><a href="{{ route('treasuries.home') }}"><span class="btn-title">Back To Treasuries</span><i class="fa fa-home text-light"></i></a></button>
@endsection
@section('content')
<div class="container">
  <div class="row">

    <table dir="rtl" class="striped" style="width: 100%">
      <thead>
      <tr class="text-center">
          <th>م</th>
          <th >اسم الخدمة</th>
          <th >الوصف</th>
          <th>السعر</th>
          <th>أدوات التحكم</th>
      </tr>
      </thead>
      <tbody>
      @if (count($services)) @foreach($services as $si => $service)@php $si++@endphp

          <tr>
              <td>{{ $si}}</td>
              <td>{{ $service->name }}</td>
              <td>{{ $service->brief }}</td>
              <td>{{ $service->price }}</td>
              <td>
                  <a href="{{route('clients.edit', $service->id)}}"><i class="fa fa-eye"></i></a>
                  <a href="{{route('clients.edit', $service->id)}}"><i class="fa fa-edit"></i></a>
                  <a href="{{route('contracts.create', $service->id)}}"><i class="fa fa-plus"></i></a>
                  
                  <a href="{{route('clients.delete', $service->id)}}"><i class="fa fa-trash"></i></a>
              </td>
          </tr>

      @endforeach
      @else
          <tr>
              <td colspan="7">لا يوجد خدمات بعد، قم بإضافة <a href="{{ route('services.create') }}">أول خدمة لك</a></td>
          </tr>
      @endif
      </tbody>
    </table>
    {{ $services->links() }}

    </div>
  </div>
  

  
</div>
@endsection


@section('script')
<script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection 