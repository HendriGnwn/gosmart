
<div aria-required="true" class="form-group required form-group-default {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Title (Lulusan)') !!}
    {!! Form::select('title', \App\TeacherProfile::titleLabels(), null, ['class' => 'full-width', 'data-init-plugin' => 'select2']) !!}
</div>
{!! $errors->first('title', '<p class="help-block">:message</p>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('first_name') ? 'has-error' : ''}}">
    {!! Form::label('first_name', 'First Name') !!}
    {!! Form::text('first_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
{!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('last_name') ? 'has-error' : ''}}">
    {!! Form::label('last_name', 'Last Name') !!}
    {!! Form::text('last_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
{!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('phone_number') ? 'has-error' : ''}}">
    {!! Form::label('phone_number', 'Phone Number') !!}
    {!! Form::text('phone_number', null, ['class' => 'form-control', 'required' => 'required', 'type'=>'number']) !!}
</div>
{!! $errors->first('phone_number', '<p class="help-block">:message</p>') !!}

<div class="form-group form-group-default required {{ $errors->has('file') ? 'has-error' : ''}}">
    {!! Form::label('file', 'Photo') !!}

    @if(isset($model->photo))
      <img src="{{ url($model->getPhotoUrl()) }}" style="background: #f2f2f2;width: 150px;" id="o"/><br/>
    @endif
    {!! Form::file('file', null, ['required' => 'required']) !!}
    {!! $errors->first('file', '<p class="help-block">:message</p>') !!}
</div>
@if(Session::has('imageMessage'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('imageMessage') }}</p>
@endif

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('latitude') ? 'has-error' : ''}}">
    {!! Form::label('latitude', 'Latitude') !!}
    {!! Form::text('latitude', null, ['class' => 'form-control', 'required' => 'required', 'type'=>'number']) !!}
</div>
{!! $errors->first('latitude', '<p class="help-block">:message</p>') !!}


<div aria-required="true" class="form-group required form-group-default {{ $errors->has('longitude') ? 'has-error' : ''}}">
    {!! Form::label('longitude', 'Longitude') !!}
    {!! Form::text('longitude', null, ['class' => 'form-control', 'required' => 'required', 'type'=>'number']) !!}
</div>
{!! $errors->first('longitude', '<p class="help-block">:message</p>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('address') ? 'has-error' : ''}}">
    {!! Form::label('address', 'Address') !!}
    {!! Form::textarea('address', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
{!! $errors->first('address', '<label class="error">:message</label>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Email') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'required' => 'required', 'type'=>'email']) !!}
</div>
{!! $errors->first('email', '<p class="help-block">:message</p>') !!}


<div aria-required="true" class="form-group required form-group-default {{ $errors->has('password') ? 'has-error' : ''}}">
    {!! Form::label('password', 'Password') !!}
    {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
</div>
{!! $errors->first('password', '<p class="help-block">:message</p>') !!}

<div aria-required="true" class="form-group required form-group-default form-group-default-select2 {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status') !!}
	{!! Form::select('status', \App\User::statusLabels(), null, ['class' => 'full-width', 'data-init-plugin' => 'select2']) !!}
</div>
{!! $errors->first('status', '<p class="help-block">:message</p>') !!}

<div aria-required="true" class="form-group required form-group-default form-group-default-select2 {{ $errors->has('role') ? 'has-error' : ''}}">
    {!! Form::label('role', 'Role') !!}
	{!! Form::select('role', \App\User::roleLabels(), null, ['class' => 'full-width', 'data-init-plugin' => 'select2']) !!}
</div>
{!! $errors->first('role', '<p class="help-block">:message</p>') !!}

<div class="pull-left">
    <div class="checkbox check-success">
        <input id="checkbox-agree" type="checkbox" required> <label for="checkbox-agree">Saya sudah mengecek data sebelum menyimpan</label>
    </div>
</div>
<br/>

{!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
<button class="btn btn-default" type="reset"><i class="pg-close"></i> Clear</button>