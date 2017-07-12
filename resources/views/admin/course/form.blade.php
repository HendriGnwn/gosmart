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

<div aria-required="true" class="form-group required form-group-default form-group-default-select2 {{ $errors->has('course_level_id') ? 'has-error' : ''}}">
    {!! Form::label('course_level_id', 'Course Level') !!}
	{!! Form::select('course_level_id', \App\CourseLevel::actived()->pluck('name', 'id')->prepend('Select a Course Level', null), null, ['class' => 'full-width', 'data-init-plugin' => 'select2']) !!}
</div>
{!! $errors->first('course_level_id', '<p class="help-block">:message</p>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('section') ? 'has-error' : ''}}">
    {!! Form::label('section', 'Section') !!}
    {!! Form::text('section', null, ['class' => 'form-control', 'required' => 'required', 'type' => 'numeric']) !!}
</div>
{!! $errors->first('section', '<p class="help-block">:message</p>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
{!! $errors->first('name', '<p class="help-block">:message</p>') !!}

<div aria-required="true" class="form-group required form-group-default {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', 'Description') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
{!! $errors->first('description', '<label class="error">:message</label>') !!}

<div aria-required="true" class="form-group required form-group-default form-group-default-select2 {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status') !!}
	{!! Form::select('status', \App\Course::statusLabels(), null, ['class' => 'full-width', 'data-init-plugin' => 'select2']) !!}
</div>

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