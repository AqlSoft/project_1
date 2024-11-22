@extends('layouts.admin')

@section('title')
	العقود
@endsection

@section('pageHeading')
	تعديل بيانات عقد
@endsection

@section('header_includes')
	<link rel="stylesheet" href="{{ asset('assets/admin/css/editContract.css') }}">
@endsection

@section('content')
	<style>
		button.nav-link a {
			color: #fff;
		}

		button.nav-link.active a {
			color: #0051ff;
		}
	</style>
	<div class="container mb-5">

		<fieldset class="m-3" dir="rtl">
			<legend class="custom-bg" style="">
				تعديل بيانات عقد &nbsp; &nbsp; {{ $contract->client->a_name }} &nbsp;
				@if ($contract->status == 1)
					<button class="btn btn-sm btn-outline-light" data-bs-toggle="tooltip" data-bs-title="ايقاف العقد">
						<a href="{{ route('contract.park', $contract->id) }}"><i class="fa fa-stop"></i></a></button>
					&nbsp;
					<button class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" data-bs-title="استقبال بضاعة على العقد">
						<a href="{{ route('reception.create', $contract->id) }}"><i class="fa fa-cart-flatbed"></i></a></button>
				@else
					<button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-title="اعتماد العقد">
						<a href="{{ route('contract.approve', $contract->id) }}"><i class="fa fa-check"></i></a></button>
				@endif
				&nbsp;
				<button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-title="انهاء العقد">
					<a href="{{ route('contract.approve', $contract->id) }}"><i class="fa fa-circle-xmark"></i></a></button>

				&nbsp;
				<button class="btn btn-sm btn-outline-light" data-bs-toggle="tooltip" data-bs-title="عرض محتويات العقد">
					<a href="{{ route('contract.view', [$contract->id, 2]) }}"><i class="fa fa-search"></i></a></button>
			</legend>

			<div class="border p-3 m-4 bg-light" style="box-shadow: 0 0 8px 3px #777 inset">
				<nav>
					<div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
						<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab"
							aria-controls="nav-home" aria-selected="true">
							<a> البيانات الأساسية
							</a>
							&nbsp; <a href="{{ route('contract.print', [$contract->id]) }}"><i class="fa fa-print"></i></a>
						</button>
						<button class="nav-link text-light" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab"
							aria-controls="nav-profile" aria-selected="false">
							<a href="{{ route('contract.edit', [$contract->id, 2]) }}"> فترات العقد </a>
						</button>
						<button class="nav-link text-light" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab"
							aria-controls="nav-contact" aria-selected="false">
							<a href="{{ route('contract.edit', [$contract->id, 3]) }}"> الدفعات المالية </a>
						</button>
						<button class="nav-link text-light" id="nav-payment-tab" data-bs-toggle="tab" data-bs-target="#nav-payment" type="button" role="tab"
							aria-controls="nav-payment" aria-selected="false">
							<a href="{{ route('contract.edit', [$contract->id, 4]) }}"> الشروط الأساسية </a>
						</button>
						<button class="nav-link text-light" id="nav-contract_parts-tab" data-bs-toggle="tab" data-bs-target="#nav-contract-parts" type="button"
							role="tab" aria-controls="nav-contract_parts" aria-selected="false">
							<a href="{{ route('contract.edit', [$contract->id, 5]) }}"> الشروط الإضافية </a>
						</button>
						<button class="nav-link text-light" id="nav-setting-tab" data-bs-toggle="tab" data-bs-target="#nav-setting" type="button" role="tab"
							aria-controls="nav-setting" aria-selected="false">
							<a href="{{ route('contract.edit', [$contract->id, 6]) }}"> اعدادات العقد </a>
						</button>
					</div>
				</nav>

				<div class="tab-content mx-4 mb-4" id="nav-tabContent" style="">

					<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
						<form class="p-4 w-75 m-auto" dir="rtl" action="{{ route('contract.update') }}" method="post">
							@csrf

							<input type="hidden" name="id" value="{{ $contract->id }}">
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

							<h4>الترقيم</h4>

							<table class=" w-100">
								<tr>
									<td class="text-left">نوع العقد:</td>
									<td class="">
										<select id="type" name="type">
											<option hidden>حدد نوع العقد</option>
											<option {{ $contract->type == 1 ? 'selected' : '' }} value="1">عقد
												تأجير أساسى</option>
											<option {{ $contract->type == 2 ? 'selected' : '' }} value="2">زيادة
												عدد طبالى</option>
											<option {{ $contract->type == 3 ? 'selected' : '' }} value="3">تمديد
												مدة عقد</option>
										</select>
									</td>
									<td class="text-left">الكود:</td>
									<td class="">
										<input id="s_number" type="text" name="code" value="{{ $contract->code }}">
									</td>
									<td class="text-left">الرقم المسلسل:</td>
									<td class="">
										<input id="s_number" type="text" name="s_number" value="{{ $contract->s_number }}">
									</td>
								</tr>

								<tr>
									<td> الوصف </td>
									<td colspan="5">
										<textarea style="width: 96%" rows="5" type="text" name="brief">{{ $contract->brief }}</textarea>
									</td>
								</tr>
							</table>

							<h4> تاريخ الانشاء </h4>

							<table class="w-100">
								<tr>
									<td class="text-left">في يوم:</td>
									<td class="cal-1">
										<span id="in_day_greg_display" style="padding: 0 1em;color: #0051ff">{{ $contract->in_day_greg }}</span>
									</td>
									<td class="text-left">الموافق:</td>
									<td class="cal-2">
										<span id="in_day_hijri_display" style="padding: 0 1em;color: #0051ff">{{ $contract->in_day_hij }}</span>
									</td>
								</tr>
							</table>
							<br>
							<h4> التوقيت والمدد </h4>

							<table class="w-100">
								<tr>
									<td>
										<label>الفترة المبدئية</label>
									</td>
									<td colspan="2">
										<span id="start_period px-3" style="width: 30px;color: #0051ff">{{ $contract->start_period }}</span>
										<label>شهر/أشهر، بعدها يتم التجديد لمدة:</label>
									</td>
									<td><span id="start_period px-3" style="width: 30px;color: #0051ff">{{ $contract->renew_period }}</span>
										شهر/أشهر
									</td>
								</tr>
								<tr>
									<td class="text-left">بداية العقد:</td>
									<td class="cal-1">
										<span id="starts_in_greg_display" style="padding: 0 1em;">{{ $contract->starts_in_greg }}</span>
									</td>
									<td class="text-left">الموافق:</td>
									<td class="cal-2">
										<span id="starts_in_hijri_display" style="padding: 0 1em;">{{ $contract->starts_in_hij }}</span>
									</td>
								</tr>
								<tr>
									<td class="text-left">نهاية العقد:</td>
									<td class="cal-1">
										<span id="ends_in_greg_display" style="padding: 0 1em;color: #0051ff">{{ $contract->ends_in_greg }}</span>
									</td>
									<td class="text-left">الموافق:</td>
									<td class="cal-2">
										<span id="ends_in_hijri_display" style="padding: 0 1em;color: #0051ff">{{ $contract->ends_in_hij }}</span>
									</td>
								</tr>
							</table>
							<!-- One "tab" for each step in the form: -->
							<br>
							<div style="buttons m-0 py-1 px-0 justify-content-end">
								<button class="btn btn-sm btn-outline-primary" id="submitBtn" type="submit">تحديث
									البيانات</button>
								<button class="btn btn-sm btn-outline-secondary ml-3" id="dismiss_btn"><a href="{{ route('clients.home') }}">إلغاء</a></button>
							</div>
							<br>
						</form>

						<script>
							let dateInputs = ['in_day', 'starts_in', 'ends_in'];
							window.onload = function() {
								dateInputs.forEach((id) => {
									const dateInput = document.getElementById(id)
									//updateOnload (id)

									dateInput.onchange = function(e) {
										updateOnchange(e.target.id)
									}
								})
							}

							function updateOnload(id) {
								let today = new Date();
								document.getElementById(id + '_greg_display').innerHTML = today.toLocaleDateString('en-eg')
								document.getElementById(id + '_greg_input').value = dateFormatNumeral(today)
								document.getElementById(id + '_hijri_display').innerHTML = today.toLocaleDateString('ar-sa')
								document.getElementById(id + '_hijri_input').value = today.toLocaleDateString('ar-sa')
							}

							function updateOnchange(id) {
								let today = new Date(document.getElementById(id).value);
								document.getElementById(id + '_greg_display').innerHTML = today.toLocaleDateString('en-eg')
								document.getElementById(id + '_greg_input').value = dateFormatNumeral(today)
								document.getElementById(id + '_hijri_display').innerHTML = today.toLocaleDateString('ar-sa')
								document.getElementById(id + '_hijri_input').value = today.toLocaleDateString('ar-sa')
							}

							function dateFormatNumeral(date) {
								return date.getFullYear() + '-' + [date.getMonth() + 1] + '-' + date.getDate();
							}
						</script>

					</div>

				</div>
			</div>
		</fieldset>
	</div>
@endsection
