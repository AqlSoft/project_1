@extends('layouts.admin')

@section('title')
	اخراج بضاعة
@endsection
@section('pageHeading')
	إخراج بضاعة على سند
@endsection

@section('content')

	<div class="container mb-5">
		@if ($receipt->confirmation != 'approved')
			<fieldset>
				<legend class="custom-bg">
					اختيار طبالى لإخراجها على السند
				</legend>

				<div class="border p-3 m-4 bg-light" style="box-shadow: 0 0 8px 3px #777 inset">
					@if (count($tables))
						<form class="mb-1" id="myForm" action="{{ route('delivery.entries.store') }}" method="POST">
							@csrf
							<input type="hidden" name="receipt_id" value="{{ $receipt->id }}">
							<input id="contract_id" type="hidden" name="contract_id" value="{{ $receipt->contract_id }}">

							<div class="input-group">

								<label class="input-group-text">طبلية رقم:</label>
								<input class="form-control" class="search_pallet" id="searchPallet" type="number" name="table" placeholder="البحث">
								<select class="form-control" id="pick_table_id" name="table_id">
									<option hidden>اختر الطبلية</option>
									@foreach ($tables as $i => $table)
										<option value="{{ $table->table_id }}">{{ $table->name }}</option>
									@endforeach
								</select>

								<select class="form-control" id="pick_item_id" name="item_id">
									<option hidden>اختر الصنف</option>
								</select>
								<select class="form-control" id="pick_box_size" name="box_size">
									<option hidden>اختر الحجم</option>
								</select>
								<input class="form-control" id="pic_qty" type="number" name="outputs">
								<button class="input-group-text">إضافة إلى السند</button>

							</div>
							@error('table_id')
								<p><small class="alert alert-sm text-danger">{{ $message }}</small></p>
							@enderror
							@error('inputs')
								<p><small class="alert alert-sm text-danger">{{ $message }}</small></p>
							@enderror
							@error('box_size')
								<p><small class="alert alert-sm text-danger">{{ $message }}</small></p>
							@enderror
							@error('item_id')
								<p><small class="alert alert-sm text-danger">{{ $message }}</small></p>
							@enderror

						</form>
						<script>
							const input1 = document.querySelector('#searchPallet');
							const input2 = document.querySelector('#pick_item_id');
							const input3 = document.querySelector('#pick_box_size');
							const input4 = document.querySelector('#pic_qty');

							input1.addEventListener('keydown', function(e) {
								if (entered(e)) {
									input2.focus()
								}
							});
							input2.addEventListener('keydown', function(e) {
								if (entered(e)) {
									input3.focus()
								}
							});
							input3.addEventListener('keydown', function(e) {
								if (entered(e)) {
									input4.focus()
								}
							});


							function entered(evt) {
								return evt.keyCode === 13
							}
						</script>
					@else
						<div class="text-right"> لا يوجد أى بضاعة لاخراجها</div>
					@endif
				</div>
			</fieldset>
		@endif
		<fieldset>
			<legend class="custom-bg">
				محتويات السند
			</legend>
			<div class="border p-3 m-4 bg-light" style="box-shadow: 0 0 8px 3px #777 inset">
				<br>
				@php $counter = 1 @endphp
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
						<span class="label" id="current_client" data-client-id="{{ $receipt->client_id }}">العميل:
						</span>

						<span class="data" data-bs-toggle="tooltip" title="عرض بيانات العميل"><a
								href="{{ route('clients.view', [$receipt->client->id]) }}">{{ $receipt->theClient->a_name }}</a></span>
					</div>
					<div class="col col-4 text-center m-0 text-primary">
						<h3>
							سند {{ $receipt->type == 1 ? 'استلام' : 'تسليم' }} بضاعة</h3>
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
						<span class="data" data-bs-toggle="tooltip" title="عرض بيانات العقد">
							<a href="{{ route('contract.view', [$receipt->contract_id, 5]) }}">{{ $receipt->contract->s_number }}</a></span>
					</div>
				</div>
			</div>
			<div class="border p-3 m-4 bg-light" style="box-shadow: 0 0 8px 3px #777 inset">
				@if (isset($receipt_entries) && count($receipt_entries))
					@foreach ($receipt_entries as $index => $entry)
						<form class="mt-1" id="form_{{ $index }}" action="{{ route('delivery.entries.update') }}" method="POST">

							@csrf
							<input type="hidden" name="id" value="{{ $entry->id }}">
							<div class="input-group">
								<label class="input-group-text">{{ str_pad($counter++, 2, '0', STR_PAD_LEFT) }}</label>
								<input class="form-control update-input" id="" data-form-id="#form_{{ $index }}" type="number" name="table_name"
									value="{{ $entry->table->name }}">
								<input class="form-control update-input" id="" data-form-id="#form_{{ $index }}" type="hidden" name="table_id"
									value="{{ $entry->table_id }}">

								<select class="form-control update-input" id="item" data-form-id="#form_{{ $index }}" name="item">
									<option hidden>الصنف</option>
									@if (count($items))
										@foreach ($items as $item)
											<option {{ $entry->item_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->parent->name }} {{ $item->name }}
											</option>
										@endforeach
									@endif

								</select>

								<select class="form-control update-input" id="box" data-form-id="#form_{{ $index }}" name="box">
									<option hidden>حجم الكرتون</option>
									@if (count($boxes))
										@foreach ($boxes as $box)
											<option {{ $entry->box_size == $box->id ? 'selected' : '' }} value="{{ $box->id }}">{{ $box->short }}</option>
										@endforeach
									@endif
								</select>

								<input class="form-control update-input" id="qty" data-form-id="#form_{{ $index }}" type="number" name="outputs"
									value="{{ $entry->outputs }}" placeholder="الكمية المدخلة 1234">
								@if ($receipt->confirmation != 'approved')
									<label class="input-group-text"> <a href="{{ route('receipt.entry.delete', $entry->id) }}"><i class="fa fa-trash text-danger"
												style="border-radius: opx"></i></a> </label>
									<button class="input-group-text text-primary" id="button_{{ $index }}" type="submit">تحديث</button>
								@endif
							</div>

						</form>
					@endforeach
				@else
					<div class="text-right">لم يتم بعد إضافة أى إدخالات على هذا السند</div>
				@endif
			</div>
			<div class="border p-3 m-4 bg-light" style="box-shadow: 0 0 8px 3px #777 inset">
				<div class="buttons m-0 p-0 justify-content-end" style="border: 0">
					<button class="btn btn-sm btn-outline-primary"><a href="{{ route('delivery.home', [1]) }}">
							سندات الإخراج </a></button>
					@if (isset($receipt_entries) && count($receipt_entries))
						<button class="btn btn-sm btn-outline-primary"><a href="{{ route('delivery.print', [$receipt->id]) }}">عرض</a></button>
						@if ($receipt->confirmation == 'inprogress')
							<button class="btn btn-sm btn-outline-primary"><a href="{{ route('delivery.approve', [$receipt->id]) }}">
									اعتماد
								</a></button>
						@else
							<button class="btn btn-sm btn-outline-primary"><a href="{{ route('delivery.park', [$receipt->id]) }}">
									فك الاعتماد
								</a></button>
						@endif
					@endif
					<button class="btn btn-sm btn-outline-primary"><a href="{{ route('contract.view', [$receipt->contract_id, 5]) }}">
							العقد</a></button>
				</div>
			</div>

		</fieldset>
	</div>
