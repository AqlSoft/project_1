@extends('layouts.admin')
@section('title', 'Admin Dashboard Setting')
@section('homePage') Dashboard Setting @endsection
@section('homeLink') Dashboard Setting @endsection
@section('homeLinkActive') Show All @endsection
@section('content')
    <table>
        @if ($data)
            <tr>
                0 <td>Company Name</td>01
                <td>{{ $data['name'] }}</td>
            </tr>

            <tr>
                <td>Icon</td>
                <td><img width="200" class="shadow border" src="{{ asset('/storage/app/' . $data['icon']) }}"
                        alt="Company Logo"></td>
            </tr>

            <tr>
                <td>Status</td>
                <td>{{ $data['status'] == 1 ? 'active' : 'Paused' }}</td>
            </tr>

            <tr>
                <td>General Atert</td>
                <td>{{ $data['general_alert'] }}</td>
            </tr>

            <tr>
                <td>Address</td>
                <td>{{ $data['address'] }}</td>
            </tr>

            <tr>
                <td>Phone Number</td>
                <td>{{ $data['phone'] }}</td>
            </tr>

            <tr>
                <td>Last Time Updated</td>
                <td>
                    <span class="border p-2">{{ date('Y m d', strtotime($data['updated_at'])) }}</span>
                    <span class="border p-2">{{ date('h:i', strtotime($data['updated_at'])) }}</span>
                    <span class="border p-2">{{ date('A', strtotime($data['updated_at'])) }}</span>
                    By:
                    {{ $data['updated_by'] }}
                </td>
            </tr>
        @else
            <tr>

                <td colsopan="2"><a href="{{ route('admin.dashboard.edit') }}"><button type="button"
                            class="btn btn-primary">Edit Settings</button></a>
                </td>
            </tr>
        @endif
    </table>
@endsection
