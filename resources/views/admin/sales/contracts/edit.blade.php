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
						<button class="nav-link {{ $tab == 1 ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
							role="tab" aria-controls="nav-home" aria-selected="true">
							<a href="{{ route('contract.edit', [$contract->id, 1]) }}"> البيانات الأساسية
							</a>
							&nbsp; <a href="{{ route('contract.print', [$contract->id]) }}"><i class="fa fa-print"></i></a>
						</button>
						<button class="nav-link text-light {{ $tab == 2 ? 'active' : '' }}" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
							type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
							<a href="{{ route('contract.edit', [$contract->id, 2]) }}"> فترات العقد </a>
						</button>
						<button class="nav-link text-light {{ $tab == 3 ? 'active' : '' }}" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
							type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
							<a href="{{ route('contract-payment-info', [$contract->id, 3]) }}"> الدفعات المالية </a>
						</button>
						<button class="nav-link text-light {{ $tab == 4 ? 'active' : '' }}" id="nav-payment-tab" data-bs-toggle="tab" data-bs-target="#nav-payment"
							type="button" role="tab" aria-controls="nav-payment" aria-selected="false">
							<a href="{{ route('contract.edit', [$contract->id, 4]) }}"> الشروط الأساسية </a>
						</button>
						<button class="nav-link text-light {{ $tab == 5 ? 'active' : '' }}" id="nav-contract_parts-tab" data-bs-toggle="tab"
							data-bs-target="#nav-contract-parts" type="button" role="tab" aria-controls="nav-contract_parts" aria-selected="false">
							<a href="{{ route('contract.edit', [$contract->id, 5]) }}"> الشروط الإضافية </a>
						</button>
						<button class="nav-link text-light {{ $tab == 6 ? 'active' : '' }}" id="nav-setting-tab" data-bs-toggle="tab" data-bs-target="#nav-setting"
							type="button" role="tab" aria-controls="nav-setting" aria-selected="false">
							<a href="{{ route('contract.edit', [$contract->id, 6]) }}"> اعدادات العقد </a>
						</button>
					</div>
				</nav>

				<div class="tab-content mx-4 mb-4" id="nav-tabContent" style="">
					@if ($tab == 1)
						<div class="tab-pane fade {{ $tab == 1 ? ' show active' : '' }}" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
							<form class="p-3" id="regForm" action="{{ route('contract.update') }}" method="post">
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
										<td colspan="5"> <input style="width: 96%" type="text" name="brief" value="{{ $contract->brief }}"> </td>
									</tr>
								</table>

								<h4> تاريخ الانشاء </h4>

								<table class=" w-100">
									<tr>
										<td class="text-left">في يوم:</td>
										<td class="cal-1">
											<input class="dateGrabber" id="in_day" data-target="in_day" type="date" style="width: 30px">
											<span id="in_day_greg_display" style="padding: 0 1em;">{{ $contract->in_day_greg }}</span>
											<input id="in_day_greg_input" type="hidden" name="in_day_greg_input" value="{{ $contract->in_day_greg }}">
										</td>
										<td class="text-left">الموافق:</td>
										<td class="cal-2">
											<span id="in_day_hijri_display" style="padding: 0 1em;">{{ $contract->in_day_hij }}</span>
											<input id="in_day_hijri_input" type="hidden" name="in_day_hijri_input" value="{{ $contract->in_day_hij }}">
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
											<input id="start_period" style="max-width: 40%" type="number" name="start_period" value="{{ $contract->start_period }}">
											<label>شهر/أشهر، بعدها يتم التجديد لمدة:</label>
										</td>
										<td><input id="start_period" style="max-width: 40%" type="number" name="renew_period" value="{{ $contract->renew_period }}">
											شهر/أشهر
										</td>
									</tr>
									<tr>
										<td class="text-left">بداية العقد:</td>
										<td class="cal-1">
											<input class="dateGrabber" id="starts_in" data-target="starts_in" type="date" style="width: 30px">
											<span id="starts_in_greg_display" style="padding: 0 1em;">{{ $contract->starts_in_greg }}</span>
											<input id="starts_in_greg_input" type="hidden" name="starts_in_greg_input" value="{{ $contract->starts_in_greg }}">
										</td>
										<td class="text-left">الموافق:</td>
										<td class="cal-2">
											<span id="starts_in_hijri_display" style="padding: 0 1em;">{{ $contract->starts_in_hij }}</span>
											<input id="starts_in_hijri_input" type="hidden" name="starts_in_hijri_input" value="{{ $contract->starts_in_hij }}">
										</td>
									</tr>
									<tr>
										<td class="text-left">نهاية العقد:</td>
										<td class="cal-1">
											<input class="dateGrabber" id="ends_in" data-target="ends_in" type="date" style="width: 30px">
											<span id="ends_in_greg_display" style="padding: 0 1em;">{{ $contract->ends_in_greg }}</span>
											<input id="ends_in_greg_input" type="hidden" name="ends_in_greg_input" value="{{ $contract->ends_in_greg }}">
										</td>
										<td class="text-left">الموافق:</td>
										<td class="cal-2">
											<span id="ends_in_hijri_display" style="padding: 0 1em;">{{ $contract->ends_in_hij }}</span>
											<input id="ends_in_hijri_input" type="hidden" name="ends_in_hijri_input" value="{{ $contract->ends_in_hij }}">
										</td>
									</tr>
								</table>
								<!-- One "tab" for each step in the form: -->
								<br>
								<div style="row gap-3">
									<button class="btn btn-primary float-left" id="submitBtn" type="submit">تحديث
										البيانات</button>
									<button class="btn btn-secondary ml-3 float-left" id="dismiss_btn"><a href="{{ route('clients.home') }}">إلغاء</a></button>
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
					@elseif ($tab == 2)
						{{-- starts form line 95 in controller --}}
						<div class="tab-pane fade  {{ $tab == 2 ? ' show active' : '' }}" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
							tabindex="1" style="position: relative">

							<h4>
								قائمة الفترات النشطة والغير نشطة &nbsp; &nbsp;
								@if (count($contract->periods))
									<button data-bs-toggle="modal" data-bs-target="#createNewPeriod">
										<a class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-title="إضافة فترة جديدة على العقد"><i
												class="fa fa-plus"></i></a>
									</button>
								@endif
							</h4>

							<div class="custom-collapse mx-4" id="periods">
								@php
									$a = 0;
									$debit = 0;
									$credit = 0;
								@endphp
								@if (count($periods) > 0)
									@foreach ($periods as $period)
										<button class="btn collapse-btn {{ ++$a === 1 ? 'active' : '' }} {{ $period->status === 1 ? 'active-period' : '' }}"
											data-target="#period_{{ $period->id }}" style="border-radius:0">{{ $period->status === 1 ? 'الفترة النشطة:' : 'فترة رقم:' }}
											{{ $period->the_order }}</button>
									@endforeach
									<div class="collapse-items">
										@php $x=0; @endphp
										@foreach ($periods as $period)
											<div class="item {{ ++$x === 1 ? 'show' : '' }} {{ $period->status === 1 ? 'active-period' : '' }}" id="period_{{ $period->id }}"
												data-parent="#periods">
												<div class="d-block">
													<h4>بيانات أساسية</h4>
													<div class="row p-1 border-bottom border-dark">
														<div class="col col-2 text-left">تبدأ من: </div>
														<div class="col col-3">{{ $period->starts_in }}</div>
													</div>
													<div class="row p-1 border-bottom border-dark">
														<div class="col col-2 text-left">تنتهي في: </div>
														<div class="col col-3">{{ $period->ends_in }}</div>
													</div>
													<div class="row p-1 border-bottom border-dark">
														<div class="col col-2 text-left">المدة بالشهور: </div>
														<div class="col col-3">{{ $period->length }}</div>
													</div>
													<div class="row p-1 border-bottom border-dark">
														<div class="col col-2 text-left">الكود: </div>
														<div class="col col-3">{{ $period->the_code }}</div>
													</div>
													<div class="row p-1 border-bottom border-dark">
														<div class="col col-2 text-left">الحالة: </div>
														<div class="col col-3">{{ $period->status ? 'نشطة' : 'عير نشطة' }}</div>
													</div>

													<div class="buttons justify-content-end">
														<button class="editPeriodInfo btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPeriodInfo"
															onclick="window.location.href='{{ route('create-invoice-for-period', $period->id) }}'">
															<i class="fa fa-edit" data-bs-toggle="tooltip" data-bs-title="انشاء فاتورة"></i> انشاء فاتورة
														</button>
														@if (!$period->status)
															<button class="btn btn-sm btn-outline-success" onclick="window.location.href='{{ route('period.status-change', $period->id) }}'">
																<i class="fa fa-check" data-bs-toggle="tooltip" data-bs-title="تنشيط الفترة"></i> تنشيط الفترة
															</button>
														@endif
														<button class="btn btn-sm btn-outline-danger" onclick="window.location.href='{{ route('delete-period', [$period->id]) }}'">
															<i class="fa fa-trash" data-bs-toggle="tooltip" data-bs-title="حذف الفترة"></i>حذف الفترة
														</button>
													</div>
													<h4>بيانات الأصناف</h4>
													<div class="m-3">
														@php $periodItemsPrice = 0 @endphp
														@foreach ($period->items as $pItem)
															<form class="mb-1" method="POST" action="{{ route('contract-items-update') }}">
																@csrf
																<input type="hidden" name="itemId" value="{{ $pItem->id }}">
																<div class="input-group bg-light">
																	<label class="input-group-text"> {{ $pItem->item_id }}</label>
																	<label class="input-group-text"> {{ $pItem->item->a_name }}</label>
																	<label class="input-group-text"> عدد الوحدات</label>
																	<input class="form-control" type="number" name="qty" value="{{ $pItem->qty }}" />
																	<label class="input-group-text"> طول الفترة</label>
																	<input class="form-control" type="number" step="1" min="1" name="qty" value="{{ $period->length }}" />
																	<label class="input-group-text"> السعر</label>
																	<input class="form-control" type="number" name="price" value="{{ $pItem->price }}">
																	<label class="input-group-text"> الضريبة 15%</label>
																	<input class="form-control" type="number" step="0.01"
																		value="{{ round((float) $pItem->price * (int) $period->length * (int) $pItem->qty * 0.1304347826087, 2) }}" />
																	<label class="input-group-text"> الاجمالي</label>
																	<input class="form-control" type="number" step="0.01"
																		value="{{ $ItemPrice = round((float) $pItem->price * (int) $period->length * (int) $pItem->qty, 2) }}" />
																	<button class="input-group-text" type="submit">تحديث</button>
																	@php
																		$periodItemsPrice += $ItemPrice; // مستحقات الفترة = مجمع مدفوعات الأصناف
																	@endphp
																</div>
															</form> {{-- End of Contract Item form --}}
														@endforeach
													</div> {{-- End of Contract Items Sectiom --}}
													<h4> مدفوعات الفترة </h4>

													<div class="m-3">
														@php
															$debit += $periodItemsPrice;
															$credit += $periodCredit = 5000; // Period credit (Payment) still unknown, initially it will = 0
														@endphp
														<div class="row">
															<div class="col col-2">
																<label for="">اجمالى المستحقات </label>
																<button class="form-control">{{ $periodItemsPrice }}</button>
															</div>
															<div class="col col-2">
																<label for="">اجمالى الضريبة للفترة </label>
																<button class="form-control">{{ round($periodItemsPrice * 0.1304347826087, 2) }}</button>
															</div>
															<div class="col col-2">
																<label for="">اجمالى المدفوعات للفترة </label>
																<button class="form-control">{{ $periodCredit }}</button>
															</div>
															<div class="col col-2">
																<label for="">اجمالى المطلوب للفترة </label>
																<button class="form-control">{{ round($periodItemsPrice - $periodCredit, 2) }}</button>
															</div>
														</div>
													</div>
												</div>
											</div> {{-- End of Contract Periods Info Sectiom --}}
										@endforeach
									</div>
								@else
									<div>
										لا يوجد فترات حتى الآن، قم بإضافة <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
											data-bs-target="#createFirstPeriod">أول فترة على العقد</button>
									</div>
								@endif
							</div>
							<h4>بيانات اجمالى المدفوعات &nbsp; &nbsp; </h4>
							<div class="m-3">

								<div class="row">
									<div class="col col-1">
										<label for="">عدد </label>
										<button class="form-control">{{ count($periods) }}</button>
									</div>
									<div class="col col-2">
										<label for="">اجمالى المستحقات </label>
										<button class="form-control">{{ $debit }}</button>
									</div>
									<div class="col col-2">
										<label for="">اجمالى الضريبة للعقد </label>
										<button class="form-control">{{ round($debit * 0.1304347826087, 2) }}</button>
									</div>
									<div class="col col-2">
										<label for="">اجمالى المدفوعات للعقد </label>
										<button class="form-control">{{ $credit }}</button>
									</div>
									<div class="col col-2">
										<label for="">اجمالى المطلوب للعقد </label>
										<button class="form-control">{{ round($debit - $credit, 2) }}</button>
									</div>
								</div>
							</div>
						</div>
						{{-- Get total form total with VAT = $totalWithVAT * 0.8695652174 --}}
						{{-- Get VAT form total with VAT = $total * 0.1304347826 --}}
					@elseif ($tab == 3)
						<div class="tab-pane fade {{ $tab == 3 ? ' show active' : '' }}" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab"
							tabindex="1">
							<h4> سداد الدفعات المالية </h4>

							<div class="{{ $ct - $payments == 0 ? 'hide' : '' }}">
								<form action="{{ route('contract.payment.entry.store') }}" method="POST"
									style="background-color: #9f9f9f; padding: 5px 0.5em; height: 45px">
									@csrf
									<input type="hidden" name="contract" value="{{ $contract->id }}">
									<div class="order" style="display: inline-block; vertical-align: middle">
										<input style="width: 40px; height: 33px; text-align: center" type="text" name="ordering" value="{{ count($pses) + 1 }}">
									</div>
									<div class="create-form" style="display: inline-block; width: calc(100% - 50px);">
										<div class="row mb-2">
											<div class="col col-4 font-weight-bold text-light">
												<input id="amount" data-ctp="{{ $ct }}" style="padding: .2em 1em; width: 45%" type="number" name="amount"
													onchange="calculateRatio(this)" min="1" step="0.01" value="{{ $ct - $payments }}">
												<input id="ratio" data-ctp="{{ $ct }}" style="padding: .2em 1em; width: 45%" type="number" name="ratio"
													onchange="calculateAmount(this)" min="1" max="100" step="1"
													value="{{ $ct ? (($ct - $payments) / $ct) * 100 : 0 }}">
												&nbsp;%
											</div>

											<div class="col col-7">
												<input style="padding: .2em 1em; width: 100%" type="taxt" name="brief" placeholder=" وقت أو سبب الاستحقاق ">
											</div>
											<div class="col col-1">
												<button class="btn btn-primary" type="submit"> حفظ </button>
											</div>

										</div>
									</div>

								</form>
							</div>

							<ol class="mt-3">
								@foreach ($pses as $p => $pe)
									<li style="padding: 5px 0.5em; height: 45px">
										<form action="{{ route('contract.payment.entry.update') }}" method="POST">
											@csrf
											<input type="hidden" name="id" value="{{ $pe->id }}">
											<div class="order" style="display: inline-block; vertical-align: middle">
												<input style="width: 40px; height: 33px; text-align: center; background: #e4e3e3; border: 0" type="text" name="ordering"
													value="{{ $pe->ordering }}">
											</div>
											<div class="create-form" style="display: inline-block; width: calc(100% - 50px);">
												<div class="row mb-2">
													<div class="col col-4">
														<span style="display: inline-block; width: 25%; ">{{ $pe->ratio }}
															%</span>
														<span style="display: inline-block; width: 45%; "> [
															{{ $pe->amount }} ] ريال </span>
													</div>

													<div class="col col-6">
														<input style="padding: .2em 1em; width: 100%; background: #e4e3e3; border: 0" type="taxt" name="brief"
															placeholder=" وقت أو سبب الاستحقاق " value="{{ $pe->brief }}">
													</div>
													<div class="col col-2">
														<button class="btn btn-primary" type="submit">تحديث</button>
														<button class="btn btn-danger" type="button"><a style="color: inherit"
																href="{{ route('contract.payment.entry.delete', $pe->id) }}">حذف</a></button>
													</div>
												</div>
											</div>
										</form>
									</li>
								@endforeach
							</ol>
							<script>
								let entryType = document.getElementById('type'),
									ratio = document.getElementById('ratio'),
									amount = document.getElementById('amount');

								function calculateRatio(el) {
									ratio.value = (el.value / el.getAttribute('data-ctp') * 100).toFixed(2);
								}

								function calculateAmount(el) {
									// console.log(el.value);
									console.log(el.getAttribute('data-ctp'));
									amount.value = (el.value * el.getAttribute('data-ctp') / 100).toFixed(2);
								}
							</script>
						</div>
					@elseif ($tab == 4)
						<div class="tab-pane fade {{ $tab == 4 ? ' show active' : '' }}" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab"
							tabindex="1">
							<h4>
								فقرات العقد</h4>

							<ol style="list-style-type: auto; padding: 1em 1.5em">

								<li class="d-none px-3 bg-light my-0">

								</li>
								<li class="d-none px-3 bg-light my-0"></li>
								<li class="px-3 bg-light my-0">
									مدة الإيجار 3 أشهر غلزامى، وبدخول أول يوم بالشهر التالى يتم التجديد تلقائيا إذا رغب
									الطرف الأول وبدون إشعار الطرف الثانى.
								</li>
								<li class="px-3 bg-light my-0">
									يبدأ الإيجار فى تاريخ {{ $contract->starts_in_hij }} وينتهى فى
									{{ $contract->ends_in_hij }}.
								</li>
								<li class="px-3 bg-light my-0">
									يلتزم الطرف الثانى بدفع قيمة الايجار والالتزام بالسداد لقيمة الايجار الشهرية مقدماً، ولا
									يحق للطرف الثانى إخارج البضاعة قبل سداد كامل المستحقات للطرف الأول.
								</li>
								<li class="px-3 bg-light my-0">
									بعد تقيع الطرف الثانى على العقد يكون ملزما بسداد كامل قيمة العقد حسب البند رقم (3) حتى
									وإن لم يتم توريد البضاعة كلياً أو جزئياً، أو أنه قد تم تخزين البضاعة لمدة أقل منالمدة
									المتفق عليها.
								</li>
								<li class="px-3 bg-light my-0">
									يتم سدسد مقدم حسب البند رقم (5) وفى حالة تأخر السداد لمدة شهر؛ يحق للطرف الأول بيع
									الكمية المخزنة لديه أو جزء منها واستيفاء مبلغ الإيجار المستحق على الطرف الثانى.
								</li>
								<li class="px-3 bg-light my-0">
									الطرف الأول (المؤجر) مسئول مسئولية كاملة عن الكميات المخزنة ومسئول عن توفير الكهرباء
									وعدم توقف أجهزة التبريد.
								</li>
								<li class="px-3 bg-light my-0">
									الطرف الأول غير مسئول عن البضاعة فى حالة الكوارث الطبيعية لا سمح الله.
								</li>
								<li class="px-3 bg-light my-0">
									إخراج البضاعة من الغرف يكون بحضور الطرف الثانى أو مندوبه المسجل بالعقد أو عن طريق إشعار
									برسالة نصية أو رسالة واتساب يتم إرسالها عن طريق الرقم المسجل من الجوال المدون ببيانات
									الطرف الثانى إلى احد الهواتف المبينه فى عنوان الطرف الاول بالعقد، على أن يكون التبليغ
									قبد الإخراج بيومين على الاقل حتى لا تؤثر الصدمات الحرارية على جودة البضاعة.
								</li>
								<li class="px-3 bg-light my-0">
									في حالة قرب تاريخ الانتهاء المدون على المنتج للموجودات داخل الثلاجة فإن الطرف الثاني
									(المستأجر) يلتزم بسحب الكمية واخلاء الثلاجة من المنتج وسداد المبالغ المستحقة للطرف الأول
									وفي حالة عدم السحب او السداد يتم تبليغ الجهات المعنية لاتلاف
									البضاعة وهذا لا يسقط حق الطرف الأول في مطالبة الطرف الثاني بقيمة الايجار والطرف الأول
									غير مسؤول عن تاريخ المخزون
								</li>
								<li class="px-3 bg-light my-0">
									يقوم الطرف الثاني بتوصيل الكميات المطلوب تخزينها الى موقع الثلاجات للطرف الاول.
								</li>
								<li class="px-3 bg-light my-0">
									يلتزم الطرف الثاني بفرز المنتج قبل تعبئته واستبعاد كل ما هو تالف ويعبأ بأكياس مخصصة
									للتخزين والطرف الأول غير مسئولعن أي تلف للمنتج إذا كان هذا التلف ناتج عن سوء التعبئة أو
									المنتج نفسه.
								</li>
								<li class="px-3 bg-light my-0">
									يلتزم الطرف الثاني بتوريد البضاعة في الصباح الباكر وبعد العصر تلافيا لتعرض المنتج لصدمة
									حرارية.
								</li>
								<li class="px-3 bg-light my-0">
									يلتزم الطرف الأول بالمحافظة على منتجات الطرف الثاني حسب المتبع بالمواصفات الفنية في
									طريقة التخزين.
								</li>
								<li class="px-3 bg-light my-0">
									الطرف الأول غير مسؤول عن المنتج وصلاحيته ورائحته ويخلي مسؤوليته تماما من تخزين هذا
									المنتج.
								</li>
								<li class="px-3 bg-light my-0">
									أي خلافات تنشأ بين الطرفين في تفسير بنود العقد يتم التحكيم فيها بواسطة الجهات المختصة أو
									طرف يرضى تحكيمه الطرفان.
								</li>
							</ol>
						</div>
					@elseif ($tab == 5)
						<div class="tab-pane fade {{ $tab == 5 ? ' show active' : '' }}" id="nav-contract-parts" role="tabpanel"
							aria-labelledby="nav-contract-parts-tab" tabindex="1">
							<h4>
								الشروط الإضافية</h4>
						</div>
					@elseif ($tab == 6)
						<div class="tab-pane fade {{ $tab == 6 ? ' show active' : '' }}" id="nav-setting" role="tabpanel" aria-labelledby="nav-setting-tab"
							tabindex="1">
							<h4>
								الاعدادات
							</h4>
							<form action=""></form>
						</div>
					@endif

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

		const newPeriodLength = document.getElementById('new_length');
		const newStartDate = document.getElementById('new_starts_in');
		const newDateInput = document.getElementById('new_ends_in');
		const newEndDateBtn = document.getElementById('new_ends_in_btn');


		periodLength.addEventListener('change', function() {
			endDateInput.value = setEndDate(startDate.value, periodLength.value)
			endDateBtn.innerHTML = setEndDate(startDate.value, periodLength.value)
			document.getElementById('ends_in_hij').value = (new Date(endDateInput.value)).toLocaleDateString('ar-sa')
		});

		newPeriodLength.addEventListener('change', function() {
			newDateInput.value = setEndDate(newStartDate.value, newPeriodLength.value)
			newEndDateBtn.innerHTML = setEndDate(newStartDate.value, newPeriodLength.value)

			document.getElementById('new_ends_in_hij').value = (new Date(newDateInput.value)).toLocaleDateString('ar-sa')
		});

		window.addEventListener('load', function() {
			const new_ends_in_hij = document.getElementById('new_ends_in_hij');
			const ends_in_hij = document.getElementById('ends_in_hij');
			newDateInput.value = setEndDate(newStartDate.value, newPeriodLength.value)
			new_ends_in_hij.value = (new Date(newDateInput.value)).toLocaleDateString('ar-sa')
			endDateInput.value = setEndDate(startDate.value, periodLength.value)
			endDateBtn.innerHTML = setEndDate(startDate.value, periodLength.value)
			ends_in_hij.value = (new Date(endDateInput.value)).toLocaleDateString('ar-sa')

		})

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
			startDate.setTime(startDate.getTime() - 24 * 60 * 60 * 1000)

			// set the years after increment
			Days = startDate.getDate()
			Years = startDate.getFullYear() + yearsToAdd
			Months = monthsToAdd
			//console.log(startDate)
			return `${Years}-${Months+1}-${Days}`;
		}

		function formatDate(date) {
			let startDate = new Date('2023-12-23'); // الحصول على المكونات المختلفة للتاريخ 
			let year = startDate.getFullYear();
			let month = ('0' + (startDate.getMonth() + 1)).slice(-2); // إضافة الصفر للحصول على رقم شهر مزدوج 
			let day = ('0' + startDate.getDate()).slice(-2); // إضافة الصفر للحصول على رقم يوم مزدوج // تنسيق التاريخ بالشكل المطلوب 
			let formattedDate = `${year}-${month}-${day}`;
			return formattedDate; // الناتج: 2023-12-23
		}
	</script>
