<?php
require_once '../../function/db_connect.php';function rupiah($angka){		$hasil_rupiah = "Rp " . number_format($angka,0,',','.');	return $hasil_rupiah; }
$idinv=$_POST['idinv'];$sql = "select * from pembayaran where id_invoice='$idinv'";$query = $connect->query($sql);
?>
						<div class="modal-body">							<div class="table-responsive">							<table class="table table-striped">							<?php							while($s=$query->fetch_assoc()) {															?>							<tr>								<td><?=$s['tanggal'];?></td>								<td><?=$s['deskripsi'];?></td>								<td><?=rupiah($s['bayar']);?></td>							</tr>							<?php															}							?>								</table>							</div>                        </div>                        <div class="modal-footer">                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>						</div>						