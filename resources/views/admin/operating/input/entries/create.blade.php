@extends('layouts.admin')

@section('title')
	استلام بضاعة
@endsection
@section('pageHeading')
	استلام بضاعة على السند
@endsection

@section('content')

	<div class="container pt-3">
		<nav>
			<div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">

				<button class="nav-link">
					<a href="{{ route('operating.home', [2]) }}">الرئيسية</a>
				</button>
				<button class="nav-link">
					<a href="{{ route('reception.home', [1]) }}">
						السندات الجارية
					</a>
				</button>
				<button class="nav-link active">
					انشاء سند جديد

				</button>

			</div>
		</nav>
		<div class="tab-content" id="nav-tabContent" style="background:#fff">
			@if ($receipt->confirmation !== 'approved')
				<fieldset class="mt-5 mx-3">
					<legend>
						تخصيص طبالى على السند
					</legend>
					<br>

					<form action="{{ route('reception.entries.store') }}" method="POST">
						@csrf
						<input type="hidden" name="receipt_id" value="{{ $receipt->id }}">
						<div class="input-group">
							<label class="input-group-text" for="table">طبلية رقم </label>
							<input class="form-control" id="table" type="number" name="table_name" value="{{ old('table_name') }}" placeholder=" رقم الطبلية ">
							<label class="input-group-text" id="table_size_display">
								صغيرة
							</label>
							<input id="table_size" type="hidden" name="table_size" required>

							<label class="input-group-text" for="item">الصنف</label>
							<select class="form-control" id="item" name="item_id" required>
								@if (count($items))
									@foreach ($items as $item)
										<option {{ old('item_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">
											{{ $item->short }}</option>
									@endforeach
								@endif
							</select>
							<label class="input-group-text" for="box_size">حجم الكرتون</label>
							<select class="form-control" id="box_size" name="box_size">
								<option hidden disabled selected>حجم الكرتون</option>
								@if (count($boxes))
									@foreach ($boxes as $box)
										<option {{ old('box_size') == $box->id ? 'selected' : '' }} value="{{ $box->id }}">
											{{ $box->short }}</option>
									@endforeach
								@endif
							</select>
							<label class="input-group-text" for="inputs">الكمية المدخلة</label>
							<input class="form-control" id="inputs" type="number" name="inputs" value="{{ old('inputs') }}">
							<button class="input-group-text" id="submitEntry" type="submit" style="color: rgb(5, 160, 5)">إضافة</button>
						</div>
					</form>

				</fieldset>
			@endif

			<fieldset class="mt-5 mx-3">
				<legend>سند استلام بضاعة رقم" <span class="text-danger"> {{ $receipt->s_number }} </span></legend>
				<br>

				<div class="row receipt_info">
					<div class="col col-4">
						<span class="label">التاريخ: </span>
						<span class="data">{{ $receipt->greg_date }}</span>
					</div>
					<div class="col col-4">
					</div>
					<div class="col col-4">
						<span class="label">مسلسل: </span>
						<span class="data">{{ $receipt->s_number }}</span>
					</div>

					<div class="col col-4">
						<span class="label" id="current_client" data-client-id="{{ $client->id }}">العميل: </span>
						<span class="data" data-bs-toggle="tooltip" title="عرض بيانات العميل"><a
								href="{{ route('clients.view', [$client->id]) }}">{{ mb_substr($client->a_name, 0, 25) }}</a></span>
					</div>
					<div class="col col-4 text-center m-0 text-primary">
						<h3>
							سند استلام بضاعة</h3>
					</div>
					<div class="col col-4">
						<span class="label"> المزرعة / المصدر: </span>
						<span class="data">{{ $receipt->farm }}</span>
					</div>
					<div class="col col-8">
						<span class="label"> أخرى: </span>
						<span class="data">{{ $receipt->notes }}</span>
					</div>
					<div class="col col-4">
						<span class="label"> العقد: </span>

						<span class="data" data-bs-toggle="tooltip" title="الذهاب إلى العقد"><a href="{{ route('contract.view', [$contract->id, 2]) }}">

								{{ $contract->s_number }}</a></span>
					</div>
				</div>
				@php $counter = 1 @endphp
				@if (count($entries))
					@foreach ($entries as $index => $entry)
						{{-- {{ $entry }} --}}
						<form class="mt-1" id="form_{{ $index }}" action="{{ route('reception.entries.update') }}" method="POST">
							@csrf
							<input type="hidden" name="entry_id" value="{{ $entry->id }}">
							<div class="input-group">
								<label class="input-group-text">{{ str_pad($counter++, 2, '0', STR_PAD_LEFT) }}</label>
								<label class="input-group-text">طبلية رقم:</label>
								<label class="input-group-text">
									{{ str_pad($entry->table->name, 5, '00000', STR_PAD_LEFT) }}

								</label>
								<label class="input-group-text" for="item_{{ $index }}">الصنف</label>
								<select class="form-control" id="item_{{ $index }}" data-form-id="#form_{{ $index }}" name="item_id" required>
									@if (count($items))
										@foreach ($items as $item)
											<option {{ $entry->item_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->short }}</option>
										@endforeach
									@endif

								</select>

								<label class="input-group-text" for="box_{{ $index }}">الحجم</label>
								<select class="form-control" id="box_{{ $index }}" data-form-id="#form_{{ $index }}" name="box_size" required>
									<option hidden disabled selected>حجم الكرتون</option>
									@if (count($boxes))
										@foreach ($boxes as $box)
											<option {{ $entry->box_size == $box->id ? 'selected' : '' }} value="{{ $box->id }}">{{ $box->short }}</option>
										@endforeach
									@endif
								</select>

								<input class="form-control" id="qty" data-form-id="#form_{{ $index }}" type="number" name="inputs"
									value="{{ $entry->inputs }}" placeholder="الكمية المدخلة 1234" required>
								@if ($receipt->confirmation !== 'approved')
									<label class="input-group-text"> <a href="{{ route('receipt.entry.delete', $entry) }}"><i class="fa fa-trash text-danger"
												style="border-radius: opx"></i></a>
									</label>
									<button class="input-group-text text-primary" id="button_{{ $index }}" type="submit">تحديث</button>
								@endif
							</div>

						</form>
					@endforeach
				@else
					<div class="text-right">لم يتم بعد إضافة أى إدخالات على هذا السند</div>
				@endif
				<div class="buttons">
					<button class="btn btn-outline-primary btn-sm">
						<a href="{{ route('reception.home', [1]) }}"> العودة لسندات الاستلام </a>
					</button>
					@if (count($entries))
						@if ($receipt->confirmation == 'approved')
							<button class="btn btn-outline-primary btn-sm"><a href="{{ route('reception.park', $receipt->id) }}">
									فك الاعتماد
								</a></button>
						@else
							<button class="btn btn-outline-primary btn-sm"><a href="{{ route('reception.approve', $receipt->id) }}">اعتماد

								</a></button>
						@endif
						<button class="btn btn-outline-primary btn-sm"><a href="{{ route('reception.print', $receipt->id) }}">
								عرض
							</a></button>
					@endif
					<button class="btn btn-outline-primary btn-sm"><a href="{{ route('contract.view', [$contract->id, 2]) }}">
							الذهاب للعقد
						</a></button>
				</div>

			</fieldset>
		</div>
	</div>

@endsection
@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
			$('#table').focus();
			$('#table').select();
		})
		$(document).on('change', '#table', function() {
			if ($('#table').val() < 3000) {
				$('#table_size').val(1)
				$('#table_size_display').text("صغيرة")
				console.log($('#table_size').attr('value'))
			} else {
				$('#table_size').val(2)
				$('#table_size_display').text('كبيــرة')
				console.log($('#table_size').attr('value'))
			}
		})
	</script>
@endsection
