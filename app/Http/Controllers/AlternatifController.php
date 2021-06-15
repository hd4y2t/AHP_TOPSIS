<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alternatif;
use App\Kriteria;
use App\Nilai_bobot_alternatif;
use App\Nilai_bobot_kriteria;

class AlternatifController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
		$data['alternatif'] = Alternatif::all();
		$kode_before = Alternatif::select('kode_alternatif')->orderBy('id', 'desc')->first();
		if($kode_before != null ){
			$kd = substr($kode_before->kode_alternatif,1,strlen($kode_before->kode_alternatif)-1);
			$kd++;
			$alternatif = "A$kd";
		}else{
			$alternatif = "A1";
		}
		
		$data['kode_alternatif'] = $alternatif;

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
        return view('alternatif', $data);
    }
	public function tambah(){
		$Alternatif = new Alternatif;
		$Alternatif->kode_alternatif=$_POST['kode_alternatif'];
		$Alternatif->nama_alternatif=$_POST['nama_alternatif'];
		$Alternatif->save();
		
		$kode_kriteria = Kriteria::select('kode_kriteria')->orderBy('id', 'desc')->first();
		
		$kd_alternatif = substr($_POST['kode_alternatif'],1,strlen($_POST['kode_alternatif'])-1);
		$kd_kriteria = substr($kode_kriteria->kode_kriteria,1,strlen($kode_kriteria->kode_kriteria)-1);
		
		for($j=1 ; $j<=$kd_kriteria ; $j++){
			$Nilai_bobot_alternatif = new Nilai_bobot_alternatif;
			$Nilai_bobot_alternatif->kode_alternatif = 'A'.$kd_alternatif;
			$Nilai_bobot_alternatif->kode_kriteria = 'C'.$j;
			$Nilai_bobot_alternatif->bobot = 1;
			$Nilai_bobot_alternatif->save();
		}
		return redirect('alternatif')->with('message', 'Data berhasil ditambah');
	}
	public function ubah($id){
		$Alternatif = Alternatif::find($id);
		$Alternatif->nama_alternatif=$_POST['nama_alternatif'];
		$Alternatif->save();
		return redirect('alternatif')->with('message', 'Data berhasil diubah');
	}
	public function reset(){
		Nilai_bobot_alternatif::query()->delete();
		Alternatif::query()->delete();
		return redirect('alternatif')->with('message', 'Data berhasil dihapus');
	}
}
