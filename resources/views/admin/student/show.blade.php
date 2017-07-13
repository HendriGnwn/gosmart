@extends('layouts.app.frame')
@section('title', 'Student #' . $model->id)
@section('description', 'Student Details')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Bank', 'url' => url('/admin/student')], 'View '.$model->first_name]) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/student') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
	<div class="panel panel-default">
		<div class="panel-body">
			<a href="{{ url('admin/student/' . $model->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit User"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
			{!! Form::open([
				'method'=>'DELETE',
				'url' => ['admin/user', $model->id],
				'style' => 'display:inline'
			]) !!}
				{!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
						'type' => 'submit',
						'class' => 'btn btn-danger btn-xs',
						'title' => 'Delete Student',
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
							<th> Created At </th>
							<td> {{ $model->created_at }} </td>
						</tr>
						<tr>
							<th> Updated At </th>
							<td> {{ $model->updated_at }} </td>
						</tr>
						
						<tr>
							<th> </th>
							<td> </td>
						</tr>
						
						@php
							if (isset($model->studentProfile)) {
								$profile = $model->studentProfile;
							} else {
								$profile = new \App\StudentProfile();
							}
						@endphp
						
						<tr>
							<th> School </th>
							<td> {{ $profile->school }} </td>
						</tr>
						<tr>
							<th> School Address </th>
							<td> {{ $profile->school_address }} </td>
						</tr>
						<tr>
							<th> Degree </th>
							<td> {{ $profile->degree }} </td>
						</tr>
						<tr>
							<th> Department </th>
							<td> {{ $profile->department }} </td>
						</tr>
						<tr>
							<th> Updated At </th>
							<td> {{ $profile->updated_at }} </td>
						</tr>
						
					</tbody>
				</table>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Private Histories</h3>
				</div>
				<div class="panel-body table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Code</th>
								<th>Teacher</th>
								<th>Status</th>
								<th>Created At</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($profile->privateModels as $private)
							<tr>
								<td>{!! $private->getDetailHtml($private->code) !!}</td>
								<td> {{ isset($private->teacher) ? $private->teacher->getFullName() : $private->teacher_id }} </td>
								<td>{{ $private->getStatusLabel() }}</td>
								<td>{{ $private->created_at }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Order Histories</h3>
				</div>
				<div class="panel-body table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Code</th>
								<th>Final Amount</th>
								<th>Status</th>
								<th>Created At</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($profile->orders as $detail)
							<tr>
								<td>{!! $detail->getDetailHtml($detail->code) !!}</td>
								<td> {{ $detail->getFormattedFinalAmount() }} </td>
								<td>{{ $detail->getStatusLabel() }}</td>
								<td>{{ $detail->created_at }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Review Histories</h3>
				</div>
				<div class="panel-body table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Private</th>
								<th>Teacher</th>
								<th>Rate</th>
								<th>Description</th>
								<th>Status</th>
								<th>Created At</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($profile->reviews as $detail)
							<tr>
								<td> {!! isset($detail->privateModel) ? $detail->privateModel->getDetailHtml($detail->privateModel->code) : $detail->private_id !!} </td>
								<td> {{ isset($detail->teacher) ? $detail->teacher->getFullName() : $detail->teacher_id }} </td>
								<td> {{ $detail->rate }} </td>
								<td>{{ $detail->description }}</td>
								<td>{{ $detail->getStatusLabel() }}</td>
								<td>{{ $detail->created_at }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection