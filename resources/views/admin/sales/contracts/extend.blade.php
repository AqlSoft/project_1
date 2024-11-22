@extends('layouts.admin')

@section('title')
    العملاء
@endsection

@section('pageHeading')
    عرض جميع العملاء
@endsection

@section('content')
    <style>
        table,
        table thead tr,
        table tbody tr,
        table tr th,
        table tr td {
            border-color: var(--green)
        }

        .flex-form {
            display: flex;

        }

        .flex-form table {
            flex: 3;
        }

        .flex-form>div.submit {
            flex: 1;
        }

        .flex-form>div.submit button {
            height: 100%;
        }
    </style>

    <div class="container pt-5">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link">
                    <a href="{{ route('clients.home', [2]) }}">العملاء</a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('clients.view', [$contract->client]) }}">
                        صفحة العميل
                    </a>
                </button>
                <button class="nav-link active">
                    <a>
                        تمديد العقد رقم: {{ $contract->s_number }}
                    </a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('contract.view', [$contract->id, 1]) }}">
                        عرض العقد
                    </a>
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background-color: #fff">
            {{-- <h4 class="text-right">{{ $client->a_name }} - {{ $client->e_name }}</h4> --}}

            <h4 class="text-right">تمديد العقد رقم: </h4>

            <form action="{{ route('contract.update.extend') }}" method="POST" class="flex-form d-flex">
                @csrf
                <input type="hidden" name="id" value="{{ $contract->id }}">
                <table class="w-75 col col-auto">
                    <tr>
                        <th class="text-left">بداية العقد:</th>
                        <td class="cal-1">
                            <span style="padding: 0 1em;" id="starts_in_greg_display">{{ $contract->starts_in_greg }}</span>
                        </td>
                        <th class="text-left">الموافق:</th>
                        <td class="cal-2">
                            <span style="padding: 0 1em;" id="starts_in_hijri_display">{{ $contract->starts_in_hij }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-left">نهاية العقد:</th>
                        <td class="cal-1">
                            <input type="date" class="dateGrabber" data-target="ends_in" style="width: 30px"
                                id="ends_in">
                            <span style="padding: 0 1em;" id="ends_in_greg_display">{{ $contract->ends_in_greg }}</span>
                            <input type="hidden" name="ends_in_greg" id="ends_in_greg_input"
                                value="{{ $contract->ends_in_greg }}">
                        </td>

                        <th class="text-left">الموافق:</th>
                        <td class="cal-2">
                            <span style="padding: 0 1em;" id="ends_in_hijri_display">{{ $contract->ends_in_hij }}</span>
                            <input type="hidden" name="ends_in_hij" id="ends_in_hijri_input"
                                value="{{ $contract->ends_in_hij }}">
                        </td>
                    </tr>
                </table>
                <div class="submit">
                    <button class="btn btn-outline-success btn-block fw-bold">تمديــــــــــــــــــــد</button>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('script')
    <script>
        let dateInputs = ['ends_in'];

        window.onload = function() {
            dateInputs.forEach((id) => {
                const dateInput = document.getElementById(id)
                //updateOnload (id)
                dateInput.onchange = function(e) {
                    updateOnchange(e.target.id)
                }
            })
        }

        function updateOnchange(id) {
            let today = new Date(document.getElementById(id).value);
            document.getElementById(id + '_greg_display').innerHTML = today.toLocaleDateString('en-eg')
            document.getElementById(id + '_greg_input').value = dateFormatNumeral(today)
            document.getElementById(id + '_hijri_display').innerHTML = today.toLocaleDateString('ar-sa')
            document.getElementById(id + '_hijri_input').value = today.toLocaleDateString('ar-sa')
        }

        function dateFormatNumeral(date) {
            return date.getFullYear() + '-' + [date.getMonth() + 1] + '-' + date.getDate();
        }
    </script>
@endsection
