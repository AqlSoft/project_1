@extends('layouts.admin')
@section('title')
    Application Roles
@endsection
@section('content')

    <div class="container" style="min-height: 100vh">
        <fieldset class="shadow p-4">
            <legend >
                أدوار التطبيق &nbsp; 
                <button type="button" class="btn btn-outline-primary py-0 px-2" data-bs-toggle="modal"
                        data-bs-target="#createRoleModal"><i class="fa fa-plus"></i></button>
                
            </legend>

            {{$roles}}
            <table id="RolesTable" class="table mt-4" style="width: 100%">
                {{-- <table id="productsTable" class="table table-hover table-product" style="width:100%"> --}}
                <thead>
                    <tr class="bg-secondary">
                        <th class="bg-secondary">#</th>
                        <th>كود</th>
                        <th>اسم الدور</th>
                        <th>الاسم العربى</th>
                        <th>تم الانشاء</th>
                        <th><i class="fa fa-cogs"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($roles))
                        @php $i=0 @endphp
                        @foreach ($roles as $ui => $item)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $item->name }} </td>
                                <td>{{ $item->display_name_en }}</td>
                                <td>{{ $item->display_name_ar }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a href="{{ route('display-role', [$item->id]) }}"><i class="fa fa-eye"
                                            title="Display Role info"></i></a>
                                    <a href="{{ route('edit-role-info', $item->id) }}"><i class="fa fa-edit"
                                            title="Edit role info"></i></a>

                                    <a href="{{ route('destroy-role', $item->id) }}"
                                        onclick="return confirm('This action is one way, you will not able to undo this, are you sure.?')"><i
                                            class="fa fa-trash" title="Delete Role"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">لا يوجد صلاحيات فى هذا التطبيق، قم بـ  <a
                                    href="{{ route('create-new-role') }}">
                                    إضافة صلاحية</a></td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </fieldset>

    </div>



@endsection
@section('scripts')
    <script>
        // let table = new DataTable('#RolesTable');
        $(document).ready(function() {
            $('#RolesTable').DataTable();
        });
    </script>
@endsection
@section('modals')
    <!-- Tooltip Modal -->
    <div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleModal"
        aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header row">
                    <h5 class="modal-title col text-end" id="createRoleModalTitle">إضافة دور جديد</h5>
                    <button type="button" class="close col-auto" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <form action="{{ route('store-role-info') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-inputs">
                            
                            <div class="input-group mt-3">
                                <label for="name" class="input-group-text required">كود</label>
                                <input type="text" name="name" id="name" class="form-control" required
                                value="{{ old('name') }}">
                            </div>
                            <div class="input-group mt-3">
                                <label for="display_name_ar" class="input-group-text required">الاسم</label>
                                <input type="text" name="display_name_ar" id="display_name_ar" class="form-control" required
                                value="{{ old('display_name_ar') }}">
                            </div>
                            <div class="input-group mt-3">
                                <label for="display_name_en" class="input-group-text required">الاسم العربى</label>
                                <input type="text" name="display_name_en" id="display_name_en" class="form-control" required
                                    value="{{ old('display_name_en') }}">
                            </div>
                            <div class="input-group mt-3">
                                <label for="brief" class="input-group-text required">الوصف</label>
                                <input type="text" name="brief" id="brief" class="form-control" required
                                    value="{{ old('brief') }}">
    
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-0">
                        <div class="buttons justify-content-end py-2 px-3">
                            <button type="button" class="btn btn-sm py-1 btn-danger" data-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-sm py-1 btn-primary">تحديث البيانات</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
