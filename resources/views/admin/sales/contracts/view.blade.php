@extends('layouts.admin')
@section('title')
	العقود
@endsection

@section('pageHeading')
	عرض تفاصيل العقد
@endsection

@section('content')
	<style>
		#nav-home ol,
		#nav-home ul {
			padding: 0 1rem 0 0;
		}

		#nav-home p,
		#nav-home ul li,
		#nav-home ol li {
			background-color: transparent;
			margin: 0.3rem auto;
			padding: 0.2rem;
			text-align: justify;
			width: 90%;
			font: Normal 16px/1.6 Cairo;
		}

		#nav-home table tr td {
			font: Normal 14px/1.3 Cairo;
			padding: .2rem .7rem;
			border-bottom: 1px solid #0282fa;
			border-right: 1px solid #0282fa;
		}

		#nav-home table tr td:first-child {
			border-right: none
		}

		#nav-home table tr:last-child td {
			border-bottom: 2px solid #0282fa;
		}

		#nav-home table tr th {
			font: Bold 14px/1.3 Cairo;
			padding: .2rem .7rem;
			border-bottom: 2px solid #0282fa !important;
			border-top: 2px solid #0282fa;
			border-right: 1px solid #0282fa;
		}

		#nav-home table tr th:first-child {
			border-right: none
		}
	</style>
	<div class="container pt-5">
		<div class="border pt-4 pb-3" style="background:rgba(159, 253, 122, 0.849)">

			<fieldset class="m-3" dir="rtl">
				<legend style="right: 20px; left: auto"> بيانات العقد
					<a href="{{ route('contract.edit', [$contract->id, 1]) }}"><i class="fa fa-edit"></i></a>
				</legend>
				<br>
				<h4 class="btn btn-secondary btn-block text-right"><a href="{{ route('clients.view', [$client->id]) }}">{{ $client->a_name }}</a>
					</h2>
					<br>
					<nav>
						<div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
							<button class="nav-link {{ $tab == 1 ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
								role="tab" aria-controls="nav-home" aria-selected="true"> <a href="{{ route('contract.view', [$contract->id, 1]) }}">العقد</a>
								&nbsp; <a href="{{ route('contract.print', [$contract->id]) }}"><i class="fa fa-print"></i></a>
							</button>
							<button class="nav-link {{ $tab == 2 ? 'active' : '' }}" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
								role="tab" aria-controls="nav-profile" aria-selected="false">
								<a href="{{ route('contract.view', [$contract->id, 2]) }}">سندات الادخال</a>
							</button>
							<button class="nav-link {{ $tab == 5 ? 'active' : '' }}" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
								role="tab" aria-controls="nav-profile" aria-selected="false">
								<a href="{{ route('contract.view', [$contract->id, 5]) }}"> سندات الاخراج</a>
							</button>
							<button class="nav-link {{ $tab == 3 ? 'active' : '' }}" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button"
								role="tab" aria-controls="nav-contact" aria-selected="false">
								<a href="{{ route('contract.view', [$contract->id, 3]) }}">تقارير الأصناف</a>
							</button>
							<button class="nav-link {{ $tab == 4 ? 'active' : '' }}" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled"
								type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">
								<a href="{{ route('contract.view', [$contract->id, 4]) }}">تقارير الطبليات</a>
							</button>
							<button class="nav-link {{ $tab == 6 ? 'active' : '' }}" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled"
								type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">
								<a href="{{ route('contract.view', [$contract->id, 6]) }}">تقارير الطبليات - 2</a>
							</button>
						</div>
					</nav>
					<div class="tab-content" id="nav-tabContent" style="">

						@if ($tab == 1)
							<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
								<div class="text-right">
									<h4 class="d-block text-center my-0 py-2" style="background-color: #ccc"> عقد تأجير
										طبالى </h4>
									<p class="my-0 py-0" style="text-indent: 30px">
										<b>مقدمة: </b>
										بعون الله وتوفيقه، فى يوم
										<i class="text-primary">{{ $contract->in_day_greg }}</i>
										م، الموافق
										<i class="text-primary">{{ $contract->in_day_hij }}</i>
										، قد اجتمع كل من:-<br>
									</p>
									<ul class="my-0 py-0" style="list-style: square; text-align: justify;">
										<li> <i class="text-primary">مخازن
												أيمن محمد عبد الله الغماس للتخزين </i> سجل تجاري
											<i class="text-primary">{{ $contractor->cr }}7016846037</i> ،
											ويمثلها
											المدير العام - أيمن محمد عبد الله الغماس <i class="text-primary">{{ $contractor->name }}</i>
											وعنوانها الوطنى: <i class="text-primary">{{ $company->state }} -
												{{ $company->city }} -
												{{ $company->street }}.</i>، جوال: <i class="text-primary">{{ $company->phone }}</i>
											، بريد الكتروني: <i class="text-primary">{{ 'admin@ag-stores.com' }}</i> <span class="party float-left">طرف
												أول.</span>
										</li>
										<li>و
											<i class="text-primary">{{ $client->a_name }}</i>
											وينوب عنه/ها السيد:
											<i class="text-primary" class="clientName">{{ $client->person ? $client->person : $client->a_name }}</i>،
											@if ($client->cr)
												سجل تجاري:
												<i class="text-primary">{{ $client->cr }}</i>
											@elseif ($client->iqama)
												ويحمل هوية/إقامة رقم:
												<i class="text-primary">{{ $client->iqama }}</i>،
											@endif
											@if ($client->phone)
												هاتف:
												<i class="text-primary">{{ $client->phone }}</i>،
											@endif
											@if ($client->address)
												وعنوانه:
												<i class="text-primary">{{ $client->address }}</i>،
											@endif
											<span class="party float-left">طرف
												ثان.</span>
										</li>
									</ul>
									<p style="text-indent: 30px; padding: 6px 16px 0">
										<b>تمهيد:</b>
										حيث أن الطرف الأول لديه مخازن تبريد وتجميد ويعمل فى مجال التخزين بخدماته، ومرخص
										له بمزاولة النشاط بموجب الترخيص رقم (41063418526) وحيث أن الطرف الثانى يرغب فى
										استئجار (طبالى / غرف) لدى الطرف الأول، فقد اتفقا وهما بكامل أهليتهما الشرعية
										المعتبرة
										للتوقيع على هذا العقد فيما يلى:-
									</p>

									<ol class="m-0 pb-2 py-0" style="list-style-type: auto; border-bottom: 2px solid #0282fa">
										<li class="px-3 my-0">تعتبر المقدمة والتمهيد أعلاه جزءًا لا يتجزأ من العقد
											ويجب تفسيره وتطبيقه على هذا الأساس.</li>
										{{-- {{ var_dump() }} --}}
										<li class="px-3 my-0 fw-bold"> أصناف العقد</li>
										<table class="table table-light" style="width: 90%; margin: auto">
											<tr>
												<th class="" style="background-color: #0282fa; color: #fff">#</th>
												<th class="" style="background-color: #0282fa; color: #fff">الصنف
												</th>
												<th class="" style="background-color: #0282fa; color: #fff">الكمية
												</th>
												<th class="" style="background-color: #0282fa; color: #fff">المدة
												</th>
												<th class="" style="background-color: #0282fa; color: #fff">وحدة
													القياس</th>
												<th class="" style="background-color: #0282fa; color: #fff">سعر
													الوحدة</th>
												<th class="" style="background-color: #0282fa; color: #fff">الخصم
												</th>
												<th class="" style="background-color: #0282fa; color: #fff">الضريبة
												</th>
												<th class="" style="background-color: #0282fa; color: #fff">الاجمالى
												</th>

											</tr>
											@if (count($contract->items))
												@php
													$Total = 0;
													$VAT = 0;
													$counter = 0;
												@endphp
												@foreach ($contract->items as $contractItem)
													<tr>
														<td class="">{{ ++$counter }}</td>
														<td class="">
															{{ $contractItem->item->a_name }}</td>
														<td class="">{{ $contractItem->qty }}</td>
														<td class="">{{ $contract->start_period }}</td>
														<td class="">
															{{ $contractItem->item->unit->a_name }}</td>
														<td class="">{{ $contractItem->price }}
														</td>
														<td class="">{{ $contractItem->discount ?? 0 }}</td>
														@php
															$total = calcTotalPrice($contractItem->price, $contractItem->discount, $contract->start_period, $contractItem->qty);
															$vat = $total * 0.1304347826;
															$Total += $total;
															$VAT += $vat;
														@endphp
														<td class="">
															{{ number_format($vat, 2) }}
														</td>
														<td class="">
															{{ number_format($total, 2) }}
														</td>
														@php
															// $VAT += number_format($vat);
															// $Total += number_format($total);
														@endphp
													</tr>
												@endforeach
												<tr>
													<th class=" bg-primary text-light" colspan="2">الاجمالى قبل
														الضريبة</th>
													<th class="">{{ number_format($Total * 0.8695652174, 2) }}</th>
													<th class=" bg-primary text-light" colspan="2"> الضريبة: 15%
													</th>
													<th class="">{{ number_format($VAT, 2) }}</th>
													<th class=" bg-primary text-light" colspan="2">الاجمالى مع
														الضريبة</th>
													<th class="">{{ number_format($Total, 2) }}</th>
												</tr>
											@endif
										</table>
										<li class="px-3 my-0">
											مدة الإيجار 3 أشهر إلزامى، وبدخول أول يوم بالشهر التالى يتم التجديد تلقائيا إذا
											رغب
											الطرف الأول وبدون إشعار الطرف الثانى.
										</li>
										<li class="px-3 my-0">
											يبدأ الإيجار فى تاريخ <i class="text-primary">({{ $contract->starts_in_greg }})</i> ولمدة <i
												class="text-primary">({{ $contract->start_period }})</i> شهر / أشهر
											، قابلة للتجديد لمدة <i class="text-primary">({{ $contract->renew_period }})</i> شهر /
											أشهر، حسب البند رقم (3)
										</li>
										<li class="px-3 my-0">
											يلتزم الطرف الثانى بدفع قيمة الايجار والالتزام بالسداد لقيمة الايجار الشهرية
											مقدماً، ولا
											يحق للطرف الثانى إخراج البضاعة قبل سداد كامل المستحقات للطرف الأول.
										</li>
										<li class="px-3 my-0">
											بعد توقيع الطرف الثانى على العقد يكون ملزما بسداد كامل قيمة العقد حسب البند رقم
											(3) حتى8
											وإن لم يتم توريد البضاعة كلياً أو جزئياً، أو أنه قد تم تخزين البضاعة لمدة أقل
											من المدة
											المتفق عليها.
										</li>
										<li class="px-3 my-0">
											يتم سداد المقدم حسب البند رقم (5) وفى حالة تأخر السداد لمدة شهر؛ يحق للطرف الأول
											البيع من
											الكمية المخزنة لديه لاستيفاء مبلغ الإيجار المستحق على الطرف الثانى.
										</li>
										<li class="px-3 my-0">
											الطرف الأول (المؤجر) مسئول مسئولية كاملة عن الكميات المخزنة ومسئول عن توفير
											الكهرباء
											وعدم توقف أجهزة التبريد.
										</li>
										<li class="px-3 my-0">
											الطرف الأول غير مسئول عن البضاعة فى حالة الكوارث الطبيعية لا سمح الله.
										</li>
										<li class="px-3 my-0">
											إخراج البضاعة من الغرف يكون بحضور الطرف الثانى أو مندوبه المسجل بالعقد أو عن
											طريق إشعار
											برسالة نصية أو رسالة واتساب يتم إرسالها عن طريق الرقم المسجل من الجوال المدون
											ببيانات
											الطرف الثانى إلى احد الهواتف المبينه فى عنوان الطرف الاول بالعقد، على أن يكون
											التبليغ
											قبد الإخراج بيومين على الاقل حتى لا تؤثر الصدمات الحرارية على جودة البضاعة.
										</li>
										<li class="px-3 my-0">
											في حالة قرب تاريخ الانتهاء المدون على المنتج للموجودات داخل الثلاجة فإن الطرف
											الثاني
											(المستأجر) يلتزم بسحب الكمية واخلاء الثلاجة من المنتج وسداد المبالغ المستحقة
											للطرف الأول
											وفي حالة عدم السحب او السداد يتم تبليغ الجهات المعنية لاتلاف
											البضاعة وهذا لا يسقط حق الطرف الأول في مطالبة الطرف الثاني بقيمة الايجار والطرف
											الأول
											غير مسؤول عن تاريخ المخزون
										</li>
										<li class="px-3 my-0">
											يقوم الطرف الثاني بتوصيل الكميات المطلوب تخزينها الى موقع الثلاجات للطرف الاول.
										</li>
										<li class="px-3 my-0">
											يلتزم الطرف الثاني بفرز المنتج قبل تعبئته واستبعاد كل ما هو تالف ويعبأ بعبوات
											مخصصة
											للتخزين والطرف الأول غير مسئول عن أي تلف للمنتج إذا كان هذا التلف ناتج عن سوء
											التعبئة أو
											كان التلف بالمنتج نفسه.
										</li>
										<li class="px-3 my-0">
											يلتزم الطرف الثاني بتوريد البضاعة في الصباح الباكر وبعد العصر تلافيا لتعرض
											المنتج لصدمة
											حرارية.
										</li>
										<li class="px-3 my-0">
											يلتزم الطرف الأول بالمحافظة على منتجات الطرف الثاني حسب المتبع بالمواصفات الفنية
											في
											طريقة التخزين.
										</li>
										<li class="px-3 my-0">
											الطرف الأول غير مسؤول عن المنتج وصلاحيته ورائحته ويخلي مسؤوليته تماما من تخزين
											هذا
											المنتج.
										</li>
										<li class="px-3 my-0">
											أي خلافات تنشأ بين الطرفين في تفسير بنود العقد يتم التحكيم فيها بواسطة الجهات
											المختصة أو
											طرف يرضى تحكيمه الطرفان.
										</li>

									</ol>

								</div>

							</div>
						@endif

						@php $docNum = 0 @endphp

						@if ($tab == 2)
							<div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="1">
								<h4 class=""> السندات التابعة للعقد </h4>

								<h4 class="d-block">
									سندات الادخال / السندات غير المعتمدة
									<a href="{{ route('reception.create', [1]) }}"><i class="fa fa-plus"></i></a>
								</h4>
								<table class="w-100">
									<tr>
										<td>#</td>
										<td> مسلسل </td>
										<td> نوع السند </td>
										<td> تاريخ الادخال </td>
										<td> السائق </td>
										<td> اجمالى السند </td>
										<td> ملاحظات </td>
										<td> عمليات </td>
									</tr>
									@if (count($contract->inputs))
										@php
											$total = 0;
										@endphp
										@foreach ($contract->inputs as $ii => $item)
											@if ($item->confirmation == 'inprogress')
												<tr>
													<td>{{ ++$docNum }}</td>
													<td>{{ $item->s_number }}</td>
													<td>{{ receiptType($item->type) }}</td>
													<td>{{ $item->hij_date }}</td>
													<td>{{ $item->driver != null ? $item->driver->a_name : 'غير معروف' }}
													</td>
													<td>{{ $item->totalQty }}</td>
													<td>{{ $item->notes }}</td>
													<td>
														<a href="{{ route('reception.edit', [$item->id]) }}"><i class="fa fa-edit text-primary"></i></a>
														<a href="{{ route('reception.entries.create', [$item->id, 0]) }}"><i class="fa fa-sign-out-alt text-info"></i></a>
														<a href="{{ route('reception.print', [$item->id]) }}"><i class="text-primary fas fa-eye"></i></a>
														<a href="{{ route('reception.approve', [$item->id]) }}"><i class="fa fa-check text-success"></i></a>
														<a href="{{ route('reception.destroy', [$item->id]) }}"
															onclick="if (!confirm('انت على وشك القيام بعملية لا يمكن الرجوع عنها، هل أنت متأكد؟')) return false"><i
																class="text-danger fas fa-trash"></i></a>
													</td>
												</tr>
												@php
													$total += $item->totalQty;
												@endphp
											@endif
										@endforeach
									@else
										<tr>
											<td colspan="7">لم يتم ادخال بضاعة بعد</td>
										</tr>
									@endif
								</table>

								<h4 class="d-block">

									سندات الادخال / السندات المعتمدة
								</h4>

								<table class="w-100">
									<tr>
										<td>#</td>
										<td> مسلسل </td>
										<td> نوع السند </td>
										<td> تاريخ الادخال </td>
										<td> السائق </td>
										<td> اجمالى السند </td>
										<td> ملاحظات </td>
										<td> عمليات </td>
									</tr>
									@php
										$total = 0;
									@endphp
									@if (count($contract->inputs))
										@foreach ($contract->inputs as $ii => $item)
											@if ($item->confirmation == 'approved')
												<tr>
													<td>{{ ++$docNum }}</td>
													<td>{{ $item->s_number }}</td>
													<td>{{ receiptType($item->type) }}</td>
													<td>{{ $item->hij_date }}</td>
													<td>{{ $item->driver != null ? $item->driver->a_name : 'غير معروف' }}
													</td>
													<td>{{ $item->totalQty }}</td>
													@php
														$total += $item->totalQty;
													@endphp
													<td>{{ $item->notes }}</td>
													<td>
														<a href="{{ route('reception.print', [$item->id]) }}"><i class="text-primary fas fa-eye"></i></a>
														<a data-bs-toggle="tooltip" data-bs-title="Park Receipt for editing" href="{{ route('reception.park', [$item->id]) }}"><i
																class="text-primary fas fa-ban"></i></a>
														<a href="{{ route('reception.destroy', [$item->id]) }}"
															onclick="if (!confirm('النت على وشك القيام بعملية لا يمكن الرجوع عنها، هل أنت متأكد؟')) return false"><i
																class="text-danger fas fa-trash"></i></a>
													</td>
												</tr>
											@endif
										@endforeach
									@else
										<tr>
											<td colspan="7">لم يتم ادخال بضاعة بعد</td>
										</tr>
									@endif
								</table>
								<div class="row">
									<div class="col col-10">اجمالى الادخالات </div>
									<div class="col col-2">{{ $total }}</div>
								</div>
							</div>
						@endif

						@if ($tab == 3)
							<div class="tab-pane fade show active" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="1">

								<h4 class=""> تفاصيل الأصناف وأحجام الكرتون </h4>
								<table class="w-100">
									<caption>
										سندات الادخال

									</caption>
									<thead>
										<tr>
											<th>#</th>
											<th>الصنف</th>
											<th>كرتون</th>
											<th>المدخلات</th>
											<th>المخرجات</th>
											<th>الاجمالى</th>
											<th><i class="fa fa-cogs"></i></th>
										</tr>
									</thead>
									<tbody>

										@if ($itemsInArr)
											@php
												$credit = 0;
												$creditIn = 0;
												$creditOut = 0;
											@endphp
											@foreach ($itemsInArr as $in => $the_item)
												{{-- ++$in  --}}
												{{-- var_dump($item) --}}
												<tr>
													<td>{{ ++$in }}</td>
													<td>{{ $the_item->item_name }}</td>
													<td>{{ $the_item->box_name }}</td>
													<td>{{ $the_item->totalInputs }}</td>

													<td>{{ $the_item->totalOutputs }}</td>

													<td>{{ $the_item->totalInputs - $the_item->totalOutputs }}</td>
													@php
														$creditIn += $the_item->totalInputs;
														$creditOut += $the_item->totalOutputs;
														//$credit += $the_item->totalInputs ;
													@endphp
													<td>
														<a class="text-primary" id="history" data-search-url="{{ route('contract.items.history') }}"
															data-search-token="{{ csrf_token() }}" data-item-id="{{ $the_item->item_id }}" data-box-id="{{ $the_item->box_size }}"
															data-contract-id="{{ $contract->id }}">
															<i class="fa fa-eye"></i>
														</a>
													</td>
												</tr>
											@endforeach
										@endif
									</tbody>
									<tfoot>
										<th colspan="3">الاجمالى</th>
										<th> {{ $creditIn }} </th>
										<th> {{ $creditOut }} </th>
										<th> {{ $creditIn - $creditOut }} </th>
										<th></th>
									</tfoot>
								</table>

							</div>
						@endif

						@if ($tab == 4)
							<style>
								.tables_stats tr th,
								.tables_stats tr td {
									padding: 5px 1rem
								}
							</style>

							@php
								$totalIn = 0;
								$totalOut = 0;
								$indexOfTables = 0;
								$smallConsumed = 0;
								$largeConsumed = 0;
								$smallOccupied = 0;
								$largeOccupied = 0;
							@endphp
							<div class="tab-pane fade show active" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="1">
								<h4 class="">
									تفاصيل الطبليات أعداد وحمولة </h4>

								<table class="w-100">

									<thead>
										<tr>
											<th>#</th>
											<th>رقم الطبلية</th>
											<th>الحجم</th>
											<th>الأصناف</th>
											<th>الكمية المدخلة</th>
											<th>الكمية المخرجة</th>
											<th>الكمية المتبقية</th>
											<th>عرض</th>
										</tr>
									</thead>
									<tbody>
										@if ($tablesInArr)
											@foreach ($tablesInArr as $in => $table)
												@if ($table['in']->total_qty - $table['out'] > 0)
													<tr>

														<td>{{ ++$indexOfTables }}</td>
														<td class="text-right px-2">
															{{ $table['in']->table_name }}
														</td>
														<td class="text-right px-2">
															{{ $table['in']->table_size == 1 ? 'صغيرة' : 'كبيرة' }}
															@php
																$table['in']->table_size == 1 ? ($smallOccupied += 1) : ($largeOccupied += 1);
																$table['in']->table_size == 1 ? ($smallConsumed += 1) : ($largeConsumed += 1);
															@endphp
														</td>
														<td class="text-right">{{ $table['in']->item_name }}</td>
														<td class="text-right px-2">{{ $in = $table['in']->total_qty }}
														</td>
														@php $totalIn += $in @endphp
														<td class="text-right px-2">
															{{ $out = $table['out'] == null ? 0 : $table['out'] }}
														</td>@php $totalOut += $out @endphp
														<td class="text-right px-2">{{ $total = $in - $out }}</td>

														<td>
															<a class="seeTableContents" data-token="{{ csrf_token() }}" data-id="{{ $table['in']->table_name }}"
																data-contract="{{ $contract->id }}" data-href="{{ route('table.getInfo') }}"><i class="fa fa-eye"></i></a>
														</td>
													</tr>
												@endif
											@endforeach
											@php

											@endphp
										@endif
									</tbody>

								</table>

								<h4 class="mt-5">
									الطبالي المخرجة</h4>
								<table class="w-100">

									<thead>
										<tr>
											<th>#</th>
											<th>رقم الطبلية</th>
											<th>الحجم</th>
											<th>الأصناف</th>
											<th>الكمية المدخلة</th>
											<th>الكمية المخرجة</th>
											<th>الكمية المتبقية</th>
											<th>عرض</th>
										</tr>
									</thead>
									<tbody>
										@php
											$totalIn = 0;
											$totalOut = 0;
										@endphp
										@if ($tablesInArr)
											@foreach ($tablesInArr as $in => $table)
												@if ($table['in']->total_qty - $table['out'] <= 0)
													<tr>

														<td>{{ ++$indexOfTables }}</td>
														<td class="text-right px-2">
															{{ $table['in']->table_name }}
														</td>
														<td class="text-right px-2">
															{{ $table['in']->table_size == 1 ? 'صغيرة' : 'كبيرة' }}
														</td>
														@php
															$table['in']->table_size == 1 ? ($smallConsumed += 1) : ($largeConsumed += 1);
														@endphp
														<td class="text-right">{{ $table['in']->item_name }}</td>
														<td class="text-right px-2">{{ $in = $table['in']->total_qty }}
														</td>
														@php $totalIn += $in @endphp
														<td class="text-right px-2">
															{{ $out = $table['out'] == null ? 0 : $table['out'] }}
														</td>@php $totalOut += $out @endphp
														<td class="text-right px-2">{{ $total = $in - $out }}</td>
														<td>
															<a class="seeTableContents" data-token="{{ csrf_token() }}" data-id="{{ $table['in']->table_name }}"
																data-contract="{{ $contract->id }}" data-href="{{ route('table.getInfo') }}"><i class="fa fa-eye"></i></a>
														</td>
													</tr>
												@endif
											@endforeach
										@endif
									<tfoot>
										<th colspan="4">الاجمالى</th>
										<th>{{ $totalIn }}</th>
										<th>{{ $totalOut }}</th>
										<th>{{ $totalIn - $totalOut }}</th>
										<!--<th class="text-right px-2"> {{ $contract->inputsQty }}</th>-->
										<!--<th class="text-right px-2">{{ $contract->outputsQty }}</th>-->
										<!--<th class="text-right px-2">{{ $contract->inputsQty - $contract->outputsQty }}-->
										</th>
										<th></th>
									</tfoot>
									</tbody>

								</table>
								<h4 class="">
									ملخص الطبالى </h4>
								<table class="w-100 tables_stats">
									<thead>
										<tr>
											<th>الطبالى</th>
											<th>محجوزة</th>
											<th>مستهلكة</th>
											<th>مشغولة</th>
											<th>متاحة</th>
										</tr>
									</thead>
									<tbody>
										{{-- <tr>
                                            <th>صغيرة</th>
                                            <td>{{ $bookedTables['small'] }}</td>
                                            <td>{{ $smallConsumed }}</td>
                                            <td>{{ $smallOccupied }}</td>
                                            <td>{{ $bookedTables['small'] - $smallOccupied }}</td>
                                        </tr>
                                        <tr>
                                            <th>كبيرة</th>
                                            <td>{{ $bookedTables['large'] }}</td>
                                            <td>{{ $largeConsumed }}</td>
                                            <td>{{ $largeOccupied }}</td>
                                            <td>{{ $bookedTables['large'] - $largeOccupied }}</td> --}}
										</tr>
									</tbody>
								</table>
							</div>

						@endif

						@if ($tab == 5)
							<div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="1">
								<h4 class=""> السندات التابعة للعقد </h4>

								<h4 class="d-block">
									سندات الإخراج تحت الاجراء
									<a href="{{ route('delivery.create', [2]) }}"><i class="fa fa-plus"></i></a>
								</h4>
								<table class="w-100">
									<tr>
										<td>#</td>
										<td> مسلسل </td>
										<td> نوع السند </td>
										<td> تاريخ الادخال </td>
										<td> السائق </td>
										<td> اجمالى السند </td>
										<td> ملاحظات </td>
										<td> عمليات </td>
									</tr>
									@if (count($contract->outputs))
										@foreach ($contract->outputs as $ii => $item)
											@if ($item->confirmation == 'inprogress')
												<tr>
													<td>{{ ++$docNum }}</td>
													<td>{{ $item->s_number }}</td>
													<td>{{ receiptType($item->type) }}</td>
													<td>{{ $item->hij_date }}</td>
													<td>{{ $item->driver }}</td>
													<td>{{ $item->totalQty }}</td>
													<td>{{ $item->notes }}</td>
													<td>
														<a href="{{ route('delivery.edit', [$item->id]) }}"><i class="fa fa-edit text-primary"></i></a>
														<a href="{{ route('delivery.entries.create', [$item->id, 0]) }}"><i class="fa fa-sign-out-alt text-info"></i></a>
														<a href="{{ route('delivery.view', [$item->id]) }}"><i class="text-primary fas fa-eye"></i></a>
														<a href="{{ route('delivery.approve', [$item->id]) }}"><i class="fa fa-check text-success"></i></a>
														<a href="{{ route('delivery.destroy', [$item->id]) }}"
															onclick="if (!confirm('النت على وشك القيام بعملية لا يمكن الرجوع عنها، هل أنت متأكد؟')) return false"><i
																class="text-danger fas fa-trash"></i></a>
													</td>
												</tr>
											@endif
										@endforeach
									@else
										<tr>
											<td colspan="7">
												لا يوجد سندات اخراج تحت الاجراء</td>
										</tr>
									@endif
								</table>

								<h4 class="d-block">
									سندات الإخراج المعتمدة
								</h4>
								<table class="w-100">
									<tr>
										<td>#</td>
										<td> مسلسل </td>
										<td> نوع السند </td>
										<td> تاريخ الادخال </td>
										<td> السائق </td>
										<td> اجمالى السند </td>
										<td> ملاحظات </td>
										<td> عمليات </td>
									</tr>
									@if (count($contract->outputs))
										@foreach ($contract->outputs as $ii => $item)
											@if ($item->confirmation == 'approved')
												<tr>
													<td>{{ ++$docNum }}</td>
													<td>{{ $item->s_number }}</td>
													<td>{{ receiptType($item->type) }}</td>
													<td>{{ $item->hij_date }}</td>
													<td>{{ $item->driver }}</td>
													<td>{{ $item->totalQty }}</td>
													<td>{{ $item->notes }}</td>
													<td>
														<a href="{{ route('delivery.print', [$item->id]) }}"><i class="text-primary fas fa-eye"></i></a>
														<a href="{{ route('delivery.park', [$item->id]) }}"><i class="text-primary fas fa-ban" data-bs-toggle="tooltip"
																data-bs-title="Park Receipt for editing"></i></a>
														<a href="{{ route('delivery.destroy', [$item->id]) }}"
															onclick="if (!confirm('انت على وشك القيام بعملية لا يمكن الرجوع عنها، هل أنت متأكد؟')) return false"><i
																class="text-danger fas fa-trash"></i></a>
													</td>
												</tr>
											@endif
										@endforeach
									@else
										<tr>
											<td colspan="7">لا يوجد سندات إخراج معتمدة</td>
										</tr>
									@endif
								</table>
							</div>
						@endif
						@if ($tab == 6)
							<div class="tab-pane fade show active" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="1">
								<h4 class="">
									تفاصيل الطبليات أعداد وحمولة </h4>

								<div class="row">
									@if (count($cTables) > 0)
										@php
											$start = 1;
											$page = isset($_GET['page']) ? $_GET['page'] : 1;
											$counter = $start + ($page - 1) * 24;
											$cTables->used_tables = 0;
										@endphp
										@foreach ($cTables as $cTable)
											<div class="col col-4 py-1">
												<div class="px-3 py-2" style="border-radius: 16px; border: 5px solid #444; height: 300px; margin: 0 0px; position: relative">
													<span class="table_index"
														style="border-top-right-radius: 8px; position: absolute; top: 5px; right: 5px;; display: block; padding: 0.15em 1em; border: 1px solid #333">
														{{ $counter++ }} </span>
													<span class="seeTableContents btn btn-outline-primary" data-token="{{ csrf_token() }}" data-id="{{ $cTable->tableName }}"
														data-contract="{{ $contract->id }}" data-href="{{ route('table.getInfo') }}"
														style="border-bottom-left-radius: 8px;cursor: pointer; position: absolute; bottom: 5px; left: 5px;; display: block; padding: 0.15em 1em;">
														المزيد </span>
													<h2 class="text-center" style=" font-size: 54px;">
														{{ $cTable->tableName }}
													</h2>
													<table class="w-100 mb-3">
														<thead>
															<tr>
																<th>وارد</th>
																<th>صادر</th>
																<th>باقي</th>
															</tr>
														</thead>
														<tbody>
															<tr class="text-primary">
																<td>{{ $inputs = $cTable->totalInputs }}</td>
																<td>{{ $outputs = $cTable->totalOutputs }}</td>
																<td>{{ $inputs - $outputs }}</td>
															</tr>
														</tbody>
													</table>

													@if ($cTable->load['total'] > 0)
														<div>[ {{ $cTable->contract }} ]</div>

														@php
															$tableItems = array_unique(explode(',', $cTable->items));
														@endphp
														<div class="row text-end">
															@foreach ($tableItems as $tii => $tsid)
																<span class="col col-auto m-1 badge btn btn-outline-primary">
																	{{ $storeItems[$tsid] }}
																</span>
															@endforeach
														</div>
													@else
														<div>الطبلية فارغة</div>
													@endif

												</div>
											</div>
										@endforeach
									@else
										<div>
											لم يتم استقبال بضاعة على هذا العقد
										</div>
									@endif
								</div>
							</div>
							{{ $cTables->links() }}
						@endif
					</div>

			</fieldset>
			<div id="tableLook"
				style="padding: 100px 0; display: none !important; position: fixed; z-index: 99999; top: 0; left: 0; width: 100vw; display: block; height: 100vh; background-color: #000c">

			</div>

			<div id="itemsLook"
				style="padding: 100px 0; display: none !important; position: fixed; z-index: 99999; top: 0; left: 0; width: 100vw; display: block; height: 100vh; background-color: #000c">

			</div>

			<div id="reportPrint"
				style="padding: 100px 0; display: none !important; position: fixed; z-index: 99999; top: 0; left: 0; width: 100vw; display: block; height: 100vh; background-color: #000c">

			</div>
		</div>
	</div>

