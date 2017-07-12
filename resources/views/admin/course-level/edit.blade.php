@extends('layouts.app.frame')
@section('title', 'Edit Course Level')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Course Level', 'url' => url('/admin/course-level')], 'Update']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/course-level') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')


    {!! Form::model($courseLevel, [
            'method' => 'PATCH',
            'url' => ['/admin/course-level', $courseLevel->id],
            'files' => true,
            'id' => 'formValidate',
        ]) !!}

        @include ('admin.course-level.form', ['submitButtonText' => 'Update'])

	{!! Form::close() !!}
@endsection