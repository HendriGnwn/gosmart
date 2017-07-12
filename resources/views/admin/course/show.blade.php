@extends('layouts.app.frame')
@section('title', 'Course #' . $model->id)
@section('description', 'Course Details')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Bank', 'url' => url('/admin/course')], 'View '.$model->name]) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/course') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
	<div class="panel panel-default">
		<div class="panel-body">
			<a href="{{ url('admin/course/' . $model->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Course"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
			{!! Form::open([
				'method'=>'DELETE',
				'url' => ['admin/course', $model->id],
				'style' => 'display:inline'
			]) !!}
				{!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
						'type' => 'submit',
						'class' => 'btn btn-danger btn-xs',
						'title' => 'Delete Payment',
						'onclick'=>'return confirm("Confirm delete?")'
				))!!}
			{!! Form::close() !!}
			<br/>
			<br/>

			<div class="table-responsive">
				<table class="table table-condensed">
					<tbody>
						<tr>
							<th>ID</th><td>{{ $model->id }}</td>
						</tr>
						<tr>
							<th> Name </th>
							<td> {{ $model->name }} </td>
						</tr>
						<tr>
							<th> Course Level </th>
							<td> {{ isset($model->courseLevel) ? $model->courseLevel->name : null }} </td>
						</tr>
						<tr>
							<th> Description </th>
							<td> {{ $model->description }} </td>
						</tr>
						<tr>
							<th> Section </th>
							<td> {{ $model->section }} </td>
						</tr>
						<tr>
							<th> Section Time </th>
							<td> {{ $model->section_time }} </td>
						</tr>
						<tr>
							<th> Status </th>
							<td> {{ $model->getStatusLabel() }} </td>
						</tr>
						<tr>
							<th> Created At </th>
							<td> {{ $model->created_at }} </td>
						</tr>
						<tr>
							<th> Updated At </th>
							<td> {{ $model->updated_at }} </td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
@endsection