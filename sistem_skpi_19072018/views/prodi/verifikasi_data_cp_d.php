<?php 
	$cek_notice = 'X0X';
	if(isset($notice)){
		$cek_notice = $notice;
	}
 ?>

<br>
<body>
	<div>
		<h3><?php echo $label_title['idn']; ?></h3>
		<h3><i><?php echo $label_title['en']; ?></i></h3>
		<h3><?php echo $label_title['arb']; ?></h3>
	</div>
<?php if($label_prodi['status']==1){ ?>
<div>
	<?php if($sts_skpi){ ?>
		<div class="bs-callout bs-callout-warning">Verifikasi <i><?php echo $label_title['idn']; ?></i>  Tidak Aktif untuk Sdr. <?php echo $label_prodi['nama']; ?></div>
	<?php }else{ ?>
		<div class="bs-callout bs-callout-warning">Verifikasi <i><?php echo $label_title['idn']; ?></i>  Tidak Aktif untuk Prodi <?php echo $label_prodi['nama']; ?></div>
	<?php } ?>
</div>
<?php }else{ ?>
		<?php if($status){ ?>
		<div class="bs-callout bs-callout-success">Menampilkan Data untuk NIM <b><?php echo $nim ?></b> atas nama Sdr/i. <b><?php echo $nama; ?></b></div>
		<?php }else{ ?>
		<div class="bs-callout bs-callout-error">Data <b><?php echo $label_title['idn']; ?></b> untuk NIM <b><?php echo $nim ?></b> atas nama Sdr/i. <b><?php echo $nama; ?></b> tidak ditemukan !</div>
		<?php } ?>
	<div>

		<?php if($status){ ?>
		<?php if(isset($notice)){ ?>
			<div class="container">
				<div class="alert alert-danger">Belum dilakukan verifikasi Informasi Kualifikasi dan Hasil yang Dicapai !</div>
			</div>
		<?php } ?>

		<div class="bs-callout bs-callout-info"><input type="checkbox" name="select_all" id="select_all"> Verifikasi semua data <b>Informasi Kualifikasi dan Hasil yang Dicapai</b></div>

		<form action="<?php echo base_url(); ?>skpi/skpi_prodi/verifikasi_data_cp" method="POST">
		<table class="table table-bordered">
			<?php for ($i=0; $i < count($cp_title); $i++) { 
				?>

			<?php if(isset($cp_konten[$cp_title[$i]['KODE']])){ ?>

				<tr>
					<th><?php echo $cp_title[$i]['IDN'] ?></th>
					<th><i><?php echo $cp_title[$i]['EN'] ?></i></th>
					<?php if(!$status_skpi){ ?><th>Verifikasi</th><?php } ?>
					
				</tr>

				<?php for ($j=0; $j < count($cp_konten[$cp_title[$i]['KODE']]); $j++) { 
					?>
					<tr style="text-align: justify; padding: 5px;">
						<td><?php echo $cp_konten[$cp_title[$i]['KODE']][$j]['IDN']; ?></td>
						<td><i><?php echo $cp_konten[$cp_title[$i]['KODE']][$j]['EN']; ?></i></td>
						<?php if(!$status_skpi){ ?> <td align="center" style="vertical-align: middle;"><input type="checkbox" class="capaian" value="<?php echo $cp_konten[$cp_title[$i]['KODE']][$j]['KODE']; ?>" name="capaian[]" <?php echo $validasi[$cp_konten[$cp_title[$i]['KODE']][$j]['KODE']]; ?>></td> <?php } ?>
					</tr>

				<?php } ?>

				<?php } ?>

				<?php } ?>





		</table>
		<?php if(!$status_skpi){ ?>
		<div class="bs-callout bs-callout-warning">Tekan tombol <b>simpan data capaian</b> sebelum melanjutkan proses verifikasi Surat Keterangan Pendamping Ijazah</div>
		<div align="right">
			<button class="btn-uin btn btn-inverse btn btn-small" name="sv_capaian">Simpan Data Capaian</button>
		</div>
		<?php } ?>
		<br>
		</form>
		<?php } ?>
	<?php } ?>
		<table class="table">
			<tr>
				<td align="left"><?php echo anchor('skpi/skpi_prodi/verifikasi_data_mhs/0', 'Kembali', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
				<td align="right"><?php echo anchor('skpi/skpi_prodi/verifikasi_data_prestasi/', 'Selanjutnya', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
			</tr>
		</table>
	</div>
</body>

<script>
	
	var notice = '<?php echo $cek_notice ?>';
	console.log(notice)

	function unselectall(){
		if(notice == '1'){
			$(".capaian").each(function(){
				this.checked = false;
			});
		}		
	}

	function selectallcek(){
		if(notice != '1'){
			if($('.capaian:checked').length == $(".capaian").length){
				$("#select_all")[0].checked = true;
			}else{
				$("#select_all")[0].checked = false;
			}
		}
	}

	unselectall();
	selectallcek();

	$(document).ready(function(){	
	$("#select_all").on('change', function(){
		var status = this.checked;
		$(".capaian").each(function(){
			this.checked = status;
		})
	});

	$(".capaian").on('change', function(){
		//console.log('danang');
		if($('.capaian:checked').length == $(".capaian").length){
			$("#select_all")[0].checked = true;
		}else{
			$("#select_all")[0].checked = false;
		}
	});
});

</script>