@extends('layouts.app.frame')
@section('title', 'Create New Bank')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Bank', 'url' => url('/admin/bank')], 'Create']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/bank') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
    {!! Form::open(['url' => '/admin/bank', 'id' => 'formValidate', 'files' => true]) !!}

		@include ('admin.bank.form')

	{!! Form::close() !!}
@endsection


@push("script")
<script>
$(document).ready(function() {

    $('#formValidate').validate();

});
</script>
@endpush