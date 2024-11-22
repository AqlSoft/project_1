@extends('layouts.admin')
@section('title')
	مستخدم
@endsection

@section('pageHeading')
	بيانات المستخدم
@endsection

@section('content')

	<div class="container pt-3" style="min-height: 100vh">
		<nav>
			<div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
				<button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
					aria-selected="true">
					<a href="{{ route('users.home') }}"> الموظفين </a>
				</button>
				<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab"
					aria-controls="nav-home" aria-selected="true">
					<a> البيانات الأساسية </a>
				</button>
				<button class="nav-link " id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab"
					aria-controls="nav-profile" aria-selected="false">
					<a href="{{ route('see.own.login.info', [0]) }}"> بيانات تسجيل الدخول</a>
				</button>
				<button class="nav-link " id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab"
					aria-controls="nav-contact" aria-selected="false">
					<a href="{{ route('see.own.permissions', [0]) }}"> الصلاحيات </a>
				</button>
				<button class="nav-link " id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled" type="button" role="tab"
					aria-controls="nav-disabled" aria-selected="false">
					<a href="{{ route('users.show', [4]) }}"> أيام العمل </a>
				</button>
			</div>
		</nav>

		<div class="tab-content" id="nav-tabContent" style="">
			<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
				<fieldset class="m-3" dir="rtl">
					<h4 style="right: 20px; left: auto"> تعديل بيانات المستخدم </h4>
					<fieldset class="bg-light" dir="rtl">
						<form class="my-0 mx-3" action="{{ route('users.profiles.update') }}" method="post">
							@csrf
							<input type="hidden" name="id" value="{{ $user->id }}">
							<div class="input-group mt-3">
								<label class="input-group-text required" for="firstName">الاسم الأول</label>
								<input class="form-control" id="firstName" type="text" name="firstName" required value="{{ $user->profile->firstName }}" />
								<label class="input-group-text required" for="lastName">اسم العائلة</label>
								<input class="form-control" id="lastName" type="text" name="lastName" required value="{{ $user->profile->lastName }}" />
								<label class="input-group-text" for="title"> اللقب </label>
								<input class="form-control" id="title" type="text" name="title" value="{{ $user->profile->title }}" />
							</div>

							<div class="input-group mt-3">
								<label class="input-group-text" for="gender">النوع</label>
								<select class="form-control" id="gender" name="gender">
									<option hidden>اختر الجنس</option>
									<option {{ $user->profile->gender == 1 ? 'selected' : '' }} value="1">ذكر</option>
									<option {{ $user->profile->gender == 0 ? 'selected' : '' }} value="0">أنثى
									</option>
								</select>
								<label class="input-group-text" for="type">القسم</label>
								<select class="form-control" id="type" name="type">
									<option {{ $user->profile->type == 1 ? 'selected' : '' }} value="1">الإدارة
									</option>
									<option {{ $user->profile->type == 0 ? 'selected' : '' }} value="0">الموظفين
									</option>
								</select>
								<label class="input-group-text required" for="dob">تاريخ الميلاد</label>
								<input class="form-control" id="dob" type="date" name="dob" placeholder="اسم المستخدم" required
									value="{{ $user->profile->dob }}" />
							</div>

							<div class="input-group mt-3">
								<label class="input-group-text required" for="phone">الهاتف</label>
								<input class="form-control" id="phone" type="text" name="phone" placeholder="اسم المستخدم" required
									value="{{ $user->profile->phone }}" />
								<label class="input-group-text" for="profession">الوظيفة
									{{ $user->profession }}</label>
								<select class="form-control" id="profession" name="profession">
									@foreach ($professions as $id => $p)
										<option {{ $user->profile->profession == $id ? 'selected' : '' }} value="{{ $id }}">{{ $p[1] }}</option>
									@endforeach
								</select>
								<label class="input-group-text" for="natId">رقم الهوية</label>
								<input class="form-control" id="natId" type="text" name="natId" value="{{ $user->profile->natId }}" />

								<button class="input-group-text" id="submitBtn" type="submit">تحديث بياناتى</button>
							</div>
						</form>
					</fieldset>

					<h4>الأدوار &nbsp; &nbsp;
						<button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addNewRole">
							<div data-bs-toggle="tooltip" title="إضافة أدوار جديدة"><i class="fa fa-plus"></i></div>
						</button>
					</h4>
					<fieldset>
						<form class="my-0 mx-3" action="{{ route('assign.role.to.user') }}" method="post">

							@csrf
							<input type="hidden" name="id" value="{{ $user->id }}">
							{{-- $user->roles --}}

							{{ $user->hasRole(3) ? 'checked' : '' }}
							@if (count($roles) > 0)
								<ul>
									@foreach ($roles as $role)
										<li class="form-check form-check-reverse">
											<input class="form-check-input" id="roles_{{ $role->id }}" type="checkbox" name="roles[]"
												{{ $user->hasRole($role->id) ? 'checked' : '' }} value="{{ $role->id }}">
											<label class="form-check-label" for="roles_{{ $role->id }}">{{ $role->display_name_ar }}
											</label>
										</li>
									@endforeach
								</ul>
							@endif

							<div class="buttons mt-3 p-0" style="justify-content:end">
								<button class="btn btn-primary" type="submit">تحديث الأدوار</button>
							</div>
						</form>
					</fieldset>
				</fieldset>
			</div>
		</div>
	</div>

	{{-- Modals --}}
	<!-- Modal -->
	<div class="modal fade" id="addNewRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header mx-0 bg-secondary" style="background-color: #777">
					<h1 class="modal-title fs-5" id="exampleModalLabel">إضافة أدوار</h1>
					<button class="button-close ml-1 my-1 p-1" data-bs-dismiss="modal" type="button" aria-label="Close"><i class="fa fa-times"></i></button>
				</div>
				<div class="modal-body">
					<form action="{{ route('store-role-info') }}" method="POST">
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
								<textarea class="form-control" id="brief" style="height: 150px" name="brief" placeholder="">{{ $role->brief }}</textarea>
								<label for="brief">نبذة عن الدور:</label>
							</div>

							<div class="form-check form-switch form-check-reverse mt-3" dir="rtl">
								<input class="form-check-input" id="role_status" type="checkbox" role="switch" name="status" {{ $role->status ? 'checked' : '' }}>
								<label class="form-check-label" for="role_status"> الحالة: <span id="statusText">{{ $role->status ? 'مفعلة' : 'معطلة' }}</span></label>
							</div>
						</fieldset>

						<div class="buttons text-left">

							<button class="btn btn-secondary" data-bs-dismiss="modal" type="button">إلغاء</button>
							<button class="btn btn-success" id="submitBtn" type="submit">تحديث بيانات الدور</button>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>

	</div>
@endsection

@section('script')
@endsection
