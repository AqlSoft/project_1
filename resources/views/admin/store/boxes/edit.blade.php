@extends('layouts.admin')
@section('title')
    تعديل صنف ثلاجة
@endsection

@section('pageHeading')
    تعديل بيانات صنف ثلاجة
@endsection

@section('content')
    <div class="container pt-2">

        <div class="buttons">
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('store.items.stats') }}"> <i
                        class="fa fa-chart-line"></i>
                    احصائيات</a></button>
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('store.items.home') }}"> <i
                        class="fa fa-list"></i>
                    الأصناف</button>
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a
                    href="{{ route('store.items.view', [$item->id]) }}">
                    <i class="fa fa-eye"></i>
                    عرض</a></button>
            <button type="button" class="btn btn-sm px-2 btn-success"><a>
                    <i class="fa fa-plus"></i>
                    تعديل </a></button>
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('store.items.create') }}">
                    <i class="fa fa-plus"></i>
                    إضافة </a></button>
            <button type="button" class="btn btn-sm px-2 btn-outline-danger"><a
                    href="{{ route('store.items.remove', [$item->id]) }}">
                    <i class="fa fa-plus"></i>
                    حذف </a></button>
        </div>
        <style>
            .form-wrapper {
                box-shadow: 0 0 5px 2px #ccc;

            }

            form.change-image {

                border: 1px solid #777;
                width: 300px;
                height: 300px;
                border-radius: 20px;
                overflow: hidden;
            }

            .change-image-buttons {
                position: relative;
                display: flex;
            }

            .change-image-btn,
            form.change-image label {
                border: 0;
                outline: 0;
                border-top: 1px solid #777;
                font-size: 16px;
                font-weight: bold;
                height: 50px;
                line-height: 50px;
                background-color: #eee;
                flex: auto;
                text-align: center;
                cursor: pointer
            }

            form.change-image input[type=file] {
                display: none;
            }

            form.change-image label {
                right: 0;
                border-left: 1px solid #777;
            }

            .change-image-btn {
                left: 0;
            }
        </style>
        <fieldset>
            <legend>تحديث بيانات صنف ثلاجة</legend>

            <br>
            <div class=" p-3">

                <div class="form-wrapper mb-3 p-4" dir="rtl">
                    <form action="{{ route('store.items.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <div class="input-group mb-3">
                            <label for="name" class="input-group-text"> اسم الصنف </label>
                            <input type="text" class="form-control" name="name" id="name" required
                                value="{{ $item->name }}">
                        </div>
                        <div class="input-group mb-3">
                            <label for="short" class="input-group-text"> الاسم المختصر </label>
                            <input type="text" class="form-control" name="short" id="short" required
                                value="{{ $item->short }}">
                        </div>
                        <div class="input-group mb-3">
                            <label for="brief" class="input-group-text"> الوصف </label>
                            <input type="text" class="form-control" name="brief" id="brief" required
                                value="{{ $item->brief }}">
                        </div>

                        <div class="buttons">
                            <button class="btn btn-outline-info" type="reset">اعادة ضبط</button>
                            <button class="btn btn-outline-primary" type="submit">تحديث</button>
                        </div>
                    </form>
                </div>

                <div class="form-wrapper p-3" dir="rtl">
                    <form class="change-image" action="{{ route('store.items.change.image') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <img id="item-image" class="item-image" width="300" height="250"
                            src="{{ asset('storage/app/admin/uploads/images/' . ($item->pic == 'none' ? 'default.png' : $item->pic)) }}"
                            alt="">

                        <input type="file" name="pic" required id="pic" accept="image/*"
                            onchange="loadFile(event)" />
                        <div class="change-image-buttons">
                            <label for="pic">اختر صورة من جهازك</label>
                            <button class="change-image-btn" data-bs-toggle="tooltip" title="تغيير الصورة">
                                {{ $item->pic == 'none' ? 'إضافة صورة' : 'تغيير الصورة' }}
                            </button>
                        </div>
                    </form>

                </div>

            </div>


        </fieldset>
        <br>


    </div>
@endsection


@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="
                                https://cdn.jsdelivr.net/npm/FileReader@0.10.2/FileReader.min.js
                                "></script>
    <script>
        function loadFile(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('item-image');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
