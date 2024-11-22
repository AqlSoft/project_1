@extends('layouts.admin')
@section('title') الأصناف @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') الأصناف @endsection
@section('homeLinkActive') الرئيسية @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('item.create', 1) }}"><span class="btn-title">إضافة صنف جديد</span><i class="fa fa-plus text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.setting') }}"><span class="btn-title">Settings</span><i class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')

    <div class="container">
        <div class="search">
            <form method="POST">
                <div class="row mb-3">
                    <div class="col col-5">
                        <div class="input-group">
                            <label for="aj_search" class="input-group-text"><i class="fa fa-search"></i></label>
                            <input type="text" data-search-token="{{ csrf_token() }}" data-search-url="{{ route('treasuries.aj') }}" class="form-control" name="search" id="aj_search">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="border">
                <table class="striped" dir="rtl" id="data" style="width: 100%"> 
                    <thead>
                    <tr class="text-center">
                        <th>م</th>
                        <th>الاسم</th>
                        <th>الوحدة</th>
                        <th>التصنيف</th>
                        <th>الباركــــود</th>
                        <th>الضبــــــط</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($items)) @foreach($items as $in => $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->a_name }}</td>
                            
                            <td>{{ $item->unit }}</td>
                            <td>{{ $item->parent_cat }}</td>
                            <td>{{ $item->barcode }}</td>
                            <td>
                                <a href="{{route('item.view', $item->id)}}"><i class="fa fa-eye"></i></a>
                                <a href="{{route('item.show', $item->id)}}"><i class="fa fa-edit"></i></a>
                                <a href="{{route('item.copy', $item->id)}}"><i class="fa fa-copy"></i></a>
                                <a href="{{route('item.delete', $item->id)}}"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>

                    @endforeach
                    @else
                        <tr>
                            <td colspan="7">No measuring units inserted yet</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            {{ $items->links() }}


            </div>


    </div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
    <script>

    </script>
@endsection
