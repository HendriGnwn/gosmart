@extends('layouts.app.frame')
@section('title', 'Create New Teacher Course')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Teacher', 'url' => url('/admin/teacher')], 
	['title' => 'View#'.$userId, 'url' => url('/admin/teacher/'.$userId)], 'Create Course']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/teacher/' . $userId) }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
    {!! Form::open(['url' => '/admin/teacher/course/create/'.$userId, 'id' => 'formValidate', 'files' => true]) !!}

		@include ('admin.teacher.form-course', ['userId' => $userId])

	{!! Form::close() !!}
@endsection


@push("script")
<script>
$(document).ready(function() {

    $('#formValidate').validate();

});
</script>
@endpush