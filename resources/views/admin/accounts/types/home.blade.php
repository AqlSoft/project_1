@extends('layouts.admin')
@section('title') Accounts Types @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Accounts Types @endsection
@section('homeLinkActive') Home @endsection
@section('links')

@endsection
@section('content')

    <div class="container">

        <div class="row">
            <div class="col col-8 border">
                <fieldset class="">
                    <legend>Accounts Types</legend>
                    <table class="table striped mt-4">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Control</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($types))
                            @foreach($types as $in => $type)
                                <tr>
                                    <td>{{ $in+1 }}</td>
                                    <td>{{ $type->e_name }} - {{ $type->a_name }}</td>
                                    <td><span title="{{ $type->brief }}">{{ strlen($type->brief) >= 100 ? substr($type->brief, 0, 50).'.....' : $type->brief }}</span>{{ $type->brief }}</td>
                                    <td>
                                        <a class="edit" href="javascript:;"
                                           data-id="{{ $type->id }}"
                                           data-aname="{{ $type->a_name }}"
                                           data-ename="{{ $type->e_name }}"
                                           data-brief="{{ $type->brief }}"
                                           onclick="sendData(this)">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{route('accounts.types.delete', $type->id)}}" onclick="if(!confirm('you are about to delete an item, this is one way operation, you will not be able to undo this operation, Are you sure!')) return false"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">Nod Accounts Types inserted yet!</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                </fieldset>
            </div>
            <div class="col col-4 border">
                <fieldset>
                    <legend>Add New Accounts Type</legend>
                    <form id="editForm" action="{{ route('accounts.types.store') }}" method="post" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <label for="Name">Name</label>
                            <input type="text" id="Name" name="a_name" class="form-control mb-3" placeholder="Arabic Name">
                            <input type="text" name="e_name" class="form-control" placeholder="Latin Name">
                        </div>

                        <div class="mb-3">
                            <label for="brief">Description</label>
                            <textarea id="brief" name="brief" rows="8" class="form-control mb-3" placeholder="Category Description"></textarea>
                        </div>

                        <div class="buttons">
                            <button type="reset" class="btn btn-info">Reset Form</button>
                            <button type="submit" class="btn btn-success">Submit Form</button>
                        </div>
                    </form>

                    <form id="updateForm" action="{{ route('accounts.types.update') }}" method="post" class="mt-4 d-none">
                        @csrf
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="">Name</label>
                            <input type="text" id="aName" name="a_name" class="form-control mb-3" placeholder="Arabic Name">
                            <input type="text" id="eName" name="e_name" class="form-control" placeholder="Latin Name">
                        </div>

                        <div class="mb-3">
                            <label for="brief">Description</label>
                            <textarea id="brief" name="brief" rows="8" class="form-control mb-3" placeholder="Category Description"></textarea>
                        </div>

                        <div class="buttons">
                            <button type="reset" class="btn btn-info">Reset</button>
                            <button type="button" onclick="cancelUpdate()" class="btn btn-primary">Cancel</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>

                </fieldset>
            </div>
        </div>

    </div>


@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
    <script>
         function sendData(item) {
             $('legend').html('Edit Accounts type Information')
             $('#editForm').slideUp()
             $('#updateForm').removeClass('d-none')
             $('#updateForm #id').val(item.getAttribute('data-id'))
             $('#updateForm #aName').val(item.getAttribute('data-aname'))
             $('#updateForm #eName').val(item.getAttribute('data-ename'))
             $('#updateForm #brief').val(item.getAttribute('data-brief'))
         }
         function cancelUpdate() {
             $('legend').html('Add New Accounts type')
             $('#editForm').slideDown()
             $('#updateForm').addClass('d-none')
         }
    </script>
@endsection
