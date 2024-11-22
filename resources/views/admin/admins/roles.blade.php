@extends('layouts.admin')
@section('title')
    {{ $admin->userName }}
@endsection

@section('content')
    <div class="container" style="min-height: 100vh">

        @include('admin.admins.profile-top')
        <div class="card m-0 card-default">
            <div class="card-header">
                <h2>الأدوار والصلاحيات</h2>
                
            </div>
            <div class="card-body">
                @if (!empty($roles))
                <div class="accordion" id="rpAccordion">
                    
                    @php $c=0 @endphp
                    @foreach ($roles as $role)
                        <div class="card">
                            <div class="card-header" id="headingBorder_{{ $role->id }}">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-counter="{{ $c++ }}"
                                        data-toggle="collapse" data-target="#collapseBorder_{{ $role->id }}"
                                        aria-expanded="{{ $c >= 1 ? 'false' : 'true' }}"
                                        aria-controls="collapseBorder_{{ $role->id }}">
                                        {{ $role->display_name }}
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseBorder_{{ $role->id }}" class="collapse {{ $c >= 1 ? 'show' : '' }}"
                                aria-labelledby="headingBorder_{{ $role->id }}" data-parent="#rpAccordion">
                                <div class="card-body">
                                    @foreach ($role->permissions as $rp)
                                        <button class="btn btn-sm mb-1 btn-outline-success button-pill">
                                            {{ $rp->display_name }}

                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                    <div class="alert alert-info">لا يوجد أدوار مخصصة لهذا المدير حتى الآن، يمكنك <a href="{{route('')}}"></a></div>
                @endif
            </div>
        </div>
    @endsection


    @section('script')
    @endsection
