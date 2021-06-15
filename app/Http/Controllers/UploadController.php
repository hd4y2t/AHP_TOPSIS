<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Kriteria;
use App\Alternatif;
use App\Hasil;
use App\Nilai_bobot_kriteria;
use App\Nilai_bobot_alternatif;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
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
        return view('upload',$data);
	}
	
	public function tambah(Request $request){
		if ($files = $request->file('hasil')) {
            $name = $files->getClientOriginalName();
            $files->move('hasil', $name);
        }
		$hasil = new Hasil;
		$hasil->periode = $_POST['periode'];
		$hasil->hasil = $name;
		$hasil->save();
		return redirect('upload');
	}
}
