<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Kriteria;
use App\Alternatif;
use App\Nilai_bobot_kriteria;
use App\Nilai_bobot_alternatif;

class PerhitunganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
		$data['kriteria'] = Kriteria::all();
		$data['alternatif'] = Alternatif::all();
		
		$no = Nilai_bobot_kriteria::select('no')->orderBy('id', 'desc')->first();
		$data['no'] = $no->no;
		for( $i=1 ; $i<=$no->no ; $i++){
			for( $j=1 ; $j<=$no->no ; $j++){
				$data_bobot[$i][$j] = Nilai_bobot_kriteria::select('bobot')->where('kode_kriteria_baris','C'.$i)->where('kode_kriteria_kolom','C'.$j)->first();
			}
		}
		
		$data['total_bobot'] = Nilai_bobot_kriteria::selectRaw('SUM(bobot) as total_bobot')->groupBy('kode_kriteria_kolom')->get();
		//////
		$kode_kriteria = Kriteria::select('kode_kriteria')->orderBy('id', 'desc')->first();
		$kode_alternatif = Alternatif::select('kode_alternatif')->orderBy('id', 'desc')->first();
		
		$kd_kriteria = substr($kode_kriteria->kode_kriteria,1,strlen($kode_kriteria->kode_kriteria)-1);
		$kd_alternatif = substr($kode_alternatif->kode_alternatif,1,strlen($kode_alternatif->kode_alternatif)-1);
		
		//$data['no'] = $kd_kriteria;
		
		for($i=1 ; $i<=$kd_alternatif ; $i++){
			for($j=1 ; $j<=$kd_kriteria ; $j++){
				$data_bobot_alternatif[$i][$j] = Nilai_bobot_alternatif::select('bobot')->where('kode_alternatif','A'.$i)->where('kode_kriteria','C'.$j)->first();
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
		
		
        return view('perhitungan', $data)->with('tampil' , $data_bobot)->with('tampil_alternatif', $data_bobot_alternatif);
    }
}
