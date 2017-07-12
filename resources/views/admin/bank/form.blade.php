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

<div aria-required="true" class="form-group required form-group-default form-group-default-select2 {{ $errors->has('payment_id') ? 'has-error' : ''}}">
    {!! Form::label('payment_id', 'Payment') !!}
	{!! Form::select('payment_id', \App\Payment::actived()->pluck('name', 'id')->prepend('Select a Payment', null), null, ['class' => 'full-width', 'data-init-plugin' => 'select2']) !!}
</div>
{!! $errors->first('payment_id', '<p class="help-block">:message</p>') !!}

<div class="form-group form-group-default required {{ $errors->has('file') ? 'has-error' : ''}}">
    {!! Form::label('file', 'Image Logo') !!}

    @if(isset($bank->image))
      <img src="{{ url($bank->getImageUrl()) }}" style="background: #f2f2f2;width: 150px;" id="o"/><br/>
    @endif
    {!! Form::file('file', null, ['required' => 'required']) !!}
    {!! $errors->first('file', '<p class="help-block">:message</p>') !!}
</div>
@if(Session::has('imageMessage'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('imageMessage') }}</p>
@endif

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Description') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
{!! $errors->first('description', '<label class="error">:message</label>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('branch') ? 'has-error' : ''}}">
    {!! Form::label('branch', 'Branch') !!}
    {!! Form::text('branch', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
{!! $errors->first('branch', '<p class="help-block">:message</p>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('behalf_of') ? 'has-error' : ''}}">
    {!! Form::label('behalf_of', 'Behalf Of') !!}
    {!! Form::text('behalf_of', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
{!! $errors->first('behalf_of', '<p class="help-block">:message</p>') !!}

<div class="pull-left">
    <div class="checkbox check-success">
        <input id="checkbox-agree" type="checkbox" required> <label for="checkbox-agree">Saya sudah mengecek data sebelum menyimpan</label>
    </div>
</div>
<br/>

{!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
<button class="btn btn-default" type="reset"><i class="pg-close"></i> Clear</button>

@push("script")
<script>
tinymce.init({
      selector: "textarea",
      theme: "modern",
      paste_data_images: true,
	  force_br_newlines : false,
      force_p_newlines : false,
      forced_root_block : '',
      height : 250,
      plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
      ],
      toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
      image_advtab: true
    });
</script>
@endpush