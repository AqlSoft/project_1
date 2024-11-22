<div class="receipt position-relative m-auto bg-light" dir="rtl" style="width: 21cm">

	<div class="row receipt_info p-1 w-100">
		<div class="col col-6">
			<span class="text-danger text-right fw-bold"> التاريخ: </span>
			<span class="px-2 "> {{ $receipt->greg_date }} </span>
		</div>

		<div class="col col-6">
			<span class="text-right text-danger fw-bold">مسلسل: </span>
			<span class="px-2 fw-bold ">{{ $receipt->s_number }}</span>
		</div>
		<div class="col col-6">
			<span class="text-danger text-right fw-bold">العميل: </span>
			<span class="px-2 ">{{ $receipt->client->a_name }}</span>
		</div>

		<div class="col col-4">
			<span class="text-danger text-right fw-bold"> العقد: </span>
			<span class="px-2 ">{{ $receipt->contract->s_number }}</span>
		</div>
		<div class="col col-6">
			<span class="text-danger text-right fw-bold"> المزرعة / المصدر: </span>
			<span class="px-2 ">{{ $receipt->farm }}</span>
		</div>
		<div class="col col-6">
			<span class="text-danger text-right fw-bold"> المندوب / السائق: </span>
			<span class="px-2 ">{{ $receipt->drivere }}</span>
		</div>
		<div class="col col-6">
			<span class="text-danger text-right fw-bold"> أخرى: </span>
			<span class="px-2 ">{{ $receipt->notes }}</span>
		</div>
		<div class="col col-6">
			<span class="text-danger text-right fw-bold"> اجمالى السند: </span>
			<span class="px-2 ">{{ $receipt->total_outputs }}</span>
		</div>

	</div>
	<table id="receipt_items_table" style="border-bottom-color: red; width: 100%">
		<thead>
			<tr class="">
				<th class="fw-bold bg-danger py-2 fs-6">#</th>
				<th class="fw-bold bg-danger py-2 fs-6">رقم الطبلية</th>
				<th class="fw-bold bg-danger py-2 fs-6">حجم الطبلية</th>
				<th class="fw-bold bg-danger py-2 fs-6">الأصناف</th>
				<th class="fw-bold bg-danger py-2 fs-6">حجم الكرتون</th>
				<th class="fw-bold bg-danger py-2 fs-6">الكمية</th>
			</tr>
		</thead>
		<tbody>
			@if (count($entries))
				@foreach ($entries as $index => $entry)
					<tr>
						<td class="fw-normal border-left">{{ ++$index }}</td>
						<td class="fw-normal border-left">{{ str_pad($entry->table->name, 5, '0', STR_PAD_LEFT) }}</td>
						<td class="fw-normal border-left">{{ $entry->table_size == 1 ? 'صغيرة' : 'كبيرة' }}
						</td>
						<td class="fw-normal border-left">{{ $entry->storeItem->parent->name }} {{ $entry->storeItem->name }} {{ $entry->storeItem->grade->name }}
						</td>
						<td class="fw-normal border-left">{{ $entry->storeBox->name }}</td>
						<td class="fw-normal">{{ $entry->outputs }}</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td class="text-right" colspan="6">لم يتم بعد إضافة أى إدخالات على هذا السند</td>
				</tr>

			@endif
		</tbody>
	</table>

	<button class="closeBtn bg-danger" id="closeBtn" data-bs-close="#receitInfo ">
		اغلاق
	</button>
</div>

<script>
	$('#closeBtn').click(
		function() {
			$($(this).attr('data-bs-close')).removeClass('show')
		}
	)
</script>
