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
        <legend class="custom-bg px-3">
            عرض قائمة صلاحيات التطبيق &nbsp;
            <button type="button" class="btn btn-outline-light py-0 px-2" data-bs-toggle="modal"
                data-bs-target="#createPermissionModal">
                <i data-bs-toggle="tooltip" data-bs-title="Add New Permission" class="fa fa-plus"></i>
            </button>
        </legend> <br><br>
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
                            
                            @foreach ($menues as $sm)
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
                            @foreach ($menues as $sm)
                            
                                @if ($sm->parent == $root->id)
                                <div class="tabItem {{$y===0?'show':$y}}" id="tab_{{$sm->id}}" data-parent="#card_{{$root->id}}">
                                    @php $z = 0 @endphp
                                    @foreach ($permissions as $smp)
                                    
                                    @if ($smp->menu_id == $sm->id)    
                                        <div class="col col-12 col-lg-6 mb-1">
                                            <div class="input-group"> 
                                                <button for="" class="form-control text-right">
                                                    {{$smp->display_name_ar}}
                                                </button>
                                                <button for="" class="input-group-text">
                                                    <a href="{{route('edit-permission-info', [$smp->id])}}"><i class="fa fa-edit text-primary"></i></a>
                                                </button>
                                                <button for="" class="input-group-text">
                                                    <a href="{{route('destroy-permission', [$smp->id])}}"><i class="fa fa-trash text-danger"></i></a>
                                                </button>
                                            </div>
                                        </div>
                                        @php $z++ @endphp
                                        @endif
                                        @endforeach
                                        <div class="col col-auto">
                                            <a data-bs-toggle="modal" data-submenu-id="{{$smp->id}}" data-bs-target="#createPermissionModal" 
                                                data-submenu-name="{{ $sm->parent_menu->display_name_ar }} - {{ $sm->display_name_ar }}" 
                                                href="{{route('create-new-permission')}}" 
                                                class="createNewPermissionModalTrigger btn btn-outline-primary btn-sm">اضافة صلاحية</a>
                                        </div>
                                    
                                    {{-- Permissions Ends Here --}}
                                </div>
                                @php $y++ @endphp
                                @endif
                            @endforeach
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
    </fieldset>
</div>



@endsection
@section('script')
    <script>
        // let table = new DataTable('#RolesTable');
        $(document).ready(()=>{
            $(document).on('click', '.createNewPermissionModalTrigger', function() {
                const __sm_id = $(this).attr('data-submenu-id')
                const __sm_name = $(this).attr('data-submenu-name')
                const __pm_option = `<option value="${__sm_id}">${__sm_name}</option>`
                $('#permission-parent-menu').html(__pm_option)
            });
        })
    </script>
@endsection
@section('modals')
    <!-- Tooltip Modal -->
    <div class="modal fade" id="createPermissionModal" tabindex="-1" role="dialog" aria-labelledby="createPermissionModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content overflow-hidden">
                <div class="modal-header row custom-bg-transparent">
                    <h5 class="modal-title col text-right" id="createPermissionModalTitle">إضافة صلاحية جديدة</h5>
                    <button type="button" class="close col-auto" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <form action="{{ route('store-permission-info') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="input-group mt-3">
                            <label for="name" class="input-group-text required">كود</label>
                            <input type="text" name="name" id="name" class="form-control" required
                                value="{{ old('name') }}">
                                <label for="permission-parent-menu" class="input-group-text">Parent Menu</label>
                                <select name="menu_id" id="permission-parent-menu" class="form-control">
                                    @foreach ($menues as $p)
                                        <option value="{{ $p->id }}">{{ $p->parent_menu->display_name_ar }} - {{ $p->display_name_ar }}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="input-group mt-3">
                            <label for="display_name_en" class="input-group-text required">اسم الصلاحية</label>
                            <input type="text" name="display_name_en" id="display_name_en" class="form-control" required
                                value="{{ old('display_name_en') }}">
                            <label for="display_name_ar" class="input-group-text required">الاسم بالعربي</label>
                            <input type="text" name="display_name_ar" id="display_name_ar" class="form-control" required
                                value="{{ old('display_name_ar') }}">
                            
                        </div>
                        <div class="input-group mt-3">
                            <label for="brief" class="input-group-text required">الوصف</label>
                            <input type="text" name="brief" id="brief" class="form-control" required
                                value="{{ old('brief') }}">

                        </div>
                    </div>
                    
                    <div class="buttons justify-content-end custom-bg-transparent">
                    <button type="button" class="btn btn-sm py-1 px-3 btn-info" data-bs-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-sm py-1 px-3 btn-success">حفظ البيانات</button>
                   
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
