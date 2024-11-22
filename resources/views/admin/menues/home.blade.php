@extends('layouts.admin')
@section('title')
    القوائم فى التطبيق
@endsection
@section('pageHeading')
    القوائم فى التطبيق
@endsection
@section('content')
    <div class="container" style="min-height: 100vh">
        <fieldset>
            <legend>القوائم فى التطبيق &nbsp;
                <button type="button" class="btn btn-outline-secondary py-0 px-2">
                    <i data-bs-toggle="modal" data-bs-target="#createMenuModal" class="fa fa-plus"></i></button>
            </legend>
            <br>
            <br>

            @if (count($roots))
                <div class="display bg-light p-3 w-100" id="menues-list">
                    <nav class="tabsDisplay">
                        @foreach ($roots as $ui => $root)
                            @if ($root->id == 0) @continue @endif
                            <button class="navBtn {{$ui == 1 ? 'active':''}}" data-target="#tab_{{$root->id}}">
                                <i data-target="#tab_{{$root->id}}" class="{{$root->icon}}"></i> &nbsp; {{$root->display_name_ar}}
                            </button>
                        @endforeach
                    </nav>
                    <div class="tabs">
                        @foreach ($roots as $ui => $root)
                            @if ($root->id == 0) @continue @endif
                            @if (count($root->subMenues))
                            <div class="tabItem text-right  {{$ui == 1 ? 'show':''}}" id="tab_{{$root->id}}"  data-parent="#menues-list">
                                <div class="row" >
                                    <div class="col col-12 pb-3">
                                        <button class="btn y-0 btn-sm btn-outline-primary"><a class="m-0 p-0" href="{{route('edit-menu-info', [$root->id])}}">تعديل بيانات القائمة</a></button>
                                        <button class="btn y-0 btn-sm btn-outline-danger"><a class="m-0 p-0" href="{{route('destroy-menu', [$root->id])}}" onclick="if(!confirm('سوف تحذف القائمة وكل ما يرتبط بها من قوائم فرعية وصلاحيات، هذه الحركة لا يمكن الرجوع عنها، هل أنت متأكد؟'))return false">حذف بيانات القائمة</a></button>
                                    </div>
                                    @foreach ($root->subMenues as $ism)
                                    <div class="col col-12 col-lg-6 mb-1">
                                        <div class="input-group">
                                            <label for="" class="input-group-text">
                                                <i class="{{$ism->icon}}"></i>
                                            </label>
                                            <label for="" class="form-control">
                                                {{$ism->display_name_ar}}
                                            </label>
                                            <button for="" class="input-group-text">
                                                <a href="{{route('edit-menu-info', [$ism->id])}}"><i class="fa fa-edit text-primary"></i></a>
                                            </button>
                                            <button for="" class="input-group-text">
                                                <a href="{{route('destroy-menu', [$ism->id])}}"><i class="fa fa-trash text-danger"></i></a>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="col col-12 col-lg-6 mb-1">
                                        <div class="input-group">
                                            <button data-bs-toggle="modal" data-bs-target="#createSubMenuModal" class="addSubMenu form-control btn-outline-primary" data-parent-id="{{ $root->id }}"
                                                data-parent-name="{{ $root->display_name_ar }} - {{ $root->parent_menu->display_name_ar }}">
                                            إضافة قائمة فرعية
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            @else 
                                <div class="tabItem text-right  {{$ui == 1 ? 'show':''}}" id="tab_{{$ui}}">
                                لا يوجد قوائم فرعية مدرجة لعرضها، يمكنك 
                                <button data-bs-toggle="modal" data-bs-target="#createSubMenuModal" class="addSubMenu btn btn-outline-primary py-1 my-0 mx-3"
                                    class="addSubMenu" data-parent-id="{{ $root->id }}"
                                    data-parent-name="{{ $root->display_name_ar }} - {{ $root->parent_menu->display_name_ar }}">
                                إضافة أول قائمة فرعية
                                </button>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <tr>
                    <td colspan="7">لا يوجد قوائم رئيسية مضافة غى التطبيق  حتى الان، يمكنك إضافة &nbsp; <button
                            class="btn btn-outline-secondary py-1 px-2" data-bs-toggle="modal"
                            data-bs-target="#createMenuModal">قائمتك
                            الأولى</button></td>
                    </td>
                </tr>
            @endif


        </fieldset>

    </div>
@endsection
@section('script')
    <script>
        $('.addSubMenu').click((e) => {
            const _parent_id = e.target.getAttribute('data-parent-id')
            const _parent_name = e.target.getAttribute('data-parent-name')
            console.log(_parent_id, _parent_name)
            $('#sub_menu_id').html(() => {
                return `<option value="${_parent_id}">${_parent_name}</option>`
            })
        });

        

    </script>
