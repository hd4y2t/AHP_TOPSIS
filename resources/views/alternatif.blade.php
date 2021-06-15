@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card">
		<div class="card-header">
			<h3>Alternatif</h3>
		</div>
		<div class="card-body">
			<button type="button" onclick='pemberitahuan()' class="btn btn-success">Tambah Alternatif</button><br><br>
			<table id="tb_alternatif" class="display" style="width:100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Kode Alternatif</th>
						<th>Nama Alternatif</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1 ?>
					@foreach($alternatif as $row)
						<tr id="{{ $row->id }}">
							<td class="no">{{ $i++ }}</td>
							<td class="kode_alternatif">{{ $row->kode_alternatif }}</td>
							<td class="nama_alternatif">{{ $row->nama_alternatif }}</td>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal_alternatif" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form method="post" id="tambah_edit_alternatif" enctype="multipart/form-data">
				@csrf
				<div class="modal-header">
					<h5 class="modal-title" id="header">Input Alternatif Baru</h5>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label ><b>Kode Alternatif</b></label>
						<input type="text" class="form-control" name="kode_alternatif" required readonly>
					</div>
					<div class="form-group">
						<label ><b>Nama Alternatif</b></label>
						<input type="text" class="form-control" name="nama_alternatif" required>
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
				Apakah anda ingin menghapus Alternatif ini?
			</div>
			<div class="modal-footer">
				<form method="post" id="hapus_alternatif">
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
    $('#tb_alternatif').DataTable();
});
$('button.delete').click(function(){
	$('#hapus_alternatif').attr('action','{{ url("hapus/alternatif")}}/'+this.id);
});
function pemberitahuan(){
	$('#modal_pemberitahuan').modal();
}
function tambah(){
	$('#tambah_edit_alternatif').attr('action','{{ url("tambah/alternatif") }}');
	$('.form-control').val('');
	$(".form-control[name='kode_alternatif']").val('{!! $kode_alternatif !!}');
	$('#modal_alternatif').modal();
}
function ubah(id){
	$('#tambah_edit_alternatif').attr('action','{{ url("ubah/alternatif")}}/'+id);
	var row=$('tr#'+id);
	$(".form-control[name='kode_alternatif']").val(row.find('.kode_alternatif').html());
	$(".form-control[name='nama_alternatif']").val(row.find('.nama_alternatif').html());
	$("#simpan").attr('name','edit')
	$('#modal_alternatif').modal();
}
</script>
@endsection
