@extends('layouts.app.frame')
@section('title', 'Edit Bank')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Bank', 'url' => url('/admin/bank')], 'Update']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/bank') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')


    {!! Form::model($bank, [
            'method' => 'PATCH',
            'url' => ['/admin/bank', $bank->id],
            'files' => true,
            'id' => 'formValidate',
        ]) !!}

        @include ('admin.payment.form', ['submitButtonText' => 'Update'])

	{!! Form::close() !!}
@endsection