@endsection
@section('modals')
    <!-- Create Menu Modal -->
    <div class="modal fade" id="createMenuModal" tabindex="-1" role="dialog" aria-labelledby="createMenuModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content overflow-hidden">
                <div class="modal-header custom-bg-transparent row">
                    <h5 class="modal-title text-right col" id="createMenuModalTitle">اضافة قائمة جديدة</h5>
                    <button type="button" class="close col-auto" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <form action="{{ route('store-menu-info') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="input-group mt-3">
                            <label for="name" class="input-group-text">الكود</label>
                            <input type="text" name="label" id="name" class="form-control" required
                                value="{{ old('label') }}">
                            <label for="display_name_en" class="input-group-text">الاسم</label>
                            <input type="text" name="display_name_en" id="display_name_en" class="form-control" required
                                value="{{ old('display_name_en') }}">
                            <label for="display_name_ar" class="input-group-text">الاسم العربى</label>
                            <input type="text" name="display_name_ar" id="display_name_ar" class="form-control" required
                                value="{{ old('display_name_ar') }}">
                        </div>
                        <div class="input-group mt-3">
                            <label for="brief" class="input-group-text">الوصف</label>
                            <input type="text" name="brief" id="brief" class="form-control" required
                                value="{{ old('brief') }}">

                        </div>
                        <div class="input-group mt-3">
                            <label for="icon" class="input-group-text">أيقونة</label>
                            <input type="text" name="icon" id="icon" class="form-control" required
                                value="{{ old('icon') }}">
                            <label for="url" class="input-group-text">الرابط</label>
                            <input type="text" name="url" id="url" class="form-control"
                                value="{{ old('url') }}">

                        </div>
                        <div class="input-group mt-3">
                            <label for="menu_id" class="input-group-text">القائمة الرئيسية</label>
                            <select name="menu_id" id="menu_id" class="form-control" value="{{ old('menu_id') }}">
                                @foreach ($roots as $r)
                                    <option value="{{ $r->id }}">{{ $r->display_name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   
                        <div class="buttons m-0 custom-bg-transparent">
                            <button type="button" class="btn btn-sm py-1 btn-danger"
                                data-bs-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-sm py-1 btn-primary">أضافة قائمة فرعية</button>
                        </div>
                   
                </form>
            </div>

        </div>
    </div>

    <!-- Create SubMenu Modal -->
    <div class="modal fade" id="createSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="createSubMenuModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content overflow-hidden">
                <div class="modal-header row custom-bg-transparent">
                    <h5 class="modal-title text-right col" id="createSubMenuModalTitle">اضافة قائمة فرعية جديدة</h5>
                    <button type="button" class="close col-auto" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <form action="{{ route('store-menu-info') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="input-group mt-3">
                            <label for="sub_name" class="input-group-text">كود</label>
                            <input type="text" name="label" id="sub_name" class="form-control" required
                                value="{{ old('name') }}">
                            <label for="sub_display_name" class="input-group-text">الاسم</label>
                            <input type="text" name="display_name_en" id="sub_display_name" class="form-control"
                                required value="{{ old('display_name_') }}">
                                <label for="sub_display_name_ar" class="input-group-text">الاسم العربى</label>
                            <input type="text" name="display_name_ar" id="sub_display_name_ar" class="form-control" required
                                value="{{ old('display_name_ar') }}">
                        </div>
                        <div class="input-group mt-3">
                            <label for="sub_brief" class="input-group-text">الوصف</label>
                            <input type="text" name="brief" id="sub_brief" class="form-control" required
                                value="{{ old('brief') }}">
                        </div>
                        <div class="input-group mt-3">
                            <label for="sub_icon" class="input-group-text">ايقونة</label>
                            <input type="text" name="icon" id="sub_icon" class="form-control" required
                                value="{{ old('icon') }}">
                            <label for="sub_url" class="input-group-text">الرابط</label>
                            <input type="text" name="url" id="sub_url" class="form-control"
                                value="{{ old('url') }}">
                        </div>
                        <div class="input-group mt-3">
                            <label for="sub_menu_id" class="input-group-text">القائمة الرئيسية</label>
                            <select name="menu_id" id="sub_menu_id" class="form-control" value="{{ old('menu_id') }}">
                                <option value="1">قائمة رئيسية</option>
                                @foreach ($roots as $r)
                                    <option value="{{ $r->id }}">{{ $r->display_name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="buttons m-0 custom-bg-transparent">
                        <button type="button" class="btn btn-sm py-1 btn-danger"
                            data-bs-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-sm py-1 btn-primary">إضافة القائمة</button>
                    </div>
                    
                </form>
            </div>

        </div>
    </div>
@endsection
