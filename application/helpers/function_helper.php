<?php 
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function bmp_to_hex($filename) {
    $bmp = file_get_contents($filename);
    $output = '';
    for($i=0; $i < strlen($bmp); $i++) {
      $output .= dechex(ord($bmp[$i]));
    }
    return $output;
  }

	function hari_ini($hari){
	
		switch($hari){
			case 'Sun':
				$hari_ini = "Minggu";
			break;
	
			case 'Mon':			
				$hari_ini = "Senin";
			break;
	
			case 'Tue':
				$hari_ini = "Selasa";
			break;
	
			case 'Wed':
				$hari_ini = "Rabu";
			break;
	
			case 'Thu':
				$hari_ini = "Kamis";
			break;
	
			case 'Fri':
				$hari_ini = "Jumat";
			break;
	
			case 'Sat':
				$hari_ini = "Sabtu";
			break;
			
			default:
				$hari_ini = "Tidak di ketahui";		
			break;
		}
	
		return  $hari_ini ;
	
	}

	function KonDecRomawi($angka){
		$hsl = "";
		if($angka<1||$angka>3999){
			$hsl = "Batas Angka 1 s/d 3999";
		}else{
			 while($angka>=1000){
				 $hsl .= "M";
				 $angka -= 1000;
			 }
			 if($angka>=500){
				 if($angka>500){
					 if($angka>=900){
						 $hsl .= "M";
						 $angka-=900;
					 }else{
						 $hsl .= "D";
						 $angka-=500;
					 }
				 }
			 }
			 while($angka>=100){
				 if($angka>=400){
					 $hsl .= "CD";
					 $angka-=400;
				 }else{
					 $angka-=100;
				 }
			 }
			 if($angka>=50){
				 if($angka>=90){
					 $hsl .= "XC";
					  $angka-=90;
				 }else{
					$hsl .= "L";
					$angka-=50;
				 }
			 }
			 while($angka>=10){
				 if($angka>=40){
					$hsl .= "XL";
					$angka-=40;
				 }else{
					$hsl .= "X";
					$angka-=10;
				 }
			 }
			 if($angka>=5){
				 if($angka==9){
					 $hsl .= "IX";
					 $angka-=9;
				 }else{
					$hsl .= "V";
					$angka-=5;
				 }
			 }
			 while($angka>=1){
				 if($angka==4){
					$hsl .= "IV";
					$angka-=4;
				 }else{
					$hsl .= "I";
					$angka-=1;
				 }
			 }
		}
		return ($hsl);
	}

?>