@extends('layouts.admin')
@section('title')
	فئات أصناف التخزين
@endsection
@section('pageHeading')
	اسماء فئات الأصناف  المخزنة بالثلاجة
@endsection

@section('content')
	<div class="container">
		<fieldset>
			<legend>اسماء  الفئات</legend>
			<div class="m-4 bg-light " style="box-shadow: 0 0 10px 3px #777 inset">
				<div class="buttons">
					<button class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('store.items.stats') }}"> <i class="fa fa-chart-line"></i>
							احصائيات</a></button>
					<button class="btn btn-sm px-2 btn-outline-primary"><a href="{{ route('store.items.home') }}"> <i class="fa fa-list"></i>
							الأصناف</a></button>
					<button class="btn btn-sm px-2 btn-success"><a> <i class="fa fa-tags"></i>
							الفئات</a></button>
					<button class="btn btn-sm px-2 btn-outline-secondary"><a href="{{ route('store-items-grades-list') }}"> <i class="fa fa-ranking-star"></i>
						الدرجات</a></button>
				</div>
			</div>

			<div class="search mr-4">
				<form method="POST">
					<div class="row mb-3">
						<div class="col col-5">
							<div class="input-group">
								<label class="input-group-text" for="aj_search">البحث فى الفئات</label>
								<input class="form-control bg-light" id="aj_search" data-search-token="{{ csrf_token() }}" data-search-url="{{ route('treasuries.aj') }}"
									type="text" name="search">
								<label class="input-group-text" for="aj_search"><i class="fa fa-search"></i></label>
							</div>
						</div>
					</div>
				</form>

			</div>

			<div class="m-4 p-4 bg-light " style="box-shadow: 0 0 10px 3px #777 inset">

				<div class="row">
					{{--  storage\app\admin\uploads\images\store_item_1710668689.png --}}
					@if (count($categories))
						@foreach ($categories as $in => $item)
							<div class="col col-12 col-lg-6 col-xl-4">
								<div class="item">
									<div class="item-image"
										style="width: 50px; height: 50px; margin: 0.5rem; background-image: url('{{ url('assets/admin/uploads/images', $item->image) }}'); background-size: 100% 100%; border-radius: 50%">
									</div>
									<div class="item-name pr-3 fw-bold">
										{{ $item->parent_id === 10 ? '' : @$item->parent->name . ' > ' }}{{ $item->name }}

										<div class="buttons">
											<button class="btn btn-outline-success btn-sm"><a href="{{ route('store-items-categories-edit', [$item->id]) }}"> <i
														class="fa fa-edit text-success"></i> تعديل </a></button>
											<button class="btn btn-outline-primary btn-sm"><a href="{{ route('store.items.view', [$item->id]) }}"><i class="fa fa-eye text-primary"></i>
													رؤية المزيد </a></button>
											<button class="btn btn-outline-danger btn-sm"><a href="{{ route('store.items.remove', [$item->id]) }}"><i
														class="fa fa-trash text-danger"></i> حذف </a></button>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					@else
						<div class="col col-12 text-right">لم تتم إضافة فئات بعد، استخدم النموذج بالأسفل لإضافة فئات للتطبيق.</div>
					@endif
				</div>
                <div class="px-4 py-0 m-0">
					{{ $categories->links() }}
				</div>					
                    <div class="hr"></div>
                <div class="row py-0 px-3">
    				<form class="col col-md-12 col-lg-6" action="{{ route('store-items-categories-store') }}" method="POST" enctype="multipart/form-data">
    					@csrf
    					<div class="input-group mb-2">
    						<label class="input-group-text required" for="parent">اسم الفئة الرئيسية</label>
    						<select class="form-control" id="parent" name="parent" value="{{ old('parent') }}">
    							<option value="10">فئة رئيسية</option>
    							@if (count($parents))
    								
    								@foreach ($parents as $category)
    								   
    									    <option value="{{ $category->id }}">{{ @$category->parent->name }} > {{ $category->name }}</option>
									 
    								@endforeach
    								
    							@endif
    						</select>
						</div>
						<div class="input-group mb-2">
    						<label class="input-group-text required" for="name">اسم الفئة</label>
    						<input class="form-control" id="name" required type="text" name="name" value="{{ old('name') }}">
						</div>
						<div class="input-group mb-2">
    						<input class="form-control" id="pic" type="file" name="pic" value="{{ old('pic') }}">
    					</div>
    					<div class="input-group mb-2">
    						<label class="input-group-text" for="brief">الوصف المختصر للفئة</label>
    						<input class="form-control" id="brief" type="text" name="brief" value="{{ old('brief') }}">
						</div>
						<div class="input-group">
    						<button class="btn btn-block btn-outline-primary" type="submit">إضافة فئة جديدة</button>
    					</div>
    				</form>
				</div>
			</div>
		</fieldset>
		<br>
	</div>
@endsection

@section('script')
	<script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>

	<script>
		function fetchData(url) {
			document.addEventListener('click', callback(e))
		}
	</script>
@endsection
