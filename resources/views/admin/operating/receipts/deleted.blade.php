@extends('layouts.admin')

@section('title')
    سندات الإدخال
@endsection

@section('pageHeading')
    عرض سندات الإدخال
@endsection


@section('content')
    <div class="container pt-5" style="min-height: 100vh">
        <table>
            <tr>
                <td>id</td>
                <td>receipt_id</td>
            </tr>
            @foreach ($deleted as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->receipt_id }}</td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection


@section('script')
@endsection
