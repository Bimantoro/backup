<br>
<body>
	<div class="container">
		<div>
			<form action="<?php echo base_url(); ?>skpi/skpi_admin/verifikasi_detail_penulisan" method="POST" id='form_saran'>
			<h3>Detail <?php echo $judul; ?></h3>
			<table class="table table-bordered">
			<?php foreach($kegiatan as $key => $value){ ?>
				<tr>
					<th width="30%;"><?php echo $key; ?></th>
					<td><?php echo $value; ?></td>
				</tr>
			<?php } ?>
				<tr>
					<th style="vertical-align: middle;">SARAN PENULISAN</th>
					<td style="vertical-align: middle;">
						<textarea class="form-control" id="saran" name="saran" cols="100" form="form_saran" <?php echo $readonly; ?> ><?php echo $skpi_saran; ?></textarea>
					</td>
				</tr>
				<tr>
					<th style="vertical-align: middle;">VERIFIKASI</th>
					<td style="vertical-align: middle;"><input type="checkbox" <?php echo $sts; ?> name="cx_verifikasi" id="cx_verifikasi" onchange="disable_saran();">  Penulisan Data <?php echo $judul; ?> Sudah Benar</td>
				</tr>
			</table>
			<br>

			<div hidden>
				<input type="text" name="id_k" value="<?php echo $kegiatan['ID']; ?>">
				<input type="text" id="status_data" name="status_data" value="<?php echo $status_data; ?>">
			</div>
<!-- 			<div class="form-group">
				<label><b>Saran</b></label>
				<textarea class="form-control" name="saran" cols="100" form="form_saran"><?php echo $skpi_saran; ?></textarea>
			</div> -->
			<div align="right"><button class="btn-uin btn btn-inverse btn btn-small" type="submit" name="sv_saran">Simpan</button></div>
			</form>
		</div>
	</div>
</body>

<script type="text/javascript">
	function disable_saran(){
		if(form_saran.cx_verifikasi.checked==true){
			//return confirm('Apakah anda yakin bahwa penulisan data <?php echo $judul; ?> Sudah benar ?');
			$("#saran").prop("readonly", true);
			form_saran.saran.value='Penulisan Data Sudah Benar';
			form_saran.status_data.value='1';
		}else{
			$("#saran").prop("readonly", false);
			form_saran.saran.value='Penulisan Belum sesuai, masukkan saran kemudian simpan !';
			form_saran.status_data.value='0';
		}		
	}
</script>