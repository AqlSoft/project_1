<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Print Contract Document</title>
		<link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
			integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		{{-- <link rel="stylesheet" href="{{ asset('assets/admin/css/print_style.css') }}"> --}}

		<style>
			html {
				width: 21cm;
			}

			* {
				padding: 0;
				margin: 0;
				box-sizing: border-box
			}

			.contract-container {
				padding: 1em;
				margin: 1em auto;
				overflow: hidden
			}

			@media print {
				* {
					font-family: Cairo;
				}

				html {
					width: 21cm;
					height: 29cm;
					overflow: hidden
				}

				.contract-container {
					width: calc (21cm - 2em);
					height: 29cm;
					font: normal 0.8em / 1.2 Cairo;
					padding: 0 1.5em;
					margin: 0.5rem auto;
					overflow: hidden
				}

				body.print {
					overflow: hidden
				}

				.buttons {
					display: none;
				}

				table tr td {
					padding: 2px 1em;
					border-bottom: 1px solid #777;
					border-right: 1px solid #777;
				}

				table tr td:first-child {
					border-right: none
				}

				table tr:last-child td {
					border-bottom: 2px solid #777;
				}

				table tr th {
					border-bottom: 2px solid #777 !important;
					border-top: 2px solid #777;
					border-right: 1px solid #777;
				}

				table tr th:first-child {
					border-right: none
				}
			}

			ol,
			ul {
				padding: 0 1rem 0 0;
			}

			p,
			ul li,
			ol li {
				margin: 0;
				padding: 0;
				text-align: justify;
				width: 100%;
			}

			table tr td {
				padding: 2px 1em;
				border-bottom: 1px solid #0282fa;
				border-right: 1px solid #0282fa;
			}

			table tr td:first-child {
				border-right: none
			}

			table tr:last-child td {
				border-bottom: 2px solid #0282fa;
			}

			table tr th {
				border-bottom: 2px solid #0282fa !important;
				border-top: 2px solid #0282fa;
				border-right: 1px solid #0282fa;
			}

			table tr th:first-child {
				border-right: none
			}
		</style>
	</head>

	<body class="print" dir="rtl">

		<div class="contract-container">

			<div class="receipt position-relative" dir="rtl">
				<div class="d-flex" style="border-bottom: 3px solid #0282fa; padding-bottom: 0">
					<div class="col">
						<div class="d-grid text-center">
							<h4 class="card-title fw-bold text-primary" style="font-size: 16px; padding: 0">مؤسسة مخازن أيمن
								الغماس </h4>
							<p class="p-0" style="font-size: 12px">تخزين | تبريد | تجميد | شراع | بيع | تصدير
								<small class="d-block">س ت: 7016846037</small>
								<b class="text-primary fs-6">عقد تأجير مساحات تخزينية</b>
							</p>
						</div>
					</div>
					<div class="col text-center">
						<img src="{{ asset('assets/admin/uploads/images/logo.png') }}" alt="" width="80">

					</div>
					<div class="col">
						<div class="d-grid text-center ">
							<h4 class="card-title fw-bold text-primary" style="font-size: 18px; padding: 0">Ayman Al Ghamas
								Stores</h4>
							<p class="p-0" style="font-size: 10px">Storing | Colling | Freezing | Purchase | Sell
								|
								Export
								<small class="d-block">CR: 7016846037</small>
								<b class="text-primary fs-6">Store Spaces Rent Contract</b>
							</p>

						</div>
					</div>
				</div>

				<div class="text-right">
					<div class="row my-0 py-2" style="background-color: #a2ecff75">
						<div class="col col-4" style="height: 100%; font-size: 10px">SN: {{ $contract->code }}</div>
						<h4 class="col col-4 text-center">عقد تأجير طبالى</h4>
						<div class="col col-4 text-left">رقم العقد: {{ $contract->s_number }}</div>
					</div>
					<p class="my-0 py-0" style="font: 700 14px/1.2 Cairo; text-indent: 30px">
						<b>مقدمة: </b>
						بعون الله وتوفيقه، فى يوم
						<i class="text-primary">{{ $contract->in_day_greg }}</i>
						م، الموافق
						<i class="text-primary">{{ $contract->in_day_hij }}</i>
						، قد اجتمع كل من:-<br>
					</p>
					<ul class="my-0 py-0" style="list-style: square; text-align: justify;  font: 700 14px/1.3 Cairo">
						<li> <i class="text-primary">مخازن أيمن محمد عبد الله الغماس للتخزين </i> سجل تجاري
							<i class="text-primary">{{ $contractor->cr }}7016846037</i> ،
							ويمثلها
							المدير العام - أيمن محمد عبد الله الغماس <i class="text-primary">{{ $contractor->name }}</i>
							وعنوانها الوطنى: <i class="text-primary">{{ $company->state }} - {{ $company->city }} -
								{{ $company->street }}.</i>، جوال: <i class="text-primary">{{ $company->phone }}</i>
							، بريد الكتروني: <i class="text-primary">{{ 'admin@ag-stores.com' }}</i> <span class="party float-left">طرف
								أول.</span>
						</li>
						{{ $client->alter }}
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
					<p style="font: normal 14px/1.3 Cairo; text-indent: 30px; padding: 6px 16px 0">
						<b>تمهيد:</b>
						حيث أن الطرف الأول لديه مخازن تبريد وتجميد ويعمل فى مجال التخزين بخدماته، ومرخص
						له بمزاولة النشاط بموجب الترخيص رقم (41063418526) وحيث أن الطرف الثانى يرغب فى
						استئجار (طبالى / غرف) لدى الطرف الأول، فقد اتفقا وهما بكامل أهليتهما الشرعية المعتبرة
						للتوقيع على هذا العقد فيما يلى:-
					</p>

					<ol class="m-0 pb-2 py-0" style="list-style-type: auto; font: normal 14px/1.3 Cairo; border-bottom: 2px solid #0282fa">
						<li class="px-3 my-0">تعتبر المقدمة والتمهيد أعلاه جزءًا لا يتجزأ من العقد
							ويجب تفسيره وتطبيقه على هذا الأساس.</li>
						{{-- {{ var_dump() }} --}}
						<li class="px-3 my-0 fw-bold"> أصناف العقد</li>
						<table class="table w-100 table-light">
							<tr>
								<th class="py-1" style="background-color: #0282fa; color: #fff">#</th>
								<th class="py-1" style="background-color: #0282fa; color: #fff">الصنف</th>
								<th class="py-1" style="background-color: #0282fa; color: #fff">الكمية</th>
								<th class="py-1" style="background-color: #0282fa; color: #fff">المدة</th>
								<th class="py-1" style="background-color: #0282fa; color: #fff">وحدة القياس</th>
								<th class="py-1" style="background-color: #0282fa; color: #fff">سعر الوحدة</th>
								<th class="py-1" style="background-color: #0282fa; color: #fff">الخصم </th>
								<th class="py-1" style="background-color: #0282fa; color: #fff">الضريبة</th>
								<th class="py-1" style="background-color: #0282fa; color: #fff">الاجمالى</th>

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
									<th class="py-1 bg-primary text-light" colspan="2">الاجمالى قبل الضريبة</th>
									<th class="py-1">{{ number_format($Total * 0.8695652174, 2) }}</th>
									<th class="py-1 bg-primary text-light" colspan="2"> الضريبة: 15%</th>
									<th class="py-1">{{ number_format($VAT, 2) }}</th>
									<th class="py-1 bg-primary text-light" colspan="2">الاجمالى مع الضريبة</th>
									<th class="py-1">{{ number_format($Total, 2) }}</th>
								</tr>
							@endif
						</table>
						<li class="px-3 my-0">
							مدة الإيجار 3 أشهر إلزامى، وبدخول أول يوم بالشهر التالى يتم التجديد تلقائيا إذا
							رغب
							الطرف الأول وبدون إشعار الطرف الثانى.
						</li>
						<li class="px-3 my-0">
							يبدأ الإيجار فى تاريخ <i class="text-primary">({{ $contract->starts_in_hij }})</i> ولمدة
							<i class="text-primary">({{ $contract->start_period }})</i> شهر / أشهر
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
							(3) حتى
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
				<div class="row px-4" style="margin-top: 1rem">
					<div class="col">
						<div class="d-grid text-right">
							<h5 class="card-title text-primary" style="font-size: 18px; padding: 0"><b>طرف أول:
								</b>مؤسسة مخازن أيمن الغماس </h5>
							<b class="text-right">المسؤول: أيمن محمد عبد الله الغماس</b><br>
							<b class="text-right">التوقيع:</b><br>

						</div>
					</div>

					<div class="col">
						<div class="d-grid text-right">
							<h5 class="card-title text-primary" style="font-size: 20px; padding: 0">
								<b>
									طرف ثان:
								</b> {{ $client->a_name }}
							</h5>
							<b class="text-right">المسؤول: {{ $client->a_name }}</b><br>
							<b class="text-right">التوقيع:</b><br>

						</div>
					</div>
				</div>
			</div>
			<div class="buttons">
				<button class="btn btn-outline-primary" onclick="window.location='{{ route('contracts.home') }}'">
					بيانات العقد
				</button>
				<button class="btn btn-outline-primary" onclick="window.location='{{ route('contract.edit', [$contract->id, 1]) }}'">العودة للتعديل
				</button>

				<button class="btn btn-outline-primary" onclick="window.location='{{ route('contract.view', [$contract->id, 1]) }}'">عرص العقد</button>
			</div>
		</div>

		<script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

	</body>

</html>
