@extends('layouts.app.frame')
@section('title', 'Payment #' . $payment->id)
@section('description', 'Payment Details')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Payment', 'url' => url('/admin/payment')], 'View '.$payment->name]) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/payment') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
	<div class="panel panel-default">
		<div class="panel-body">
			<a href="{{ url('admin/payment/' . $payment->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Payment"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
			{!! Form::open([
				'method'=>'DELETE',
				'url' => ['admin/payment', $payment->id],
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
							<th>ID</th><td>{{ $payment->id }}</td>
						</tr>
						<tr>
							<th> Name </th>
							<td> {{ $payment->name }} </td>
						</tr>
						<tr>
							<th> Status </th>
							<td> {{ $payment->getStatusLabel() }} </td>
						</tr>
						<tr>
							<th> Order </th>
							<td> {{ $payment->order }} </td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
@endsection