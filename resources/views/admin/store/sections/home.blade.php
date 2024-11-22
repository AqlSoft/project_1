@extends('layouts.admin')

@section('title')
    الأقسام
@endsection

@section('pageHeading')
    عرض جميع الأقسام
@endsection
@section('content')
    <div class="container">
        <style>
            section#sections button {
                font-size: 90px;
                font-weight: bold;
            }
        </style>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
                <button class="nav-link">
                    <a href="{{ route('stores.home') }}">التخزين</a>
                </button>
                <button class="nav-link active">
                    <a>
                        الأقسام
                    </a> &nbsp; 
                    <a href="{{route('sections.create')}}"><i class="fa fa-plus"></i></a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('rooms.home') }}">الغرف</a>
                </button>
                <button class="nav-link">
                    <a href="{{ route('store.storeArray') }}">مصفوفة التخزين</a>
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent" style="background-color: #fff">
            <section>
                <h2>
                    مخازن أيمن العماس للتخزين.
                </h2>
            </section>
            <section id="sections" class="bg-warning px-5 py-3">
                <div class="row">
                    @foreach ($sections as $i => $section)
                    <div class="col col-3">
                        <div class="bg-light">
                            <button style="height: 200px;" class="btn btn-block btn-outline-primary">
                                <a href="{{{route('sections.view', $section->id)}}}">{{$section->code}}</a>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    
                    
                </div>
            </section>

        </div>

    </div>
@endsection

@section('script')
    <script></script>
@endsection
