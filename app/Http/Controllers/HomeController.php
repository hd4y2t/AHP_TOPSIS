<?php

namespace App\Http\Controllers;

use App\Alternatif;
use App\Hasil;
use App\Kriteria;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Nilai_bobot_alternatif;
use App\Nilai_bobot_kriteria;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
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

    $data['hasil'] = Hasil::get();

    return view('home', $data);
  }
}
