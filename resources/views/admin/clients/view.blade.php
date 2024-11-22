@extends('layouts.admin')

@section('title')
	{{ $client->a_name }}
@endsection

@section('pageHeading')
	عرض بيانات العميل
@endsection

@section('content')
	<style>
		table tr td {
			padding: 8px 1rem;
		}
	</style>
	<div class="container">
		<fieldset>
			<legend class="custom-bg">عرض بيانات العميل &nbsp; &nbsp;
				<a class="btn btn-sm btn-outline-light" data-bs-toggle="tooltip" data-bs-title="تعديل بيانات عميل" href="{{ route('client.edit', [$client->id]) }}"><i
						class="fa fa-edit"></i></a>
			</legend>
			<div class="m-4 bg-light p-4" style="box-shadow: 0 0 8px 3px #777 inset">

				<div class="buttons" role="tablist" style="border: 0">
					<button class="btn btn-outline-secondary">
						<a href="{{ route('clients.home', [2]) }}">العملاء</a>
					</button>
					<button class="btn btn-outline-secondary">
						<a href="{{ route('clients.stats') }}">
							احصائيات العميل &nbsp;

						</a>
					</button>
					<button class="btn btn-outline-secondary">
						<a href="{{ route('clients.reports.home') }}">تقارير العملاء</a>
					</button>
				</div>

				<div class="p-4">
					<h3 class="text-right">{{ $client->a_name }} - {{ $client->e_name }}</h3>

					<table class="w-100" dir="rtl">
						<tr>
							<td class="text-left">السجل التجارى:</td>
							<td class="text-right">{{ !$client->cr ? 'Not assigned' : $client->cr }}</td>
							<td class="text-left">الرقم الضريبى:</td>
							<td class="text-right">{{ !$client->vat ? 'Not assigned' : $client->vat }}</td>
							<td class="text-left">المجال:</td>
							<td class="text-right">{{ $scopes[$client->industry] }}</td>
						</tr>
						<tr>
							<td class="text-left">الهاتف:</td>
							<td class="text-right">{{ $client->phone ? $client->phone : 'Not assigned' }}</td>
							<td class="text-left">البريد الالكترونى:</td>
							<td class="text-right">{{ $client->email }}</td>
							<td class="text-left">الموقع الالكترونى:</td>
							<td class="text-right">{{ $client->website }}</td>
						</tr>
						<tr>
							<td class="text-left">العنوان:</td>
							<td class="text-right" colspan="3">
								{{-- {{ $country }} - {{ $client->state }} -
                        {{ $client->city }}
                        - {{ $client->street }} --}}
							</td>
							<td class="text-left">عميل منذ:</td>
							<td class="text-right">{{ $client->created_at }}</td>
						</tr>
					</table>

					<h4 class="text-right my-4">العقود &nbsp; &nbsp; <a class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-title="إضافة عقد جديد"
							href="{{ route('contract.create', [$client->id]) }}"><i class="fa fa-plus"></i></a></h4>

					<table class="w-100" dir="rtl">
						<tr>
							<td>#</td>
							<td>المسلسل</td>
							<td>الكود</td>
							<td>تاريخ البداية</td>
							<td>تاريخ الانتهاء</td>
							<td>الحالة</td>
							<td>إدارة العقود</td>
						</tr>
						@if (count($client->contracts))
							@foreach ($client->contracts as $ii => $item)
								<tr>
									<td> {{ ++$ii }} </td>
									<td> {{ $item->s_number }} </td>
									<td> {{ $item->code }} </td>
									<td> {{ $item->starts_in_greg }} - {{ $item->starts_in_hij }} </td>
									<td> {{ $item->ends_in_greg }} - {{ $item->ends_in_hij }} </td>
									<td> {{ $item->status }}
										activity: {{ $item->status }}
										approved: {{ $item->status }}
										parked: {{ $item->status }}
									</td>
									<td>
										<a data-bs-toggle="tooltip" href="{{ route('contract.view', [$item->id, 2]) }}" title="عرض العقد"><i class="fa fa-eye text-primary"></i></a>
										<a data-bs-toggle="tooltip" href="{{ route('contract.edit', [$item->id, 1]) }}" title="تعديل بيانات"><i
												class="fa fa-edit text-info"></i></a>
										@if ($item->status == 0)
											<a data-bs-toggle="tooltip" href="{{ route('contract.approve', $item->id) }}" title="اعتماد العقد"><i
													class="fa fa-check text-success"></i></a>
										@endif
										@if ($item->status == 1)
											<a data-bs-toggle="tooltip" href="{{ route('contract.park', $item->id) }}" title="وقف اعتماد العقد"><i class="fa fa-ban text-info"></i></a>
										@endif
										@if ($item->status == 2)
											<a href="{{ route('contract.approve', $item->id) }}" title="اعتماد العقد"><i class="fa fa-check text-success"></i></a>
										@endif
										<a data-bs-toggle="tooltip" href="{{ route('contract.extend', $item->id) }}" title="تمديد العقد مدة إضافية"><i
												class="fas fa-external-link-alt text-success"></i></a>
										<a data-bs-toggle="tooltip" href="{{ route('delete-contract', $item->id) }}" title="حذف العقد"><i class="fa fa-trash text-danger"></i></a>
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="7">
									<div class="buttons p-0">
										لم يتم بعد تسجيل عقود حتى الان &nbsp;
										<button class="btn btn-sm btn-outline-success">
											<a href="{{ route('contract.create', [$client->id]) }}">أضف
												العقد الأول!</a>
										</button>
									</div>
								</td>

							</tr>
						@endif
					</table>
				</div>

			</div>
		</fieldset>
	</div>
@endsection
@section('script')
@endsection
