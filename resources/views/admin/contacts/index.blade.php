@extends('layouts.admin')
@section('title')
    جهات الاتصال
@endsection
@section('pageHeading')
    جهات الاتصال
@endsection

@section('content')
    <div class="container p-3" style="min-height: 100vh">

        <fieldset>
            <legend style="top: -1.5rem; border-radius: 0.375rem">
                جهات الاتصال &nbsp; &nbsp;
                <button class="btn btn-sm btn-outline-success"><a data-bs-toggle="tooltip" data-bs-title="إضافة جهة اتصال"
                        href="{{ route('contacts.create') }}"><i class="fa fa-plus"></i></a></button>
            </legend>

            <table class="w-100 my-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الهاتف</th>
                        <th>البريد الالكترونى</th>
                        <th>الإقامة</th>
                        <th>الوظيفة</th>
                        <th><i class="fa fa-cogs"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @if (null != count($contacts))
                        @foreach ($contacts as $index => $c)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ $c->name }}</td>
                                <td>{{ $c->phone }}</td>
                                <td>{{ $c->email }}</td>
                                <td>{{ $c->iqama }}</td>
                                <td>{{ $c->rule }}</td>
                                <td>
                                    <a class="btn py-1 btn-sm btn-outline-info" data-bs-toggle="tooltip"
                                        data-bs-title="عرض بيانات جهة اتصال"
                                        href="{{ route('contacts.show', [$c->id]) }}"><i class="fa fa-eye"></i></a>
                                    <a class="btn py-1 btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                        data-bs-title="تعديل بيانات جهة اتصال"
                                        href="{{ route('contacts.edit', [$c->id]) }}"><i class="fa fa-edit"></i></a>
                                    <a class="btn py-1 btn-sm btn-outline-danger" data-bs-toggle="tooltip"
                                        data-bs-title="حذف بيانات جهة اتصال"
                                        href="{{ route('contacts.destroy', [$c->id]) }}"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">لم يتم بعد إدخال أى جهات اتصال</td>
                        </tr>
                    @endif
                </tbody>
            </table>


        </fieldset>

    </div>
@endsection


@section('script')
@endsection
