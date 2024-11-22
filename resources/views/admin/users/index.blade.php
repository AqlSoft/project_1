@extends('layouts.admin')
@section('title')
	الإعدادات العامة
@endsection
@section('pageHeading')
	الإعدادات العامة
@endsection

@section('content')
	<div class="container" style="min-height: 100vh">
		<nav>
			<div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
				<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab"
					aria-controls="nav-home" aria-selected="true">
					<a> الموارد البشرية </a>
				</button>
				<button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
					aria-selected="true">
					<a href="{{ route('display-permissions-list') }}"> الصلاحيات </a>

				</button>
				<button class="nav-link " id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab"
					aria-controls="nav-profile" aria-selected="false">
					<a href="{{ route('display-menues-list') }}"> القوائم</a>
				</button>
				<button class="nav-link " id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab"
					aria-controls="nav-contact" aria-selected="false">
					<a href="{{ route('display-roles-list') }}"> الادوار </a>
				</button>

				<button class="nav-link " id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab"
					aria-controls="nav-contact" aria-selected="false">
					<a href="{{-- route('rules.setting', [$user->id]) --}}"> الاعدادات </a>
				</button>
			</div>
		</nav>

		<div class="tab-content" id="nav-tabContent" style="">
			<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
				<fieldset class="m-3" dir="rtl">
					<div class="row">
						<h4 class="col col-4"> جميع الموظفين &nbsp; &nbsp;
							<button class="btn btn-sm btn-primary py-1 float-left" data-bs-toggle="modal" data-bs-target="#addNewRule" type="button"
								style="border-radius: 0"><i class="fa fa-plus" data-bs-toggle="tooltip" title="إضافة دور جديد للتطبيق"></i></button>
						</h4>

						<div class="col col-8 input-group">
							<label class="input-group-text" for="search"><i class="fa fa-search"></i></label>
							<input class="form-control" id="search" type="text" name="search" placeholder="ابحث فى المستخدمين">
						</div>
					</div>

					<fieldset class="p-4">

						<table class="striped" dir="rtl" style="width: 100%">
							<thead>
								<tr class="text-center">
									<th>مسلسل</th>
									<th>الاسم</th>
									<th>البريد</th>
									<th>مسجل منذ</th>
									<th>الطبيعة</th>
									<th>الوظيفة</th>
									<th>التحكم</th>
								</tr>
							</thead>
							<tbody>
								@if (count($users))
									@php $i=0 @endphp @foreach ($users as $ui => $user)
										<tr>
											<td>{{ ++$i }}</td>
											<td>{{ $user->profile->firstName }} {{ $user->profile->lastName }} [
												{{ $user->profile->title }} ] </td>
											<td>{{ $user->email }}</td>
											<td>{{ $user->created_at }}</td>
											<td>{{ $user->profile->profession }}{{-- $professions[$user->profile->profession][1] --}}</td>
											<td>{{ $professions[$user->profile->profession][1] }}{{-- $professions[$user->profile->profession][1] --}}
											</td>
											<td>
												<a href="{{ route('users.show.basic.info', [$user->id]) }}"><i class="fa fa-eye" data-bs-toggle="tooltip"
														data-bs-title="عرض بيانات العميل"></i></a>
												<a data-bs-toggle="tooltip" data-bs-title="حذف العميل" href="{{ route('users.delete', $user->id) }}"
													onclick="return confirm('هل تريد حذف هذا العميل بالفعل؟، هذه الحركة لا يمكن الرجوع عنها.')"><i class="fa fa-trash"
														title="حذف العميل"></i></a>

											</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="7">لم يتم بعد تسجيل موظفين حتى الان <a href="{{ route('users.create') }}">أدخل
												أول مستخدم لك فى التطبيق!</a></td>
									</tr>
								@endif
							</tbody>
						</table>
						{{ $users->links() }}
					</fieldset>

				</fieldset>
			</div>

		</div>

	</div>

	{{-- Modals --}}
	<!-- Modal -->
	<div class="modal fade" id="addNewRule" tabindex="-1" aria-labelledby="addNewEmployee" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" style="width: 800px">
				<div class="modal-header mx-0 bg-secondary" style="background-color: #777">
					<h1 class="modal-title fs-5" id="addNewEmployee">إضافة موظف جديد</h1>
					<button class="button-close ml-1 my-1 p-1" data-bs-dismiss="modal" type="button" aria-label="Close"><i class="fa fa-times"></i></button>
				</div>
				<div class="modal-body">
					<form action="{{ route('users.store') }}" method="post">

						@csrf

						<fieldset style="box-shadow: none; border: 1px solid #777">
							<legend>اسم الدور:</legend>
							<div class="input-group mt-3">
								<input class="form-control" id="name" type="text" name="name" required placeholder=" اسم الدور" value="{{ old('name') }}">

								<input class="form-control" id="display_name_ar" type="text" name="display_name_ar" required placeholder="الاسم العربى"
									value="{{ old('display_name_ar') }}">

								<input class="form-control" id="display_name_en" type="text" name="display_name_en" required placeholder="الاسم اللاتيني"
									value="{{ old('display_name_en') }}">
							</div>
						</fieldset>

						<fieldset style="box-shadow: none; border: 1px solid #777; background: #ccc4">
							<legend> الوصف:</legend>

							<div class="form-floating mt-3">
								<textarea class="form-control" id="brief" style="height: 150px" name="brief" placeholder="">{{ old('brief') }}</textarea>
								<label for="brief">نبذة عن الدور:</label>
							</div>

							<div class="form-check form-switch form-check-reverse mt-3" dir="rtl">
								<input class="form-check-input" id="rule_status" type="checkbox" role="switch" name="status">
								<label class="form-check-label" for="rule_status"> الحالة: <span id="statusText">معطلة</span></label>
							</div>
						</fieldset>

						<div class="buttons">

							<button class="btn btn-info" id="dismiss_btn" id="submitBtn" onclick="window.location='{{ route('users.home') }}'"
								type="button">إلغاء</button>
							<button class="btn btn-success" id="submitBtn" type="submit">تحديث بيانات الدور</button>
						</div>

					</form>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" data-bs-dismiss="modal" type="button">إغلاق</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
@endsection
