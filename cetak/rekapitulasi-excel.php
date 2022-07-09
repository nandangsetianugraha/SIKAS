<?php
include '../function/db_connect.php';
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Nama Siswa');
$sheet->setCellValue('C1', 'Kelas');
$sheet->setCellValue('D1', 'SPP');
$sheet->setCellValue('E1', 'Seragam');
$sheet->setCellValue('F1', 'Buku');
$sheet->setCellValue('G1', 'Psikotest');
$sheet->setCellValue('H1', 'Bangunan');
$sheet->setCellValue('I1', 'PSB');
$sheet->setCellValue('J1', 'Pendaftaran');
$sheet->setCellValue('K1', 'Tunggakan Tahun Lalu');
$sheet->setCellValue('L1', 'PAS');
$sheet->setCellValue('M1', 'Ujian Madrasah');
$sheet->setCellValue('N1', 'Ujian Sekolah');
$sheet->setCellValue('O1', 'PAT');
$sheet->setCellValue('P1', 'Jumlah Tunggakan');
$sheet->setCellValue('Q1', 'Jumlah Tabungan');
$sheet->setCellValue('R1', 'Sisa Tabungan');
$sheet->setCellValue('S1', 'Sisa Tunggakan');
$tapel=$_GET['tapel'];
$kelas=$_GET['kelas'];
$smt=$_GET['smt'];
$bulan=(int) $_GET['bulan'];
$jenis=$_GET['jenis'];
$thn=isset($_GET['thn']) ? $_GET['thn'] : date("Y");

