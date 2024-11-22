@extends('layouts.admin')

@section('title')
	تقارير الفترات
@endsection

@section('pageHeading')
	تقرير الفترات
@endsection

@section('content')
	<div class="container">
		<fieldset>
			<legend class="custom-bg">بيانات العقد</legend>
			<div class="m-4 bg-light p-4" style="box-shadow: 0 0 8px 3px #777 inset">
				<div class="row">
					<div class="col col-12 col-xl-6">
						<h4 class="btn btn-primary btn-block">معلومات العقد</h4>
						<table class="table col table-lite  table-striped-columns">
							<tr>
								<td class="text-left">اسم العميل:</td>
								<td><a href="{{ route('client.edit', [$contract->id, 2]) }}">{{ $contract->the_client->a_name }}</a></td>
							</tr>
							<tr>
								<td class="text-left">رقم العميل:</td>
								<td><a href="{{ route('client.edit', [$contract->id, 2]) }}">{{ $contract->the_client->s_number }}</a></td>
							</tr>
							<tr>
								<td class="text-left">رقم العقد:</td>
								<td><a href="{{ route('contract.edit', [$contract->id, 2]) }}">{{ $contract->s_number }}</a></td>
							</tr>
							<tr>
								<td class="text-left">عدد الفترات فى العقد:</td>
								<td>{{ count($contract->periods) }}</td>
							</tr>
							<tr>
								<td class="text-left">تاريخ بداية العقد:</td>
								<td>ميلادي: {{ $contract->starts_in_greg }} - هجري:{{ $contract->starts_in_hij }}</td>

							</tr>
							<tr>
								<td class="text-left">تاريخ نهاية العقد:</td>
								<td>ميلادي: {{ $contract->ends_in_greg }} - هجري:{{ $contract->ends_in_hij }}</td>
							</tr>
						</table>

						<h4 class="btn btn-primary btn-block">معلومات الفترات</h4>
						@foreach ($contract->periods as $period)
							<div style="padding: 1rem; background-color: {{ $period->status ? '#3935' : '#CCC' }}">
								<div class="input-group mb-2">
									<label class="input-group-text" for="">{{ $period->the_order }}</label>
									<label class="input-group-text" for="">{{ $period->the_code }}</label>
									<label class="input-group-text" for="">تبدأ من: </label>
									<label class="form-control" for="">{{ explode(' ', $period->starts_in)[0] }}</label>
									<label class="input-group-text" for="">المدة: </label>
									<label class="input-group-text" for="">{{ $period->length }} أشهر</label>

								</div>
								<style>
									table#contractItems input {
										max-width: 100px;
										margin: 0;
									}

									table#contractItems tr {
										border-bottom: 1px solid #ccc
									}

									table#contractItems tr td {
										padding: 0;
										border: 1px solid transparent;
										border-bottom: 1px solid #ccc;
										padding: 3px 0;
									}
								</style>
								<table class="w-100" id="contractItems">
									@foreach ($items as $item)
										<form action="{{ '' }}" method="POST"></form>
										<tr>

											<td><label class="" for="items_{{ $item->id }}">{{ $item->a_name }}</label></td>
											<td><input class="" id="items_{{ $item->id }}" type="number" name="items[{{ $item->id }}]"
													value="{{ old('items[' . $item->id . ']', findItemQty($period->items, $item->id)) }}" min="0" step="1" /></td>
											<td><label class="" for="items_{{ $item->id }}_price">سعر الوحدة</label></td>
											<td><input class="" type="number" name="item_price[{{ $item->id }}]" min="0" step="0.01"
													value="{{ old('items[' . $item->id . ']', findItemPrice($period->items, $item->id)) }}"></td>
											<td>
												<button class="btn btn-primary btn-sm">Update</button>
											</td>
										</tr>
									@endforeach
								</table>
								<div class="buttons my-0 p-0 pt-2 justify-content-end">
									<button class="btn btn-sm btn-outline-primary">تحديث البيانات</button>
									<button class="btn btn-sm btn-outline-danger" onclick="window.location='{{ route('delete-period', $period->id) }}'">حذف</button>

								</div>
							</div>
						@endforeach

					</div>
					<div class="col col-12 col-xl-6">
						<form class="border-right border-2 pr-3 m-auto border-dark" action="{{ route('create-first-period', [$contract->id]) }}" method="POST">
							<h4 class="btn btn-primary btn-block">إضافة فترة جديدة</h4>
							@csrf
							<h6 class="text-right">البيانات الأساسية</h6>
							<div class="input-group mb-2">
								<label class="input-group-text" for="starts_in">تبدأ من</label>
								<input class="form-control" id="starts_in" type="hidden" name="starts_in" value="{{ $contract->ends_in_greg }}">
								<button class="form-control" id="starts_in_btn" type="button">{{ $contract->ends_in_greg }}</button>

								<label class="input-group-text" for="ends_in">تنتهي فى</label>
								@php
									$ex = explode('-', $contract->ends_in_greg);
									$nd = $ex[0] . '-' . ++$ex[1] . '-' . --$ex[2];
								@endphp
								<input class="form-control" id="ends_in" type="hidden" name="ends_in" />
								<button class="form-control" id="ends_in_btn" type="button">{{ implode('-', $ex) }}</button>
							</div>

							<div class="input-group mb-2">
								<label class="input-group-text" for="length">المدة بالشهور</label>
								<input class="form-control" id="length" type="number" name="length" min="0" max="12" value="1"
									oninput="validateInput(this)" />
								{{-- <button class="form-control" id="starts_in" type="button">{{ $contract->start_period }}</button> --}}
								<label class="input-group-text" for="length">الترتيب</label>
							</div>

							<h6 class="text-right">الاصناف على الفترة</h6>

							<div class="input-group mb-2">
								<label class="input-group-text" for="items_1">طبالي صغيرة</label>
								<input class="form-control" id="items_1" type="number" name="items[1]" value="{{ old('items[1]', 0) }}" min="0"
									step="1" />
								<label class="input-group-text" for="items_1_price">سعر الوحدة</label>
								<input class="form-control" type="number" name="item_price[1]" value="0.00" min="0" step="0.01">
							</div>
							<div class="input-group mb-2">
								<label class="input-group-text" for="items_2">طبالي كبيرة</label>
								<input class="form-control" id="items_2" type="number" name="items[2]" value="{{ old('items[2]', 0) }}" min="0"
									step="1" />
								<label class="input-group-text" for="items_1_price">سعر الوحدة</label>
								<input class="form-control" type="number" name="item_price[2]" value="0.00" min="0" step="0.01">
							</div>
							<div class="input-group mb-2">
								<label class="input-group-text" for="items_4">غرفة صغيرة</label>
								<input class="form-control" id="items_4" type="number" name="items[4]" value="{{ old('items[4]', 0) }}" min="0"
									step="1" />
								<label class="input-group-text" for="items_1_price">سعر الوحدة</label>
								<input class="form-control" type="number" name="item_price[4]" value="0.00" min="0" step="0.01">
							</div>
							<div class="input-group mb-2">
								<label class="input-group-text" for="items_3">غرفة كبيرة</label>
								<input class="form-control" id="items_3" type="number" name="items[3]" value="{{ old('items[3]', 0) }}" min="0"
									step="1" />
								<label class="input-group-text" for="items_1_price">سعر الوحدة</label>
								<input class="form-control" type="number" name="item_price[3]" value="0.00" min="0" step="0.01">
							</div>

							<div class="buttons m-0 py-1 px-0 justify-content-end">
								<button class="btn btn-outline-primary" type="submit">حفظ البيانات</button>
							</div>

						</form>
					</div>
				</div>

			</div>
		</fieldset>

	</div>
