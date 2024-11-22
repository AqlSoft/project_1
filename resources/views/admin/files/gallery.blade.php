@extends('layouts.admin')
@section('title')
    التقارير | الرئيسية
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    العملاء
@endsection
@section('homeLinkActive')
    التقارير / الرئيسية
@endsection
@section('links')
    <button class="btn btn-sm btn-primary">
        <a href="{{ route('clients.create') }}">
            <i class="fa fa-plus text-light"></i>
        </a>
    </button>
    <button class="btn btn-sm btn-primary">
        <a href="{{ route('items.setting') }}">
            <i class="fa fa-cogs text-light"></i>
        </a>
    </button>
@endsection
@section('content')
    <style>
        h5.list-item+ol.submenu {
            display: none;
            overflow: hidden;
        }

        h5.list-item+ol.expand {
            height: auto
        }
    </style>
    <div class="container-fluid pt-5" style="min-height: 100vh">
        <div class="cards row  w-100">
            <div class="col col-3 text-right">
                <ol>
                    @foreach ($menues as $item)
                        <li class="m-1 p-0 py-1 bg-primary" style="border-radius: 5px">
                            <h5 class="list-item px-3">{{ $item->name }}</h5> {{-- onclick="expand(this, evt)" --}}
                            <ol class="submenu">
                                @foreach ($item->submenues as $sm)
                                    <li class="py-2 ps-2 pe-5 bg-secondary m-0">
                                        <h6>{{ $sm->name }}
                                            <i style="float: left; margin: 0 1em" class="modalTrigger fa fa-plus"
                                                data-bs-toggle="modal" data-bs-id="{{ $sm->id }}"
                                                data-menu="{{ $item->name }}" data-cat-name="{{ $sm->name }}"
                                                data-bs-target="#exampleModal"></i>
                                        </h6>
                                        @if (count($sm->files))
                                            <ul>
                                                @foreach ($sm->files as $file)
                                                    <li><a
                                                            href="{{ route('files.gallery', [$file->id]) }}">{{ $file->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif

                                    </li>
                                @endforeach
                            </ol>
                        </li>
                    @endforeach
                </ol>
            </div>

            <div class="col col-9">
                <div class="card">
                    <div class="card-header">
                        <h4> الملفات </h4>
                    </div>

                    @if ($display)
                        <div>Type: {{ $display->type }}</div>
                        id: {{ $display->id }}
                        {{ url('storage/app/' . $display->file_path . '/' . $display->file_name) }}
                    @endif
                    @if ($display == null)
                        <div class="card-body">اختر أحد ملفات الشرح لعرضه هنا</div>
                    @else
                        <img src="{{ url('storage/app/' . $display->file_path . '/' . $display->file_name) }}"
                            alt="">
                    @endif

                    {{-- <form action="{{ route('support.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" id="file">
                        <input type="submit" value="Upload">
                        @error('file')
                            <div class="alert alert-danger">error</div>
                        @enderror
                    </form> --}}
                </div>
            </div>
        </div> {{-- the End Of Card --}}
    </div>
    <!-- Button trigger modal -->


    <!-- Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header position-relative px-3 py-1">
                    <h1 class="modal-title fs-4 " id="exampleModalLabel">إضافة ملف دعم جديد ألى <span id="MenuName"></span>
                    </h1>
                    <button type="button" class="btn-close position-absolute my-1" data-bs-dismiss="modal"
                        aria-label="Close" style="left: 1em;color: #500"></button>
                </div>
                <form action="{{ route('support.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="formBody" class="modal-body">
                        <div class="input-group mb-3">
                            <label for="" class="input-group-text">وضع الدرس فى قائمة:</label>
                            <select name="parent" id="parent" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <input type="file" name="file" class="form-control" id="">
                            <input type="saveAs" name="text" class="form-control" id=""
                                placeholder="حفظ باسم ......">
                        </div>
                        <div class="input-group mb-3">
                            <label for="" class="input-group-text">عنوان الشرح</label>
                            <input type="text" name="name" class="form-control" id="">
                        </div>
                        <div class="input-group mb-3">
                            <label for="" class="input-group-text">وصف المحتوى</label>
                            <input type="text" name="brief" class="form-control" id="">
                        </div>
                    </div>
                    <div class="modal-footer py-2 ">
                        <button type="button" class="btn btn-secondary btn-sm mx-2" data-bs-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary btn-sm">رفع الملفات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('script')
    <script>
        $('h5.list-item').click(function() {
            $('ol.submenu').not($(this).next('ol')).slideUp('slow')
            $(this).next('ol.submenu').slideDown('slow')
        });


        $('.modalTrigger').click(function() {
            $('#MenuName').html($(this).attr('data-menu'))
            $('#parent option').html($(this).attr('data-cat-name'))
            $('#parent option').val($(this).attr('data-bs-id'))


        })
    </script>
@endsection
