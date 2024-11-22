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
			<legend class="custom-bg">العقود التى سوف تنتهى قبل 7 أيام

			</legend>
			<div class="accordion mt-5" id="ContractsPeriods">
				@php $a=0 @endphp {{-- Display First item Only --}}
				@foreach ($contracts as $contract)
					{{-- Start Looping Contracts --}}
					@if ($contract->remainingDays > 0 && $contract->remainingDays <= 7)
						{{-- Fitering Contracts according to status and remaining days --}}
						<div class="accordion-item">
							{{-- Start of accordion Item --}}
							<h2 class="accordion-header">
								<button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $contract->id }}" type="button"
									aria-expanded="{{ $a === 0 ? 'true' : 'false' }}" aria-controls="collapse_{{ $contract->id }}">
									{{ str_pad(++$a, 3, '0', STR_PAD_LEFT) }} - {{ $contract->the_client->a_name }} - الوقت المتبقى {{ $contract->remainingDays }} يوم/أيام
								</button>
							</h2>

							<div class="accordion-collapse collapse {{ $a === 1 ? 'show' : '' }}" id="collapse_{{ $contract->id }}" data-bs-parent="#ContractsPeriods">
								<div class="accordion-body">
									@foreach ($contract->periods as $period)
										<div class="input-group py-1 px-3 {{ $period->status ? 'bg-success' : '' }}">
											<label class="input-group-text" for="">{{ __('الكـــود') }}</label>
											<label class="form-control" for="">{{ $period->the_code }}</label>
											<label class="input-group-text" for="">{{ __('بدأت من:') }}</label>
											<label class="form-control" for="">{{ $period->starts_in }}</label>
											<label class="input-group-text" for="">{{ __('تنتهي فى:') }}</label>
											<label class="form-control" for="">{{ $period->ends_in }}</label>
											<label class="input-group-text" for="">{{ __('الحالة:') }}</label>
											<label class="form-control" for="">{{ $period->status === 1 ? 'نشطة' : 'منتهية' }}</label>
											<button class="input-group-text bg-info">تمديد</button>
											<button class="input-group-text bg-danger" onclick="window.location.href = '{{ route('period-delete', $period->id) }}'">حذف</button>
										</div>
									@endforeach
									<div class="buttons">
										<button class="btn btn-outline-primary"><a href="{{ route('contract.edit', [$contract->id, 2]) }}">الذهاب للعقد
												{{ $contract->s_number }}</a></button>
										<button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="createNewPeriod" data-contract="{{ $contract->id }}">إضافة
											<a href="{{ route('create-period-view', [$contract->id]) }}">فترة جديدة</a></button>
										<button class="btn btn-outline-danger"><a href="{{ route('contract.park', [$contract->id]) }}"></a>ايقاف العقد</button>

									</div>
								</div>
							</div>
						</div>
					@endif
					{{-- End of Contracts Fitering --}}
				@endforeach
				{{-- End Looping Contracts --}}
			</div>
		</fieldset>

		<fieldset>
			<legend class="custom-bg">العقود المستمرة</legend>
			<div class="accordion mt-5" id="ContractsPeriods">
				@php $b=0 @endphp {{-- Display First item Only --}}
				@foreach ($contracts as $contract)
					{{-- Start Looping Contracts --}}
					@if ($contract->remainingDays > 7)
						{{-- Fitering Contracts according to status and remaining days --}}
						<div class="accordion-item">
							{{-- Start of accordion Item --}}

							<h2 class="accordion-header">
								<button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $contract->id }}" type="button"
									aria-expanded="{{ $b === 0 ? 'true' : 'false' }}" aria-controls="collapse_{{ $contract->id }}">
									{{ str_pad(++$b, 3, '0', STR_PAD_LEFT) }} - {{ $contract->client->a_name }} - الوقت المتبقى {{ $contract->remainingDays }} يوم/أيام
								</button>
							</h2>

							<div class="accordion-collapse collapse {{ $b === 1 ? 'show' : '' }}" id="collapse_{{ $contract->id }}" data-bs-parent="#ContractsPeriods">
								<div class="accordion-body">
									@foreach ($contract->periods as $period)
										<div class="input-group">
											<label class="input-group-text" for="">{{ __('الكـــود') }}</label>
											<label class="form-control" for="">{{ $period->the_code }}</label>
											<label class="input-group-text" for="">{{ __('بدأت من:') }}</label>
											<label class="form-control" for="">{{ $period->starts_in }}</label>
											<label class="input-group-text" for="">{{ __('تنتهي فى:') }}</label>
											<label class="form-control" for="">{{ $period->ends_in }}</label>
											<label class="input-group-text" for="">{{ __('الحالة:') }}</label>
											<label class="form-control" for="">{{ $period->status === 1 ? 'نشطة' : 'منتهية' }}</label>
										</div>
									@endforeach
									{{ $contract->periods }}
									<a calss="btn btn-outline-primary btn-sm" href="{{ route('contract.edit', [$contract->id, 1]) }}">{{ $contract->s_number }}</a>
								</div>
							</div>
						</div>
					@endif
					{{-- End of Contracts Fitering --}}
				@endforeach
				{{-- End Looping Contracts --}}
			</div>
		</fieldset>

		<fieldset>
			<legend class="custom-bg">العقود المنتهية</legend>
			<div class="accordion mt-5" id="ContractsPeriods">
				@php $c=0 @endphp {{-- Display First item Only --}}
				@foreach ($contracts as $contract)
					{{-- Start Looping Contracts --}}
					@if ($contract->remainingDays <= 0)
						{{-- Fitering Contracts according to status and remaining days --}}
						<div class="accordion-item">
							{{-- Start of accordion Item --}}
							<h2 class="accordion-header">
								<button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $contract->id }}" type="button"
									aria-expanded="{{ $c === 0 ? 'true' : 'false' }}" aria-controls="collapse_{{ $contract->id }}">
									{{ str_pad(++$a, 3, '0', STR_PAD_LEFT) }} - {{ $contract->client->a_name }} - انتهى العقد منذ {{ ABS($contract->remainingDays) }}
									يوم/أيام
								</button>
							</h2>

							<div class="accordion-collapse collapse {{ $c === 1 ? 'show' : '' }}" id="collapse_{{ $contract->id }}" data-bs-parent="#ContractsPeriods">
								<div class="accordion-body">
									@foreach ($contract->periods as $period)
										<div class="input-group">
											<label class="input-group-text" for="">{{ __('الكـــود') }}</label>
											<label class="form-control" for="">{{ $period->the_code }}</label>
											<label class="input-group-text" for="">{{ __('بدأت من:') }}</label>
											<label class="form-control" for="">{{ $period->starts_in }}</label>
											<label class="input-group-text" for="">{{ __('تنتهي فى:') }}</label>
											<label class="form-control" for="">{{ $period->ends_in }}</label>
											<label class="input-group-text" for="">{{ __('الحالة:') }}</label>
											<label class="form-control" for="">{{ $period->status === 1 ? 'نشطة' : 'منتهية' }}</label>
										</div>
									@endforeach
									{{ $contract->periods }}
									<a calss="btn btn-outline-primary btn-sm" href="{{ route('contract.edit', [$contract->id, 1]) }}">{{ $contract->s_number }}</a>
								</div>
							</div>
						</div>
					@else
						{{-- End of Contracts Fitering --}}
						@if ($c == 0)
							<div class="accordion-item">
								{{-- Start of accordion Item --}}
								<h2 class="accordion-header">
									<button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $contract->id }}" type="button"
										aria-expanded="{{ $a === 0 ? 'true' : 'false' }}" aria-controls="collapse_{{ $contract->id }}">
										لا يوجد عقود منتهية
									</button>
								</h2>
							</div>
						@endif
					@endif
				@endforeach
				{{-- End Looping Contracts --}}
			</div>
		</fieldset>
	</div>
@endsection

@section('script')
	<script></script>
@endsection

@section('modals')
	<!-- Button trigger modal -->

	<!-- Modal -->
	<div class="modal fade" id="createNewPeriod" tabindex="-1" aria-labelledby="createNewPeriodLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="createNewPeriodLabel">إضافة فترات على العقد</h1>
					<button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam unde possimus adipisci eaque perferendis earum, quidem odit amet explicabo.
					Temporibus nostrum laboriosam ipsum non explicabo ratione tempore odit blanditiis atque.
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" data-bs-dismiss="modal" type="button">اغلاق</button>
					<button class="btn btn-primary" type="button">حفظ البيانات</button>
				</div>
			</div>
		</div>
	</div>
@endsection
