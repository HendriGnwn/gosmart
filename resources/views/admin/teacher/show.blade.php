@extends('layouts.app.frame')
@section('title', 'Teacher #' . $model->id)
@section('description', 'Teacher Details')
@section('breadcrumbs')
	@php echo \Breadcrumbs::render([['title' => 'Teacher', 'url' => url('/admin/teacher')], 'View '.$model->first_name]) @endphp
@endsection
@section('button')
	<a href="{{ url('/admin/teacher') }}" class="btn btn-info btn-xs no-border">Back</a>
@endsection

@section('content')
	<div class="panel panel-default">
		<div class="panel-body">
			<a href="{{ url('admin/teacher/' . $model->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Teacher"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
			{!! Form::open([
				'method'=>'DELETE',
				'url' => ['admin/teacher', $model->id],
				'style' => 'display:inline'
			]) !!}
				{!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
						'type' => 'submit',
						'class' => 'btn btn-danger btn-xs',
						'title' => 'Delete Teacher',
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
							<th> Unique Number </th>
							<td> {{ $model->unique_number }} </td>
						</tr>
						
						@php
							if (isset($model->teacherProfile)) {
								$profile = $model->teacherProfile;
							} else {
								$profile = new \App\TeacherProfile();
							}
						@endphp
						
						<tr>
							<th> Title </th>
							<td> {{ $profile->getTitleLabel() }} </td>
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
						
						<tr>
							<th> Izajah Number </th>
							<td> {{ $profile->izajah_number }} </td>
						</tr>
						<tr>
							<th> Graduated </th>
							<td> {{ $profile->graduated }} </td>
						</tr>
						<tr>
							<th> Bio </th>
							<td> {{ $profile->bio }} </td>
						</tr>
						<tr>
							<th> Upload Izajah </th>
							<td> {!! $profile->getUploadIzajahHtml() !!} </td>
						</tr>
						<tr>
							<th> Total </th>
							<td> {{ $profile->getFormattedTotal() }} </td>
						</tr>
						<tr>
							<th> Total Updated At </th>
							<td> {{ $profile->total_updated_at }} </td>
						</tr>
						<tr>
							<th> Updated At </th>
							<td> {{ $profile->updated_at }} </td>
						</tr>
						
					</tbody>
				</table>
			</div>
			
			@php
			if (isset($profile->teacherBank)) {
				$bank = $profile->teacherBank;
			} else {
				$bank = new \App\TeacherBank();
			}
			@endphp
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Bank Information Details</h3>
				</div>
				<div class="panel-body table-responsive">
					<table class="table table-bordered">
					<tbody>
						<tr>
							<th>Bank Name</th><td>{{ $bank->name }}</td>
						</tr>
						<tr>
							<th>Rekening Number</th><th>{{ $bank->number }}</th>
						</tr>
						<tr>
							<th>Bank Behalf Of</th><td>{{ $bank->behalf_of }}</td>
						</tr>
						<tr>
							<th>Branch</th><td>{{ $bank->branch }}</td>
						</tr>
					</tbody>
				</table>
				</div>
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
								<th>Student</th>
								<th>Status</th>
								<th>Created At</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($profile->privateModels as $private)
							<tr>
								<td>{!! $private->getDetailHtml($private->code) !!}</td>
								<td> {{ isset($private->student) ? $private->student->getFullName() : $private->student_id }} </td>
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
					<h3 class="panel-title">Teacher Courses</h3>
					<a href="{{ url('admin/teacher/course/create/' . $model->id) }}" class="btn btn-success btn-xs">Add Data</a>
				</div>
				<div class="panel-body">
					<input type="hidden" id="drs" name="drange"/>
					<input type="hidden" id="did" name="did"/>
					<div class="form-group-attached">
						<div class="row clearfix">
							<div class="col-sm-6 col-xs-12">
								<div class="form-group form-group-default">
									<label>Pencarian</label>
									<form id="formsearch">
										<input type="text" id="search-table" class="form-control" name="firstName" placeholder="put your keyword">
									</form>
								</div>
							</div>
							<div class="col-sm-3 col-xs-6">
								<div class="form-group form-group-default">
									<label>Start date</label>
									<input type="text" id="datepicker-start" class="form-control" name="firstName" placeholder="pick a start date">
								</div>
							</div>
							<div class="col-sm-3 col-xs-6">
								<div class="form-group form-group-default">
									<label>End date</label>
									<input type="text" id="datepicker-end" class="form-control" name="firstName" placeholder="pick an end date">
								</div>
							</div>
						</div>
					</div>

					<div class="clearfix"></div>
					<table class="table table-hover" id="course-table">
						<thead>
							<tr>
								<th>Course</th>
								<th>Description</th>
								<th>Expected Cost</th>
								<th>Expected Cost Updated At</th>
								<th>Additional Cost</th>
								<th>Admin Fee</th>
								<th>Final Cost</th>
								<th>Approved By</th>
								<th>Approved At</th>
								<th>Module</th>
								<th>Status</th>
								<th>Created At</th>
								<th>Updated At</th>
								<th>Actions</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Total Honor Histories</h3>
				</div>
				<div class="panel-body table-responsive">
					<input type="hidden" id="drs" name="drange"/>
					<input type="hidden" id="did" name="did"/>
					<div class="form-group-attached">
						<div class="row clearfix">
							<div class="col-sm-6 col-xs-12">
								<div class="form-group form-group-default">
									<label>Pencarian</label>
									<form id="formsearchhistory">
										<input type="text" id="search-history-table" class="form-control" name="firstName" placeholder="put your keyword">
									</form>
								</div>
							</div>
							<div class="col-sm-3 col-xs-6">
								<div class="form-group form-group-default">
									<label>Start date</label>
									<input type="text" id="datepicker-start-history" class="form-control" name="firstName" placeholder="pick a start date">
								</div>
							</div>
							<div class="col-sm-3 col-xs-6">
								<div class="form-group form-group-default">
									<label>End date</label>
									<input type="text" id="datepicker-end-history" class="form-control" name="firstName" placeholder="pick an end date">
								</div>
							</div>
						</div>
					</div>
					<table class="table" id="history-table">
						<thead>
							<tr>
								<th>Private</th>
								<th>Operation</th>
								<th>Total</th>
								<th>Status</th>
								<th>Bukti Transfer</th>
								<th>Created At</th>
								<th>Updated At</th>
								<th>Actions</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection

@push("script")
<script>

var oTable;
oTable = $('#course-table').DataTable({
    processing: true,
    serverSide: true,
    dom: 'lBfrtip',
    order:  [[ 0, "asc" ]],
    buttons: [
        {
            extend: 'print',
            autoPrint: true,
            customize: function ( win ) {
                $(win.document.body)
                    .css( 'padding', '2px' )
                    .prepend(
                        '<img src="{{asset('img/logo.png')}}" style="float:right; top:0; left:0;height: 40px;right: 10px;background: #101010;padding: 8px;border-radius: 4px" /><h5 style="font-size: 9px;margin-top: 0px;"><br/><font style="font-size:14px;margin-top: 5px;margin-bottom:20px;"> Laporan Payment</font><br/><br/><font style="font-size:8px;margin-top:15px;">{{date('Y-m-d h:i:s')}}</font></h5><br/><br/>'
                    );


                $(win.document.body).find( 'div' )
                    .css( {'padding': '2px', 'text-align': 'center', 'margin-top': '-50px'} )
                    .prepend(
                        ''
                    );

                $(win.document.body).find( 'table' )
                    .addClass( 'compact' )
                    .css( { 'font-size': '9px', 'padding': '2px' } );


            },
            title: '',
            orientation: 'landscape',
            exportOptions: {columns: ':visible'} ,
            text: '<i class="fa fa-print" data-toggle="tooltip" title="" data-original-title="Print"></i>'
        },
        {extend: 'colvis', text: '<i class="fa fa-eye" data-toggle="tooltip" title="" data-original-title="Column visible"></i>'},
        {extend: 'csv', text: '<i class="fa fa-file-excel-o" data-toggle="tooltip" title="" data-original-title="Export CSV"></i>'}
    ],
    sDom: "<'table-responsive fixed't><'row'<p i>> B",
    sPaginationType: "bootstrap",
    destroy: true,
    responsive: true,
    scrollCollapse: true,
    oLanguage: {
        "sLengthMenu": "_MENU_ ",
        "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
    },
    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
    ajax: {
    url: '{!! url('admin/teacher/course/data/' . $model->id) !!}',
        data: function (d) {
            d.range = $('input[name=drange]').val();
        }
    },
    columns: [
		{ data: "course_id", name: "course_id" },
		{ data: "description", name: "description", visible:false },
		{ data: "expected_cost", name: "expected_cost" },
		{ data: "expected_cost_updated_at", name: "expected_cost_updated_at", visible:false },
		{ data: "additional_cost", name: "additional_cost", visible:false },
		{ data: "admin_fee", name: "admin_fee", visible:false },
		{ data: "final_cost", name: "final_cost" },
		{ data: "approved_by", name: "approved_by" },
		{ data: "approved_at", name: "approved_at", visible:false },
		{ data: "module", name: "module", visible:false },
		{ data: "status", name: "status" },
		{ data: "created_at", name: "created_at", visible:false },
		{ data: "updated_at", name: "updated_at", visible:false },
        { data: "action", name: "action", searchable: false, orderable: false },
    ],
}).on( 'processing.dt', function ( e, settings, processing ) {if(processing){Pace.start();} else {Pace.stop();}});

$("#user-table_wrapper > .dt-buttons").appendTo("div.export-options-container");


$('#datepicker-start').datepicker({format: 'yyyy/mm/dd'}).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    if($('#datepicker-end').val() != ""){
        $('#drs').val($('#datepicker-start').val()+":"+$('#datepicker-end').val());
        oTable.draw();
    }else{
        $('#datepicker-end').focus();
    }

});
$('#datepicker-end').datepicker({format: 'yyyy/mm/dd'}).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    if($('#datepicker-start').val() != ""){
        $('#drs').val($('#datepicker-start').val()+":"+$('#datepicker-end').val());
        oTable.draw();
    }else{
        $('#datepicker-start').focus();
    }

});

