<?php
require_once '../../function/db_connect.php';
$idsiswa=$_POST['idsiswa'];$jenis=$_POST['jenis'];$tapel=$_POST['tapel'];
//$idmp=$utt['jenis'];$mpl=$connect->query("select * from jenis_tunggakan where id_tunggakan='$jenis'")->fetch_assoc();
?>
						<div class="modal-body">							<div class="form-group form-group-default">								<label>Jenis Tunggakan</label>								<input type="hidden" name="idsiswa" class="form-control" value="<?php echo $idsiswa;?>">								<input type="hidden" name="jenis" class="form-control" value="<?php echo $jenis;?>">								<input type="hidden" name="tapel" class="form-control" value="<?php echo $tapel;?>">								<input type="text" autocomplete=off class="form-control" readonly placeholder="Name" value="<?=$mpl['nama_tunggakan'];?>">							</div>							<div class="form-group form-group-default">								<label>Tarif</label>								<input type="text" name="tarif" autocomplete=off class="form-control" placeholder="Biaya">							</div>                        </div>                        <div class="modal-footer">                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>							<button type="submit" class="btn btn-danger waves-effect waves-light">Simpan</button>						</div>						