@endsection
@section('script')
	<script>
		// Change End date according to period length

		const periodLength = document.getElementById('length');
		const startDate = document.getElementById('starts_in');
		const endDateInput = document.getElementById('ends_in');
		const endDateBtn = document.getElementById('ends_in_btn');
		periodLength.addEventListener('change', function() {
			endDateInput.value = setEndDate(startDate.value, periodLength.value)
			endDateBtn.innerHTML = setEndDate(startDate.value, periodLength.value)
			//console.log(setEndDate(startDate.value, periodLength.value))
		});

		function validateInput(input) {
			if (input.value > 12) {
				input.value = 12;
			}
		}

		function setEndDate(date, increment) {
			const startDate = new Date(date)
			const months = startDate.getMonth() + Number(increment)
			const yearsToAdd = Math.floor(months / 12);
			const monthsToAdd = months % 12;

			console.log(months, yearsToAdd, monthsToAdd)
			// set the years after increment
			Years = startDate.getFullYear() + yearsToAdd
			Months = monthsToAdd
			Days = startDate.getDate()
			return `${Years}-${Months+1}-${Days-1}`;
		}

		function formatDate(date) {
			let startDate = new Date('2023-12-23'); // الحصول على المكونات المختلفة للتاريخ 
			let year = startDate.getFullYear();
			let month = ('0' + (startDate.getMonth() + 1)).slice(-2); // إضافة الصفر للحصول على رقم شهر مزدوج 
			let day = ('0' + startDate.getDate()).slice(-2); // إضافة الصفر للحصول على رقم يوم مزدوج // تنسيق التاريخ بالشكل المطلوب 
			let formattedDate = `${year}-${month}-${day-1}`;
			return formattedDate; // الناتج: 2023-12-23
		}
	</script>
@endsection
