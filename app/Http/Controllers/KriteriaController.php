<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kriteria;
use App\Nilai_bobot_alternatif;
use App\Nilai_bobot_kriteria;

class KriteriaController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$data['kriteria'] = Kriteria::all();
		$kode_before = Kriteria::select('kode_kriteria')->orderBy('id', 'desc')->first();
		if ($kode_before != null) {
			$kd = substr($kode_before->kode_kriteria, 1, strlen($kode_before->kode_kriteria) - 1);
			$kd++;
			$kriteria = "C$kd";
		} else {
			$kriteria = "C1";
		}
		$data['kode_kriteria'] = $kriteria;

		$check_nilai_bobot_kriteria = Nilai_bobot_kriteria::get();
		$check_nilai_bobot_alternatif = Nilai_bobot_alternatif::get();
		$check_kriteria = Kriteria::get();
		if (count($check_nilai_bobot_kriteria)) {
			$data['check_nilai_bobot_kriteria'] = 1;
		} else {
			$data['check_nilai_bobot_kriteria'] = 0;
		}
		if (count($check_nilai_bobot_alternatif)) {
			$data['check_nilai_bobot_alternatif'] = 1;
		} else {
			$data['check_nilai_bobot_alternatif'] = 0;
		}
		if (count($check_kriteria)) {
			$data['check_kriteria'] = 1;
		} else {
			$data['check_kriteria'] = 0;
		}
		if(count($check_nilai_bobot_kriteria) > 1 && count($check_nilai_bobot_alternatif) > 1){
			$data['perhitungan'] = 1;
		  }else{
			$data['perhitungan'] = 0;
		  }
		return view('kriteria', $data);
	}
	public function tambah()
	{
		$Kriteria = new Kriteria;
		$Kriteria->kode_kriteria = $_POST['kode_kriteria'];
		$Kriteria->nama_kriteria = $_POST['nama_kriteria'];
		$Kriteria->atribut_kriteria = $_POST['atribut_kriteria'];
		$Kriteria->save();
		$k = substr($_POST['kode_kriteria'], 1, strlen($_POST['kode_kriteria']) - 1);


		if ($k == 1) {
			$Nilai_bobot_kriteria = new Nilai_bobot_kriteria;
			$Nilai_bobot_kriteria->no = $k;
			$Nilai_bobot_kriteria->kode_kriteria_kolom = 'C' . $k;
			$Nilai_bobot_kriteria->kode_kriteria_baris = 'C' . $k;
			$Nilai_bobot_kriteria->bobot = 1;
			$Nilai_bobot_kriteria->save();
		} else {
			for ($i = 1; $i <= $k; $i++) {
				if ($k == $i) {
					for ($j = 1; $j <= $k; $j++) {
						$Nilai_bobot_kriteria = new Nilai_bobot_kriteria;
						$Nilai_bobot_kriteria->no = $k;
						$Nilai_bobot_kriteria->kode_kriteria_baris = 'C' . $i;
						$Nilai_bobot_kriteria->kode_kriteria_kolom = 'C' . $j;
						$Nilai_bobot_kriteria->bobot = 1;
						$Nilai_bobot_kriteria->save();
					}
				} else {
					$Nilai_bobot_kriteria = new Nilai_bobot_kriteria;
					$Nilai_bobot_kriteria->no = $k;
					$Nilai_bobot_kriteria->kode_kriteria_baris = 'C' . $i;
					$Nilai_bobot_kriteria->kode_kriteria_kolom = 'C' . $k;
					$Nilai_bobot_kriteria->bobot = 1;
					$Nilai_bobot_kriteria->save();
				}
			}
		}




		return redirect('kriteria')->with('message', 'Data berhasil ditambah');
	}
	public function ubah($id)
	{
		$Kriteria = Kriteria::find($id);
		$Kriteria->nama_kriteria = $_POST['nama_kriteria'];
		$Kriteria->atribut_kriteria = $_POST['atribut_kriteria'];
		$Kriteria->save();
		return redirect('kriteria')->with('message', 'Data berhasil diubah');
	}
	public function reset()
	{
		Nilai_bobot_kriteria::query()->delete();
		Kriteria::query()->delete();
		return redirect('kriteria')->with('message', 'Data berhasil dihapus');
	}
}
