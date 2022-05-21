<?php
 include 'fpdf/fpdf.php';
 include 'exfpdf.php';
 include 'easyTable.php';
 include '../function/db_connect.php';
 function TanggalIndo($tanggal)
	{
		$bulan = array ('Januari',
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
		$split = explode('-', $tanggal);
		return $split[2] . ' ' . $bulan[ (int)$split[1]-1 ] . ' ' . $split[0];
	};

function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
};
function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}
	
function namahari($tanggal){
    
    //fungsi mencari namahari
    //format $tgl YYYY-MM-DD
    //harviacode.com
    
    $tgl=substr($tanggal,8,2);
    $bln=substr($tanggal,5,2);
    $thn=substr($tanggal,0,4);

    $info=date('w', mktime(0,0,0,$bln,$tgl,$thn));
    
    switch($info){
        case '0': return "Minggu"; break;
        case '1': return "Senin"; break;
        case '2': return "Selasa"; break;
        case '3': return "Rabu"; break;
        case '4': return "Kamis"; break;
        case '5': return "Jumat"; break;
        case '6': return "Sabtu"; break;
    };
    
};

	$tapel=$_GET['tapel'];
$kelas=$_GET['kelas'];
$smt=$_GET['smt'];
$bulan=(int) $_GET['bulan'];
$jenis=$_GET['jenis'];
$thn=isset($_GET['thn']) ? $_GET['thn'] : date("Y");
$jprinter=$connect->query("select * from printer where status='1'")->fetch_assoc();
$bln = array("Juli", "Agustus", "September", "Oktober", "November", "Desember", "Januari", "Februari", "Maret", "April", "Mei", "Juni");
		$pdf=new exFPDF('L','mm',array(330,215));
		$pdf->AddPage(); 
		$pdf->SetFont('Times','',8);
