	<?php $kondisi_kurang = 0; ?>
<br>
<body>
	<div>
		<h3><?php echo ($sts_skpi)?'':'Verifikasi Penulisan '; echo $label_title['idn']; ?></h3>
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

	<?php if($status_prestasi || $status_organisasi || $status_sertifikasi || $status_sertifikasi_uin || $status_magang || $status_karakter){ ?>
		<div class="bs-callout bs-callout-success">Menampilkan Data untuk Sdr. <b><?php echo $nama ?></b> dengan NIM <b><?php echo $nim; ?></b></div>
	<?php }else if(!$status_prestasi && !$status_organisasi){ ?>
		<div class="bs-callout bs-callout-error">Tidak ada data <b><?php echo $label_title['idn']; ?></b> yang tervalidasi untuk NIM <b><?php echo $nim ?></b> atas nama Sdr/i. <b><?php echo $nama; ?></b></div>
	<?php } ?>
	<div>
	<div class="container">
	<?php if($status_prestasi){ ?>
		<div class="container">
			<h3><?php echo $label_kegiatan[0]; ?></h3>
			<table class="table table-bordered">
				<tr>
					<th width="5px">No.</th>
					<th>Indonesia</th>
					<th>Inggris</th>
					<th width="5px">Status</th>
					<?php if(!$sts_skpi && $lvl_petugas!='dokumen'){ ?> <th>Proses</th> <?php } ?>
				</tr>
				<?php $i=1; ?>
				<?php foreach($dpm_prestasi as $key){ ?>
				<tr>
					<td style="vertical-align: middle;"><?php echo $i; $i++; ?></td>
					<td style="vertical-align: middle;"><?php echo $key['NM_LOMBA']; ?></td>
					<td style="vertical-align: middle;"><i><?php echo $key['NM_LOMBA2']; ?></i></td>
					<td style="vertical-align: middle; text-align: center;">
						<?php  if($key['STATUS']=='SUDAH'){ ?>
							<span class="badge badge-success">
								<i class="icon-white icon-ok"></i>
							</span>
						<?php }else{ ?>
							<span class="badge badge-important">
								<i class="icon-white icon-remove"></i>
								<?php $kondisi_kurang++; ?>
							</span>
						<?php } ?>
					</td>
					<?php if(!$sts_skpi && $lvl_petugas!='dokumen'){ ?><td width="5%;" style="vertical-align: middle; text-align: center;"><?php echo anchor('skpi/skpi_prodi/verifikasi_detail_penulisan/'.$key['ID_RIWAYAT'].'/prestasi', 'Verifikasi', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td> <?php } ?>
				</tr>
				<?php } ?>
				
			</table>
		</div>
		<?php } ?>
		<?php if($status_organisasi){ ?>
		<div class="container">
			<h3><?php echo $label_kegiatan[1]; ?></h3>
			<table class="table table-bordered">
				<tr>
					<th width="5px">No.</th>
					<th>Indonesia</th>
					<th>Inggris</th>
					<th width="5px">Status</th>
					<?php if(!$sts_skpi && $lvl_petugas!='dokumen'){ ?> <th>Proses</th> <?php } ?>
				</tr>
				<?php $i=1; ?>
				<?php foreach($dpm_org as $key){ ?>
				<tr>
					<td style="vertical-align: middle;"><?php echo $i; $i++; ?></td>
					<td style="vertical-align: middle;"><?php echo $key['NM_ORGANISASI']; ?></td>
					<td style="vertical-align: middle;"><i><?php echo $key['NM_ORGANISASI2']; ?></i></td>
					<td style="vertical-align: middle; text-align: center;">
						<?php  if($key['STATUS']=='SUDAH'){ ?>
							<span class="badge badge-success">
								<i class="icon-white icon-ok"></i>
							</span>
						<?php }else{ ?>
							<span class="badge badge-important">
								<i class="icon-white icon-remove"></i>
								<?php $kondisi_kurang++; ?>
							</span>
						<?php } ?>
					</td>
					<?php if(!$sts_skpi && $lvl_petugas!='dokumen'){ ?> <td width="5%;" style="vertical-align: middle; text-align: center;"><?php echo anchor('skpi/skpi_prodi/verifikasi_detail_penulisan/'.$key['ID_RIWAYAT'].'/organisasi', 'Verifikasi', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td> <?php } ?>
				</tr>
				<?php } ?>
				
			</table>
		</div>
		<?php } ?>

		<?php if($status_sertifikasi){ ?>
		<div class="container">
			<h3><?php echo $label_kegiatan[2]; ?></h3>
			<table class="table table-bordered">
				<tr>
					<th width="5px">No.</th>
					<th>Indonesia</th>
					<th>Inggris</th>
					<th width="5px">Status</th>
					<?php if(!$sts_skpi && $lvl_petugas!='dokumen'){ ?> <th>Proses</th> <?php } ?>
				</tr>
				<?php $i=1; ?>
				<?php foreach($dpm_sertifikasi as $key){ ?>
				<tr>
					<td style="vertical-align: middle;"><?php echo $i; $i++; ?></td>
					<td style="vertical-align: middle;"><?php echo $key['NM_KEGIATAN']; ?></td>
					<td style="vertical-align: middle;"><i><?php echo $key['NM_KEGIATAN2']; ?></i></td>
					<td style="vertical-align: middle; text-align: center;">
						<?php  if($key['STATUS']=='SUDAH'){ ?>
							<span class="badge badge-success">
								<i class="icon-white icon-ok"></i>
							</span>
						<?php }else{ ?>
							<span class="badge badge-important">
								<i class="icon-white icon-remove"></i>
								<?php $kondisi_kurang++; ?>
							</span>
						<?php } ?>
					</td>
					<?php if(!$sts_skpi && $lvl_petugas!='dokumen'){ ?><td width="5%;" style="vertical-align: middle; text-align: center;"><?php echo anchor('skpi/skpi_prodi/verifikasi_detail_penulisan/'.$key['ID_RIWAYAT'].'/sertifikasi', 'Verifikasi', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td> <?php } ?>
				</tr>
				<?php } ?>
				
			</table>
		</div>
		<?php } ?>

		<?php if($status_sertifikasi_uin){ ?>
		<div class="container">
			<h3><?php echo $label_kegiatan[2].' ( ICT, IKLA dan TOEC )'; ?></h3>
			<table class="table table-bordered">
				<tr>
					<th width="5px">No.</th>
					<th>Indonesia</th>
					<th>Inggris</th>
					<th width="5px">Status</th>
					<?php if(!$sts_skpi && $lvl_petugas!='dokumen'){ ?> <th>Proses</th> <?php } ?>
				</tr>
				<?php $i=1; ?>
				<?php foreach($uin_sertifikasi as $key){ ?>
				<tr>
					<td style="vertical-align: middle;"><?php echo $i; $i++; ?></td>
					<td style="vertical-align: middle;"><?php echo $key['NAMA_IDN']; ?></td>
					<td style="vertical-align: middle;"><i><?php echo $key['NAMA_EN']; ?></i></td>
					<td style="vertical-align: middle; text-align: center;">
						<span class="badge badge-success">
							<i class="icon-white icon-ok"></i>
						</span>
					</td>
					<?php if(!$sts_skpi && $lvl_petugas!='dokumen'){ ?><td width="5%;" style="vertical-align: middle; text-align: center;"><button class="btn-uin btn btn-small btn btn-inverse" disabled>Verifikasi</button></td> <?php } ?>
				</tr>
				<?php } ?>
				
			</table>
		</div>
		<?php } ?>

		<?php if($status_magang){ ?>
		<div class="container">
			<h3><?php echo $label_kegiatan[3]; ?></h3>
			<table class="table table-bordered">
				<tr>
					<th width="5px">No.</th>
					<th>Indonesia</th>
					<th>Inggris</th>
					<th width="5px">Status</th>
					<?php if(!$sts_skpi && $lvl_petugas!='dokumen'){ ?> <th>Proses</th> <?php } ?>
				</tr>
				<?php $i=1; ?>
				<?php foreach($dpm_magang as $key){ ?>
				<tr>
					<td style="vertical-align: middle;"><?php echo $i; $i++; ?></td>
					<td style="vertical-align: middle;"><?php echo $key['NM_KEGIATAN']; ?></td>
					<td style="vertical-align: middle;"><i><?php echo $key['NM_KEGIATAN2']; ?></i></td>
					<td style="vertical-align: middle; text-align: center;">
						<?php  if($key['STATUS']=='SUDAH'){ ?>
							<span class="badge badge-success">
								<i class="icon-white icon-ok"></i>
							</span>
						<?php }else{ ?>
							<span class="badge badge-important">
								<i class="icon-white icon-remove"></i>
								<?php $kondisi_kurang++; ?>
							</span>
						<?php } ?>
					</td>
					<?php if(!$sts_skpi && $lvl_petugas!='dokumen'){ ?><td width="5%;" style="vertical-align: middle; text-align: center;"><?php echo anchor('skpi/skpi_prodi/verifikasi_detail_penulisan/'.$key['ID_RIWAYAT'].'/magang', 'Verifikasi', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td> <?php } ?>
				</tr>
				<?php } ?>			
			</table>
		</div>
		<?php } ?>

		<?php if($status_karakter){ ?>
		<div class="container">
			<h3><?php echo $label_kegiatan[4]; ?></h3>
			<table class="table table-bordered">
				<tr>
					<th width="5px">No.</th>
					<th>Indonesia</th>
					<th>Inggris</th>
					<th width="5px">Status</th>
					<?php if(!$sts_skpi && $lvl_petugas!='dokumen'){ ?> <th>Proses</th> <?php } ?>
				</tr>
				<?php $i=1; ?>
				<?php foreach($dpm_karakter as $key){ ?>
				<tr>
					<td><?php echo $i; $i++; ?></td>
					<td><?php echo $key['NM_KEGIATAN']; ?></td>
					<td><i><?php echo $key['NM_KEGIATAN2']; ?></i></td>
					<td style="vertical-align: middle; text-align: center;">
						<?php  if($key['STATUS']=='SUDAH'){ ?>
							<span class="badge badge-success">
								<i class="icon-white icon-ok"></i>
							</span>
						<?php }else{ ?>
							<span class="badge badge-important">
								<i class="icon-white icon-remove"></i>
								<?php $kondisi_kurang++; ?>
							</span>
						<?php } ?>
					</td>
					<?php if(!$sts_skpi && $lvl_petugas!='dokumen'){ ?><td width="5%;" style="vertical-align: middle; text-align: center;"><?php echo anchor('skpi/skpi_prodi/verifikasi_detail_penulisan/'.$key['ID_RIWAYAT'].'/kegiatan', 'Verifikasi', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td> <?php } ?>
				</tr>
				<?php } ?>			
			</table>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
	<?php if($lvl_petugas=='all' || $lvl_petugas=='dokumen'){ ?>
		<div>
			<table class="table">
				<tr>
					<?php if($sts_skpi){ ?>
						<td align="left"><?php echo anchor('skpi/skpi_prodi/verifikasi_data_cp', 'Kembali', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
					<?php }else{ ?>
						<td align="left"><?php echo anchor('skpi/skpi_prodi/verifikasi_data_prestasi', 'Kembali', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
					<?php } ?>
					<td align="right">
						<?php if($kondisi_kurang<=0){ ?>
						<?php echo anchor('skpi/skpi_prodi/verifikasi_akhir/', 'Selanjutnya', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?>
						<?php }else{ ?>
							<button class="btn-uin btn btn-small btn btn-inverse" disabled>Selanjutnya</button>
						<?php } ?>
							
					</td>
				</tr>
			</table>
		</div>
	<?php } ?>
	</div>
</body>