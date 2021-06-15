@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Hasil</div>
				<div class="card-body">
				@foreach($hasil as $row)
					Periode: {{ $row->periode }}
					<a href="{{ url('hasil').'/'.$row->hasil }}">Download</a> <br>
				@endforeach
				</div>
            </div>
        </div>
    </div>
</div>

@endsection
