@extends('layouts.app.frame')
@section('title', 'Edit User')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'User', 'url' => url('/admin/user')], 'Update']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/user') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')


    {!! Form::model($model, [
            'method' => 'PATCH',
            'url' => ['/admin/user', $model->id],
            'files' => true,
            'id' => 'formValidate',
        ]) !!}

        @include ('admin.user.form', ['submitButtonText' => 'Update'])

	{!! Form::close() !!}
@endsection