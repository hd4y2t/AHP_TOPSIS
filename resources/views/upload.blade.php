@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card mb-5">
		<div class="card-header">
			<h3>Upload</h3>
		</div>
		<div class="card-body">
			<form action="{{ url('tambah/upload') }}" method="post" enctype="multipart/form-data">
				@csrf
				<div class="form-group">
					<label>Periode</label>
					<input type="text" class="form-control" name="periode">
				</div>
				<label>File : </label>
				<input type="file" class="form-control" name="hasil">
				<br>
				<br>
				<button type="submit" class="btn btn-primary">Sign in</button>
			</form>
		</div>
	</div>
</div>

@endsection