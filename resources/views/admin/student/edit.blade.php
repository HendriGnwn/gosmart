@extends('layouts.app.frame')
@section('title', 'Edit Student')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Student', 'url' => url('/admin/student')], 'Update']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/student') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')


    {!! Form::model($model, [
            'method' => 'PATCH',
            'url' => ['/admin/student', $model->id],
            'files' => true,
            'id' => 'formValidate',
        ]) !!}

        @include ('admin.student.form', ['submitButtonText' => 'Update'])

	{!! Form::close() !!}
@endsection