@extends('layouts.admin')

@section('title')
	التقارير | الرئيسية
@endsection

@section('pageHeading')
	تقارير العملاء
@endsection

@section('content')
	<div class="container pt-5" style="min-height: 100vh">
		<div class="cards">
			<div class="card w-100">
				<div class="card-body row">

					<div class="col col-3 text-center mb-3">
						<div class="border border-info">
							<div class="p-5"><i class="text-primary fa-3x fas fa-folder-open" data-bs-toggle="tooltip" data-bs-title="جميع العقود"></i></div>
							<a class="p-2 fs-4 d-block bg-info" href="{{ route('clients.reports.contracts') }}"> جميع
								العقود
							</a>
						</div>
					</div>

					<div class="col col-3 text-center mb-3">
						<div class="border border-info">
							<div class="p-5">
								<i class="text-primary fa-3x fas fa-file-invoice-dollar" data-bs-toggle="tooltip" data-bs-title="تقارير الطبالى"></i>
							</div>
							<a class="p-2 fs-4 d-block bg-info" href="{{ route('table.report') }}"> تقارير
								الطبالى
							</a>
						</div>
					</div>

					<div class="col col-3 text-center mb-3">
						<div class="border border-info">
							<div class="p-5"><i class="text-primary fa-3x fas fa-file-invoice" data-bs-toggle="tooltip" data-bs-title="تقارير الأصناف"></i></div>
							<a class="p-2 fs-4 d-block bg-info" href="{{ route('clients.reports.storeitems') }}"> تقارير
								الأصناف
							</a>
						</div>
					</div>

					<div class="col col-3 text-center mb-3">
						<div class="border border-info">
							<div class="p-5"><i class="text-primary fa-3x fas fa-table" data-bs-toggle="tooltip" data-bs-title="تقرير الاصناف فى جدول"></i></div>
							<a class="p-2 fs-4 d-block bg-info" href="">
								<form action="{{ route('clients.items.stats') }}" method="POST">
									@csrf
									<input type="hidden" name="searchQuery">
									<button type="submit" style="border: 0; outline: none; background: transparent; color: #fff">
										تقارير جدول الأصناف
									</button>
								</form>

							</a>
						</div>
					</div>

					<div class="col col-3 text-center mb-3">
						<div class="border border-info">
							<div class="p-5"><i class="text-primary fa-3x fas fa-sort-amount-down-alt" data-bs-toggle="tooltip" data-bs-title="تقارر الكميات"></i>
							</div>
							<a class="p-2 fs-4 d-block bg-info" href="{{ route('reception.home', [1]) }}">تقارير
								الكميات</a>
						</div>
					</div>

					<div class="col col-3 text-center mb-3">
						<div class="border border-info">
							<div class="p-5"><i class="text-primary fa-3x fas fa-sort-amount-down-alt" data-bs-toggle="tooltip" data-bs-title="تقارر الكميات"></i>
							</div>
							<a class="p-2 fs-4 d-block bg-info" href="{{ route('contracts.table.credit') }}">تقارير
								رصيد الطبالى</a>
						</div>
					</div>

					<div class="col col-3 text-center mb-3">
						<div class="border border-info">
							<div class="p-5"><i class="text-primary fa-3x fas fa-calendar-days" data-bs-toggle="tooltip" data-bs-title="السندات الملغاة والمحذوفة"></i>
							</div>
							<a class="p-2 fs-4 d-block bg-info" href="{{ route('contracts-periods-report') }}">
								فترات العقود
							</a>
						</div>
					</div>
				</div>
			</div>
		</div> {{-- the End Of Card --}}

	</div>
@endsection

@section('script')
@endsection