$sjum=array();
$ko=0;
$jnst=$connect->query("select * from jenis_tunggakan order by id_tunggakan asc");
while($sis=$jnst->fetch_assoc()){
	$ko=$ko+1;
	$sjum[$ko]=0;
};
$i = 2;
$no = 1;
$sjum[$ko+1]=0;$sjum[$ko+2]=0;$sjum[$ko+3]=0;$sjum[$ko+4]=0;
if($kelas==="0"){
	$nsis=$connect->query("select * from penempatan where tapel='$tapel' and smt='$smt' order by rombel,nama asc");
}else{
	$nsis=$connect->query("select * from penempatan where rombel='$kelas' and tapel='$tapel' and smt='$smt' order by nama asc");
};
while($namasis=$nsis->fetch_assoc()){
	$ids=$namasis['peserta_didik_id'];
	$sheet->setCellValue('A'.$i, $no++);
	$sheet->setCellValue('B'.$i, $namasis['nama']);
	$sheet->setCellValue('C'.$i, $namasis['rombel']);
	$spp=$connect->query("select * from tarif_spp where peserta_didik_id='$ids'")->fetch_assoc();
	$jumlah=0;
	$sisa=0;
	$nomor=0;
	$bayarnya=0;
	$stab=0;
	$stun=0;
	for($j = 1; $j < $bulan+1; $j++){
		$sppbln=$connect->query("select * from pembayaran where peserta_didik_id='$ids' and tapel='$tapel' and jenis='1' and bulan='$j'")->num_rows;
		if($sppbln>0){
		}else{
			$blnspp=$connect->query("select * from bulan_spp where id_bulan='$j'")->fetch_assoc();
			$jumlah=$jumlah+$spp['tarif'];
			$sisa=$sisa+$spp['tarif'];
		};
	};
	if($jumlah>0){
		$sheet->setCellValue('D'.$i, $jumlah);
	}else{
		$sheet->setCellValue('D'.$i, '');
	};
	$sjum[1]=$sjum[1]+$jumlah;
	$stun=$stun+$jumlah;
	$sql11="select * from jenis_tunggakan where id_tunggakan > 1";
	$query11 = $connect->query($sql11);
	$jumlah1=0;
	$urut=0;
	$huruf = array("E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O");
	while($h=$query11->fetch_assoc()) {
		$idt=$h['id_tunggakan'];
		$cek=$connect->query("select * from pembayaran where peserta_didik_id='$ids' and tapel='$tapel' and jenis='$idt'")->num_rows;
		$tarifnya=$connect->query("select * from tunggakan_lain where peserta_didik_id='$ids' and tapel='$tapel' and jenis='$idt'")->fetch_assoc();
		if($tarifnya['tarif']==0){	
			$sheet->setCellValue($huruf[$urut].$i, '');
			$sjum[$idt]=$sjum[$idt];
			$stun=$stun;
		}else{
			if($cek>0){
				$bayar=$connect->query("select sum(bayar) as sudahbayar from pembayaran where peserta_didik_id='$ids' and tapel='$tapel' and jenis='$idt'")->fetch_assoc();
				$sudah=$bayar['sudahbayar'];
				if($sudah==$tarifnya['tarif']){
					$sheet->setCellValue($huruf[$urut].$i, '');
					$sjum[$idt]=$sjum[$idt];
					$stun=$stun;
				}else{
					$sisanya=$tarifnya['tarif']-$sudah;
					$jumlah=$jumlah+$tarifnya['tarif'];
					$sisa=$sisa+$sisanya;
					$bayarnya=$bayarnya+$sudah;
					$sheet->setCellValue($huruf[$urut].$i, $sisanya);
					$sjum[$idt]=$sjum[$idt]+$sisanya;
					$stun=$stun+$sisanya;
				};
			}else{
				$jumlah1=$jumlah1+$tarifnya['tarif'];
				$sisa=$sisa+$tarifnya['tarif'];
				$sheet->setCellValue($huruf[$urut].$i, $tarifnya['tarif']);
				$sjum[$idt]=$sjum[$idt]+$tarifnya['tarif'];
				$stun=$stun+$tarifnya['tarif'];
			};
		};
		$urut=$urut+1;
	};
	if($stun>0){
		$sheet->setCellValue('P'.$i, $stun);
	}else{
		$sheet->setCellValue('P'.$i, '');
	};
	$idnas=$connect->query("select * from nasabah where user_id='$ids'")->fetch_assoc();
	$idn=$idnas['nasabah_id'];
	$ssaldo=$connect->query("SELECT sum(IF(kode='1',masuk,0)) as setoran, sum(IF(kode='2',keluar,0)) as penarikan FROM tabungan WHERE nasabah_id = '$idn'")->fetch_assoc();
	$saldo=$ssaldo['setoran']-$ssaldo['penarikan'];
	$sjum[$ko+1]=$sjum[$ko+1]+$saldo;
    if($saldo>0){
		$sheet->setCellValue('Q'.$i, $saldo);
	}else{
		$sheet->setCellValue('Q'.$i, '');
	};
	$sisatab=$saldo-$stun;
	if($sisatab>0){
		$sheet->setCellValue('R'.$i, $sisatab);
		$sjum[$ko+2]=$sjum[$ko+2]+$sisatab;
	}else{
		$sheet->setCellValue('R'.$i, '');
		if($stun-$saldo>0){
			$sheet->setCellValue('S'.$i, $stun-$saldo);
		}else{
           	$sheet->setCellValue('S'.$i, '');
        }
		$sjum[$ko+3]=$sjum[$ko+3]+$stun-$saldo;
	};
	$i++;
};
			$nsis=$connect->query("select * from nasabah where jenis>1");
          	$stab=0;
			while($namasis=$nsis->fetch_assoc()){
				$idn=$namasis['nasabah_id'];
				$ssaldo=$connect->query("SELECT sum(IF(kode='1',masuk,0)) as setoran, sum(IF(kode='2',keluar,0)) as penarikan FROM tabungan WHERE nasabah_id = '$idn'")->fetch_assoc();
				$saldo=$ssaldo['setoran']-$ssaldo['penarikan'];
				$sheet->setCellValue('A'.$i, $no++);
				$sheet->setCellValue('B'.$i, $namasis['nama']);
				$sheet->setCellValue('C'.$i, '');
				$sheet->setCellValue('D'.$i, '');
				$sheet->setCellValue('E'.$i, '');
				$sheet->setCellValue('F'.$i, '');
				$sheet->setCellValue('G'.$i, '');
				$sheet->setCellValue('H'.$i, '');
				$sheet->setCellValue('I'.$i, '');
				$sheet->setCellValue('J'.$i, '');
				$sheet->setCellValue('K'.$i, '');
				$sheet->setCellValue('L'.$i, '');
				$sheet->setCellValue('M'.$i, '');
				$sheet->setCellValue('N'.$i, '');
				$sheet->setCellValue('O'.$i, '');
				$sheet->setCellValue('P'.$i, '');
				if($saldo>0){
					$sheet->setCellValue('Q'.$i, $saldo);
					$sheet->setCellValue('R'.$i, $saldo);
				}else{
					$sheet->setCellValue('Q'.$i, '');
					$sheet->setCellValue('R'.$i, '');
				}
				$sheet->setCellValue('S'.$i, '');
				$i++;
			};

$styleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
		];
$i = $i - 1;
$sheet->getStyle('A1:S'.$i)->applyFromArray($styleArray);

$file_name=time() . '.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($file_name);
header('Content-Type: application/x-www-form-urlencoded');
header('Content-Transfer-Encoding: Binary');
header("Content-disposition: attachment; filename=\"".$file_name."\"");
readfile($file_name);
unlink($file_name);
exit;
?>