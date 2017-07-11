@extends('layouts.app.frame')
@section('title', 'Create New Payment')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Payment', 'url' => url('/admin/payment')], 'Create']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/payment') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
    {!! Form::open(['url' => '/admin/payment', 'id' => 'formValidate', 'files' => true]) !!}

		@include ('admin.payment.form')

	{!! Form::close() !!}
@endsection


@push("script")
<script>
$(document).ready(function() {

    $('#formValidate').validate();

});
</script>
@endpush