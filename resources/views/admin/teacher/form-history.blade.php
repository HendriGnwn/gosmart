
<div class="form-group form-group-default required {{ $errors->has('file') ? 'has-error' : ''}}">
    {!! Form::label('file', 'Upload Bukti Transfer') !!}

    @if(isset($model->evidence))
      {!! $model->getEvidenceHtml() !!}
    @endif
    {!! Form::file('file', null, ['required' => 'required']) !!}
    {!! $errors->first('file', '<p class="help-block">:message</p>') !!}
</div>
@if(Session::has('imageMessage'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('imageMessage') }}</p>
@endif

<div class="pull-left">
    <div class="checkbox check-success">
        <input id="checkbox-agree" type="checkbox" required> <label for="checkbox-agree">Saya sudah mengecek data sebelum menyimpan</label>
    </div>
</div>
<br/>

{!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
<button class="btn btn-default" type="reset"><i class="pg-close"></i> Clear</button>
