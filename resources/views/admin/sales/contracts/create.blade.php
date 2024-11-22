@extends('layouts.admin')

@section('title')
	العقود
@endsection

@section('pageHeading')
	إضافة عقد جديد
@endsection

@section('header_includes')
	<link rel="stylesheet" href="{{ asset('assets/admin/css/editContract.css') }}">
@endsection

@section('content')
	<div class="container">

		<fieldset class="m-3 mt-5" dir="rtl">
			<legend class="custom-bg" style="right: 20px; left: auto">إضافة عقد جديد</legend>
			<div class="border p-4 m-4 bg-light" style="box-shadow: 0 0 8px 3px #777 inset">
				<nav>
					<div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
						<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab"
							aria-controls="nav-home" aria-selected="true">
							<a> البيانات الأساسية
							</a>

						</button>
						<button class="nav-link text-light" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab"
							aria-controls="nav-profile" aria-selected="false">
							فترات العقد
						</button>
						<button class="nav-link text-light" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab"
							aria-controls="nav-contact" aria-selected="false">
							الدفعات المالية
						</button>
						<button class="nav-link text-light" id="nav-payment-tab" data-bs-toggle="tab" data-bs-target="#nav-payment" type="button" role="tab"
							aria-controls="nav-payment" aria-selected="false">
							الشروط الأساسية
						</button>
						<button class="nav-link text-light" id="nav-contract_parts-tab" data-bs-toggle="tab" data-bs-target="#nav-contract-parts" type="button"
							role="tab" aria-controls="nav-contract_parts" aria-selected="false">
							الشروط الإضافية
						</button>
						<button class="nav-link text-light" id="nav-setting-tab" data-bs-toggle="tab" data-bs-target="#nav-setting" type="button" role="tab"
							aria-controls="nav-setting" aria-selected="false">
							اعدادات العقد
						</button>
					</div>
				</nav>

				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
						<form class="p-3" id="regForm" action="{{ route('contract.store', $client->id) }}" method="post">
							@csrf
							<style>
								table tr td {
									border-left: 0 !important;
									font-weight: bolder;
								}

								table tr td input {
									display: inline-block;
									background-color: transparent;
									border: 1px solid transparent;
									border-bottom-color: #777;
									margin: 0 16px
								}

								.col-lg-6+.col-lg-6:nth-child(even) {
									border-right: 1px solid #333
								}
							</style>
							<div class="row" dir="rtl">
								<b class="col-auto"> اسم العميل:</b> &nbsp;
								<span class="col-auto">{{ $client->a_name }}</span>، &nbsp;
								<b class="col-auto"> اسم المسؤول:</b> &nbsp;
								<span class="col-auto">{{ $client->person ? $client->person : 'N/A' }}</span>، &nbsp;
								<b class="col-auto"> الهاتف:</b> &nbsp;
								<span class="col-auto">{{ $client->phone ? $client->phone : 'N/A' }}</span>، &nbsp;
								<b class="col-auto"> السجل التجاري:</b> &nbsp;
								<span class="col-auto">{{ $client->cr ? $client->cr : 'N/A' }}</span>.
								<b class="col-auto"> الإقامة / الهوية :</b> &nbsp;
								<span class="col-auto">{{ $client->iqama ? $client->iqama : 'N/A' }}</span>.
							</div>

							<table class=" w-100 mt-4">
								<tr>
									<td class="text-left">نوع العقد:</td>
									<td class="">
										<select id="type" name="type" required>

											<option selected value="1">عقد تأجير أساسى</option>
											<option value="2">زيادة عدد طبالى</option>
											<option value="3">تمديد مدة عقد</option>
										</select>
									</td>
									<td class="text-left">الكود:</td>
									<td class="">
										<input id="code" type="hidden" name="code" value="{{ $cCode }}">
										<input id="code" type="button" value="{{ $cCode }}">
									</td>
									<td class="text-left">الرقم المسلسل:</td>
									<td class="">
										<input id="s_number" type="hidden" name="s_number" value="{{ $lastContract }}">
										<input id="s_number" type="button" value="{{ $lastContract }}">
									</td>
								</tr>
							</table>

							<div class="row" style="border-bottom: 2px solid #333">
								<div class="col col-12 col-lg-6">
									<h4 class="label text-right font-weight-bold">الفترة الأولى</h4>
									<div class="input-group  mb-2">
										<label class="input-group-text" for="day_in">فى يوم:</label>
										<input id="day_in_hidden" type="hidden" name="day_in_greg">
										<input class="form-control" id="day_in" type="date">

										<label class="input-group-text" for="day_in_hijri">الموافق:</label>
										<input id="day_in_hijri_hidden" type="hidden" name="day_in_hijri">

										<button class="form-control" id="day_in_hijri" name="day_in_hijri" type="button">--/--/----</button>
									</div>
									<div class="input-group mb-2">
										<label class="input-group-text" for="starts_in">يبدأ في:</label>
										<input id="starts_in_hidden" type="hidden" name="starts_in_greg">
										<input class="form-control" id="starts_in" type="date">

										<label class="input-group-text" for="starts_in_hijri">الموافق:</label>
										<input id="starts_in_hijri_hidden" type="hidden" name="starts_in_hijri">
										<button class="form-control" id="starts_in_hijri" name="starts_in_hijri" type="button">--/--/----</button>
									</div>
									<div class="input-group mb-2">
										<label class="input-group-text" for="ends_in">نهاية الفترة الأولى:</label>
										<input id="ends_in_hidden" type="hidden" name="ends_in_greg">
										<input class="form-control" id="ends_in" type="button">

										<label class="input-group-text" for="ends_in_hijri">الموافق:</label>
										<input id="ends_in_hijri_hidden" type="hidden" name="ends_in_hijri">
										<button class="form-control" id="ends_in_hijri" name="ends_in_hijri" type="button">--/--/----</button>
									</div>

									<div class="input-group mb-2">
										<label class="input-group-text" for="new_length">المدة بالشهور</label>
										<input class="form-control" id="new_length" type="button" name="length" value="3" />

										<label class="input-group-text" for="length">الترتيب</label>
										<input class="form-control" type="button" value="1" />
									</div>
								</div>
								<div class="col col-12 col-lg-6">
									<h4 class="text-right">الاصناف </h4>
									<div class="input-group mb-2">
										<label class="input-group-text" for="items_1">طبالي صغيرة</label>
										<input class="form-control" id="items_1" data-required="#items_1_price" type="number" name="items[1]"
											value="{{ old('items[1]', 0) }}" min="0" step="1" />
										<label class="input-group-text" for="items_1_price">سعر الوحدة</label>
										<input class="form-control" type="number" name="item_price[1]" value="0.00" min="0" step="0.01">
									</div>
									<div class="input-group mb-2">
										<label class="input-group-text" for="items_2">طبالي كبيرة</label>
										<input class="form-control" id="items_2" data-required="#items_2_price" type="number" name="items[2]"
											value="{{ old('items[2]', 0) }}" min="0" step="1" />
										<label class="input-group-text" for="items_1_price">سعر الوحدة</label>
										<input class="form-control" type="number" name="item_price[2]" value="0.00" min="0" step="0.01">
									</div>
									<div class="input-group mb-2">
										<label class="input-group-text" for="items_4">غرفة صغيرة</label>
										<input class="form-control" id="items_4" data-required="#items_2_price" type="number" name="items[4]"
											value="{{ old('items[4]', 0) }}" min="0" step="1" />
										<label class="input-group-text" for="items_1_price">سعر الوحدة</label>
										<input class="form-control" type="number" name="item_price[4]" value="0.00" min="0" step="0.01">
									</div>
									<div class="input-group mb-2">
										<label class="input-group-text" for="items_3">غرفة كبيرة</label>
										<input class="form-control" id="items_3" data-required="#items_2_price" type="number" name="items[3]"
											value="{{ old('items[3]', 0) }}" min="0" step="1" />
										<label class="input-group-text" for="items_1_price">سعر الوحدة</label>
										<input class="form-control" type="number" name="item_price[3]" value="0.00" min="0" step="0.01">
									</div>
								</div>
							</div>

							<!-- One "tab" for each step in the form: -->
							<div class="buttons px-0 py-2 m-0 justify-content-end">
								<button class="btn btn-sm btn-outline-success" id="dismiss_btn" type="button"
									onclick="window.location='{{ route('clients.home') }}'">إلغاء</button>
								<button class="btn btn-sm btn-outline-secondary" id="submitBtn" type="submit">إدراج</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
