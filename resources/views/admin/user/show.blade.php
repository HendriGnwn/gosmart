@extends('layouts.app.frame')
@section('title', 'User #' . $model->id)
@section('description', 'User Details')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Bank', 'url' => url('/admin/user')], 'View '.$model->first_name]) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/user') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
	<div class="panel panel-default">
		<div class="panel-body">
			<a href="{{ url('admin/user/' . $model->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit User"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
			{!! Form::open([
				'method'=>'DELETE',
				'url' => ['admin/user', $model->id],
				'style' => 'display:inline'
			]) !!}
				{!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
						'type' => 'submit',
						'class' => 'btn btn-danger btn-xs',
						'title' => 'Delete User',
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
							<th> Unique Number </th>
							<td> {{ $model->unique_number }} </td>
						</tr>
						<tr>
							<th> Name </th>
							<td> {{ $model->getFullName() }} </td>
						</tr>
						<tr>
							<th> Phone Number </th>
							<td> {{ $model->phone_number }} </td>c
						</tr>
						<tr>
							<th> Photo </th>
							<td> {!! $model->getPhotoHtml() !!} </td>
						</tr>
						<tr>
							<th> Latitude </th>
							<td> {{ $model->latitude }} </td>
						</tr>
						<tr>
							<th> Address </th>
							<td> {{ $model->address }} </td>
						</tr>
						<tr>
							<th> Email </th>
							<td> {{ $model->email }} </td>
						</tr>
						<tr>
							<th> Firebase Token </th>
							<td> {{ $model->firebase_token }} </td>
						</tr>
						<tr>
							<th> Status </th>
							<td> {{ $model->getStatusLabel() }} </td>
						</tr>
						<tr>
							<th> Role </th>
							<td> {{ $model->getRoleLabel() }} </td>
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