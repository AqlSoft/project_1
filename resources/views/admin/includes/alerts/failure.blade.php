@if (Session::has('error'))
	<div class="container my-0">
		<div class="alert alert-sm py-2 my-0 alert-danger text-right">
			{!! Session::get('error') !!}
		</div>
	</div>
@endif
