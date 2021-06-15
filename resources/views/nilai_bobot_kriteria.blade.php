@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card">
		<div class="card-header">
			<h3>Nilai Bobot Kriteria</h3>
		</div>
		<div class="card-body">
			<button type="button" class="btn btn-danger" onclick='pemberitahuan()'>Reset</button>
			<button type="button" onclick='tambah()' hidden class="btn btn-success" @if(Auth::user()->role == 'kepala_cabang') hidden @endif>Tambah Kriteria</button><br><br>
			<table id="tb_kriteria" class="table table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>Kode</th>
						@foreach($kriteria as $row)
						<th>{{ $row->kode_kriteria }}</th>
						@endforeach
					</tr>
				</thead>
				<tbody>
					@foreach($kriteria as $row)
					@php $idx = $loop->index+1; @endphp
					<tr>
						<td>{{ $row->kode_kriteria }}</td>
						@for($j=1 ; $j<=$no ; $j++) <td>
							@php $nilai = $tampil[$idx][$j]['bobot'] ; @endphp
							{{ $nilai }} <a href="#" data-toggle="modal" data-target="#modal_kriteria" onclick="edit('{{ $idx }}','{{ $j }}','{{ $nilai }}');"><span class="material-icons">create</span></a>
							</td>
							@endfor
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_pemberitahuan" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="header">Pemberitahuan!</h5>
			</div>
			<div class="modal-body">
				Pastikan Data Nilai bobot alternatif sudah direset terlebih dahulu
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				<a href="{{ url('reset_kriteria') }}" class="btn btn-danger text-white">Reset</a>
			</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_kriteria" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form action='{{ url("ubah/nilai_bobot_kriteria") }}' method="post">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title" id="header">Edit Nilai Bobot Kriteria</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label><b>Baris</b></label>
						<input type="text" class="form-control" name="baris" id="baris" readonly>
					</div>
					<div class="form-group">
						<label><b>Kolom</b></label>
						<input type="text" class="form-control" name="kolom" id="kolom" readonly>
					</div>
					<div class="form-group">
						<label><b>Nilai</b></label>
						<input type="number" class="form-control" name="nilai" id="nilai" required>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary" name="simpan" id="simpan">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	function edit(baris, kolom, nilai) {
		$('#baris').val('C' + baris);
		$('#kolom').val('C' + kolom);
		$('#nilai').val(nilai);
	}

	function pemberitahuan() {
		$('#modal_pemberitahuan').modal();
	}
</script>
@endsection