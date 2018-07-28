<br>
<body>
	<h3>Verifikasi Data Mahasiswa</h3>
	<form class="form-inline" action="<?php echo base_url(); ?>skpi/skpi_admin/verifikasi_data_mhs" method="POST">
		<div class="form-group">
	      <label >Nomor Induk Mahasiswa</label>
	      <input type="text" class="form-control" name="nim" value="<?php echo $nim; ?>" required>
	      <button style="vertical-align: middle;" type="submit" class="btn-uin btn-inverse btn-small" name="cek_nim">Cek Data Mahasiswa</button>
	    </div>

	</form>
	<?php if(!$status && $notif!=''){ ?>
	<div class="bs-callout bs-callout-error">
		<p align="center"><?php echo $notif; ?></p>
	</div>
	<?php 	} ?>
	<?php if($status){ ?>
		<h3><?php echo $label_title['idn']; ?></h3>
		<h3><i><?php echo $label_title['en']; ?></i></h3>
		<h3><?php echo $label_title['arb']; ?></h3>
		<div style="padding-left:10px;">
			<table>
				<?php for($i=0; $i<count($mahasiswa); $i++){ ?>

					<tr valign="middle" class="success">
						<td width="30%;" style="vertical-align: middle; padding: 7px;">
							<h4><?php echo $label_detail[$i]['idn']; ?></h4>
							<h5><i><?php echo $label_detail[$i]['en']; ?></i></h5>
							<h5><?php echo $label_detail[$i]['arb']; ?></h5>
						</td>
						<td style="vertical-align: middle; padding: 2px;"><?php echo " : "; ?></td>
						<td style="vertical-align: middle;"><?php echo $mahasiswa[$i]; ?></td>
					</tr>
				<?php } ?>
		</div>
		<div>
			<table class="table">
				<tr><td align="right"><?php echo anchor('skpi/skpi_admin/verifikasi_data_cp', 'Selanjutnya', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td></tr>
			</table>
		</div>
		
	<?php } ?>

</body>