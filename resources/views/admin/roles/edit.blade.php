@extends('layouts.admin')
@section('title')
    أدوار مديري التطبيق
@endsection
@section('pageHeading')
أدوار مديري التطبيق
@endsection
@section('content')
    <div class="container">

        <fieldset>
            <legend>
               تحديث بيانات  [ {{ $role->display_name_ar }} ] &nbsp; &nbsp;
                

                    <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2" data-bs-toggle="modal"
                        data-bs-target="#assignToAdminModal"><i data-bs-toggle="tooltip"
                            data-bs-title="Assign Role to Admin / Admins" class="fa fa-network-wired"></i>
                    </button>
                    <a href="{{ route('role-permissions', [$role->id]) }}" class="btn btn-sm btn-outline-primary py-0 px-2">
                        <i data-bs-toggle="tooltip" data-bs-title="Attach Permission / Permissions to Role"
                            class="fa fa-magic"></i></a>
               
                    </legend>

            <br><br>

            <fieldset >
                <legend>
                    تحديث البيانات الأساسية
                </legend>
                
                <form action="{{ route('update-role-info') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-inputs col-12">
                            <input type="hidden" name="id" value="{{$role->id}}">
                            <div class="input-group mt-3">
                                <label for="name" class="input-group-text required">كود</label>
                                <input type="text" name="name" id="name" class="form-control" required
                                    value="{{ old('name', $role->name) }}">
                                <label for="display_name_ar" class="input-group-text required">الاسم</label>
                                <input type="text" name="display_name_ar" id="display_name_ar" class="form-control" required
                                value="{{ old('display_name_ar', $role->display_name_ar) }}">
                                <label for="display_name_en" class="input-group-text required">الاسم العربى</label>
                                <input type="text" name="display_name_en" id="display_name_en" class="form-control" required
                                    value="{{ old('display_name_en', $role->display_name_en) }}">
                            </div>
                            <div class="input-group mt-3">
                                <label for="brief" class="input-group-text required">الوصف</label>
                                <textarea name="brief" id="brief" style="height: 100px" class="form-control" required area-label="الوصف">{{ old('brief', $role->brief) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0" style="background-color: #eeea">
                        <div class="buttons justify-content-end py-2 px-3">
                            <button type="button" class="btn btn-sm py-1 btn-danger" data-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-sm py-1 btn-primary">تحديث البيانات</button>
                        </div>
                    </div>
                </form>
               
            </fieldset>

            <fieldset>
                <legend>
                    مديرين يمكن منحهم هذا الدور:
                </legend>
                <div class="card-body py-2">
                    <div class="row w-100" dir="rtl" >
                        @php $b=0 @endphp
                        @foreach ($admins as $admin)
                            @if (!$admin->hasRole($role->id))
                                <div class="col col-12 col-sm-6">
                                    <div class="input-group mb-1">
                                        <button type="button" class="form-control">
                                            <a
                                            href="{{ route('display-admin', [$admin->id]) }}">{{ $admin->fullName() }}
                                        </a>
                                    </button>
                                    <label for="" class="input-group-text" data-bs-toggle="tooltip" data-bs-title="تعين الدور لهذا المدير"><a
                                            href="{{ route('assign-role-to-admin', [$admin->id, $role->id]) }}"><i
                                            class="fa fa-cart-flatbed-suitcase text-success"></i>
                                        </a>
                                    </label>
                                    </div>
                                </div>
                                @php $b++ @endphp
                            @endif
                        @endforeach
                        @if ($b==0)
                        <div class="col col-12 col-sm-6">هذه القائمة فارغة</div>
                        @endif
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>
                    مديرين تم منحهم هذا الدور:
                </legend>
                <div class="card-body py-2">
                    <div class="row w-100" dir="rtl" >
                        @php $c=0 @endphp
                        @foreach ($admins as $admin)
                            @if ($admin->hasRole($role->id))
                                <div class="col col-12 col-sm-6">
                                    <div class="input-group mb-1">
                                        <button type="button" class="form-control">
                                            <a
                                            href="{{ route('display-admin', [$admin->id]) }}">{{ $admin->fullName() }}
                                        </a>
                                    </button>
                                    <label for="" class="input-group-text" data-bs-toggle="tooltip" data-bs-title="ازالة الدور من هذا المدير"><a
                                            href="{{ route('dettach-role-from-admin', [$admin->id, $role->id]) }}"><i
                                            class="fa fa-calendar-xmark text-danger"></i>
                                        </a>
                                    </label>
                                    </div>
                                </div>
                                @php $c++ @endphp
                            @endif
                        @endforeach
                        @if ($c==0)
                        <div class="col col-12 col-sm-6">هذه القائمة فارغة</div>
                        @endif
                        
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>
                    صلاحيات الدور:
                </legend>

                <div class="card-body">
                    @php $a = 0 @endphp
                    @foreach ($permissions as $permission)
                        @if ($role->hasPermission($permission->id))
                        <div class="col col-12 col-lg-6 mb-1">
                            <div class="input-group"> 
                                <label class="input-group-text">
                                    <input type="checkbox" name="permissions[]" id="perm_{{$permission->id}}" value="{{$permission->id}}">
                                </label>
                                <label for="perm_{{$permission->id}}" type="button" class="form-control text-right">
                                    {{$permission->display_name_ar}} 
                                </label>
                                
                            </div>
                        </div>
                        @php $a++ @endphp
                        @endif                        
                    @endforeach
                    @if ($a === 0)
                    <div class="alert alert-info text-right my-0">
                        لم يتم تخصيص صلاحيات لهذا الدور بعد، يمكنك تخصيص بعض الصلاحيات بالأسفل
                    </div>
                    @endif
                </div>
            </fieldset>
            
            <fieldset>
                <legend>
                    صلاحيات يمكن منحها لهذا الدور:
                </legend>
                <div class="card-body">
                    <div class="display w-100" id="permissions-display">
                        @foreach ($roots as $root)
                            @if ($root->id === 0) @continue @endif
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="col bg-light"><i class="mx-3 {{$root->icon}}"></i>{{$root->display_name_ar }} - {{$root->id}}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="display w-100" id="card_{{$root->id}}">
                                        <nav class="tabsDisplay" >
                                            @php $x=0 @endphp
                                            
                                            @foreach ($subMenues as $sm)
                                                @if ($sm->parent == $root->id) 
                                                <button data-bs-toggle="tooltip" data-bs-title="{{$sm->brief??'لا يوجد وصف لهذه القائمة'}}" 
                                                    class="navBtn {{$x === 0 ? 'active':$x}}" data-target="#tab_{{$sm->id}}">
                                                    <i data-target="#tab_{{$sm->id}}" class="{{$sm->icon}}"></i> &nbsp; {{$sm->display_name_ar}}
                                                </button>
                                                @php $x++ @endphp
                                                @endif
                                            @endforeach
                                            @if ($x===0) 
                                            <button class="navBtn {{$x === 0 ? 'active':$x}}" data-target="#tab_{{$sm->id}}">
                                                <a href="{{route('create-submenu', [$root->id])}}">إضافة قائمة فرعية</a> 
                                            </button>
                                            @endif
                                        </nav>
                                        <div class="tabs">
                                            @php $y=0 @endphp
                                            @foreach ($subMenues as $sm) {{--  Submenu Loop--}}
                                            
                                                @if ($sm->parent == $root->id)
                                                <div class="tabItem {{$y===0?'show':$y}}" id="tab_{{$sm->id}}" data-parent="#card_{{$root->id}}">
                                                    <form action="{{route('attach-permissions-to-role', [$role->id])}}" method="post">
                                                        @csrf
                                                        @php $z = 0 @endphp
                                                        @foreach ($permissions as $smp) {{--End of permissions loop--}}
                                                            
                                                            @if ($smp->menu_id == $sm->id && !$role->hasPermission($smp->id))    
                                                            <div class="col col-12 col-lg-6 mb-1">
                                                                <div class="input-group"> 
                                                                    <label class="input-group-text">
                                                                        <input type="checkbox" name="permissions[]" id="perm_{{$smp->id}}" value="{{$smp->id}}">
                                                                    </label>
                                                                    <label for="perm_{{$smp->id}}" type="button" class="form-control text-right">
                                                                        {{$smp->display_name_ar}} 
                                                                    </label>
                                                                    
                                                                </div>
                                                            </div>
                                                            @php $z++ @endphp
                                                            @endif
                                                        @endforeach {{--End of permissions loop--}}
                                                        @if ($z > 0) 
                                                            <div class="buttons justify-items-start"> {{--form submit buttons--}}
                                                                <button class="btn btn-sm btn-outline-primary" type="submit">إضافة الصلاحيات</button>
                                                            </div>
                                                        @endif
                                                    </form>{{-- Permissions Ends Here --}}
                                                </div>
                                                @php $y++ @endphp
                                                @endif
                                            @endforeach {{--End of submenu loop--}}
                                        
                                            @if ($y===0)
                                            <div class="tabItem {{$y===0?'show':$y}}" id="tab_{{$sm->id}}">
                                            No Permissions
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>              
                </div>
            </fieldset>
                {{-- {{ $menues }} --}}
            </div>
        
        </fieldset>
    </div>
@endsection