@endsection
@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
			const today = function(q = 'en-eg') {
				const greg = (new Date()).toISOString().split('T')[0]
				return (new Date()).toLocaleDateString(q);
			}
			$('#day_in').val((new Date()).toISOString().split('T')[0])

			setDate($('#day_in'))

			$('#day_in').on('change', function() {
				setDate($(this))
			});
			$('#starts_in').on('change', function() {
				setDate($(this))
				setEndDate('#ends_in', $(this).val())
			});

		});

		function formatGreg(date) {
			greg = (new Date(date)).toLocaleDateString('en-eg')
			const splitted = greg.split('/')
			return `${splitted[2]}-${splitted[0]}-${splitted[1]}`
		}

		function setDate(elem) {
			var selectedDate = new Date(elem.val());
			const selector = '#'.concat(elem.attr('id'))

			$(selector + '_hijri').html(selectedDate.toLocaleDateString('ar-sa'));
			$(selector + '_hijri_input').val(selectedDate.toLocaleDateString('ar-sa'));
			$(selector + '_hidden').val(formatGreg(selectedDate));
			$(selector + '_hijri_hidden').val(selectedDate.toLocaleDateString('ar-sa'));
		}

		function setEndDate(selector, date) {
			const startDate = new Date(date)
			const months = startDate.getMonth() + Number(3)
			const yearsToAdd = Math.floor(months / 12);
			const monthsToAdd = months % 12;
			// set the years after increment
			Years = startDate.getFullYear() + yearsToAdd
			Months = monthsToAdd
			Days = startDate.getDate()
			const endDate = `${Years}-${Months+1}-${Days-1}`;
			const endDateForInput = `${Months+1}/${Days-1}/${Years}`

			$(selector).val(endDateForInput)
			$(selector + '_hijri').html((new Date(endDate)).toLocaleDateString('ar-sa'));
			$(selector + '_hijri_input').val((new Date(endDate)).toLocaleDateString('ar-sa'));
			$(selector + '_hidden').val(endDate);
			$(selector + '_hijri_hidden').val((new Date(endDate)).toLocaleDateString('ar-sa'));
		}
	</script>
@endsection
