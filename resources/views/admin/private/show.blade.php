@extends('layouts.app.frame')
@section('title', 'Private#' . $model->id)
@section('description', 'Private Details')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Private', 'url' => url('/admin/private')], 'View '.$model->code]) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/private') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
	<div class="panel panel-default">
		<div class="panel-body">
			<a href="{{ url('admin/private/' . $model->id . '/edit') }}" class="btn btn-primary btn-xs" title="Update Status"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
			{!! Form::open([
				'method'=>'DELETE',
				'url' => ['admin/private', $model->id],
				'style' => 'display:inline'
			]) !!}
				{!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
						'type' => 'submit',
						'class' => 'btn btn-danger btn-xs',
						'title' => 'Delete Private',
						'onclick'=>'return confirm("Confirm delete?")'
				))!!}
			{!! Form::close() !!}
			<br/>
			<br/>

			<div class="table-responsive">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th>ID</th><td>{{ $model->id }}</td>
						</tr>
						<tr>
							<th> Code </th>
							<th> {{ $model->code }} </th>
						</tr>
						<tr>
							<th> Student </th>
							<td> {{ isset($model->student) ? $model->student->getFullName() : $model->user_id }} </td>
						</tr>
						<tr>
							<th> Teacher </th>
							<td> {{ isset($model->teacher) ? $model->teacher->getFullName() : $model->teacher_id }} </td>
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
							<th> Start Date </th>
							<td> {{ $model->start_date }} </td>
						</tr>
						<tr>
							<th> End Date </th>
							<td> {{ $model->end_date }} </td>
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
							<th> Order Detail </th>
							<td> {!! $model->order->getDetailHtml() !!} </td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Private Details</h3>
				</div>
				<div class="panel-body table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th width="20%">Course</th>
								<th width="80%">Details</th>
								
							</tr>
						</thead>
						<tbody>
							@foreach($model->privateDetails as $detail)
							<tr>
								<td>{{ isset($detail->course) ? $detail->course->name : $detail->course_id }}</td>
								<td>
									<table class="table table-bordered table-hover">
										<tbody>
											<tr>
												<th width="15%">On At</th>
												<td>{!! $detail->getOnAt() !!}</td>
											</tr>
											<tr>
												<th>Section</th>
												<td>{{ $detail->section }}</td>
											</tr>
											<tr>
												<th>Section Time</th>
												<td>{{ $detail->section_time }}</td>
											</tr>
											<tr>
												<th>Student Details</th>
												<td>{!! $detail->getStudentDetailsHtml() !!}</td>
											</tr>
											<tr>
												<th>Teacher Details</th>
												<td>{!! $detail->getTeacherDetailsHtml() !!}</td>
											</tr>
											<tr>
												<th>Checklist</th>
												<td>{{ $detail->getChecklistLabel() }}</td>
											</tr>
											<tr>
												<th>Checklist At</th>
												<td>{{ $detail->checklist_at }}</td>
											</tr>
											<tr>
												<th>Created At</th>
												<td> {{ $detail->created_at }} </td>
											</tr>
											<tr>
												<th>Updated At</th>
												<td> {{ $detail->updated_at }} </td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
	</div>
@endsection