/**
		$table2=new easyTable($pdf, '{30,185}');
		$table2->easyCell('','img:logo.jpg,w20;rowspan:4;align:C;border:B');
		$table2->easyCell('SD ISLAM AL-JANNAH','font-size:14;align:L;');
		$table2->printRow();
		$table2->easyCell('Jl. Raya Gabuswetan No. 1 Desa Gabuswetan Kec. Gabuswetan','align:L');
		$table2->printRow();
		$table2->easyCell('Kab. Indramayu - Jawa Barat 45263 Telp. (0234) 5508501','align:L');
		$table2->printRow();
		$table2->easyCell('Website: https://sdi-aljannah.web.id Email: sdi.aljannah@gmail.com','align:L;border:B');
		$table2->printRow();
		$table2->endTable();
	**/	
		$table2=new easyTable($pdf, '{215}', 'align:C');
		$table2->easyCell('LAPORAN KEWAJIBAN ADMINISTRASI SISWA','align:C');
		$table2->printRow();
		$table2->easyCell('SAMPAI DENGAN '.$bln[$bulan-1].' TAHUN '.$thn,'align:C');
		$table2->printRow();
		$jam=date('Y-m-d h:i:s');
		$table2->easyCell('Dicetak Tanggal : '.$jam,'align:C');
		$table2->printRow();
		$table2->endTable();
		
		//$namasiswa=$connect->query("select * from siswa where peserta_didik_id='$siswa'")->fetch_assoc();
		$table2=new easyTable($pdf, '{60,5,150}', 'align:L');
		$table2->easyCell('Kelas','align:L');
		$table2->easyCell(':','align:L');
		$table2->easyCell($kelas,'align:L');
		$table2->printRow();
		
		$table2->easyCell('Tahun Pelajaran','align:L');
		$table2->easyCell(':','align:L');
		$table2->easyCell($tapel,'align:L');
		$table2->printRow();
		$table2->endTable();
		
		
		$sjum=array();
		$ko=0;
		$jnst=$connect->query("select * from jenis_tunggakan order by id_tunggakan asc");
		$table2=new easyTable($pdf, '{43,23,23,23,23,23,23,23,23,23,23,23,23,30,30,30}', 'align:L');
		$table2->easyCell('Nama Siswa','align:C;valign:M;border:1');
		$pdf->SetFont('Times','',8);
		while($sis=$jnst->fetch_assoc()){
			$ko=$ko+1;
			$sjum[$ko]=0;
			$table2->easyCell($sis['nama_tunggakan'],'align:C;valign:M;border:1');
		};
		$sjum[$ko+1]=0;$sjum[$ko+2]=0;$sjum[$ko+3]=0;
		$table2->easyCell('Tabungan','align:C;valign:M;border:1');
		$table2->easyCell('Sisa Tabungan','align:C;valign:M;border:1');
		$table2->easyCell('Sisa Tunggakan','align:C;valign:M;border:1');
		$table2->printRow(true);
		if($kelas==="lainnya"){
			$nsis=$connect->query("select * from nasabah where jenis>1");
          	$stab=0;
			while($namasis=$nsis->fetch_assoc()){
				$idn=$namasis['nasabah_id'];
				$ssaldo=$connect->query("SELECT sum(IF(kode='1',masuk,0)) as setoran, sum(IF(kode='2',keluar,0)) as penarikan FROM tabungan WHERE nasabah_id = '$idn'")->fetch_assoc();
				$saldo=$ssaldo['setoran']-$ssaldo['penarikan'];
				$pdf->SetFont('Times','',8);
				$table2->rowStyle('min-height:8');
              	$table2->easyCell($namasis['nama'],'align:L;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell(rupiah($saldo),'align:R;valign:M;border:1');
				$table2->easyCell(rupiah($saldo),'align:R;valign:M;border:1');
              	$stab=$stab+$saldo;
				$table2->easyCell('','align:R;valign:M;border:1');
              	$table2->printRow();
			};
          		$pdf->SetFont('Times','',8);
				$table2->rowStyle('min-height:8');
              	$table2->easyCell('Jumlah','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
				$table2->easyCell(rupiah($stab),'align:R;valign:M;border:1');
				//$stab=$stab+$saldo;
				$table2->easyCell(rupiah($stab),'align:R;valign:M;border:1');
				$table2->easyCell('','align:R;valign:M;border:1');
              	$table2->printRow();
		}else{
			$namakelas=$connect->query("select * from penempatan where rombel='$kelas' and tapel='$tapel' and smt='$smt'")->fetch_assoc();
			$nsis=$connect->query("select * from penempatan where rombel='$kelas' and tapel='$tapel' and smt='$smt' order by nama asc");
			while($namasis=$nsis->fetch_assoc()){
				$pdf->SetFont('Times','',8);
				$table2->rowStyle('min-height:8');
				$table2->easyCell($namasis['nama'],'align:L;valign:M;border:1');
				$ids=$namasis['peserta_didik_id'];
				$spp=$connect->query("select * from tarif_spp where peserta_didik_id='$ids'")->fetch_assoc();
				$jumlah=0;
				$sisa=0;
				$nomor=0;
				$bayarnya=0;
				$stab=0;
				$stun=0;
				for($i = 1; $i < $bulan+1; $i++){
					$sppbln=$connect->query("select * from pembayaran where peserta_didik_id='$ids' and tapel='$tapel' and jenis='1' and bulan='$i'")->num_rows;
					if($sppbln>0){
						//oke
					}else{
						$blnspp=$connect->query("select * from bulan_spp where id_bulan='$i'")->fetch_assoc();
						$jumlah=$jumlah+$spp['tarif'];
						$sisa=$sisa+$spp['tarif'];
						/**
						$nomor=$nomor+1;
						$table2->easyCell('SPP Tahun '.$tapel,'align:L;');
						$table2->easyCell($blnspp['bulan'],'align:L;');
						$table2->easyCell(rupiah($spp['tarif']),'align:R;');
						$table2->easyCell('-','align:R;');
						$table2->easyCell(rupiah($spp['tarif']),'align:R;');
						**/
					};
				};
				$table2->easyCell(rupiah($jumlah),'align:R;valign:M;border:1');
				$sjum[1]=$sjum[1]+$jumlah;
				$stun=$stun+$jumlah;
				$sql11="select * from jenis_tunggakan where id_tunggakan > 1";
				$query11 = $connect->query($sql11);
				$jumlah1=0;
				
				while($h=$query11->fetch_assoc()) {
					$idt=$h['id_tunggakan'];
					$cek=$connect->query("select * from pembayaran where peserta_didik_id='$ids' and tapel='$tapel' and jenis='$idt'")->num_rows;
					$tarifnya=$connect->query("select * from tunggakan_lain where peserta_didik_id='$ids' and tapel='$tapel' and jenis='$idt'")->fetch_assoc();
					if($tarifnya['tarif']==0){
						//oke
						$table2->easyCell('','align:R;valign:M;border:1');
						$sjum[$idt]=$sjum[$idt];
						$stun=$stun;
					}else{
						if($cek>0){
							$bayar=$connect->query("select sum(bayar) as sudahbayar from pembayaran where peserta_didik_id='$ids' and tapel='$tapel' and jenis='$idt'")->fetch_assoc();
							$sudah=$bayar['sudahbayar'];
							if($sudah==$tarifnya['tarif']){
								$table2->easyCell('','align:R;valign:M;border:1');
								$sjum[$idt]=$sjum[$idt];
								$stun=$stun;
							}else{
								$sisanya=$tarifnya['tarif']-$sudah;
								$jumlah=$jumlah+$tarifnya['tarif'];
								$sisa=$sisa+$sisanya;
								$bayarnya=$bayarnya+$sudah;
								$table2->easyCell(rupiah($sisanya),'align:R;valign:M;border:1');
								$sjum[$idt]=$sjum[$idt]+$sisanya;
								$stun=$stun+$sisanya;
							}
						}else{
							$jumlah1=$jumlah1+$tarifnya['tarif'];
							$sisa=$sisa+$tarifnya['tarif'];
							$table2->easyCell(rupiah($tarifnya['tarif']),'align:R;valign:M;border:1');
							$sjum[$idt]=$sjum[$idt]+$tarifnya['tarif'];
							$stun=$stun+$tarifnya['tarif'];
						}
					}
				};
				$idnas=$connect->query("select * from nasabah where user_id='$ids'")->fetch_assoc();
				$idn=$idnas['nasabah_id'];
				$ssaldo=$connect->query("SELECT sum(IF(kode='1',masuk,0)) as setoran, sum(IF(kode='2',keluar,0)) as penarikan FROM tabungan WHERE nasabah_id = '$idn'")->fetch_assoc();
				$saldo=$ssaldo['setoran']-$ssaldo['penarikan'];
				$sjum[$ko+1]=$sjum[$ko+1]+$saldo;
				$table2->easyCell(rupiah($saldo),'align:R;valign:M;border:1');
				$sisatab=$saldo-$stun;
				if($sisatab>0){
					$table2->easyCell(rupiah($sisatab),'align:R;valign:M;border:1');
					$table2->easyCell('','align:R;valign:M;border:1');
					$sjum[$ko+2]=$sjum[$ko+2]+$sisatab;
				}else{
					$table2->easyCell('','align:R;valign:M;border:1');
					$table2->easyCell(rupiah($stun-$saldo),'align:R;valign:M;border:1');
					$sjum[$ko+3]=$sjum[$ko+3]+$stun-$saldo;
				};
				$table2->printRow();
			}
			$table2->easyCell('Jumlah','align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[1]),'align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[2]),'align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[3]),'align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[4]),'align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[5]),'align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[6]),'align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[7]),'align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[8]),'align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[9]),'align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[10]),'align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[11]),'align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[12]),'align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[13]),'align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[14]),'align:R;valign:M;border:1');
			$table2->easyCell(rupiah($sjum[15]),'align:R;valign:M;border:1');
			$table2->printRow();

		};
			$table2->endTable();
		
	
		
		
		
		
			$pdf->Output();
			//$pdf->Output('D',$namafilenya);
		 


 

?>