@extends('layouts.admin')
@section('title')
	تعديل بيانات فئة أصناف مخزنية
@endsection

@section('pageHeading')
	تعديل بيانات فئة أصناف مخزنية
@endsection

@section('content')
	<div class="container pt-2">

	
		<fieldset>
			<legend class="custom-bg"> تعديل بيانات فئة أصناف مخزنية
			</legend>

			<div class=" m-4 bg-light" style="box-shadow: 0 0 8px 3px #777 inset">
				<div class="buttons">
					<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store.items.stats') }}"> <i class="fa fa-chart-line"></i>
							احصائيات</a></button>
					<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store.items.home') }}"> <i class="fa fa-list"></i>
							الأصناف</button>
					<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store-items-categories-list') }}"> <i
								class="fa fa-list"></i>
							الفئات</button>
					<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store-items-categories-view', [$item->id]) }}">
							<i class="fa fa-eye"></i>
							عرض</a></button>
					<button class="btn btn-sm px-2 btn-success" type="button"><a>
							<i class="fa fa-plus"></i>
							تعديل </a></button>
					<button class="btn btn-sm px-2 btn-outline-danger" type="button"><a href="{{ route('store-items-categories-remove', [$item->id]) }}">
							<i class="fa fa-plus"></i>
							حذف </a></button>
				</div>
			</div>
			<div class=" m-4 p-3 bg-light" style="box-shadow: 0 0 8px 3px #777 inset">
				<div class="row">
					<div class="col col-12 col-lg-8">
						<form action="{{ route('store-items-grades-update', [$item->id]) }}" method="post" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="id" value="{{ $item->id }}">
							
							<div class="input-group mb-3">
								<label class="input-group-text" for="name"> الاسم </label>
								<input class="form-control" id="name" type="text" name="name" required value="{{ $item->name }}">
							</div>
							
							<div class="input-group mb-3">
								<label class="input-group-text" for="short"> الاسم المختصر </label>
								<input class="form-control" id="short" type="text" name="short" required value="{{ $item->short }}">
							</div>

							<div class="buttons">
								<button class="btn btn-outline-info" type="reset">اعادة ضبط النموذج</button>
								<button class="btn btn-outline-primary" type="submit">تحديث البيانات</button>
							</div>
						</form>
					</div>
				
				</div>

			</div>

		</fieldset>

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
