@extends('layouts.app.frame')
@section('title', 'Edit Private Status')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Private', 'url' => url('/admin/private')], 'Private Status']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/private') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
    {!! Form::model($model, [
            'method' => 'PATCH',
            'url' => ['/admin/private', $model->id],
            'files' => true,
            'id' => 'formValidate',
        ]) !!}

        @include ('admin.private.form', ['submitButtonText' => 'Update'])

	{!! Form::close() !!}
@endsection