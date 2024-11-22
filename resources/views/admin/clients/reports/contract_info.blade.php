@extends('layouts.admin')

@section('title')
	تقارير الفترات
@endsection

@section('pageHeading')
	تقرير الفترات
@endsection

@section('content')
	<div class="container">
		<div>{{ $contract->s_number }}</div>
	</div>
@endsection