@endsection

@section('script')
	<script>
		let buttons = document.querySelectorAll('nav div button');
		buttons.forEach(element => {
			element.addEventListener('click', function() {
				document.querySelector('nav button.active').classList.remove('active');
				this.classList.add('active')
				document.querySelector('.tab-pane.active').classList.remove('show')
				document.querySelector('.tab-pane.active').classList.remove('active')
				document.querySelector(this.getAttribute('data-bs-target')).classList.add('active');
				document.querySelector(this.getAttribute('data-bs-target')).classList.add('show');
			})
		});

		$(document).ready(function() {
			$(document).on('click', '.seeTableContents', function() {
				let ajax_search_url = $(this).attr('data-href');
				let ajax_search_token = $(this).attr('data-token');
				let ajax_table_id = $(this).attr('data-id');
				let ajax_contract_id = $(this).attr('data-contract');

				jQuery.ajax({
					url: ajax_search_url,
					type: 'POST',
					dataType: 'html',
					data: {
						table_id: ajax_table_id,
						'_token': ajax_search_token,
						ajax_search_url: ajax_search_url,
						contract: ajax_contract_id
					},
					cash: false,
					success: function(data) {
						$('#tableLook').html(data);
					},
					error: function() {

					}
				}).then(
					function() {
						$('#tableLook').css({
							display: 'block'
						});
					}
				);

			});

		});

		$(document).on('click', '#history', function() {
			let ajax_search_url = $(this).attr('data-search-url');
			let ajax_search_token = $(this).attr('data-search-token');
			let ajax_item_id = $(this).attr('data-item-id');
			let ajax_box_id = $(this).attr('data-box-id');
			let ajax_contract_id = $(this).attr('data-contract-id');

			jQuery.ajax({
				url: ajax_search_url,
				type: 'POST',
				dataType: 'html',
				data: {
					'_token': ajax_search_token,
					ajax_search_url: ajax_search_url,
					contract: ajax_contract_id,
					box: ajax_box_id,
					item: ajax_item_id,
				},
				cash: false,
				success: function(data) {
					$('#itemsLook').html(data);
				},
				error: function() {

				}
			}).then(
				function() {
					$('#itemsLook').css({
						display: 'block'
					});
				}
			);



		});
	</script>
	<script src="{{ asset('resources\js\datatablesar.js') }}"></script>
@endsection
