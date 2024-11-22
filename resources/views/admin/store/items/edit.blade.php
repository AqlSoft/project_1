@extends('layouts.admin')
@section('title')
	تعديل صنف ثلاجة
@endsection

@section('pageHeading')
	تعديل بيانات صنف ثلاجة
@endsection

@section('content')
	<div class="container">
		<fieldset>
			<legend>تحديث بيانات صنف ثلاجة</legend>
			<div class="m-4" style="background-color: #fff; box-shadow: 0 0 8px 3px #777 inset">
				<div class="buttons pr-4">
					<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store.items.stats') }}"> <i class="fa fa-chart-line"></i>
							احصائيات</a></button>
					<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store.items.home') }}"> <i class="fa fa-list"></i>
							الأصناف</button>
					<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store.items.view', [$item->id]) }}">
							<i class="fa fa-eye"></i>
							عرض</a></button>
					<button class="btn btn-sm px-2 btn-success" type="button"><a>
							<i class="fa fa-plus"></i>
							تعديل </a></button>

					<button class="btn btn-sm px-2 btn-outline-danger" type="button"><a href="{{ route('store.items.remove', [$item->id]) }}">
							<i class="fa fa-plus"></i>
							حذف </a></button>
				</div>
			</div>

			<div class="m-4 p-4" style="background-color: #fff; box-shadow: 0 0 8px 3px #777 inset">
				<div class="row">
					<div class="col col-12 col-lg-8">

						<form action="{{ route('store.items.update') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="item_id" value="{{ $item->id }}">
							<div class="input-group mb-2">
								<label class="input-group-text" for="parent">التصنيف الأب</label>
								<select class="form-control" id="parent" name="parent">
									@if (count($categories))
									@foreach ($categories as $category)
									@if ($category->parent_id > 10)
									<option {{ $item->parent_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">
										{{ $category->parent->name }} >
										{{ $category->name }}</option>
                                            				@endif												
									@endforeach
										}
									@endif
								</select>
								<label class="input-group-text" for="grade">الجودة</label>
								<select class="form-control" id="grade" name="grade" value="{{ old('grade', $item->grade_id) }}">
									@if (count($grades))
										{
										@foreach ($grades as $grade)
											<option {{ $item->grade_id == $grade->id ? 'selected' : '' }} value="{{ $grade->id }}">{{ $grade->name }}</option>
										@endforeach
										}
									@endif
								</select>
							</div>
							<div class="input-group mb-2">
								<label class="input-group-text" for="name">اسم الصنف التجاري</label>
								<input class="form-control" id="name" type="text" name="name" value="{{ old('name', $item->name) }}">
							</div>
							<div class="input-group mb-2">
								<label class="input-group-text" for="short">اسم الصنف الظاهر</label>
								<input class="form-control" id="short" type="text" name="short" value="{{ old('short', $item->short) }}">
							</div>
							<div class="form-floating ">
								<textarea class="form-control" id="brief" placeholder="" style="height: 100px" name="brief">{{ old('brief', $item->brief) }}</textarea>
								<label for="brief">الوصف</label>
							</div>

							<div class="buttons justify-content-end">
								<button class="btn btn-sm btn-outline-danger" type="reset">افراغ النموذج</button>
								<button class="btn btn-sm btn-outline-info" type="submit">تحديث بيانات الصنف</button>
							</div>

						</form>
					</div>
					<div class="col col-12 col-lg-4">
						<div class="form-wrapper p-3" dir="rtl">
							<form class="change-image" action="{{ route('store.items.change.image') }}" method="post" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="id" value="{{ $item->id }}">
								<img class="item-image" id="item-image" width="250" height="250" src="{{ asset('storage/uploads/images/' . $item->pic) }}"
									alt="">
								<input id="pic" type="file" name="pic" required accept="image/*" onchange="loadFile(event)" />
								<div class="change-image-buttons">
									<label for="pic">اختر صورة من جهازك</label>
									<button class="change-image-btn" data-bs-toggle="tooltip" title="تغيير الصورة">
										{{ $item->pic == 'none' ? 'إضافة صورة' : 'تغيير الصورة' }}
									</button>
								</div>
							</form>
						</div>
					</div>
					{{-- var_dump(asset('assets/admin/uploads/images/' . $item->pic)) --}}
					{{ var_dump(env('APP_URL') . '/storage/uploads/images/' . $item->pic) }}

				</div>

		</fieldset>
		<br>

	</div>
@endsection

@section('script')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/FileReader@0.10.2/FileReader.min.js"></script>
	<script>
		function loadFile(event) {
			var reader = new FileReader();
			reader.onload = function() {
				var output = document.getElementById('item-image');
				output.src = reader.result;
			};
			reader.readAsDataURL(event.target.files[0]);
		}
	</script>
@endsection
