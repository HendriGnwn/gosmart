@extends('layouts.app.frame')
@section('title', 'Edit Order Status')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Order', 'url' => url('/admin/order')], 'Order Status']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/order') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
    {!! Form::model($model, [
            'method' => 'PATCH',
            'url' => ['/admin/order', $model->id],
            'files' => true,
            'id' => 'formValidate',
        ]) !!}

        @include ('admin.order.form', ['submitButtonText' => 'Update'])

	{!! Form::close() !!}
@endsection