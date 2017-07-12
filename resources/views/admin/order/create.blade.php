@extends('layouts.app.frame')
@section('title', 'Create New Course')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Course', 'url' => url('/admin/course')], 'Create']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/course') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
    {!! Form::open(['url' => '/admin/course', 'id' => 'formValidate', 'files' => true]) !!}

		@include ('admin.course.form')

	{!! Form::close() !!}
@endsection


@push("script")
<script>
$(document).ready(function() {

    $('#formValidate').validate();

});
</script>
@endpush