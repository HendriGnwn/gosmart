@extends('layouts.app.frame')
@section('title', 'Edit Teacher')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Teacher', 'url' => url('/admin/teacher')], 'Update']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/teacher') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')


    {!! Form::model($model, [
            'method' => 'PATCH',
            'url' => ['/admin/teacher', $model->id],
            'files' => true,
            'id' => 'formValidate',
        ]) !!}

        @include ('admin.teacher.form', ['submitButtonText' => 'Update'])

	{!! Form::close() !!}
@endsection