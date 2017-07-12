@extends('layouts.app.frame')
@section('title', 'Create New Course Level')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Course Level', 'url' => url('/admin/course-level')], 'Create']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/course-level') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
    {!! Form::open(['url' => '/admin/course-level', 'id' => 'formValidate', 'files' => true]) !!}

		@include ('admin.course-level.form')

	{!! Form::close() !!}
@endsection


@push("script")
<script>
$(document).ready(function() {

    $('#formValidate').validate();

});
</script>
@endpush