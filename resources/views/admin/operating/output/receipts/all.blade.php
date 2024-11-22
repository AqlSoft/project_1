@extends('layouts.admin')

@section('title')
	سندات الإخراج
@endsection

@section('pageHeading')
	عرض سندات الإخراج
@endsection

@section('content')

	<div class="container mb-3 py-5">
		<nav>
			<div class="nav nav-tabs p-0" id="nav-tab" role="tablist" style="border: 0;">
				<button class="nav-link p-0">
					<a class="px-3" href="{{ route('operating.home', [2]) }}">الرئيسية</a>
				</button>
				<button class="nav-link p-0 {{ $tab == 1 ? 'active' : '' }}">
					<a class="px-3" href="{{ route('delivery.home', [1]) }}">
						السندات ( الجارية ) تحت الاجراء &nbsp;
						<a class="btn btn-primary text-light m-1" data-bs-toggle="tooltip" data-bs-title="إضافة سند استلام جديد"
							href="{{ route('delivery.create', [0]) }}"><i class="fa fa-plus"></i></a>
					</a>
				</button>
				<button class="nav-link p-0  {{ $tab != 1 ? 'active' : '' }}">
					<a class="px-3" href="{{ route('delivery.home', [2]) }}">السندات المعتمدة</a>
				</button>
			</div>
		</nav>
		<div class="tab-content" id="nav-tabContent" style="background-color: #fff">
			<div class="section-heading">
				<div class="search">
					<div class="input-group">
						<label class="input-group-text" for="aj_search"><i class="fa fa-search"></i></label>
						<input class="form-control" id="aj_search_by_number" data-search-token="{{ csrf_token() }}" data-search-url="{{ route('delivery.search') }}"
							data-tab="{{ $tab }}" type="text" placeholder="ابحث بالرقم المسلسل">
						<input class="form-control" id="aj_search_by_contract" data-search-token="{{ csrf_token() }}"
							data-search-url="{{ route('receipts.search_input_receipts') }}" data-tab="{{ $tab }}" type="text" placeholder="ابحث برقم العقد">
						<input class="form-control" id="aj_search_by_client" data-search-token="{{ csrf_token() }}"
							data-search-url="{{ route('receipts.search_input_receipts') }}" data-tab="{{ $tab }}" type="text" placeholder="ابحث باسم العميل">
					</div>
				</div>
			</div>

			<div id="receipts_data">
				<table class="w-100">
					<thead>
						<tr>
							<th>#</th>
							<th>التاريخ</th>
							<th>رقم السند</th>
							<th>مرجعى</th>
							<th>العقد</th>
							<th>اجمالي</th>
							<th><i class="fa fa-cogs"></i></th>
						</tr>
					</thead>
					<tbody>
						@if (count($receipts))
							@foreach ($receipts as $in => $item)
								<tr>
									<td>{{ ++$in }}</td>
									<td>
										{{ $item->hij_date }} <br>
										{{ $item->greg_date }}
									</td>
									<td>
										<a class="btn btn-sm displayReceipt btn-block p-1 mb-1 bg-secondary" class="fa fa-eye text-primary" data-receipt-id="{{ $item->id }}"
											data-search-token="{{ csrf_token() }}" data-search-url="{{ route('delivery.info') }}" data-tab="1" data-bs-toggle="tooltip"
											data-bs-title="عرض محتويات السند">{{ $item->s_number }}</a>
										<span class="btn btn-sm btn-block p-1 mb-1 bg-secondary">بواسطة:
											{{ $item->the_admin }}</span>
									</td>
									<td>
										السائق
										: {{ $item->driver }} <br>
										ملاحظات: {{ $item->notes }}
									</td>
									<td><a class="btn btn-sm btn-block p-1 mb-1 bg-secondary" data-bs-toggle="tooltip" data-bs-title="رؤية العقد"
											href="{{ route('contract.view', [$item->contract_id, 5]) }}">العقد:
											{{ $item->contract_serial }}</a>

										<a class="btn btn-sm btn-block p-1 bg-secondary" data-bs-toggle="tooltip" data-bs-title="رؤية العميل"
											href="{{ route('clients.view', [$item->client_id]) }}"> العميل:
											{{ $item->client_name }}</a>
									</td>
									<td>{{ $item->total_outputs }}</td>
									<td>
										<a class="displayReceipt" data-receipt-id="{{ $item->id }}" data-search-token="{{ csrf_token() }}"
											data-search-url="{{ route('delivery.info') }}"><i class="fa fa-eye text-primary" data-bs-toggle="tooltip"
												data-bs-title="عرض محتويات السند"></i></a>
										@if ($tab == 1)
											<a href="{{ route('delivery.entries.create', [$item->id, 0]) }}"><i class="fa fa-sign-in-alt text-info" data-bs-toggle="tooltip"
													data-bs-title="استلام بضاعة على السند"></i></a>

											<a href="{{ route('delivery.approve', [$item->id]) }}"><i class="fa fa-check text-success" data-bs-toggle="tooltip"
													data-bs-title="اعتماد السند"></i></a>

											<a href="{{ route('delivery.edit', [$item->id]) }}"><i class="fa fa-edit text-primary" data-bs-toggle="tooltip"
													data-bs-title="تعديل بيانات السند"></i></a>
											<a class="" data-tab="1" href="{{ route('stores.table.position', [$item->id]) }}"><i class="fa fa-th text-primary"
													data-bs-toggle="tooltip" data-bs-title="تسكين طبالى السند"></i></a>

											<a href="{{ route('delivery.destroy', [$item->id]) }}"
												onclick="if (!confirm('انت على وشك القيام بعملية لا يمكن الرجوع نها، هل أنت متأكد؟')) return false"><i
													class="fa fa-trash text-danger"data-bs-toggle="tooltip" data-bs-title="حذف السند"></i></a>
										@else
											<a href="{{ route('delivery.print', [$item->id]) }}"><i class="fa fa-print text-primary px-1" data-bs-toggle="tooltip"
													data-bs-title="طباعة السند"></i></a>

											<a class="" data-tab="1" href="{{ route('stores.table.position', [$item->id]) }}"><i class="fa fa-th text-primary"
													data-bs-toggle="tooltip" data-bs-title="تسكين طبالى السند"></i></a>
											<a href="{{ route('delivery.park', [$item->id, 0]) }}" onclick="if(!confirm('are you sure?')return false)"><i
													class="fas fa-ban text-info px-1" data-bs-toggle="tooltip" data-bs-title="إتاحة السند للتعديل"></i></a>
										@endif
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="5"> لا يوجد سندات إخراج
									{{ $tab == 1 ? 'قيد التشغيل' : 'معتمدة' }} حتى الآن

								</td>
							</tr>
						@endif
					</tbody>
				</table>

				<div class="my-3">
					{{ $receipts->links() }}
				</div>
			</div>
		</div>

	</div>
	<div id="receitInfo">
		show
	</div>
