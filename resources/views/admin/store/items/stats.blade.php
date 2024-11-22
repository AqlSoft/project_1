@extends('layouts.admin')
@section('title')
	احصائيات أصناف التخزين
@endsection

@section('pageHeading')
	احصائيات أصناف التخزين
@endsection

@section('content')
	<div class="container">

		<fieldset>
			<legend class="custom-bg">اسماء الأصناف</legend>
			<div class="m-4 bg-light" style="box-shadow: 0 0 8px 3px #777 inset">
				<div class="buttons py-2">
					<div class="buttons">
						<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store.items.stats') }}"> <i class="fa fa-chart-line"></i>
								احصائيات</a></button>
						<button class="btn btn-sm px-2 btn-success" type="button"><a> <i class="fa fa-list"></i>
								الأصناف</button>
						<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store-items-categories-list') }}">
								<i class="fa fa-tags"></i>
								الفئات </a></button>
						<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store-items-grades-list') }}">
								<i class="fa fa-ranking-star"></i>
								الدرجات </a></button>
					</div>
				</div>
			</div>

			<div class="search pr-4">
				<form method="POST">
					<div class="row mb-3">
						<div class="col col-5">
							<div class="input-group">
								<label class="input-group-text" for="aj_search">البحث في الاحصائيات</label>
								<input class="form-control bg-light" id="aj_search" data-search-token="{{ csrf_token() }}" data-search-url="{{ route('treasuries.aj') }}"
									type="text" name="search">
								<label class="input-group-text" for="aj_search"><i class="fa fa-search"></i></label>
							</div>
						</div>
					</div>
				</form>

			</div>

			<div class="m-4" style="background-color: #fff; box-shadow: 0 0 8px 3px #777 inset">
				@if (count($items))
					<div class="row p-3">
						{{--  assets\admin\uploads\images\store_item_1710668689.png --}}
						@foreach ($items as $in => $item)
							<div class="col col-12 col-sm-6">
								<div class="item">

									<div class="item-image" style="background-image: url('{{ asset('storage/assets/admin/uploads/images/' . $item->pic) }}')">
									</div>
									<div class="item-name pr-3">
										{{ $item->name }}

										<div class="buttons">
											<button class="btn btn-outline-success btn-sm"><a href="{{ route('store.items.edit', [$item->id]) }}"> <i
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
					</div>
				@else
					<div class="col col-12 text-right">لم تتم إضافة أصناف بعد، استخدم النموذج بالأسفل لإضافة أصناف.</div>
				@endif
			</div>

		</fieldset>

	</div>

@endsection

@section('script')
	<script type="text/javascript" src="{{ asset('assets/admin/js/treasury/search.datatables.js') }}"></script>
@endsection
