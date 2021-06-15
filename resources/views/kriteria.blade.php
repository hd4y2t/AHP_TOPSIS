@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card">
		<div class="card-header">
			<h3>Kriteria</h3>
		</div>
		<div class="card-body">
			<button type="button" onclick='tambah()' class="btn btn-success" @if(Auth::user()->role == 'kepala_cabang') hidden @endif>Tambah Kriteria</button><br><br>
			<table id="tb_kriteria" class="display" style="width:100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Kode Kriteria</th>
						<th>Nama Kriteria</th>
						<th>Atribut Kriteria</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1 ?>
					@foreach($kriteria as $row)
						<tr id="{{ $row->id }}">
							<td class="no">{{ $i++ }}</td>
							<td class="kode_kriteria">{{ $row->kode_kriteria }}</td>
							<td class="nama_kriteria">{{ $row->nama_kriteria }}</td>
							<td class="atribut_kriteria">{{ $row->atribut_kriteria }}</td>
							<td>
								<button type='button' onclick="ubah('{{ $row->id }}')" class='btn btn-warning'>Edit</button>
								@if(Auth::user()->role == 'pimpinan')
									<button type="button" class="btn btn-danger delete" data-toggle="modal" data-target="#modal_delete" name='delete' id='{{ $row->id }}'>Delete</button>
								@endif
							</td>
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
			<form method="post" id="tambah_edit_kriteria" enctype="multipart/form-data">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title" id="header">Input Kriteria Baru</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label ><b>Kode Kriteria</b></label>
						<input type="text" class="form-control" name="kode_kriteria" required readonly>
					</div>
					<div class="form-group">
						<label ><b>Nama Kriteria</b></label>
						<input type="text" class="form-control" name="nama_kriteria" required>
					</div>
					<div class="form-group">
						<label ><b>Atribut Kriteria</b></label>
						<select class='form-control' name='atribut_kriteria'>
							<option value="benefit">Benefit</option>
							<option value="cost">Cost</option>
						</select>
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
<div class="modal fade" id="modal_delete" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Delete?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Apakah anda ingin menghapus Kriteria ini?
			</div>
			<div class="modal-footer">
				<form method="post" id="hapus_kriteria">
					@csrf
					<input type="submit" class="btn btn-danger" value="Hapus">
					<button type="button" class="btn btn-link" data-dismiss="modal">Tidak</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
    $('#tb_kriteria').DataTable();
});
$('button.delete').click(function(){
	$('#hapus_kriteria').attr('action','{{ url("hapus/kriteria")}}/'+this.id);
});
function tambah(){
	$('#tambah_edit_kriteria').attr('action','{{ url("tambah/kriteria") }}');
	$('.form-control').val('');
	$(".form-control[name='kode_kriteria']").val('{!! $kode_kriteria !!}');
	$('#modal_kriteria').modal();
}
function ubah(id){
	$('#tambah_edit_kriteria').attr('action','{{ url("ubah/kriteria")}}/'+id);
	var row=$('tr#'+id);
	$(".form-control[name='kode_kriteria']").val(row.find('.kode_kriteria').html());
	$(".form-control[name='nama_kriteria']").val(row.find('.nama_kriteria').html());
	$(".form-control[name='atribut_kriteria']").val(row.find('.atribut_kriteria').html());
	$("#simpan").attr('name','edit')
	$('#modal_kriteria').modal();
}
</script>
@endsection
