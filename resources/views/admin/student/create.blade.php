@extends('layouts.app.frame')
@section('title', 'Create New User')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'User', 'url' => url('/admin/user')], 'Create']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/user') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
    {!! Form::open(['url' => '/admin/user', 'id' => 'formValidate', 'files' => true]) !!}

		@include ('admin.user.form')

	{!! Form::close() !!}
@endsection


@push("script")
<script>
$(document).ready(function() {

    $('#formValidate').validate();

});
</script>
@endpush