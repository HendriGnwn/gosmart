
@php
$teacherCourses = \App\TeacherCourse::whereUserId($userId)->get();
if (count($teacherCourses) > 0) {
	$courseIds = [];
	foreach($teacherCourses as $cour) {
		$courseIds[] = $cour->course_id;
	}
	$courses = \App\Course::whereNotIn('id', $courseIds)->actived()->pluck('name', 'id')->prepend('Select a Course', null);
} else {
	$courses = \App\Course::actived()->pluck('name', 'id')->prepend('Select a Course', null);
}
@endphp
<div aria-required="true" class="form-group required form-group-default form-group-default-select2 {{ $errors->has('course_id') ? 'has-error' : ''}}">
    {!! Form::label('course_id', 'Course') !!}
	{!! Form::select('course_id', $courses, null, ['class' => 'full-width', 'data-init-plugin' => 'select2']) !!}
</div>
{!! $errors->first('course_id', '<p class="help-block">:message</p>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Description') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
{!! $errors->first('description', '<label class="error">:message</label>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('expected_cost') ? 'has-error' : ''}}">
    {!! Form::label('expected_cost', 'Expected Cost') !!}
    {!! Form::text('expected_cost', null, ['class' => 'form-control', 'required' => 'required', 'type'=>'number']) !!}
</div>
{!! $errors->first('expected_cost', '<p class="help-block">:message</p>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('additional_cost') ? 'has-error' : ''}}">
    {!! Form::label('additional_cost', 'Additional Cost') !!}
    {!! Form::text('additional_cost', null, ['class' => 'form-control', 'required' => 'required', 'type'=>'number']) !!}
</div>
{!! $errors->first('additional_cost', '<p class="help-block">:message</p>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('admin_fee') ? 'has-error' : ''}}">
    {!! Form::label('admin_fee', 'Admin Fee') !!}
    {!! Form::text('admin_fee', null, ['class' => 'form-control', 'required' => 'required', 'type'=>'number']) !!}
</div>
{!! $errors->first('admin_fee', '<p class="help-block">:message</p>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('final_cost') ? 'has-error' : ''}}">
    {!! Form::label('final_cost', 'Final Cost') !!}
    {!! Form::text('final_cost', null, ['class' => 'form-control', 'required' => 'required', 'type'=>'number']) !!}
</div>
{!! $errors->first('final_cost', '<p class="help-block">:message</p>') !!}

<div class="form-group form-group-default required {{ $errors->has('file') ? 'has-error' : ''}}">
    {!! Form::label('file', 'Module') !!}

    @if(isset($model->module))
      {!! $model->getModuleHtml() !!}
    @endif
    {!! Form::file('file', null, ['required' => 'required']) !!}
    {!! $errors->first('file', '<p class="help-block">:message</p>') !!}
</div>
@if(Session::has('imageMessage'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('imageMessage') }}</p>
@endif

<div aria-required="true" class="form-group required form-group-default form-group-default-select2 {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status') !!}
	{!! Form::select('status', \App\TeacherCourse::statusLabels(), null, ['class' => 'full-width', 'data-init-plugin' => 'select2']) !!}
</div>
{!! $errors->first('status', '<p class="help-block">:message</p>') !!}

<div class="pull-left">
    <div class="checkbox check-success">
        <input id="checkbox-agree" type="checkbox" required> <label for="checkbox-agree">Saya sudah mengecek data sebelum menyimpan</label>
    </div>
</div>
<br/>

{!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
<button class="btn btn-default" type="reset"><i class="pg-close"></i> Clear</button>