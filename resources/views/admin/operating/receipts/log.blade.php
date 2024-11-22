@extends('layouts.admin')

@section('title')
    سندات الإدخال
@endsection
@section('homePage')
    {{ auth()->user()->company_name }}
@endsection
@section('homeLink')
    سندات الإدخال
@endsection
@section('homeLinkActive')
    سند إدخال جديد
@endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('receipt.create', 0) }}"><span class="btn-title">إضافة
                سند</span><i class="fa fa-plus text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('clients.home') }}"><span class="btn-title">العودة إلى
                العملاء</span><i class="fa fa-home text-light"></i></a></button>
@endsection

@section('content')

    <div class="container pt-5">
        <fieldset style="">
            <legend>
                سجل السندات المحذوفة
            </legend>

            <table class="w-100 mt-5">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>التاريخ</td>
                        <td>رقم السند</td>
                        <td>السائق</td>
                        <td>العقد</td>
                        <td>العميل</td>
                        <td>تحكم</td>
                    </tr>
                </thead>
                <tbody>
                    @if (count($receipts))
                        @foreach ($receipts as $in => $item)
                            <tr>
                                <td>{{ ++$in }}</td>
                                <td>{{ $item->hij_date }}</td>
                                <td>{{ $item->s_number }}</td>
                                <td>{{ $item->driver }}</td>
                                <td>{{ $item->contract->s_number }}</td>
                                <td>{{ $item->client->name }}</td>
                                <td>
                                    <a href="{{ route('receipt.edit', [$item->id, 0]) }}"><i class="fa fa-edit text-primary"
                                            title="إدخال بضاعة على السند"></i></a>
                                    @if ($item->type == 1)
                                        <a href="{{ route('receipt.entry.in', [$item->id, 0]) }}"><i
                                                class="fa fa-sign-out-alt text-info" title="استلام بضاعة على السند"></i></a>
                                    @else
                                        <a href="{{ route('receipt.entry.out', [$item->id, 0]) }}"><i
                                                class="fa fa-sign-out-alt text-info" title="إخراج بضاعة على السند"></i></a>
                                    @endif
                                    <a href="{{ route('receipt.destroy', [$item->id, 0]) }}"><i
                                            class="fa fa-trash text-danger" title="حذف السند"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">
                                لا يوجد سندات معدلة أو محذوفة

                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </fieldset>
    </div>

@endsection
@section('script')
    <script></script>
@endsection
