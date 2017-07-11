@extends('layouts.app.frame')
@section('title', 'Edit Payment')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Payment', 'url' => url('/admin/payment')], 'Update']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/payment') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')


    {!! Form::model($payment, [
            'method' => 'PATCH',
            'url' => ['/admin/payment', $payment->id],
            'files' => true,
            'id' => 'formValidate',
        ]) !!}

        @include ('admin.payment.form', ['submitButtonText' => 'Update'])

	{!! Form::close() !!}
@endsection