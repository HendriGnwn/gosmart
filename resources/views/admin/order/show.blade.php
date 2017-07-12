@extends('layouts.app.frame')
@section('title', 'Order #' . $model->id)
@section('description', 'Order Details')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Order', 'url' => url('/admin/order')], 'View '.$model->code]) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/order') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
	<div class="panel panel-default">
		<div class="panel-body">
			<a href="{{ url('admin/order/' . $model->id . '/edit') }}" class="btn btn-primary btn-xs" title="Update Status"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
			{!! Form::open([
				'method'=>'DELETE',
				'url' => ['admin/order', $model->id],
				'style' => 'display:inline'
			]) !!}
				{!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
						'type' => 'submit',
						'class' => 'btn btn-danger btn-xs',
						'title' => 'Delete Order',
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
							<th> Admin Fee </th>
							<td> {{ $model->getFormattedAdminFee() }} </td>
						</tr>
						<tr>
							<th> Payment </th>
							<td> {{ isset($model->payment) ? $model->payment->name : $model->payment_id }} </td>
						</tr>
						<tr>
							<th> Status </th>
							<td> {{ $model->getStatusLabel() }} </td>
						</tr>
						<tr>
							<th> Confirmed At </th>
							<td> {{ $model->confirmed_at }} </td>
						</tr>
						<tr>
							<th> Paid By </th>
							<td> {{ isset($model->paidBy) ? $model->paidBy->getFullName() : $model->paid_by }} </td>
						</tr>
						<tr>
							<th> Paid At </th>
							<td> {{ $model->paid_at }} </td>
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
			
			@php
			$confirmation = $model->orderConfirmation;
			if (!isset($confirmation)) {
				$confirmation = new \App\OrderConfirmation();
			}
			@endphp
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Order Confirmation Details</h3>
				</div>
				<div class="panel-body table-responsive">
					<table class="table table-bordered">
						<tbody>
							<tr>
								<th>ID</th><td>{{ $confirmation->id }}</td>
							</tr>
							<tr>
								<th> User </th>
								<td> {{ isset($confirmation->user) ? $confirmation->user->getFullName() : $confirmation->user_id }} </td>
								
							</tr>
							<tr>
								<th> Bank </th>
								<td> {{ isset($confirmation->bank) ? $confirmation->bank->name : $confirmation->bank_id }} </td>
							</tr>
							<tr>
								<th> Bank Number </th>
								<td> {{ $confirmation->bank_number }} </td>
							</tr>
							<tr>
								<th> Bank Behalf Of </th>
								<td> {{ $confirmation->bank_behalf_of }} </td>
							</tr>
							<tr>
								<th> Amount </th>
								<td> {{ $confirmation->getFormattedAmount() }} </td>
							</tr>
							<tr>
								<th> Bukti </th>
								<td> {!! $confirmation->getUploadBuktiHtml() !!} </td>
							</tr>
							<tr>
								<th> Description </th>
								<td> {{ $confirmation->description }} </td>
							</tr>
							<tr>
								<th> Created At </th>
								<td> {{ $confirmation->created_at }} </td>
							</tr>
							<tr>
								<th> Updated At </th>
								<td> {{ $confirmation->updated_at }} </td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Order Details</h3>
				</div>
				<div class="panel-body table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Course</th>
								<th>On At</th>
								<th>Section</th>
								<th>Section Time</th>
								<th>Amount</th>
								<th> Created At </th>
								<th> Updated At </th>
							</tr>
						</thead>
						<tbody>
							@foreach($model->orderDetails as $orderDetail)
							<tr>
								<td>{{ isset($orderDetail->course) ? $orderDetail->course->name : $orderDetail->course_id }}</td>
								<td>{!! $orderDetail->getOnAt() !!}</td>
								<td>{{ $orderDetail->section }}</td>
								<td>{{ $orderDetail->section_time }}</td>
								<td>{{ $orderDetail->getFormattedAmount() }}</td>
								<td> {{ $orderDetail->created_at }} </td>
								<td> {{ $orderDetail->updated_at }} </td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
	</div>
@endsection