@endsection

@section('script')
	<script>
		$(document).ready(function() {

			$('#aj_search_by_number').focus();
			$('#aj_search_by_number').val(localStorage.getItem('output_search_by_number_value'));

			$(document).on('input', '#aj_search_by_number', function() {
				let ajax_search_url = $('#aj_search_by_number').attr('data-search-url');
				let ajax_search_token = $('#aj_search_by_number').attr('data-search-token');
				let ajax_search_query = $('#aj_search_by_number').val();
				let ajax_search_tab = $('#aj_search_by_number').attr('data-tab');


				jQuery.ajax({
					url: ajax_search_url,
					type: 'post',
					dataType: 'html',
					data: {
						search: ajax_search_query,
						'_token': ajax_search_token,
						ajax_search_url: ajax_search_url,
						tab: ajax_search_tab
					},
					cash: false,
					success: function(data) {
						localStorage.setItem('output_search_by_number_value', ajax_search_query)
						$('#receipts_data').html(data);
					},
					error: function() {

					}
				});
			});

			$(document).on('click', '#search ul.pagination li a', function(e) {
				e.preventDefault();
				let ajax_search_url = $(this).attr('href');
				let ajax_search_token = $('#aj_search').attr('data-search-token');
				let ajax_search_query = $('#aj_search').val();
				let ajax_search_tab = $('#aj_search').attr('data-tab');


				jQuery.ajax({
					url: ajax_search_url,
					type: 'post',
					dataType: 'html',
					data: {
						search: ajax_search_query,
						'_token': ajax_search_token,
						tab: ajax_search_tab
					},
					cash: false,
					success: function(data) {
						$('#receipts_data').html(data);
					},
					error: function() {

					}
				});
			});

			$(document).on('click', '.displayReceipt', function(e) {
				e.preventDefault();
				let ajax_search_url = $(this).attr('data-search-url');
				let ajax_search_token = $(this).attr('data-search-token');
				let ajax_search_id = $(this).attr('data-receipt-id');
				let ajax_search_tab = $(this).attr('data-tab');

				console.log(ajax_search_token);
				jQuery.ajax({
					url: ajax_search_url,
					type: 'post',
					dataType: 'html',
					data: {
						id: ajax_search_id,
						'_token': ajax_search_token,
						tab: ajax_search_tab
					},
					cash: false,
					success: function(data) {
						//console.log(data)
						$('#receitInfo').html(data);
						$('#receitInfo').addClass('show');

					},
					error: function() {

					}
				});
			});

		});
	</script>
@endsection
