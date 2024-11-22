@extends('layouts.admin')

@section('title')
	تقارير العملاء
@endsection

@section('pageHeading')
	تقرير العناصر
@endsection

@section('content')
	<style>
		.storeItems input[type=checkbox]~label {
			border: 1px solid #ccc;
			background-color: rgba(255, 255, 255, 0.527);
			padding: 0.3rem 1.3rem
		}

		.storeItems input[type=checkbox]:checked~label {
			background-color: #a9cce98f;
			color: #0f068a;
			border: 1px solid rgb(21, 168, 226);
		}
	</style>
	<div class="container py-4">
		<nav>
			<div class="nav nav-tabs " id="nav-tab" role="tablist" style="border: 0;">
				<button class="nav-link ">
					<a class="px-3" href="{{ route('clients.home', [2]) }}">العملاء</a>
				</button>
				<button class="nav-link">
					<a class="px-3" href="{{ route('clients.reports.storeitems') }}">
						تقرير كميات صنف
					</a>
				</button>

				<button class="nav-link active">
					<a class="px-3">
						تقرير كميات الأصناف
					</a>
				</button>
			</div>
		</nav>
		<div class="tab-content p-3" id="nav-tabContent" style="background-color: #fff">

			<fieldset>
				<form action="{{ route('clients.items.stats') }}" method="POST">
					@csrf

					<legend>الفلترة حسب: </legend>
					<br />
					<div class="storeItems row">

						@foreach ($storeItems as $id => $item)
							<div class="col col-2">
								<input class="btn-check " id="query_{{ $id }}" type="checkbox" type="checkbox" {{ itemExists($id, $query) ? 'checked' : '' }}
									name="searchQuery[]" value="{{ $id }}" /><label class="d-block text-center" for="query_{{ $id }}">
									{{ $item }}</label>
							</div>
						@endforeach

					</div>
					<button class="btn btn-outline-primary btn-block" id="aj_search" name="search">البحث عن العناصر
						المختارة</button>
				</form>
			</fieldset>

			{{-- {{ $collection }} --}}

			<fieldset class="mt-5">
				<legend>نتيجة البحث</legend>

				<table class="w-100 my-3">

					<thead>
						<tr>
							<th>#</th>
							<th>الصنف</th>
							<th>العميل</th>
							<th>حجم الكرتون</th>
							<th>الكمية</th>
						</tr>
					</thead>

					@php
						$counter = 0;
						$total = 0;
					@endphp

					@if ($query)
						@foreach ($collection as $index => $item)
							@if ($item->remaining <= 0)
								@continue
							@endif
							<tr>
								<td>{{ ++$counter }}</td>
								<td>{{ $item->itemName }}</td>
								<td>{{ $item->clientAName }}</td>
								<td>{{ $item->boxName }}</td>
								<td>{{ $item->remaining }}</td>
								@php $total+= $item->remaining @endphp
							</tr>
						@endforeach
						<tfoot>
							<tr>
								<td colspan="4">الاجمالى</td>
								<td>{{ $total }}</td>
							</tr>
						</tfoot>
						@if ($counter == 0)
							<tr>
								<td colspan="5">
									لا يوجد عناصر تطابق فلاتر البحث
								</td>
							</tr>
						@endif
					@else
						<tr>
							<td colspan="5">
								من فضلك اختر صنف أو أكثر ليتم البحث
							</td>
						</tr>
					@endif
				</table>
			</fieldset>

		</div>
	</div>

@endsection

@section('script')
	<script></script>
@endsection
