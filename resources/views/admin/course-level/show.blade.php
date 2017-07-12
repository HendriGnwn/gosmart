@extends('layouts.app.frame')
@section('title', 'Course Level #' . $courseLevel->id)
@section('description', 'Course Level Details')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Course Level', 'url' => url('/admin/course-level')], 'View '.$courseLevel->name]) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/course-level') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
	<div class="panel panel-default">
		<div class="panel-body">
			<a href="{{ url('admin/course-level/' . $courseLevel->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Payment"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
			{!! Form::open([
				'method'=>'DELETE',
				'url' => ['admin/course-level', $courseLevel->id],
				'style' => 'display:inline'
			]) !!}
				{!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
						'type' => 'submit',
						'class' => 'btn btn-danger btn-xs',
						'title' => 'Delete Course Level',
						'onclick'=>'return confirm("Confirm delete?")'
				))!!}
			{!! Form::close() !!}
			<br/>
			<br/>

			<div class="table-responsive">
				<table class="table table-condensed">
					<tbody>
						<tr>
							<th>ID</th><td>{{ $courseLevel->id }}</td>
						</tr>
						<tr>
							<th> Name </th>
							<td> {{ $courseLevel->name }} </td>
						</tr>
						<tr>
							<th> Status </th>
							<td> {{ $courseLevel->getStatusLabel() }} </td>
						</tr>
						<tr>
							<th> Order </th>
							<td> {{ $courseLevel->order }} </td>
						</tr>
						<tr>
							<th> Deleted At </th>
							<td> {{ $courseLevel->deleted_at }} </td>
						</tr>
						<tr>
							<th> Created At </th>
							<td> {{ $courseLevel->created_at }} </td>
						</tr>
						<tr>
							<th> Updated At </th>
							<td> {{ $courseLevel->updated_at }} </td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
@endsection