@endsection

@section('modals')
	{{-- نموذج إضافة فترة جديدة على العقد --}}
	<div class="modal fade" id="createFirstPeriod" tabindex="-1" aria-labelledby="createFirstPeriodLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content overflow-hidden">
				<div class="modal-header row custom-bg">
					<h1 class="modal-title fs-5 col text-right" id="createFirstPeriodLabel">إضافة أول فترة على العقد</h1>
					<button class="btn-close col-auto" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
				</div>
				<form action="{{ route('create-first-period', [$contract->id]) }}" method="POST">
					<div class="modal-body">
						@csrf
						<h6 class="text-right">البيانات الأساسية</h6>
						<div class="input-group mb-2">
							<label class="input-group-text" for="starts_in">تبدأ من</label>
							<input class="form-control" id="starts_in" type="hidden" name="starts_in" value="{{ $contract->starts_in_greg }}">
							<button class="form-control" id="starts_in_btn" type="button">{{ $contract->starts_in_greg }}</button>

							<label class="input-group-text" for="ends_in">تنتهي فى</label>
							<input class="form-control" id="ends_in" type="hidden" name="ends_in" value="{{ $contract->ends_in_greg }}" />
							<input class="form-control" id="ends_in_hij" type="hidden" name="ends_in_hij" />
							<button class="form-control" id="ends_in_btn" type="button">{{ $contract->ends_in_greg }}</button>
						</div>
						<div class="input-group mb-2">
							<label class="input-group-text" for="length">المدة بالشهور</label>
							<input class="form-control" id="length" type="number" name="length" min="0" max="12"
								value="{{ $contract->start_period }}" oninput="validateInput(this)" />
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
					</div>
					<div class="modal-footer p-0">
						<div class="buttons m-0 py-1">
							<button class="btn btn-outline-secondary" data-bs-dismiss="modal" type="button" type="button">اغلاق</button>
							<button class="btn btn-outline-primary" type="submit">حفظ البيانات</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	{{-- نموذج إضافة فترة مخصصة على العقد --}}
	<div class="modal fade" id="createNewPeriod" tabindex="-1" aria-labelledby="createNewPeriodLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content overflow-hidden">
				<div class="modal-header row custom-bg">
					<h1 class="modal-title fs-5 col text-right" id="createNewPeriodLabel">إضافة فترة مخصصة على العقد</h1>
					<button class="btn-close col-auto" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div>
						<form class="border-right border-2 pr-3 m-auto border-dark" action="{{ route('store-period-info') }}" method="POST">
							<h4 class="btn btn-primary btn-block">تمديد العقد لفترة إضافية</h4>
							@csrf
							<h6 class="text-right">البيانات الأساسية</h6>
							<input type="hidden" name="contract_id" value="{{ $contract->id }}">
							<div class="input-group mb-2">
								<label class="input-group-text" for="new_starts_in">تبدأ من</label>
								<input class="form-control" id="new_starts_in" type="hidden" name="starts_in" value="{{ $contract->ends_in_greg }}">
								<button class="form-control" id="new_starts_in_btn" type="button">{{ $contract->ends_in_greg }}</button>

								<label class="input-group-text" for="new_ends_in">تنتهي فى</label>
								@php
									$ex = explode('-', $contract->ends_in_greg);
									$nd = $ex[0] . '-' . ++$ex[1] . '-' . --$ex[2];
								@endphp
								<input id="new_ends_in" type="hidden" name="ends_in" />
								<input id="new_ends_in_hij" type="hidden" name="ends_in_hij" />
								<button class="form-control" id="new_ends_in_btn" type="button">{{ implode('-', $ex) }}</button>
							</div>

							<div class="input-group mb-2">
								<label class="input-group-text" for="new_length">المدة بالشهور</label>
								<input class="form-control" id="new_length" type="number" name="length" min="0" max="12" value="1"
									oninput="validateInput(this)" />
								{{-- <button class="form-control" id="starts_in" type="button">{{ $contract->start_period }}</button> --}}
								<label class="input-group-text" for="length">الترتيب</label>
							</div>

							<h6 class="text-right">الاصناف على الفترة</h6>

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

							<div class="buttons m-0 py-1 px-0 justify-content-end">
								<button class="btn btn-outline-primary" type="submit">حفظ البيانات</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- نموذج إضافة أصناف جديدة على الفترات --}}
	<div class="modal fade" id="addNewContractItem" tabindex="-1" aria-labelledby="addNewContractItemLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content overflow-hidden">
				<div class="modal-header row custom-bg">
					<h1 class="modal-title fs-5 col text-right" id="addNewContractItemLabel">إضافة أول فترة على العقد</h1>
					<button class="btn-close col-auto" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
				</div>
				<form action="{{ route('create-first-period', ['replace_me']) }}" method="POST">
					<div class="modal-body">
						@csrf

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
					</div>
					<div class="modal-footer p-0">
						<div class="buttons m-0 py-1">
							<button class="btn btn-outline-secondary" data-bs-dismiss="modal" type="button" type="button">اغلاق</button>
							<button class="btn btn-outline-primary" type="submit">حفظ البيانات</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
