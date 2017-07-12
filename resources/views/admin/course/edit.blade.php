@extends('layouts.app.frame')
@section('title', 'Edit Course')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Course', 'url' => url('/admin/course')], 'Update']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/course') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')


    {!! Form::model($model, [
            'method' => 'PATCH',
            'url' => ['/admin/course', $model->id],
            'files' => true,
            'id' => 'formValidate',
        ]) !!}

        @include ('admin.bank.form', ['submitButtonText' => 'Update'])

	{!! Form::close() !!}
@endsection