<br>
<body>
	
	<div class="container">
		<div class="form-group"><h2><?php echo $mahasiswa[0]['idn']; ?></h2></div>
		<hr>
		<div>
			<table class="table table-bordered table table-hover">
				<?php  for ($i=0; $i < count($mahasiswa[1]); $i++) { 
					?>
						<tr>
							<th width="25%;"><?php echo $mahasiswa[1][$i]['idn']; ?></th>
							<td><?php echo $mahasiswa[2][$i]; ?></td>
						</tr>
					<?php
				}?>
			</table>
		</div>
	</div>


	<?php if($capaian['status'] && $capaian[3]==1){ ?>
		<div class="container">
			<div class="form-group"><h2><?php echo $capaian[0]['idn']; ?></h2></div>
			<hr>
			<div>
				<table class="table table-bordered table table-hover" cellpadding="10px;">
					<?php for ($i=0; $i < count($capaian[1]); $i++) { 
						if(isset($capaian[2][$capaian[1][$i]['KODE']])){
							?>

							<tr>
								<th><?php echo $capaian[1][$i]['IDN'] ?></th>
								<th><i><?php echo $capaian[1][$i]['EN'] ?></i></th>
							</tr>

							<?php for ($j=0; $j < count($capaian[2][$capaian[1][$i]['KODE']]); $j++) { 
								?>
									<tr>
										<td  style="padding-left: 20px;"><?php echo $capaian[2][$capaian[1][$i]['KODE']][$j]['IDN']; ?></td>
										<td  style="padding-left: 20px;"><i><?php echo $capaian[2][$capaian[1][$i]['KODE']][$j]['EN']; ?></i></td>
									</tr>

								<?php
							} ?>

							<?php
						}
					} ?>
				</table>
			</div>
		</div>
	<?php } ?>



	<?php if($status_kegiatan[0] || $status_kegiatan[1] || $status_kegiatan[2] || $status_kegiatan[3] || $status_kegiatan[4]){ ?>
	<?php if($kegiatan[3]==1){ ?>
	<div class="container">
		<div class="form-group"><h2><?php echo $kegiatan[0]['idn']; ?></h2></div>
		<hr>
		<?php for ($i=0; $i < count($kegiatan[1]); $i++) {
			?>
				<?php if($status_kegiatan[$i]){ ?>
				<div class="container">
					<div>
						<table class="table table-bordered table table-hover">
							<tr>
								<th><?php echo $kegiatan[1][$i]['idn']; ?></th>
								<th><i><?php echo $kegiatan[1][$i]['en']; ?></i></th>
							</tr>
							<?php for ($j=0; $j < count($kegiatan[2][$i]); $j++) { 
								?>
							<tr>
								<td  style="padding-left: 20px;"><?php echo ($kegiatan[2][$i][$j]['IDN']=='')?'-':$kegiatan[2][$i][$j]['IDN']; ?></td>
								<td  style="padding-left: 20px;"><i><?php echo ($kegiatan[2][$i][$j]['EN']=='')?'-':$kegiatan[2][$i][$j]['EN']; ?></i></td>
							</tr>
								<?php
							} ?>
						</table>
						<br>
					</div>
				</div>
				<?php } ?>

			<?php
			
		} ?>
	</div>
	<?php } ?>
	<?php } ?>

	<?php if(!$sts_skpi){  ?>
	<div class="container">
		<div style="padding: 2%;">
			<div style="border-radius: 5px; background-color: #d0e9c6;">
				<div style="padding: 10px;">
				<form action="<?php echo base_url(); ?>skpi/skpi_prodi/verifikasi_akhir" method="POST" id="form_verifikasi">
					<table>
						<tr style="padding: 5px;">
							<td><input type="checkbox" name="cx_persetujuan" required id="checkbox_verifikasi" onchange="enable_sv_validasi();"></td>
							<td style="padding: 5px;"><b> Saya Setuju</b>, Data Surat Keterangan Pendamping Ijazah untuk mahasiswa dengan NIM <b><?php echo $mahasiswa[2][2]; ?></b> sudah benar dan dapat dipertanggung jawabkan.</td>
						</tr>
					</table>
					<br>
					<div align="center">
						<button class="btn-uin btn btn-inverse btn btn-small" name="sv_validasi" type="submit" id="btn_verifikasi" disabled>Validasi Data Surat Keterangan Pendamping Ijazah</button>
					</div>
				</form>		
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<div>
		<table class="table">
			<tr>
				<td align="left"><?php echo anchor('skpi/skpi_prodi/verifikasi_penulisan', 'kembali', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
			</tr>
		</table>
	</div>
	
</body>




<script type="text/javascript">
	function enable_sv_validasi(){
		if(form_verifikasi.btn_verifikasi.disabled==true){
			form_verifikasi.btn_verifikasi.disabled=false;
			return confirm('Setelah dilakukan validasi, Data Surat Keterangan Pendamping Ijazah untuk mahasiswa dengan NIM <?php echo $mahasiswa[2][2]; ?> tidak dapat di ubah !');
		}else{
			form_verifikasi.btn_verifikasi.disabled=true;
		}
	}
</script>