@extends('layouts.app.frame')
@section('title', 'Create New Teacher')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Teacher', 'url' => url('/admin/teacher')], 'Create']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/teacher') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
    {!! Form::open(['url' => '/admin/teacher', 'id' => 'formValidate', 'files' => true]) !!}

		@include ('admin.teacher.form')

	{!! Form::close() !!}
@endsection


@push("script")
<script>
$(document).ready(function() {

    $('#formValidate').validate();

});
</script>
@endpush