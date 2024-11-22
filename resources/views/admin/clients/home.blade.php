@extends('layouts.admin')

@section('title')
	العملاء
@endsection

@section('pageHeading')
	عرض جميع العملاء
@endsection

@section('content')
	<style>
		.client-info {
			display: block;
		}

		.client-info:hover {
			background-color: var(--blue);
			color: var(--white)
		}
	</style>
	<div class="container">
		<fieldset>
			<legend class="custom-bg">عرض قائمة العملاء &nbsp; &nbsp;
				<a class="btn btn-sm btn-outline-light" data-bs-toggle="tooltip" data-bs-title="تعديل بيانات عميل" href="{{ route('clients.create') }}"><i
						class="fa fa-edit"></i></a>
			</legend>
			<div class="m-4 bg-light p-4" style="box-shadow: 0 0 8px 3px #777 inset">

				<div class="buttons" role="tablist" style="border: 0">
					<button class="btn btn-outline-secondary">
						<a href="{{ route('clients.home', [2]) }}">العملاء</a>
					</button>
					<button class="btn btn-outline-secondary">
						<a href="{{ route('clients.stats') }}">
							احصائيات العميل &nbsp;

						</a>
					</button>
					<button class="btn btn-outline-secondary">
						<a href="{{ route('clients.reports.home') }}">تقارير العملاء</a>
					</button>
				</div>

				<div class="search">
					<div class="input-group">
						<label class="input-group-text" for="aj_search"><i class="fa fa-search"></i></label>
						<input class="form-control" id="aj_search_by_number" data-search-token="{{ csrf_token() }}" data-search-url="{{ route('arrange.search') }}"
							type="text" placeholder="ابحث بالرقم المسلسل">
						<input class="form-control" id="aj_search_by_contract" data-search-token="{{ csrf_token() }}" data-search-url="{{ route('arrange.search') }}"
							type="text" placeholder="ابحث برقم العقد">
						<input class="form-control" id="aj_search" data-search-token="{{ csrf_token() }}" data-search-url="{{ route('clients.aj') }}" type="text"
							name="search" placeholder="ابحث باسم العميل">
					</div>

				</div>
			</div>

			<div class="m-4 bg-light p-4" id="clients_data" style="box-shadow: 0 0 8px 3px #777 inset">
				<table dir="rtl" style="width: 100%">
					<thead>
						<tr class="text-center">
							<th>#</th>
							<th>اسم العميل</th>
							<th>الهاتف</th>
							<th>مجال العمل</th>
							<th>أدوات التحكم</th>
						</tr>
					</thead>
					<tbody>
						@if (count($clients2))
							@php $i=1;  @endphp
							@php
								$page = request()->query('page') ? request()->query('page') : 1;
							@endphp
							@foreach ($clients2 as $cl => $client)
								<tr>
									<td>{{ ($page - 1) * 10 + $i }}</td>
									<td>
										<a class="client-info btn btn-info  py-1 px-3" data-bs-toggle="tooltip" href="{{ route('clients.view', [$client->id]) }}"
											title="عرض بيانات العميل">[ {{ $client->s_number }} ] -
											-
											{{ $client->a_name }} - {{ $client->e_name }}
										</a>
										<div class="clients-contracts py-2">
											@if (count($client->contracts))
												@foreach ($client->contracts as $cc => $contract)
													<span class="badge badge-{{ $contract->status === 1 ? 'success' : 'secondary' }} py-1 px-3" style="text-align: right">
														<a data-bs-toggle="tooltip" title="عرض تفاصيل العقد"
															href="{{ route('contract.view', [$contract->id, 2]) }}">{{ $contract->s_number }}</a>
														<a href="{{ route('edit-contract-basic-info', [$contract->id]) }}"><i class="fa fa-edit"></i></a>
														<a
															onclick="if(!confirm('انت هتمسح العقد باللى فيه، انت متأكد من اللى هتعمله ده؟')){}else{window.location.href = '{{ route('delete-contract', [$contract->id]) }}'}"><i
																class="fa fa-trash text-danger"></i></a>
													</span>
												@endforeach
											@else
												<div class="buttons p-0">
													<button class="btn btn-warning btn-sm btn-block">
														لا يوجد عقود مسجلة لهذا العميل
													</button>

												</div>
											@endif

									</td>

									<td>{{ $client->phone }}</td>
									<td>{{ $scope[$client->industry] }}</td>
									<td>
										<div class="buttons">
											<button class="btn btn-outline-success btn-sm"><a href="{{ route('contract.create', [$client->id]) }}"><i class="fa fa-plus"
														title="إضافة عقد  جديد"></i> عقد جديد </a>
											</button>
											<button class="btn btn-outline-danger btn-sm">
												<a href="{{ route('clients.delete', [$client->id]) }}"
													onclick="return confirm('هل تريد حذف هذا العميل بالفعل؟، هذه الحركة لا يمكن الرجوع عنها.')"><i class="fa fa-trash" title="حذف العميل"></i>
													حذف </a>
											</button>
										</div>
									</td>
								</tr>
								@php
									$i++;
								@endphp
							@endforeach
						@else
							<tr>
								<td colspan="7">لم يتم بعد تسجيل عملاء حتى الان <a href="{{ route('clients.create') }}">أدخل
										عميلك الأول!</a></td>
							</tr>
						@endif
					</tbody>
				</table>
				<div class="mt-3">
					{{ $clients2->links() }}
				</div>
			</div>
	</div>
	</div>
@endsection

@section('script')
	<script>
		$(document).ready(function() {
			$(document).on('input', '#aj_search', function() {
				let ajax_search_url = $('#aj_search').attr('data-search-url');
				let ajax_search_token = $('#aj_search').attr('data-search-token');
				let ajax_search_query = $('#aj_search').val();

				console.log(ajax_search_token);
				jQuery.ajax({
					url: ajax_search_url,
					type: 'post',
					dataType: 'html',
					data: {
						search: ajax_search_query,
						'_token': ajax_search_token,
						ajax_search_url: ajax_search_url
					},
					cash: false,
					success: function(data) {
						$('#clients_data').html(data);
					},
					error: function() {

					}
				});
			});

			$(document).on('click', '#search ul.pagination li a', function(e) {
				e.preventDefault();
				let ajax_search_url = $(this).attr('href');
				console.log(ajax_search_url)
				let ajax_search_token = $('#aj_search').attr('data-search-token');
				let ajax_search_query = $('#aj_search').val();

				console.log(ajax_search_token);
				jQuery.ajax({
					url: ajax_search_url,
					type: 'post',
					dataType: 'html',
					data: {
						search: ajax_search_query,
						'_token': ajax_search_token
					},
					cash: false,
					success: function(data) {
						$('#clients_data').html(data);
					},
					error: function() {

					}
				});
			});

		});
	</script>
@endsection
