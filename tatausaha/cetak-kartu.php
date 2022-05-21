<?php 
session_start();
require_once '../function/functions.php';
include '../function/db_connect.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Cetak Kartu';
//view('template/head', $data);
include "../template/head.php";
?>
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <?php include "../template/top-navbar.php"; ?>
	  <div class="main-sidebar sidebar-style-2">
		<?php 
		include "../template/sidebar.php";
		?>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row mt-sm-4">
				<div class="col-12">
				  <div class="card">
					<div class="card-header">
					  <h4>Cetak Kartu SPP</h4>
					  <div class="card-header-form">
						<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
						<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
						<?php $jprinter=$connect->query("select * from printer where status='1'")->fetch_assoc(); ?>
						<input type="hidden" name="lstPrinters" id="lstPrinters" value="<?=$jprinter['nama'];?>" />
						<input type="hidden" name="lstPrinterTrays" id="lstPrinterTrays" value="" />
						<input type="hidden" name="txtPdfFileCetakKartu" id="txtPdfFileCetakKartu" value="../cetak/cetak-kartu.pdf" />
						<input type="hidden" name="lstPrinterPapersCetakKartu" id="lstPrinterPapersCetakKartu" value="<?=$jprinter['spp'];?>" />
						<input type="hidden" name="txtPdfFileCetakInvoice" id="txtPdfFileCetakInvoice" value="../cetak/cetak-kartu.pdf" />
						<input type="hidden" name="lstPrinterPapersCetakInvoice" id="lstPrinterPapersCetakInvoice" value="<?=$jprinter['kwitansi'];?>" />
					  </div>
					</div>
					<div class="card-body">
					  <div class="table-responsive">
						<table class="table table-striped" id="manageMemberTable">
							<thead>
							   <tr>
									<th>Nama Siswa</th>
									<th>NIS</th>
									<th>NISN</th>
									<th>TTL</th>
									<th>Kelas</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					  </div>
					</div>
				  </div>
				</div>
			</div>
          </div>
        </section>
		<?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
  <script src="<?= base_url(); ?>assets/js/zip-full.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/JSPrintManager.js"></script>
  <script src="<?= base_url(); ?>assets/js/bluebird.min.js"></script>
<script> 
var clientPrinters = null;
    var _this = this;

    //WebSocket settings
    JSPM.JSPrintManager.auto_reconnect = true;
    JSPM.JSPrintManager.start();

    //Check JSPM WebSocket status
    function jspmWSStatus() {
        if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Open)
            return true;
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Closed) {
            alert('JSPrintManager (JSPM) is not installed or not running! Download JSPM Client App from https://neodynamic.com/downloads/jspm');
            return false;
        }
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Blocked) {
            alert('JSPM has blocked this website!');
            return false;
        }
    }
function printSPPB() {
        if (jspmWSStatus()) {

            //Create a ClientPrintJob
            var cpj = new JSPM.ClientPrintJob();

            //Set Printer info
            var myPrinter = new JSPM.InstalledPrinter($('#lstPrinters').val());
            myPrinter.paperName = "<?=$jprinter['spp'];?>";
            myPrinter.trayName = $('#lstPrinterTrays').val();
                
            cpj.clientPrinter = myPrinter;

            //Set PDF file
            var my_file = new JSPM.PrintFilePDF("../cetak/cetak-spp-belakang.pdf", JSPM.FileSourceType.URL, 'MyFile.pdf', 1);
            my_file.printRotation = JSPM.PrintRotation[$('#lstPrintRotation').val()];
            my_file.printRange = $('#txtPagesRange').val();
            my_file.printAnnotations = $('#chkPrintAnnotations').prop('checked');
            my_file.printAsGrayscale = $('#chkPrintAsGrayscale').prop('checked');
            my_file.printInReverseOrder = $('#chkPrintInReverseOrder').prop('checked');

            cpj.files.push(my_file);

            //Send print job to printer!
            cpj.sendToClient();
            //myWindow.close();    
        }
    } 
function printSPPD() {
        if (jspmWSStatus()) {

            //Create a ClientPrintJob
            var cpj = new JSPM.ClientPrintJob();

            //Set Printer info
            var myPrinter = new JSPM.InstalledPrinter($('#lstPrinters').val());
            myPrinter.paperName = "<?=$jprinter['spp'];?>";
            myPrinter.trayName = $('#lstPrinterTrays').val();
                
            cpj.clientPrinter = myPrinter;

            //Set PDF file
            var my_file = new JSPM.PrintFilePDF("../cetak/cetak-spp-depan.pdf", JSPM.FileSourceType.URL, 'MyFile.pdf', 1);
            my_file.printRotation = JSPM.PrintRotation[$('#lstPrintRotation').val()];
            my_file.printRange = $('#txtPagesRange').val();
            my_file.printAnnotations = $('#chkPrintAnnotations').prop('checked');
            my_file.printAsGrayscale = $('#chkPrintAsGrayscale').prop('checked');
            my_file.printInReverseOrder = $('#chkPrintInReverseOrder').prop('checked');

            cpj.files.push(my_file);

            //Send print job to printer!
            cpj.sendToClient();
            //myWindow.close();    
        }
    } 
$(document).ready(function(){
	$("#manageMemberTable").dataTable({
		"destroy":true,
	  "searching": true,
	  "paging":true,
	  "ajax": "../modul/siswa/daftar-siswa.php?smt=<?=$smt;?>&tapel=<?=$tapel;?>",
	  "columnDefs": [
		{ "sortable": false, "targets": [5] }
	  ]
	});
	$(document).on('click', '#getQR', function(e){
		e.preventDefault();
		var updid = $(this).data('pdid');
		var unis = $(this).data('nis');
		$.ajax({
			type : 'GET',
			url : '../modul/qrcode/buatQRCode.php',
			data :  'pdid='+updid+'&nis='+unis,
			dataType: 'json',
			success: function (data) {
				swal(data.messages, {buttons: false,timer: 500,});				
			}
		});
	});
	$(document).on('click', '#cetakDepan', function(e){
		
			e.preventDefault();
			
			var pdid = $(this).data('pdid');
			var tapel = $(this).data('tapel');
			$.ajax({
				type : 'GET',
				url : '../cetak/cetak-spp-depan.php',
				data :  'pdid='+pdid+'&tapel='+tapel,
				success: function (response) {
					printSPPD();												
				}
			});
			//PopupCenter('../cetak/cetak-kartu.php?idspp='+uidspp, 'myPop1',800,800);
			
		});
	$(document).on('click', '#cetakBelakang', function(e){
		
			e.preventDefault();
			
			var pdid = $(this).data('pdid');
			var tapel = $(this).data('tapel');
			$.ajax({
				type : 'GET',
				url : '../cetak/cetak-spp-belakang.php',
				data :  'pdid='+pdid+'&tapel='+tapel,
				success: function (response) {
					printSPPB();												
				}
			});
			//PopupCenter('../cetak/cetak-kartu.php?idspp='+uidspp, 'myPop1',800,800);
			
		});
});  
function PopupCenter(pageURL, title,w,h) {
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	};
</script>
</body>
</html>