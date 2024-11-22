@extends('layouts.admin')
@section('title')
    صلاحيات التطبيق
@endsection
@section('pageHeading')
    صلاحيات التطبيق
@endsection
@section('content')
    <div class="container" style="min-height: 100vh">
        <fieldset>
            <legend>
              
                      تحديث  صلاحيات [ {{ $role->display_name_ar }} ] &nbsp; &nbsp;
                    <a href="{{ route('display-roles-list') }}" class="btn py-0 px-2 btn-outline-primary">
                        العودة للأدوار</a>
            </legend>
            <div class="card mt-3">
                <div class="card-header">
                    <h4> إضافة صلاحيات للأدوار:</h4>
                </div>

                <div class="card-body">

                    <div class="accordion w-100" id="permissions">
						@php
                            $c = 0;
                        @endphp
                        @foreach ($menues as $root)
                        <div class="accordion-item">
                          	<h2 class="accordion-header">
                          	 	<button class="accordion-button {{++$c == 1?'':'collapsed'}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$root->id}}" aria-expanded="{{$c == 1?'true':'false'}}" aria-controls="collapse_{{$root->id}}">
                          	 	  	{{$root->display_name_ar}}
                          	 	</button>
                          	</h2>
                          	<div id="collapse_{{$root->id}}" class="accordion-collapse p-0 collapse {{$c == 1?'show':''}}" data-bs-parent="#permissions">
                          	  	
								@if(count($root->subMenues) > 0)
								<div class="accordion-body">
                              	@foreach ($root->subMenues as $sm)
									<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#menu_{{$sm->id}}" aria-expanded="false" aria-controls="menu_{{$sm->id}}">
										{{$sm->display_name_ar}}
									</button>
									@endforeach
									@foreach ($root->subMenues as $sm)
									<div class="collapse" id="menu_{{$sm->id}}">
										<form action="{{ route('attach-permissions-to-role') }}" method="post">
											@csrf
											<div class="">
												@php $mpc = 0 @endphp
												@foreach ($permissions as $permission)
													@if (!$role->hasPermission($permission->id))
													@if ($permission->menu_id == $sm->id)@php $mpc++ @endphp
														<div class="input-group">
															<label for="perm_{{$permission->id}}" class="input-group-text">{{$permission->display_name_ar}}</label>
															<label for="perm_{{$permission->id}}" class="input-group-text">
																<input type="checkbox" id="perm_{{$permission->id}}" name="permissions[]" value="{{$permission->id}}">
															</label>
														</div>
													@endif @endif
												@endforeach
											</div>
											<div class="py-3 px-0">
											@if ($mpc > 0)
											<button class="btn btn-outline-success btn-sm" type="submit">تحديث صلاحيات الدور</button>
											@else
											<div class="alert alert-warning py-1 text-center">لا يوجد صلاحيات  فى هذه القائمة يمكن إضافتها للدور</div>
											@endif
											</div>
										</form>
									</div>
								@endforeach
                            	</div>
								@else
								<div class="alert alert-info m-3 text-center">لا يوجد قوائم فرعية تابعة لهذا الجذر لعرضها هنا</div>
								@endif
                          	</div>
                        </div>
						@endforeach
                    </div>                      

                    {{-- <div class="accordion w-100" id="Permissions">
                        @php
                            $c = 0;
                        @endphp
                        @foreach ($menues as $root)
                            <div class="card">
                                <div class="card-header" id="menu_heading_{{ $root->id }}">
                                    <h2 class="mb-0"> 
                                        <button class="btn btn-link{{ $c >= 1 ? ' collapsed' : '' }}" type="button"
                                            data-toggle="collapse" data-target="#collapse_{{ $root->id }}"
                                            aria-expanded="{{ $c >= 1 ? 'false' : 'true' }}"
                                            aria-controls="collapse_{{ $root->id }}">
                                            {{ $root->display_name_ar }}
                                        </button>
                                    </h2>
                                </div>

                                <div class="card-body w-100 p-0"> 
                                    <div id="collapse_{{ $root->id }}" class="collapse {{ ++$c == 1 ? 'show' : '' }}"
                                        aria-labelledby="menu_heading_{{ $root->id }}" data-parent="#Permissions">
                                        <form action="{{ route('attach-permissions-to-role') }}" method="post">
                                            <input type="hidden" name="id" value="{{ $role->id }}">
                                            @csrf

                                            @php
                                                $c = 0;
                                            @endphp
                                            @foreach ($root->subMenues as $menu)
                                                <div class="menu w-100 m-3">
                                                    <p class="alert alert-secondary py-1">{{ $menu->display_name_ar }}
                                                    </p>
                                                    <div class="menu-permissions px-3">
                                                        <div class="row">
                                                            @foreach ($permissions as $permission)
                                                                @if ($permission->menu_id == $menu->id)
                                                                    @if (!$role->hasPermission($permission->id))
                                                                        @php
                                                                            $c++;
                                                                        @endphp
                                                                        <div class="col col-12">
                                                                            <div
                                                                                class="input-group  mr-3 mb-3">
                                                                                <label class="input-group-text" for="chekbox_{{ $permission->id }}">
                                                                                <input type="checkbox" name="permissions[]"
                                                                                   
                                                                                    id="chekbox_{{ $permission->id }}"
                                                                                    value="{{ $permission->id }}">
                                                                                </label>
                                                                                <label class="form-control"
                                                                                    data-bs-title="{{ $permission->brief }}"
                                                                                    data-bs-toggle="tooltip"
                                                                                    for="chekbox_{{ $permission->id }}">{{ $permission->display_name_ar }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @if ($c == 0)
                                                        <div class="row m-0">
                                                            <div class="col col-12 py-0 m-0 px-4">
                                                                لا يوجد صلاحيات متبقية لمنحها أو أن القائمة ليس بها صلاحيات
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                            @if ($c !== 0)
                                                <button type="submit"
                                                    class="btn btn-block btn-primary py-1 px-2 mx-3 mb-3">تحديث صلاحيات الدور</button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div> --}}
                    {{-- {{ $menues }} --}}
                </div>
            </div>
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
    <div class="modal fade" id="assignToAdminModal" tabindex="-1" role="dialog" aria-labelledby="assignToAdminModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignToAdminModalTitle">Create New Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <form action="{{ route('assign-role-to-admins') }}" method="POST">
                    @csrf
                    <input type="hidden" name="role_id" value="{{ $role->id }}">
                    <div class="modal-body">
                        <div class="row">
                            @foreach ($admins as $admin)
                                @if (!$admin->hasRole($role->id))
                                    <div class="col col-12 col-lg-6">
                                        <div class="form-check mr-3 mb-3">
                                            <input class="form-check-input" type="checkbox" value="{{ $admin->id }}"
                                                id="admin_id_{{ $admin->id }}" name="admins[]">
                                            <label class="form-check-label" for="admin_id_{{ $admin->id }}">


                                                {{ $admin->profile->first_name ?? 'Not Assigned' }}
                                                {{ $admin->profile->last_name ?? 'Not Assigned' }}
                                                <span class="badge badge-info badge-sm">[ {{ $admin->userName }} ]</span>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-sm py-1 btn-danger" data-dismiss="modal">Close</button> --}}
                        <button type="submit" class="btn btn-sm py-1 btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
