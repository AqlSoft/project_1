@extends('layouts.admin')
@section('title')
    أحجام الكرتون
@endsection

@section('pageHeading')
    أحجام الكرتون
@endsection

@section('content')
    <div class="container pt-3">
        <style>
            .item {
                height: 72px;
                border: 1px solid #cde;
                margin: 3px 8px;
                overflow: hidden;
                display: flex;
            }

            .item-image {
                height: 72px;
                width: 80px;
                background-color: #333;
                background-size: cover;
            }

            .item-name {
                width: calc(100%-180px);
                height: 72px;
                text-align: right;
                width: calc(100% - 80px);
            }

            .item-controls {
                display: inline-block;
                width: 180px;
                text-align: center;
            }
        </style>

        <div class="buttons">
            <button type="button" class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('box.size.stats') }}"> <i
                        class="fa fa-chart-line"></i>
                    احصائيات</a></button>
            <button type="button" class="btn btn-sm px-2 btn-success"><a> <i class="fa fa-list"></i>
                    أحجام الركرتون</button>

            <button type="button" class="btn btn-sm px-2 btn-outline-primary">
                <i class="fa fa-plus"></i>
                إضافة</button>

        </div>

        <fieldset>
            <legend>أحجام الركرتون</legend>
            <br>

            <div class="search">
                <form method="POST">
                    <div class="row mb-3">
                        <div class="col col-5">
                            <div class="input-group">
                                <input type="text" data-search-token="{{ csrf_token() }}"
                                    data-search-url="{{ route('treasuries.aj') }}" class="form-control" name="search"
                                    id="aj_search">
                                <label for="aj_search" class="input-group-text"><i class="fa fa-search"></i></label>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <br>
            @php
                $public_folder = asset('storage/app/admin/uploads/images/');
            @endphp

            <div class="row p-3">

                @if (count($boxes))
                    @foreach ($boxes as $in => $item)
                        <div class="col col-12 col-sm-6">
                            <div class="item">

                                <div class="item-image"
                                    style="background-image: url('{{ $public_folder . '/' . ($item->pic == 'none' ? 'default.png' : $item->pic) }}')">
                                </div>
                                <div class="item-name pr-3">
                                    {{ $item->name }} - {{ $item->short }}

                                    <div class="buttons">
                                        <button class="btn btn-outline-success btn-sm"><i
                                                class="fa fa-edit text-success"></i> تعديل </button>
                                        <button class="btn btn-outline-primary btn-sm"><i
                                                class="fa fa-eye text-primary"></i> رؤية المزيد </button>
                                        <button class="btn btn-outline-danger btn-sm"><a
                                                onclick="if(!confirm('انت على وشك القيام بعملية لا يمكن الرجوع عنها، هل انت متأكد؟ّ')) {return false}"
                                                href="{{ route('box.size.destroy', [$item->id]) }}"><i
                                                    class="fa fa-trash text-danger"></i> حذف </a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
            </div>
            <div class="col col-12 text-right">لم تتم إضافة أصناف بعد، استخدم النموذج بالأسفل لإضافة أصناف.</div>
            @endif
    </div>

    {{ $boxes->links() }}
    <br>
    <form action="{{ route('box.size.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group">
            <label class="input-group-text" for="name">الاسم الكامل</label>
            <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
            <label class="input-group-text" for="short">الاسم المختصر</label>
            <input class="form-control" type="text" name="short" id="short" value="{{ old('short') }}">
            <input class="form-control" type="file" name="pic" id="pic" value="{{ old('pic') }}">
            <button class="input-group-text" type="submit">الحفظ</button>
        </div>
    </form>
    </fieldset>
    <br>

    {{-- <fieldset>
        <legend>احجام الكرتون والصناديق</legend>
        <br>
        <div class="row p-3">
            
            @if (count($boxes)) @php $b = 0 @endphp
            @foreach ($boxes as $ib => $box)
            <div class="col col-lg-3 col-sm-6" style="position: relative; height: 32px; border: 1px solid #cde">
                <div style="display: inline-block; width: 40px; height: 30px; text-align:center; position: absolute; right: 0">{{++$b}}</div>
                <div class="pr-3" style="display: inline-block; width: calc(100%-100px); height: 30px; text-align: right; position: absolute; right: 35px; left: 35px">{{$box->name}}</div>
                <div style="display: inline-block; width: 40px; height: 30px; text-align:center; position: absolute; left: 0"><a href="{{route('store.items.remove', $box->id)}}"><i class="fa fa-trash text-danger"></i></a></div>
            </div>
            @endforeach
            @else 
            <div class="col col-12 text-right">لم تتم إضافة أصناف بعد، استخدم النموذج بالأسفل لإضافة أصناف.</div>
            @endif
        </div>

        {{$boxes->links()}}
        <br>
        <form action="{{route('store.box.size.add')}}" method="POST">
            @csrf
            <div class="input-group">
                <label class="input-group-text" for="name">اسم الصنف</label>
                <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}">
                <label class="input-group-text" for="short">اسم الصنف</label>
                <input class="form-control" type="text" name="short" id="short" value="{{old('name')}}">
                <button class="input-group-text" type="submit">الحفظ</button>
            </div>
        </form>
    </fieldset> --}}
    </div>


@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>

    <script>
        function fetchData(url) {
            document.addEventListener('click', callback(e))

            function(event) {
                console.log(event.target)
            }
        }
    </script>
@endsection
