@extends('layouts.admin')
@section('title') تصنيفات المبيعات @endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') تصنيفات المبيعات @endsection
@section('homeLinkActive') الرئيسية @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.cats.create', 1) }}"><span class="btn-title">Go Home</span><i class="fa fa-plus text-light"></i></a></button>
    <button class="btn btn-sm btn-primary"><a href="{{ route('items.setting') }}"><span class="btn-title">Settings</span><i class="fa fa-cogs text-light"></i></a></button>
@endsection
@section('content')
{{-- <ul dir="rtl" style="text-align: right">
    @foreach($cats as $i => $cat)@if ($cat->level == 1)
    <li>{{$cat->a_name}}
        <ul>
        @foreach($cats as $i => $ch1) @if ($ch1->level == 2 && $ch1->parent_cat == $cat->id)
            <li>{{$ch1->a_name}}
                <ul>
                    @foreach($cats as $i => $ch2) @if ($ch2->level == 3 && $ch2->parent_cat == $ch1->id)
                    <li>{{$ch2->a_name}}</li>
                    @endif @endforeach
                </ul>
            </li>
            @endif @endforeach
        </ul>
    </li>
    @endif @endforeach
</ul> --}}
    <div class="container">
        <div class="row">
            {{-- <div class="col col-4">
                <fieldset class="">
                    <legend>الجذر</legend>
                    <div class="accordion" id="rootLevel" style="position:relative;">
                        <div class="vLine" style="top: -16px; bottom: 10px"></div>
                        @foreach($allCats as $i => $root) @if ($root->level==1)
                            <div class="accordion-item">

                                <div class="accordion-header">
                                    <span class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#root{{$root->code}}" aria-expanded="true" aria-controls="root{{$root->code}}">
                                        &#8211;<i class="fa fa-folder"></i></span>&#8211;<span data-id="{{ $root->id }}" data-level="{{ $root->level }}" class="ml-2 parent catItem">{{$root->a_name}}</span>
                                </div>
                                <div id="root{{$root->code}}" class="accordion-collapse collapse" data-bs-parent="#rootLevel">
                                    <div class="accordion-body">
                                        <div class="vLine" style="left: 19px"></div>
                                       
                                        <div class="accordion" style="margin-left: 20px;" id="catsLevel">
                                            @foreach($allCats as $ii => $cat) @if ($cat->level == 2 && $cat->parent_cat == $root->id)
                                            <div class="accordion-item">
                                                <div class="accordion-header">
                                                    <span class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#cat{{$cat->code}}" aria-expanded="true" aria-controls="cat{{$cat->code}}">
                                                    &#8211;<i class="fa fa-folder"></i>
                                                </span>&#8211;<span data-id="{{ $cat->id }}" data-level="{{ $cat->level }}" class="ml-2 parent catItem">{{$cat->a_name}}</span>
                                                </div>
                                                <div id="cat{{$cat->code}}" class="accordion-collapse collapse" data-bs-parent="#catsLevel">
                                                    <div class="accordion-body">
                                                        <div class="vLine" style="left: 16px"></div>
                                                        @foreach($allCats as $iii => $child) @if ($child->level == 3 && $child->parent_cat==$cat->id )
                                                            <div class="ml-3 accordion-header">
                                                                &#8212;<span data-id="{{ $child->id }}" data-level="{{ $child->level }}" class="ml-2 child catItem">{{$child->a_name}}</span>
                                                            </div>
                                                        @endif @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            @endif @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif @endforeach
                    </div>
                </fieldset>
            </div> --}}
            <div class="col col-12">
                <fieldset>
                    <legend>التصنيفات</legend>
<br>
                    <table class="striped" dir="rtl" id="data" style="width: 100%"> 
                        <thead>
                        <tr class="text-center">
                            <th>م</th>
                            <th>الاسم</th>
                            <th>التصنيف الأب</th>
                            <th>الكــــود</th>
                            <th>المستوى</th>
                            <th>الضبــــــط</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count( $cats)) @php $index = 1 @endphp @foreach($cats as $in => $cat)
                            @if ($cat->id > 1) 
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $cat->a_name }}</td>
                                <td>{{ $cat->parent->a_name }}</td>
                                <td>{{ $cat->code }}</td>
                                <td>{{ $cat->level }}</td>
                                <td>
                                
                                    <a href="{{route('items.cats.edit', $cat->id)}}"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('items.cats.copy', $cat->id)}}"><i class="fa fa-copy"></i></a>
                                    <a href="{{route('items.cats.delete', $cat->id)}}" onclick="return confirm('أنت تقوم بحذف أحد التصنيفات، هذه الخطوة لا يمكن التراجع عنها، هل أنت متأكد؟')"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        @else
                            <tr>
                                <td colspan="7">No measuring units inserted yet</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                {{ $cats->links() }}

                </fieldset>
            </div>

            
        </div>

 
    </div>

    <div class="alterContext">
        <ul class="menu-items">
            <li class="context-menu-item">
                <a id="addLink" data-add-item="{{ route('item.create', 1) }}" data-url="{{ route('items.cats.create', 000) }}" href="">Add New Category</a>
            </li>
            <li class="context-menu-item">
                <a id="editLink" data-url="{{ route('items.cats.edit', 000) }}" href="">Edit Category</a>
            </li>
            <li class="context-menu-item">
                <a id="deleteLink" data-url="{{ route('items.cats.delete', 000) }}" href="">Delete Category</a>
            </li>
        </ul>
    </div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
    <script>
        $('.accordion-button i').click(function () {
            $(this).toggleClass('fa-folder-open fa-folder')
        })
        const cm = $('.alterContext');
        const ci = $('.catItem');
        ci.on('contextmenu', (e) => {
            e.preventDefault();
            showContextMenu();
            let c_id = e.target.getAttribute('data-id'), c_lvl = e.target.getAttribute('data-level')
            let cm_top = e.clientY + cm.offsetHeight > window.innerHeight ? window.innerHeight - cm.offsetHeight : e.clientY+'px';
            let cm_left = e.clientX + cm.offsetWidth > window.innerWidth ? window.innerWidth - cm.offsetWidth : e.clientX +'px';
            let al = $('#addLink'), el = $('#editLink'), dl = $('#deleteLink');
            cm.css({
                top: cm_top,
                left: cm_left
            })

            if (c_lvl == 3) {
                al.text('Add New Item');
                al.attr('href', al.attr('data-add-item').replace(/1/g, c_id));
            } else {
                al.text('Add New Category');
                al.attr('href', al.attr('data-url').replace(/0/g, c_id));
            }
            el.attr('href', el.attr('data-url').replace(/0/g, c_id));
            dl.attr('href', dl.attr('data-url').replace(/0/g, c_id));

        })
        $(window).on('click', () => {
            showContextMenu(false);
        })

        function showContextMenu(show = true) {
            cm.css({
                height: show ? 'auto': 0,
            })
        }
    </script>
@endsection

