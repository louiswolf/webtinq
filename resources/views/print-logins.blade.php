<div class="container">
	@foreach ( $students as $student )
			<div class="row"><b>{{ $student->name }}</b></div>
			<div class="row">{{ $student->email }}</div>
			<div class="row">{{ $student->password_unencrypted }}</div>
			<div class="row">&nbsp;</div>
	@endforeach       
</div>
