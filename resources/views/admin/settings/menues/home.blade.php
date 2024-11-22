@extends('layouts.admin')
@section('title')
    القوائم الرئيسية
@endsection
@section('pageHeading')
    القوائم الرئيسية
@endsection

@section('content')

    <div class="container pt-4" style="min-height: 100vh">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a href="{{ route('users.home') }}"> الموارد البشرية </a>
                </button>
                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <a href="{{ route('permissions.home') }}"> الصلاحيات </a>

                </button>
                <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <a> القوائم</a>
                </button>
                <button class="nav-link " id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <a href="{{ route('roles.home') }}"> الادوار </a>
                </button>
                <button class="nav-link " id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <a href="{{-- route('rules.setting', [$user->id]) --}}"> الاعدادات </a>
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                tabindex="0">
                <fieldset class="m-3">
                    <h4> القوائم فى التطبيق </h4>

                    <fieldset class="m-3">
                        <div class="accordion accordion-flush" id="menuesAccordion">
                            @if (count($menues))
                                @php $i=0 @endphp @foreach ($menues as $ui => $menu)
                                    @if ($menu->id == 1)
                                        @continue
                                    @endif
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#menu_{{ $menu->id }}"
                                                aria-expanded="false" aria-controls="menu_{{ $menu->id }}">
                                                {{ $menu->display_name_ar }}

                                            </button>
                                        </h2>
                                        <div id="menu_{{ $menu->id }}" class="accordion-collapse collapse"
                                            data-bs-parent="#menuesAccordion">
                                            <div class="accordion-body p-0">
                                                <div class="controls bg-secondary m-0 p-0">
                                                    <div class="buttons m-0 p-0">
                                                        <button data-bs-toggle="modal" data-bs-target="#addNewMenu"
                                                            data-bs-id="{{ $menu->id }}" class="addNewMenu btn">
                                                            <span data-bs-toggle="tooltip" class="  text-light"
                                                                data-bs-title="إضافة القائمة الفرعية"><span
                                                                    class="fa fa-plus"></i>
                                                                </span>
                                                        </button>
                                                        <button data-bs-toggle="modal" data-bs-target="#editMenu"
                                                            data-bs-id="{{ $menu->id }}" class="editMenu btn btn-sm">
                                                            <span data-bs-toggle="tooltip" class="text-light"
                                                                data-bs-title="تعديل بيانات القائمة"><i
                                                                    class="fa fa-edit"></i>
                                                            </span>
                                                        </button>
                                                        <button class="deleteMenu btn btn-sm">
                                                            <a data-bs-toggle="tooltip"
                                                                class="btn btn-sm py-0 mx-1 text-light"
                                                                data-bs-title="حذف القائمة"
                                                                onclick="if(!confirm('سوف تقوم بحذف هذه القائمة وما بها من قوائم، هل أنت متأكد؟')){return false}"
                                                                href="{{ route('menues.destroy', [$menu->id]) }}"><i
                                                                    class="fa fa-trash"></i></a>
                                                        </button>
                                                    </div>
                                                </div>
                                                @if (count($menu->children) > 0)
                                                    <ul class="row">
                                                        @foreach ($menu->children as $sm => $child)
                                                            <li class="col-md-12 col-lg-6 py-0">
                                                                <div class="row border m-1">
                                                                    <div class="col col-8 fw-bold"
                                                                        style="line-height: 1.5rem;">
                                                                        {{ $child->display_name_ar }}<br>
                                                                        {{ $child->label }} -
                                                                        {{ $child->status == 1 ? 'Active' : 'Parked' }}

                                                                    </div>
                                                                    <div class="buttons col col-4 text-left"
                                                                        style="justify-content: end; gap:1px">
                                                                        <button data-bs-toggle="modal"
                                                                            data-bs-target="#editMenu"
                                                                            data-bs-id="{{ $child->id }}"
                                                                            class="editMenu btn btn-outline-primary btn-sm ">
                                                                            <div data-bs-toggle="tooltip"
                                                                                data-bs-title="تعديل بيانات القائمة"><i
                                                                                    class="fa fa-edit"></i>
                                                                            </div>
                                                                        </button>
                                                                        <button
                                                                            class="btn btn-outline-{{ $child->status == 1 ? 'danger' : 'success' }} btn-sm py-0 px-2"><a
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-title="{{ $child->status == 1 ? 'الغاء تفعيل' : 'تفعيل' }} القائمة"
                                                                                href="{{ route('menues.change_status', [$child->id]) }}"><i
                                                                                    class="fa fa-{{ $child->status == 1 ? 'times' : 'check' }}"></i></a>
                                                                        </button>
                                                                        <button
                                                                            class="btn btn-outline-danger btn-sm py-0 px-2"><a
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-title="حذف القائمة"
                                                                                onclick="if(!confirm('سوف تقوم بحذف هذه القائمة، هل أنت متأكد؟')){return false}"
                                                                                href="{{ route('menues.destroy', [$child->id]) }}"><i
                                                                                    class="fa fa-trash"></i></a>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </fieldset>

                </fieldset>
            </div>
        </div>

        {{-- Modals --}}
        {{-- Edit Menu Details form --}}
        <div class="modal fade" id="editMenu" tabindex="-1" aria-labelledby="editMenuLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header mx-0 bg-secondary" style="background-color: #777">
                        <h1 class="modal-title fs-5" id="editMenuLabel"> تعديل بيانات القائمة </h1>
                        <button type="button" class="button-close ml-1 my-1 p-1" data-bs-dismiss="modal"
                            aria-label="Close"><i class="fa fa-times"></i></button>
                    </div>

                    <div class="modal-body">
                        <div id="editMenuFormContent">

                        </div>
                    </div>
                </div>
            </div>
        </div> {{-- Edit Menu Details Form --}}

        {{-- Add New submenu form --}}
        <div class="modal fade"id="addNewMenu" tabindex="-1" aria-labelledby="addNewMenuLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header mx-0 bg-secondary" style="background-color: #777">
                        <h1 class="modal-title fs-5" id="addNewMenuLabel"> إضافة قائمة جديدة </h1>
                        <button type="button" class="button-close ml-1 my-1 p-1" data-bs-dismiss="modal"
                            aria-label="Close"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div id="addMenuFormContent">
                            <div class="modal-body">
                                <form action="{{ route('menues.store') }}" method="post">
                                    @csrf

                                    <div class="input-group mt-3">
                                        <label for="label" class="input-group-text required">كود:</label>
                                        <input type="text" name="label" id="label" class="form-control"
                                            required value="{{ old('label') }}">

                                        <label for="url_name" class="input-group-text required"> رابط القائمة:</label>
                                        <input type="text" name="url_name" id="url_name" class="form-control"
                                            required value="{{ old('url_name') }}">
                                    </div>
                                    <div class="input-group mt-3">
                                        <label for="display_name_ar" class="input-group-text required">اسم
                                            القائمة:</label>
                                        <input type="text" name="display_name_ar" id="display_name_ar"
                                            class="form-control" required value="{{ old('display_name_ar') }}">
                                    </div>

                                    <div class="input-group mt-3">
                                        <label for="display_name_en" class="input-group-text required"> الاسم بلغة
                                            أخرى:</label>
                                        <input type="text" name="display_name_en" id="display_name_en"
                                            class="form-control" required value="{{ old('display_name_en') }}">
                                    </div>

                                    <div class="input-group mt-3">
                                        <label for="parent" class="input-group-text required"> القائمة الرئيسية:
                                        </label>
                                        <select name="parent" id="parent" class="form-control text-right">
                                            @foreach ($menues as $parent)
                                                <option {{ old('parent') == $parent->id ? 'selected' : '' }}
                                                    value="{{ $parent->id }}">{{ $parent->display_name_ar }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-success input-group-text" type="submit">تسجيل قائمة
                                            جديدة</button>
                                    </div>


                                </form>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div> {{-- Add New submenu form --}}
    </div>

    </div>
@endsection


@section('script')
    <script>
        $('.editMenu').click(function() {
            const _id = $(this).attr('data-bs-id')
            const _url = `/admin/menues/ajax/get/${_id}`


            jQuery.ajax({
                url: _url,
                type: 'get',
                dataType: 'html',

                cash: false,
                success: function(data) {
                    $('#editMenuFormContent').html(data);
                },
                error: function() {

                }
            });


        });

        $('.addNewMenu').click(function() {
            const __id = $(this).attr('data-bs-id')
            $('#parent').val(__id)
        });
    </script>
@endsection
