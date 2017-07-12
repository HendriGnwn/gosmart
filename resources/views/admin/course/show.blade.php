@extends('layouts.app.frame')
@section('title', 'Bank #' . $bank->id)
@section('description', 'Bank Details')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Bank', 'url' => url('/admin/bank')], 'View '.$bank->name]) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/bank') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
	<div class="panel panel-default">
		<div class="panel-body">
			<a href="{{ url('admin/bank/' . $bank->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Bank"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
			{!! Form::open([
				'method'=>'DELETE',
				'url' => ['admin/bank', $bank->id],
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
							<th>ID</th><td>{{ $bank->id }}</td>
						</tr>
						<tr>
							<th> Name </th>
							<td> {{ $bank->name }} </td>
						</tr>
						<tr>
							<th> Payment </th>
							<td> {{ isset($bank->payment) ? $bank->payment->name : null }} </td>
						</tr>
						<tr>
							<th> Description </th>
							<td> {{ $bank->description }} </td>
						</tr>
						<tr>
							<th> Branch </th>
							<td> {{ $bank->branch }} </td>
						</tr>
						<tr>
							<th> Behalf of </th>
							<td> {{ $bank->behalf_of }} </td>
						</tr>
						<tr>
							<th> Created At </th>
							<td> {{ $bank->created_at }} </td>
						</tr>
						<tr>
							<th> Updated At </th>
							<td> {{ $bank->updated_at }} </td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
@endsection