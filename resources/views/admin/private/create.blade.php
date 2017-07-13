@extends('layouts.app.frame')
@section('title', 'Create New Private')
@section('description', 'Please make sure to check all input')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Private', 'url' => url('/admin/private')], 'Create']) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/private') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
    {!! Form::open(['url' => '/admin/private', 'id' => 'formValidate', 'files' => true]) !!}

		@include ('admin.private.form')

	{!! Form::close() !!}
@endsection


@push("script")
<script>
$(document).ready(function() {

    $('#formValidate').validate();

});
</script>
@endpush