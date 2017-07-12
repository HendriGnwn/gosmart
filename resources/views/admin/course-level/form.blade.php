<!--<div aria-required="true" class="form-group required form-group-default {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Title') !!}
    {!! Form::textarea('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
{!! $errors->first('title', '<label class="error">:message</label>') !!}-->
<div aria-required="true" class="form-group required form-group-default {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
<div aria-required="true" class="form-group required form-group-default form-group-default-select2 {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status') !!}
	{!! Form::select('status', \App\CourseLevel::statusLabels(), null, ['class' => 'full-width', 'data-init-plugin' => 'select2']) !!}
</div>
{!! $errors->first('status', '<p class="help-block">:message</p>') !!}
<div aria-required="true" class="form-group required form-group-default {{ $errors->has('order') ? 'has-error' : ''}}">
    {!! Form::label('order', 'Order') !!}
    {!! Form::number('order', null, ['class' => 'form-control']) !!}
</div>

<div class="pull-left">
    <div class="checkbox check-success">
        <input id="checkbox-agree" type="checkbox" required> <label for="checkbox-agree">Saya sudah mengecek data sebelum menyimpan</label>
    </div>
</div>
<br/>

{!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
<button class="btn btn-default" type="reset"><i class="pg-close"></i> Clear</button>