<?php 
include '../../function/db.php';
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
if (isset($_GET['awal'])) {
  $awal = $_GET['awal'];
  $akhir = $_GET['akhir'];
  $query = mysqli_query($koneksi, "select * from tabungan where tanggal >= '$awal' and tanggal <= '$akhir'");
  $jumlah=mysqli_num_rows($query);
  $query1 = mysqli_query($koneksi, "SELECT sum(IF(kode='1',masuk,0)) as setoran FROM tabungan where tanggal >= '$awal' and tanggal <= '$akhir'");
  $setor=mysqli_fetch_array($query1);
  $query2 = mysqli_query($koneksi, "SELECT sum(IF(kode='2',keluar,0)) as penarikan FROM tabungan where tanggal >= '$awal' and tanggal <= '$akhir'");
  $ambil=mysqli_fetch_array($query2);
  $saldo=$setor['setoran']-$ambil['penarikan'];
?>
<div class="row ">
	<div class="col-xl-4 col-lg-4">
		
        <div class="card">
                  <div class="card-body card-type-3">
                    <div class="row">
                      <div class="col">
                        <h6 class="text-muted mb-0">Setoran</h6>
                        <span class="font-weight-bold mb-0"><?=rupiah($setor['setoran']);?></span>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      
                    </p>
                  </div>
                </div>
    </div>
	<div class="col-xl-4 col-lg-4">
		<div class="card">
                  <div class="card-body card-type-3">
                    <div class="row">
                      <div class="col">
                        <h6 class="text-muted mb-0">Penarikan</h6>
                        <span class="font-weight-bold mb-0"><?=rupiah($ambil['penarikan']);?></span>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      
                    </p>
                  </div>
                </div>        
    </div>
	<div class="col-xl-4 col-lg-4">
		<div class="card">
                  <div class="card-body card-type-3">
                    <div class="row">
                      <div class="col">
                        <h6 class="text-muted mb-0">Total</h6>
                        <span class="font-weight-bold mb-0"><?=rupiah($saldo);?></span>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      
                    </p>
                  </div>
                </div>        
    </div>
</div>

<?php 
};
?>