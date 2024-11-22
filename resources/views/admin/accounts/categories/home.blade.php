@extends('layouts.admin')
@section('title') Items Categories @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Items Categories @endsection
@section('homeLinkActive') Home @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('accounts.cats.home', 1) }}"><span class="btn-title">Go Home</span><i class="fa fa-home text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('accounts.setting') }}"><span class="btn-title">Settings</span><i class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')

    <div class="container">

        <fieldset>
            <legend>Add New category</legend>
            <form id="editForm" action="{{ route('accounts.cats.store') }}" method="post" class="row mt-4">
                @csrf
                <div class="col col-6 mb-3">
                    <label for="Name">Name</label>
                    <input type="text" id="Name" name="a_name" class="form-control mb-3" placeholder="Arabic Name">
                    <input type="text" name="e_name" class="form-control" placeholder="Latin Name">
                </div>

                <div class=" col col-6 mb-3">
                    <label for="brief">Description</label>
                    <textarea id="brief" name="brief" class="form-control mb-3" placeholder="Category Description"></textarea>
                </div>

                <div class="col col-12 buttons">
                    <button type="reset" class="btn btn-info">Reset Form</button>
                    <button type="submit" class="btn btn-success">Submit Form</button>
                </div>
            </form>

            <form id="updateForm" action="{{ route('accounts.cats.update') }}" method="post" class="mt-4 d-none row">
                @csrf
                <input type="hidden" id="id" name="id">
                <div class=" col col-6 mb-3">
                    <label for="">Name</label>
                    <input type="text" id="aName" name="a_name" class="form-control mb-3" placeholder="Arabic Name">
                    <input type="text" id="eName" name="e_name" class="form-control" placeholder="Latin Name">
                </div>

                <div class=" col col-6 mb-3">
                    <label for="brief">Description</label>
                    <textarea id="brief" name="brief" class="form-control mb-3" placeholder="Category Description"></textarea>
                </div>

                <div class="col col-12 buttons">
                    <button type="reset" class="btn btn-info">Reset</button>
                    <button type="button" onclick="cancelUpdate()" class="btn btn-primary">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>

        </fieldset>

        <div class="row">

            <div class="col col-12 border">
                <fieldset class="">
                    <legend>Accounts Categories</legend>

                    <table id="data" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Control</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($cats))
                            @foreach($cats as $in => $cat)
                                <tr>
                                    <td>{{ $in+1 }}</td>
                                    <td>{{ $cat->e_name }} - {{ $cat->a_name }}</td>
                                    <td><span title="{{ $cat->brief }}">{{ strlen($cat->brief) > 50 ? substr($cat->brief, 0, 45) . '......' : $cat->brief  }}</span></td>
                                    <td>
                                        <a class="edit" href="javascript:;"
                                           data-id="{{ $cat->id }}"
                                           data-aname="{{ $cat->a_name }}"
                                           data-ename="{{ $cat->e_name }}"
                                           data-brief="{{ $cat->brief }}"
                                           onclick="sendData(this)">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{route('accounts.cats.delete', $cat->id)}}" onclick="if(!confirm('you are about to delete an item, this is one way operation, you will not be able to undo this operation, Are you sure!')) return false"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">Nod Accounts Categories inserted yet!</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                        {{ $cats->links() }}


                </fieldset>
            </div>

        </div>

    </div>


@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
    <script>
         function sendData(item) {
             $('legend').html('Edit Category Information')
             $('#editForm').slideUp()
             $('#updateForm').removeClass('d-none')
             $('#updateForm #id').val(item.getAttribute('data-id'))
             $('#updateForm #aName').val(item.getAttribute('data-aname'))
             $('#updateForm #eName').val(item.getAttribute('data-ename'))
             $('#updateForm #brief').val(item.getAttribute('data-brief'))
         }
         function cancelUpdate() {
             $('legend').html('Add New category')
             $('#editForm').slideDown()
             $('#updateForm').addClass('d-none')
         }
    </script>
@endsection