$('#formsearch').submit(function () {
    oTable.search( $('#search-table').val() ).draw();
    return false;
} );

oTable.page.len(25).draw();



function deleteData(id) {
    $('#modalDelete').modal('show');
    $('#did').val(id);
}

function hapus(){
    $('#modalDelete').modal('hide');
    var id = $('#did').val();
    $.ajax({
        url: '{{url("admin/teacher/course/delete")}}' + "/" + id + '?' + $.param({"_token" : '{{ csrf_token() }}' }),
        type: 'DELETE',
        complete: function(data) {
            oTable.draw();
        }
    });
}

var oTable1;
oTable1 = $('#history-table').DataTable({
    processing: true,
    serverSide: true,
    dom: 'lBfrtip',
    order:  [[ 0, "asc" ]],
    buttons: [
        {
            extend: 'print',
            autoPrint: true,
            customize: function ( win ) {
                $(win.document.body)
                    .css( 'padding', '2px' )
                    .prepend(
                        '<img src="{{asset('img/logo.png')}}" style="float:right; top:0; left:0;height: 40px;right: 10px;background: #101010;padding: 8px;border-radius: 4px" /><h5 style="font-size: 9px;margin-top: 0px;"><br/><font style="font-size:14px;margin-top: 5px;margin-bottom:20px;"> Laporan Payment</font><br/><br/><font style="font-size:8px;margin-top:15px;">{{date('Y-m-d h:i:s')}}</font></h5><br/><br/>'
                    );


                $(win.document.body).find( 'div' )
                    .css( {'padding': '2px', 'text-align': 'center', 'margin-top': '-50px'} )
                    .prepend(
                        ''
                    );

                $(win.document.body).find( 'table' )
                    .addClass( 'compact' )
                    .css( { 'font-size': '9px', 'padding': '2px' } );


            },
            title: '',
            orientation: 'landscape',
            exportOptions: {columns: ':visible'} ,
            text: '<i class="fa fa-print" data-toggle="tooltip" title="" data-original-title="Print"></i>'
        },
        {extend: 'colvis', text: '<i class="fa fa-eye" data-toggle="tooltip" title="" data-original-title="Column visible"></i>'},
        {extend: 'csv', text: '<i class="fa fa-file-excel-o" data-toggle="tooltip" title="" data-original-title="Export CSV"></i>'}
    ],
    sDom: "<'table-responsive fixed't><'row'<p i>> B",
    sPaginationType: "bootstrap",
    destroy: true,
    responsive: true,
    scrollCollapse: true,
    oLanguage: {
        "sLengthMenu": "_MENU_ ",
        "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
    },
    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
    ajax: {
    url: '{!! url('admin/teacher/history/data/' . $model->id) !!}',
        data: function (d) {
            d.range = $('input[name=drange]').val();
        }
    },
    columns: [
		{ data: "private_id", name: "private_id" },
		{ data: "operation", name: "operation" },
		{ data: "total", name: "total" },
		{ data: "status", name: "status" },
		{ data: "evidence", name: "evidence" },
		{ data: "created_at", name: "created_at" },
		{ data: "updated_at", name: "updated_at", visible:false },
		{ data: "action", name: "action", searchable: false, orderable: false },
    ],
}).on( 'processing.dt', function ( e, settings, processing ) {if(processing){Pace.start();} else {Pace.stop();}});

$('#datepicker-start-history').datepicker({format: 'yyyy/mm/dd'}).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    if($('#datepicker-end-history').val() != ""){
        $('#drs').val($('#datepicker-start-history').val()+":"+$('#datepicker-end-history').val());
        oTable.draw();
    }else{
        $('#datepicker-end-history').focus();
    }

});
$('#datepicker-end-history').datepicker({format: 'yyyy/mm/dd'}).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    if($('#datepicker-start-history').val() != ""){
        $('#drs').val($('#datepicker-start-history').val()+":"+$('#datepicker-end-history').val());
        oTable.draw();
    }else{
        $('#datepicker-start-history').focus();
    }

});
$('#formsearchhistory').submit(function () {
    oTable1.search( $('#search-history-table').val() ).draw();
    return false;
} );

oTable.page.len(25).draw();

</script>
@endpush