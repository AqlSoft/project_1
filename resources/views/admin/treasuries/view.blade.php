@extends('layouts.admin')
@section('title') View Treasury {{ $treasury->name }} @endsection
@section('homePage') Inventory @endsection
@section('homeLink') Treasuries @endsection
@section('homeLinkActive') View Treasury {{ $treasury->name }} @endsection
@section('links')
<button class="btn btn-sm btn-primary" title="Add New Treasury"><a href="{{ route('treasuries.edit', $treasury->id) }}"><span class="btn-title">Edit Treasury Setting</span><i class="fa fa-plus text-light"></i></a></button>
<button class="btn btn-sm btn-primary" title="Back To Treasuries"><a href="{{ route('treasuries.home') }}"><span class="btn-title">Back To Treasuries</span><i class="fa fa-home text-light"></i></a></button>
@endsection
@section('content')
<div class="direction-controlled">
  <div class="row mb-2 p-2 dark-on-hover">
    <div class="col col-2 text-right">Name: </div>
    <div class="col col-10 ">{{ $treasury->name }}</div>
  </div>

  <div class="row mb-2 p-2 dark-on-hover">
    <div class="col col-2 text-right ">Type: </div>
    <div class="col col-10 ">{{ $treasury->type == 1 ? 'The Master Treasury' : $treasury->type == 3 ? 'Point Of Sale (P.O.S)' : 'Branche Treasury' }}</div>
  </div>

  <div class="row mb-2 p-2 dark-on-hover">
    <div class="col col-2 text-right ">Status:</div>
    <div class="col col-10 ">{{ $treasury->status == 0 ? 'In-Active' : 'Active' }}</div>
  </div>

  <div class="row mb-2 p-2 dark-on-hover">
    <div class="col col-2 text-right ">Cashier:</div>
    <div class="col col-10 ">{{ $admins[$treasury->cashier] }}</div>
  </div>

  <div class="row mb-2 p-2 dark-on-hover">
    <div class="col col-2 text-right ">Created At:</div>
    <div class="col col-10 ">{{ $treasury->created_at }}, By {{ $admins[$treasury->created_by] }}</div>
  </div>

  @if ($treasury->updated_by != null)
  <div class="row mb-2 p-2 dark-on-hover">
    <div class="col col-2 text-right ">Last Update:</div>
    <div class="col col-10 ">{{ $treasury->updated_at }}, By {{$admins[$treasury->updated_by] }}</div>
  </div>
  @endif

  @if (!empty($Rules))
  <div class="row mb-2 p-2 dark-on-hover">
    <div class="col col-2  text-right ">Pull From:</div>
    <div class="col col-10 ">
      <ul>
        @foreach($Rules['push_to'] as $n => $rule)
        
        <li>
          <a href="/admin/treasuries/view/{{ $rule->treasury_id }}">{{ $treasuries[$rule->treasury_id] }}</a>
        </li>
        
        @endforeach
      </ul>
    </div>
  </div>
  @endif

  <div class="row mb-2 p-2">
    <div class="col col-2  text-right ">Push To:</div>
    <div class="col col-10 ">
      <h5>This Treasury Can Push Money To:</h5>

      @foreach($Rules['pull_from'] as $n => $rule)
      <ul>
        <li>{{ $rule->push_to . ' - ' . $treasuries[$rule->push_to] }}</li>
      </ul>
          
        
      @endforeach

      <button class="btn btn-sm btn-primary" title="Back To Treasuries" data-toggle="modal" data-target="#addSubTreagury">
        <a><span class="btn-title">Add New Sub Treasury</span><i class="fa fa-plus text-light"></i></a></button>
    </div>
  </div>
</div>



<!-- Modal -->
<form action="{{ route('treasuries.addmpr', $treasury->id) }}" method="POST">
  <div class="modal fade" id="addSubTreagury" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Sub Treasuries To {{ $treasury->name }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"> &times; </span>
          </button>
        </div>
        <div class="modal-body">
            @csrf
            <div class="input-group mb-3">
              <label for="push_to" class="input-group-text">Push Money To: </label>
              <select class="form-control" name="push_to">
                <option value="">Select Treasury</option>
                @foreach($treasuries as $id => $name)
                <option {{ $id == 1 ? 'selected' : '' }} value="{{ $id }}">{{ $name }}</option>
                @endforeach
              </select>
            </div>
            @error('push_to')
              <div class="error text-danger">{{ $message }}</div>
            @enderror
                      
            <input type="hidden" name="id" value="{{ $treasury->id }}">
            <button class="btn btn-sm btn-primary" onclick="window.location.href = '{{ route('treasuries.add') }}'" type="button">Create New treasury <i class="fa fa-plus text-light"></i></button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
</form>
  
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.viewfloatedform.js') }}"></script>
@endsection 