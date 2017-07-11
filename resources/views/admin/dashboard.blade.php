@extends('layouts.app.frame')
@section('title', 'Dashboard')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render(['Dashboard']) @endphp
@endsection
@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">Dashboard</div>

		<div class="panel-body">
			Your application's dashboard.
		</div>
	</div>
@endsection
