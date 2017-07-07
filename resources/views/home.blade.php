@extends('layouts.app.frame')
@section('title', 'Dashboard')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render(['Dashboard']) @endphp
@endsection
@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">Dashboard</div>

		<div class="panel-body">
			You are logged in!
		</div>
	</div>
@endsection
