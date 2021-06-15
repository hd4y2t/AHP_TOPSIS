<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kriteria;
use App\Nilai_bobot_alternatif;
use App\Nilai_bobot_kriteria;

class Nilai_bobot_kriteriaController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$data['kriteria'] = Kriteria::all();
		$no = Nilai_bobot_kriteria::select('no')->orderBy('id', 'desc')->first();
		$data['no'] = $no->no;
		for ($i = 1; $i <= $no->no; $i++) {
			for ($j = 1; $j <= $no->no; $j++) {
				$data_bobot[$i][$j] = Nilai_bobot_kriteria::select('bobot')->where('kode_kriteria_baris', 'C' . $i)->where('kode_kriteria_kolom', 'C' . $j)->first();
			}
		}

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
		if (count($check_nilai_bobot_kriteria) > 1 && count($check_nilai_bobot_alternatif) > 1) {
			$data['perhitungan'] = 1;
		} else {
			$data['perhitungan'] = 0;
		}
		return view('nilai_bobot_kriteria', $data)->with('tampil', $data_bobot);
	}
	public function tambah()
	{
		$Nilai_bobot_kriteria = new Nilai_bobot_kriteria;
		$Nilai_bobot_kriteria->nama_kriteria = $_POST['nama_kriteria'];
		$Nilai_bobot_kriteria->atribut_kriteria = $_POST['atribut_kriteria'];
		$Nilai_bobot_kriteria->save();
		return redirect('nilai_bobot_kriteria')->with('message', 'Data berhasil ditambah');
	}
	public function ubah()
	{
		$Nilai_bobot_kriteria = Nilai_bobot_kriteria::where('kode_kriteria_baris', $_POST['baris'])->where('kode_kriteria_kolom', $_POST['kolom'])->update(['bobot' => $_POST['nilai']]);
		$Nilai_bobot_kriteria = Nilai_bobot_kriteria::where('kode_kriteria_baris', $_POST['kolom'])->where('kode_kriteria_kolom', $_POST['baris'])->update(['bobot' => 1 / $_POST['nilai']]);
		return redirect('nilai_bobot_kriteria')->with('message', 'Data berhasil ditambah');
	}
}
