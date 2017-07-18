
<p>Hi {{ $model->first_name }},</p>
<p>Berikut adalah Detail dan Password Anda yang baru:</p>
<ul>
	<li>Email: {{ $model->email }}</li>
	<li>Password: {{ $password }}</li>
</ul>
<br/>
Terimakasih.
<br/><br/>
{{ config('app.name', 'Go Smart') }}