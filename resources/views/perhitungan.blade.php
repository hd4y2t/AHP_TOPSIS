@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card mb-5">
		<div class="card-header">
			<h3>Mengukur Konsistensi Kriteria(AHP)</h3>
		</div>
		<div class="card-body">
			<h5>Matriks Perbandingan Kriteria</h5>
			<div class="table-responsive mb-5">
				<table class="table table-bordered">
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
						@php $idx = $loop->index+1 @endphp
						<tr>
							<td>{{ $row->kode_kriteria }}</td>
							@for($j=1 ; $j<=$no ; $j++) <!-- Tampilin data bobot -->
								<td>{{ $tampil[$idx][$j]['bobot'] }}</td>
								@endfor
						</tr>
						@endforeach
						<tr>
							<td>Total</td>
							@foreach($total_bobot as $row)
							<!-- Total -->
							<td>{{ $row->total_bobot }}</td>
							@endforeach
						</tr>
					</tbody>
				</table>
			</div>
			<h5>Matriks Bobot Prioritas Kriteria</h5>
			<div class="table-responsive mb-5">
				<table class="table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>Kode</th>
							@foreach($kriteria as $row)
							<th>{{ $row->kode_kriteria }}</th>
							@endforeach
							<th>Bobot Prioritas</th>
						</tr>
					</thead>
					<tbody>
						<?php $array_bobot_prioritas = array(); ?>
						@foreach($kriteria as $key => $row)
						<?php $idx = $key + 1; ?>
						<?php $bobot_prioritas = 0; ?>

						<tr>
							<td>{{ $row['kode_kriteria'] }}</td>
							@for($j=1 ; $j<=$no ; $j++) <!-- bobot/totalbobot -->
								<td>{{ $tampil[$idx][$j]['bobot']/$total_bobot[$j-1]->total_bobot }}</td>

								@php $bobot_prioritas += $tampil[$idx][$j]['bobot']/$total_bobot[$j-1]->total_bobot @endphp

								@endfor
								<td>{{ $bobot_prioritas/$no }}</td>
								<?php array_push($array_bobot_prioritas, $bobot_prioritas / $no); ?>
						</tr>

						@endforeach
					</tbody>
				</table>
			</div>

			<h5>Matriks Konsistensi Kriteria</h5>
			<div class="table-responsive mb-5">
				<table class="table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>Kode</th>
							@foreach($kriteria as $row)
							<th>{{ $row->kode_kriteria }}</th>
							@endforeach
							<th>Bobot</th>
						</tr>
					</thead>
					<tbody>
						<?php $lmax = 0; ?>
						@foreach($kriteria as $key => $row)
						<?php $idx = $key + 1; ?>
						<?php $bobot_prioritas = 0; ?>
						<?php $bobot = 0; ?>

						<tr>
							<td>{{ $row['kode_kriteria'] }}</td>
							@for($j=1 ; $j<=$no ; $j++) <td>{{ $tampil[$idx][$j]['bobot']/$total_bobot[$j-1]->total_bobot }}</td>
								@php $bobot += $tampil[$idx][$j]['bobot'] * $array_bobot_prioritas[$j-1] @endphp
								@php $bobot_prioritas += $tampil[$idx][$j]['bobot']/$total_bobot[$j-1]->total_bobot @endphp
								@endfor
								@php $pembagi = $bobot_prioritas/$no @endphp
								<td>{{ $bobot/$pembagi }}</td>
								@php $lmax += $bobot/$pembagi @endphp
						</tr>

						@endforeach
					</tbody>
				</table>
			</div>

			<h6>Berikut tabel ratio index berdasarkan ordo matriks.</h6>
			<div class="table-responsive mb-5">
				<table class="table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>Ordo Matriks</th>
							@for($i=1 ; $i <= 15 ; $i++) @if($i==$no) <th>{{ $i }}</th>
								@else
								<td>{{ $i }}</td>
								@endif
								@endfor
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Ratio Index</th>
							<td class='1'>0</td>
							<td class='2'>0</td>
							<td class='3'>0.58</td>
							<td class='4'>0.9</td>
							<td class='5'>1.12</td>
							<td class='6'>1.24</td>
							<td class='7'>1.32</td>
							<td class='8'>1.41</td>
							<td class='9'>1.46</td>
							<td class='10'>1.49</td>
							<td class='11'>1.51</td>
							<td class='12'>1.48</td>
							<td class='13'>1.56</td>
							<td class='14'>1.57</td>
							<td class='15'>1.59</td>
						</tr>

					</tbody>
				</table>
			</div>
			<!-- ci = lamda / total - total / total-1 -->
			@php $ci = (($lmax/$no)-$no)/($no-1) @endphp
			<h6>Consistency Index: {{ $ci }}</h6>
			<h6>Ratio Index: <span class="RI"></span></h6>
			<h6>Consistency Ratio: <span class="CR"></span> (<span class="status"></span>)</h6>
		</div>
	</div>
	<div class="card">
		<div class="card-header">
			<h3>Perhitungan TOPSIS</h3>
		</div>
		<div class="card-body">
			<h5>Hasil Analisa</h5>
			<div class="table-responsive mb-5">
				<table class="table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>Nama Alternatif</th>
							<?php $array_normalisasi = array(); ?>
							<?php $total_normalisasi = array(); ?>
							@foreach($kriteria as $row)
							<th>{{ $row->kode_kriteria }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@foreach($alternatif as $row)
						@php $idx = $loop->index+1 @endphp
						<tr>
							<td>{{ $row->nama_alternatif }}</td>
							@for($j=1 ; $j<=$no ; $j++) <td>{{ $tampil_alternatif[$idx][$j]['bobot'] }}</td>
								@php $array_normalisasi[$idx][$j] = pow($tampil_alternatif[$idx][$j]['bobot'],2) @endphp
								@endfor
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<h5>Normalisasi</h5>
			<div class="table-responsive mb-5">
				<table class="table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>Nama Alternatif</th>
							@foreach($kriteria as $row)
							<th>{{ $row->kode_kriteria }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						<?php
						for ($i = 1; $i <= $no; $i++) {
							$temp = 0;
							for ($j = 1; $j <= $idx; $j++) {
								$temp += $array_normalisasi[$j][$i];
							}
							$total_normalisasi[$i] = $temp;
						}
						?>
						@foreach($alternatif as $row)
						@php $idx = $loop->index+1 @endphp
						<tr>
							<td>{{ $row->nama_alternatif }}</td>
							@for($j=1 ; $j<=$no ; $j++) <!-- kuadrat dari bobot / akar total -->
								<td>{{ pow($tampil_alternatif[$idx][$j]['bobot'],2)/sqrt($total_normalisasi[$j]) }}</td>
								@endfor
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<h5>Normalisasi Terbobot</h5>
			<div class="table-responsive mb-5">
				<table class="table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>Nama Alternatif</th>
							<?php $array_solusi_ideal = array(); ?>
							<?php $max_solusi_ideal = array(); ?>
							<?php $min_solusi_ideal = array(); ?>
							@foreach($kriteria as $row)
							<th>{{ $row->kode_kriteria }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						<?php
						for ($i = 1; $i <= $no; $i++) {
							$temp = 0;
							for ($j = 1; $j <= $idx; $j++) {
								$temp += $array_normalisasi[$j][$i];
							}
							$total_normalisasi[$i] = $temp;
						}
						?>
						@foreach($alternatif as $row)
						@php $idx = $loop->index+1 @endphp
						<tr>
							<td>{{ $row->nama_alternatif }}</td>
							@for($j=1 ; $j<=$no ; $j++) <td>{{ $array_bobot_prioritas[$j-1]*pow($tampil_alternatif[$idx][$j]['bobot'],2)/sqrt($total_normalisasi[$j]) }}</td>
								@php $array_solusi_ideal[$idx][$j] = $array_bobot_prioritas[$j-1]*pow($tampil_alternatif[$idx][$j]['bobot'],2)/sqrt($total_normalisasi[$j]) @endphp
								@endfor
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<?php
			for ($i = 1; $i <= $no; $i++) {
				$max = 0;
				$temp = 0;
				for ($j = 1; $j <= $idx; $j++) {
					if ($temp < $array_solusi_ideal[$j][$i]) {
						$max = $array_solusi_ideal[$j][$i];
						$temp = $max;
					}
				}
				$max_solusi_ideal[$i] = $max;
			}
			?>
			<?php
			for ($i = 1; $i <= $no; $i++) {
				$min = 0;
				$temp = 0;
				$temp = $array_solusi_ideal[1][$i];
				for ($j = 1; $j <= $idx; $j++) {
					if ($temp >= $array_solusi_ideal[$j][$i]) {
						$min = $array_solusi_ideal[$j][$i];
						$temp = $min;
					}
				}
				$min_solusi_ideal[$i] = $min;
			}
			?>

			<h5>Matriks Solusi Ideal</h5>
			<div class="table-responsive mb-5">
				<table class="table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th></th>
							<?php $positif_solusi_ideal = array(); ?>
							<?php $negatif_solusi_ideal = array(); ?>
							@foreach($kriteria as $row)
							<th>{{ $row->kode_kriteria }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Positif</td>
							@foreach($kriteria as $row)
							@php $idx = $loop->index+1 @endphp
							<?php if ($row->atribut_kriteria == 'benefit') { ?>

								<td>{{ $max_solusi_ideal[$idx] }}</td>
								@php $positif_solusi_ideal[$idx] = $max_solusi_ideal[$idx] @endphp
							<?php } else { ?>
								<td>{{ $min_solusi_ideal[$idx] }}</td>
								@php $positif_solusi_ideal[$idx] = $min_solusi_ideal[$idx] @endphp
							<?php } ?>
							@endforeach
						</tr>
						<tr>
							<td>Negatif</td>
							@foreach($kriteria as $row)
							@php $idx = $loop->index+1 @endphp
							<?php if ($row->atribut_kriteria == 'benefit') { ?>

								<td>{{ $min_solusi_ideal[$idx] }}</td>
								@php $negatif_solusi_ideal[$idx] = $min_solusi_ideal[$idx] @endphp
							<?php } else { ?>
								<td>{{ $max_solusi_ideal[$idx] }}</td>
								@php $negatif_solusi_ideal[$idx] = $max_solusi_ideal[$idx] @endphp
							<?php } ?>
							@endforeach
						</tr>
					</tbody>
				</table>
			</div>

			<h5>jarak solusi positif</h5>
			<div class="table-responsive mb-5">
				<table class="table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>Nama Alternatif</th>
							<?php $preferensi_positif = array(); ?>
							@foreach($kriteria as $row)
							<th>{{ $row->kode_kriteria }}</th>
							@endforeach
							<th>Jarak</th>
						</tr>
					</thead>
					<tbody>
						@foreach($alternatif as $row)
						@php $jarak_positif = 0; @endphp
						@php $idx = $loop->index+1 @endphp
						<tr>
							<td>{{ $row->nama_alternatif }}</td>
							@for($j=1 ; $j<=$no ; $j++) <td>{{ pow(($array_bobot_prioritas[$j-1]*pow($tampil_alternatif[$idx][$j]['bobot'],2)/sqrt($total_normalisasi[$j]))-$positif_solusi_ideal[$j],2) }}</td>
								@php $jarak_positif += pow(($array_bobot_prioritas[$j-1]*pow($tampil_alternatif[$idx][$j]['bobot'],2)/sqrt($total_normalisasi[$j]))-$positif_solusi_ideal[$j],2) @endphp
								@endfor
								<td>{{ sqrt($jarak_positif) }}</td>
								<?php $preferensi_positif[$idx] = sqrt($jarak_positif);  ?>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<h5>jarak solusi negatif</h5>
			<div class="table-responsive mb-5">
				<table class="table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>Nama Alternatif</th>
							<?php $preferensi_negatif = array(); ?>
							@foreach($kriteria as $row)
							<th>{{ $row->kode_kriteria }}</th>
							@endforeach
							<th>Jarak</th>
						</tr>
					</thead>
					<tbody>
						@foreach($alternatif as $row)
						@php $jarak_negatif = 0; @endphp
						@php $idx = $loop->index+1 @endphp
						<tr>
							<td>{{ $row->nama_alternatif }}</td>
							@for($j=1 ; $j<=$no ; $j++) <td>{{ pow(($array_bobot_prioritas[$j-1]*pow($tampil_alternatif[$idx][$j]['bobot'],2)/sqrt($total_normalisasi[$j]))-$negatif_solusi_ideal[$j],2) }}</td>
								@php $jarak_negatif += pow(($array_bobot_prioritas[$j-1]*pow($tampil_alternatif[$idx][$j]['bobot'],2)/sqrt($total_normalisasi[$j]))-$negatif_solusi_ideal[$j],2) @endphp
								@endfor
								<td>{{ sqrt($jarak_negatif) }}</td>
								<?php $preferensi_negatif[$idx] = sqrt($jarak_negatif);  ?>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<h5>Nilai Preferensi</h5>
			<div class="table-responsive mb-5">
				<table class="table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>Nama Alternatif</th>
							<th>Positif</th>
							<th>Negatif</th>
							<th>Preferensi</th>
						</tr>
					</thead>
					<tbody>
						<?php $values = array(); ?>
						@foreach($alternatif as $row)
						@php $idx = $loop->index+1 @endphp
						<tr>
							<td>{{ $row->nama_alternatif }}</td>
							<td>{{ $preferensi_positif[$idx] }}</td>
							<td>{{ $preferensi_negatif[$idx] }}</td>
							<td>{{ $preferensi_negatif[$idx]/($preferensi_positif[$idx]+$preferensi_negatif[$idx]) }}</td>
							@php $values[$idx-1] = $preferensi_negatif[$idx]/($preferensi_positif[$idx]+$preferensi_negatif[$idx]) @endphp
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<?php
			$rank = array();
			$preference = array();
			$ordered_values = $values;
			rsort($ordered_values);

			foreach ($values as $key => $value) {
				foreach ($ordered_values as $ordered_key => $ordered_value) {
					if ($value === $ordered_value) {
						$key = $ordered_key;
						break;
					}
				}

				$rank[$key] = ((int) $key + 1);
				$preference[$key] = $value;
			}
			?>

			<h5>Ranking</h5>
			<div class="table-responsive mb-5">
				<table id="tb_kriteria" class="table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>Nama Alternatif</th>
							<th>Preferensi</th>
							<th>Ranking</th>
						</tr>
					</thead>
					<tbody>
						@foreach($alternatif as $row)
						@php $idx = $loop->index+1 @endphp
						<tr>
							<td>{{ $row->nama_alternatif }}</td>
							<td>{{ $preferensi_negatif[$idx]/($preferensi_positif[$idx]+$preferensi_negatif[$idx]) }}</td>
							<?php
							$pref = $preferensi_negatif[$idx] / ($preferensi_positif[$idx] + $preferensi_negatif[$idx]);
							$ranking = array_search($pref, $preference);
							?>
							<td>{{ $ranking+1 }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#tb_kriteria').DataTable({
			dom: 'Bfrtip',
			buttons: [
				//'copy', 'csv', 'excel', 'pdf', 'print'
				'pdf'
			]
		});
	});

	function pemberitahuan() {
		$('#modal_pemberitahuan').modal();
	}
	let RI = $('.<?php echo $no ?>').html();
	let CI = <?php echo $ci ?>;
	$('.<?php echo $no ?>').replaceWith('<th class="<?php echo $no ?>">' + RI + '</th>');
	$('.RI').text(RI);
	$('.CR').text(CI / RI);
	if (CI / RI < 0.1)
		$('.status').text('Konsisten')
	else
		$('.status').text('Tidak Konsisten')
</script>
@endsection