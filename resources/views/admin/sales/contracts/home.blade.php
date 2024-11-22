@extends('layouts.admin')
@section('title')
	العقود
@endsection

@section('pageHeading')
	الصفحة الرئيسية
@endsection

@section('links')
	<button class="btn btn-sm btn-primary"><a href="{{ route('item.create') }}"><span class="btn-title">إضافة صنف خدمى</span><i
				class="fa fa-tag text-light"></i></a></button>
	<button class="btn btn-sm btn-primary"><a href="{{ route('items.cats.create', 0) }}"><span class="btn-title">إضافة تصنيف
				مبيعات</span><i class="fa fa-tags text-light"></i></a></button>
	<button class="btn btn-sm btn-primary"><a href="{{ route('contract.create', 0) }} "><span class="btn-title">إضافة عقد
				خدمات</span><i class="fa fa-plus text-light"></i></a></button>
@endsection
@section('content')
	<div class="container py-5">
		<h4 class="col col-5 text-right">العقود</h4>
		<div class="search">
			<form method="POST">
				<div class="row mb-3">
					<div class="col col-5">
						<div class="input-group">
							<label class="input-group-text" for="aj_search"><i class="fa fa-search"></i></label>
							<input class="form-control" id="aj_search" data-search-token="{{ csrf_token() }}" data-search-url="{{ route('treasuries.aj') }}" type="text"
								name="search">
						</div>
					</div>
				</div>
			</form>
		</div>
		<div id="data_show">
			<table class="" id="myTable" dir="rtl" style="width:100%">
				<thead>
					<tr>
						<th>م</th>
						<th>الرقم المسلسل</th>
						<th>العميل</th>
						<th>نوع العقد</th>
						<th>الحالة</th>

					</tr>
				</thead>
				<tbody>

					@if (count($contracts))
						@if (isset($contracts) && !empty($contracts))
							@foreach ($contracts as $in => $contract)
								<tr>
									<td>{{ ++$in }}</td>

									<td>{{ $contract->s_number }}</td>
									<td>{{ $contract->client->a_name }}</td>
									<td>{{ $contract->contract_type }}</td>
									<td>
										<a href="{{ route('contract.view', [$contract->id, 1]) }}"><i class="fa fa-eye text-primary"></i></a>
										@if ($contract->status != 1)
											<a href="{{ route('contract.edit', [$contract->id, 1]) }}"><i class="fa fa-edit text-primary"></i></a>
											<a href="{{ route('contract.delete', [$contract->id]) }}"><i class="fa fa-trash text-danger"></i></a>
											<form style="display: inline" action="{{ route('contract.approve', $contract->id) }}" method="post">
												@csrf
												<input type="hidden" name="id" value="{{ $contract->id }}">
												<button style="display: inline; background: #0000; border: none;" type="submit"><i class="text-success fas fa-check"
														data-bs-toggle="tooltop" data-bs-title="اعتماد العقد"></i></button>
											</form>
										@else
											<a href="{{ route('contract.park', [$contract->id]) }}"><i class="fa fa-parking text-info" title="إيقاف العقد للتعديل"></i></a>
											<a href="{{ route('receipts.input.create', [$contract->id]) }}"><i class="fa fa-spinner fa-fw" title="إضافة سندات على العقد"></i></a>
											<a href="{{ route('contract.print', [$contract->id]) }}"><i class="fa fa-print fa-fw" title="طباعة العقد"></i></a>
										@endif
									</td>
								</tr>
							@endforeach
						@endif
					@else
						<tr>
							<td colspan="5">No data to display</td>
						</tr>
					@endif
				</tbody>
			</table>
			{{ $contracts->links() }}
		</div>

	</div>

@endsection

@section('script')
	<script src="{{ asset('resources\js\datatablesar.js') }}"></script>
	<script>
		let table = new DataTable('#myTable');
	</script>
@endsection
