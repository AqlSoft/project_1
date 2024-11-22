@extends('layouts.admin')
@section('title')
	أصناف التخزين
@endsection
@section('pageHeading')
	اسماء الأصناف المخزنة بالثلاجة
@endsection

@section('content')
	<div class="container pt-3">
		<style>

		</style>

		<fieldset>
			<legend class="custom-bg">اسماء الأصناف</legend>
			<div class="m-4 p-4 bg-light" style="box-shadow: 0 0 8px 3px #777 inset">
				<div class="buttons p-0">
					<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store.items.stats') }}"> <i class="fa fa-chart-line"></i>
							احصائيات</a></button>
					<button class="btn btn-sm px-2 btn-success" type="button"><a> <i class="fa fa-list"></i>
							الأصناف</button>

					<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store-items-categories-list') }}">
							<i class="fa fa-tags"></i>
							الفئات </a></button>
					<button class="btn btn-sm px-2 btn-outline-primary" type="button"><a href="{{ route('store-items-grades-list') }}">
							<i class="fa fa-ranking-star"></i>
							الدرجات </a></button>

				</div>
			</div>

			<div class="search mr-4">
				<form method="POST">
					<div class="row mb-3">
						<div class="col col-5">
							<div class="input-group">
								<label class="input-group-text" for="aj_search">البحث فى الأصناف</label>
								<input class="form-control bg-light" id="aj_search" data-search-token="{{ csrf_token() }}" data-search-url="{{ route('treasuries.aj') }}"
									type="text" name="search">
								<label class="input-group-text" for="aj_search"><i class="fa fa-search"></i></label>
							</div>
						</div>
					</div>
				</form>

			</div>

			<div class="m-4" style="background-color: #fff; box-shadow: 0 0 8px 3px #777 inset">
			    <br>
				<div class="mr-4 p-0">
					{{ $items->links() }}
				</div>
				<div class="row p-3">
					
					@if (count($items))
					@php 
					    
				        $page = request('page');
					    $counter = $page!= null? ($page-1)*10:0;
					     
			        @endphp
						@foreach ($items as $in => $item)
						@php  $itemPic = $item->pic == 'none' ? 'default.png':$item->pic @endphp
							<div class="col col-12 col-sm-6">
								<div class="item">

									<div class="item-image fw-bold" style="background-image: url('{{ asset('storage/uploads/images/' . $itemPic) }}')">
									</div>
									<div class="item-name pr-3 text-right">
										{{ ++$counter }} - {{ @$item->parent->parent->name }} > {{ @$item->parent->name }} > {{ $item->name }} > {{ @$item->grade->name }}

										<div class="buttons">
											<button class="btn btn-outline-success btn-sm"><a href="{{ route('store.items.edit', [$item->id]) }}"> <i
														class="fa fa-edit text-success"></i> تعديل </a></button>
											<button class="btn btn-outline-primary btn-sm"><a href="{{ route('store.items.view', [$item->id]) }}"><i
														class="fa fa-eye text-primary"></i>
													رؤية المزيد </a></button>
											<button class="btn btn-outline-danger btn-sm"><a onclick="if(!confirm('انت هتحذف الصنف يا معلم، انت عارف اللى هيحصل؟ مفيش استعادة للمحذوف')){return false}" href="{{ route('store.items.remove', [$item->id]) }}"><i
														class="fa fa-trash text-danger"></i> حذف </a></button>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					@else
						<div class="col col-12 text-right">لم تتم إضافة أصناف بعد، استخدم النموذج بالأسفل لإضافة أصناف.</div>
					@endif
				</div>
				<div class="pr-4 pb-3">
					{{ $items->links() }}
				</div>
			</div>

			<div class="m-4 p-4" style="background-color: #fff; box-shadow: 0 0 8px 3px #777 inset">

				<form class="" action="{{ route('store.items.store') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col col-12 col-lg-8">
							<div class="input-group mb-2">
								<label class="input-group-text" for="parent">التصنيف الأب</label>
								<select class="form-control" id="parent" name="parent" value="{{ old('parent') }}">
									@if (count($categories))
										
										@foreach ($categories as $category)
											@if ($category->parent_id > 10)
												
											<option value="{{ $category->id }}">{{ @$category->parent->name }} > {{ $category->name }}</option>
											@endif
										@endforeach
										
									@endif
								</select>
								<label class="input-group-text" for="grade">الجودة</label>
								<select class="form-control" id="grade" name="grade" value="{{ old('grade') }}">
									@if (count($grades))
										
										@foreach ($grades as $grade)
											@if ($grade->parent_id === 10)
												@continue
											@endif
											<option value="{{ $grade->id }}">{{ $grade->name }}</option>
										@endforeach
										
									@endif
								</select>
							</div>
							<div class="input-group mb-2">
								<label class="input-group-text" for="name">اسم الصنف التجاري</label>
								<input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}">
							</div>
							<div class="input-group mb-2">
								<label class="input-group-text" for="short">اسم الصنف الظاهر</label>
								<input class="form-control" id="short" type="text" name="short" value="{{ old('short') }}">
							</div>
							<div class="form-floating ">
								<textarea class="form-control" id="brief" placeholder="" style="height: 100px" name="brief"></textarea>
								<label for="brief">الوصف</label>
							</div>

						</div>
						<div class="col col-12 col-lg-4">
							<div class="change-image">
								<img class="item-image" id="item-image" width="250" height="250" src="{{ asset('storage/app/admin/uploads/images/default.png') }}"
									alt="">

								<input id="pic" type="file" name="pic" required accept="image/*" onchange="loadFile(event)" />
								<div class="change-image-buttons">
									<label for="pic">اختر صورة من جهازك</label>

								</div>
							</div>
						</div>
						@error('pic')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
					<div class="buttons justify-content-end">
						<button class="btn btn-sm btn-outline-danger" type="reset">افراغ النموذج</button>
						<button class="btn btn-sm btn-outline-info" type="submit">إضافة الصنف الى الأصناف المخزنية الموجودة</button>
					</div>

				</form>
			</div>

		</fieldset>
		<br>

	</div>
@endsection

@section('script')
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