@endsection
@section('script')
	<script type="text/javascript">
		window.onload = function() {
			document.getElementById('myForm').reset();
			$('#searchPallet').focus()

		}



		$(document).on('keyup', '#searchPallet', function() {

			for (key in $('#pick_table_id option')) {
				if ($('#pick_table_id option')[key].value == undefined) continue
				if ($(this).val() == $('#pick_table_id option')[key].textContent) {
					$('#pick_table_id option')[key].setAttribute('selected', 'true')

				}
			}

			var myFormData = new FormData($('#form_id')[0])
			if ($('#pick_table_id').val() != null && $('#pick_table_id').val() > 0) {
				$.ajax({
					type: 'post',
					url: "{{ route('table.contents.aj') }}",
					data: {
						'_token': "{{ csrf_token() }}",
						'table': $('#pick_table_id').val(),
						'contract': $('#contract_id').val(),
					},
					success: function(response) {

						$('#pick_item_id').html('')
						$('#pick_item_id').append('<option hidden>اختر الصنف</option>')

						response.forEach(entry => {
							$('#pick_item_id').append('<option value="' + entry.item_id + '">' +
								entry.item_name + '</option>')
						})
					},
					error: function() {}
				})
			} else {
				$('#tableQuery > div').css('display', 'none');
			}


		});
		$(document).on('change', '#pick_box_size', function() {

			if ($('#pick_box_size').val() != null && $('#pick_box_size').val() > 0) {
				$.ajax({
					type: 'post',
					url: "{{ route('table.itemQty.aj') }}",
					data: {
						'_token': "{{ csrf_token() }}",
						'table': $('#pick_table_id').val(),
						'item': $('#pick_item_id').val(),
						'box': $('#pick_box_size').val(),
						'contract': $('#contract_id').val(),
					},
					success: function(response) {
						console.log(response)
						$('#pic_qty').attr('max', response)
						$('#pic_qty').val(response)

					},
					error: function() {}
				})
			} else {
				$('#tableQuery > div').css('display', 'none');
			}
		});
		$(document).on('change', '#pick_item_id', function() {

			if ($('#pick_item_id').val() != null && $('#pick_item_id').val() > 0) {
				$.ajax({
					type: 'post',
					url: "{{ route('table.itemBox.aj') }}",
					data: {
						'_token': "{{ csrf_token() }}",
						'table': $('#pick_table_id').val(),
						'item': $('#pick_item_id').val(),
						'contract': $('#contract_id').val(),
					},
					success: function(response) {

						$('#pick_box_size').html('')
						$('#pick_box_size').append('<option hidden>اختر الحجم</option>')

						response.forEach(box => {
							$('#pick_box_size').append('<option value="' + box.box_size +
								'">' + box.name + '</option>')
						})
					},
					error: function() {}
				})
			} else {
				$('#tableQuery > div').css('display', 'none');
			}
		});
	</script>
@endsection
