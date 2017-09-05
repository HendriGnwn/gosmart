
<p>Hi Dear,</p>
<p>Berikut adalah Detail Saran yang Go Smart dapat dari User:</p>
<ul>
	<li>Nama Depan: {{ $model['first_name'] }}</li>
	<li>Nama Belakang: {{ $model['last_name'] }}</li>
	<li>Email: {{ $model['email'] }}</li>
	<li>Handphone: {{ $model['phone'] }}</li>
	<li>Pesan: {{ $model['message'] }}</li>
	<li>Tanggal Kirim: {{ $model['created_at'] }}</li>
</ul>
<br/>
Terimakasih.
<br/><br/>
{{ config('app.name', 'Go Smart') }}