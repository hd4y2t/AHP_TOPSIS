@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card">
		<div class="card-header">
			<h3>Nilai Bobot Alternatif</h3>
		</div>
		<div class="card-body">
			
			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_reset"> Reset</button>
			<table id="tb_kriteria" class="table table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>Kode</th>
						<th>Nama Alternatif</th>
						@foreach($kriteria as $row)
						<th>{{ $row->kode_kriteria }}</th>
						@endforeach
					</tr>
				</thead>
				<tbody>
					@foreach($alternatif as $row)
					@php $idx = $loop->index+1 @endphp
					<tr>
						<td>{{ $row->kode_alternatif }}</td>
						<td>{{ $row->nama_alternatif }}</td>
						@for($j=1 ; $j<=$no ; $j++) @php $nilai=$tampil[$idx][$j]['bobot'] ; @endphp <td>{{ $nilai }} <a href="#" data-toggle="modal" data-target="#modal_kriteria" onclick="edit('{{ $idx }}','{{ $j }}','{{ $nilai }}');"><span class="material-icons">create</span></a></td>
							@endfor
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_kriteria" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form action='{{ url("ubah/nilai_bobot_alternatif") }}' method="post">
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal_pemberitahuan" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="header">Pemberitahuan!</h5>
				</div>
				<div class="modal-body">
					Pastikan Data Kriteria tidak di tambah atau di kurang sebelum mengisi alternatif 
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="tambah();">Lanjut</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_reset" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="header">Apakah anda ingin mereset?</h5>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<a href="{{ url('reset_alternatif') }}" class="btn btn-danger">Reset</a><br><br>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	function edit(baris, kolom, nilai) {
		$('#baris').val('A' + baris);
		$('#kolom').val('C' + kolom);
		$('#nilai').val(nilai);
	}
</script>
@endsection