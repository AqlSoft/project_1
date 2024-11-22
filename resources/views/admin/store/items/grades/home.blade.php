@extends('layouts.admin')
@section('title')
	أصناف التخزين
@endsection
@section('pageHeading')
	اسماء الأصناف المخزنة بالثلاجة
@endsection

@section('content')
	<div class="container pt-3">

		<fieldset>
			<legend>اسماء الأصناف</legend>
			<br>

			<div class="m-4 bg-light " style="box-shadow: 0 0 10px 3px #777 inset">
				<div class="buttons">
					<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store.items.stats') }}"> <i class="fa fa-chart-line"></i>
							احصائيات</a></button>
					<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store.items.home') }}"> <i class="fa fa-list"></i>
							الأصناف</button>
					<button class="btn btn-sm px-2 btn-outline-success" type="button"><a href="{{ route('store-items-categories-list') }}"> <i
								class="fa fa-tags"></i>
							الفئات</button>

					<button class="btn btn-sm px-2 btn-primary" type="button"><a>
							<i class="fa fa-ranking-star"></i>
							الدرجات </a></button>

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
					<div class="col col-6">
						<table class="w-100">
							<thead>
								<tr>
									<th>#</th>
									<th>الاسم</th>
									<th>الاسم المختصر</th>
									<th><i class="fa fa-cogs"></i></th>
								</tr>
							</thead>
							<tbody>
								@if (count($grades))
									@php $c = 0 @endphp
									@foreach ($grades as $in => $item)
										<tr>
											<td>{{ ++$c }}</td>
											<td>{{ $item->name }}</td>
											<td>{{ $item->short }}</td>
											<td>
												<button class="btn btn-outline-success btn-sm"><a href="{{ route('store-items-grades-edit', [$item->id]) }}"> <i class="fa fa-edit"></i>
													</a></button>
												<button class="btn btn-outline-primary btn-sm"><a href="{{ route('store-items-grades-view', [$item->id]) }}"><i class="fa fa-eye"></i>
													</a></button>
												<button class="btn btn-outline-danger btn-sm"><a href="{{ route('store-items-grades-remove', [$item->id]) }}"><i class="fa fa-trash"></i>
													</a></button>
											</td>
										</tr>
									@endforeach
								@else
									<div class="col col-12 text-right">لم تتم إضافة درجات للأصناف بعد، استخدم النموذج بالأسفل لإضافة درجات الأصناف للتطبيق.</div>
								@endif

							</tbody>
						</table>
					</div>
					<div class="col col-6">
						<form class="p-4" action="{{ route('store-items-grades-store') }}" method="POST">
							@csrf
							<h4 class="text-right">أضافة اسم درجة جودة جديدة</h4>
							<div class="input-group mb-3">
								<label class="input-group-text required" for="name">اسم الدرجة</label>
								<input class="form-control" id="name" required type="text" name="name" value="{{ old('name') }}">
							</div>
							<div class="input-group mb-3">
								<label class="input-group-text" for="short">الاسم المختصر</label>
								<input class="form-control" id="short" type="text" name="short" value="{{ old('short') }}">
							</div>
							<div class="input-group">
								<button class="form-control" type="submit">الحفظ</button>
							</div>
						</form>
					</div>
				</div>
				{{--  storage\app\admin\uploads\images\store_item_1710668689.png --}}

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
