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
		<div class="container">
				<?php $index=0; ?>
			<h3><?php echo $label_kegiatan[$index]; $index++; ?></h3>

				<?php if(isset($pesan_prestasi)){ ?>
				<div class="container">
					<div class="alert alert-danger"><?php echo $pesan_prestasi; ?></div>
				</div>
				<?php
				} ?>

			<form action="<?php echo base_url(); ?>skpi/skpi_admin/verifikasi_data_prestasi" method="POST">
			<table class="table table-bordered">
				<tr>
					<th>No</th>
					<th>Prestasi</th>
					<th>Jenis</th>
					<th>Peringkat</th>
					<th>Penyelenggara</th>
					<th>Tahun</th>
					<th>Keterangan</th>
					<th>Bukti</th>
					<th>Verifikasi</th>
				</tr>
				<?php if(count($dpm_prestasi)==0){ ?>
					<tr>
						<td colspan="9" align="center">Data tidak ditemukan !</td>
					</tr>
				<?php }else{ ?>
					<?php $i=1; ?>
					<?php foreach($dpm_prestasi as $key){ ?>
					<tr align="center">
						<td><?php echo $i; $i++; ?></td>
						<td><?php echo $key['NM_LOMBA']; ?></td>
						<td><?php echo $key['NM_JENIS']; ?></td>
						<td><?php echo $key['NM_PERINGKAT']; ?></td>
						<td><?php echo $key['NM_PENY_LOMBA']; ?></td>
						<td><?php echo $key['THN_BERI']; ?></td>
						<td><?php echo $key['KETERANGAN']; ?></td>
						<td><?php echo anchor('skpi/skpi_admin/sertifikat_kegiatan/'.$key['ID_RIWAYAT'].'/prestasi', 'cek', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
						<td align="center"><input type="checkbox" name="prestasi[]" value="<?php echo $key['ID_RIWAYAT']; ?>" <?php echo $prestasi_valid[$key['ID_RIWAYAT']]; ?> class="form-control"></td>
					</tr>
					<?php } ?>
				<?php } ?>
				
			</table>

			<?php if(count($dpm_prestasi)!=0){ ?>
			<div align="right">
				<button class="btn-uin btn btn-inverse btn btn-small" name="sv_prestasi">Simpan Data Prestasi</button>
			</div>
			<?php } ?>
			</form>
		</div>


		<div class="container">
			<h3><?php echo $label_kegiatan[$index]; $index++; ?></h3>

				<?php if(isset($pesan_organisasi)){ ?>
				<div class="container">
					<div class="alert alert-danger"><?php echo $pesan_organisasi; ?></div>
				</div>
				<?php } ?>
				
			<form action="<?php echo base_url(); ?>skpi/skpi_admin/verifikasi_data_prestasi" method="POST">
			<table class="table table-bordered">
				<tr>
					<th>No</th>
					<th>Nama Organisasi</th>
					<th>Jabatan</th>
					<th>Masa Jabatan</th>
					<th>Tahun</th>
					<th>Bukti</th>
					<th>Verifikasi</th>
				</tr>
				<?php if(count($dpm_org)==0){ ?>
					<tr>
						<td colspan="6" align="center">Data tidak ditemukan !</td>
					</tr>
				<?php }else{ ?>
					<?php $i=1; ?>
					<?php foreach($dpm_org as $key){ ?>
					<tr align="center">
						<td><?php echo $i; $i++; ?></td>
						<td><?php echo $key['NM_ORGANISASI']; ?></td>
						<td><?php echo $key['JABATAN']; ?></td>
						<td><?php echo $key['LAMA']; ?></td>
						<td><?php echo $key['THN_MASUK']; ?></td>
						<td><?php echo anchor('skpi/skpi_admin/sertifikat_kegiatan/'.$key['ID_RIWAYAT'].'/organisasi', 'cek', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
						<td align="center"><input type="checkbox" name="organisasi[]" value="<?php echo $key['ID_RIWAYAT']; ?>" <?php echo $organisasi_valid[$key['ID_RIWAYAT']]; ?> class="form-control"></td>
					</tr>
					<?php } ?>
				<?php } ?>				
			</table>
			<?php if(count($dpm_org)!=0){ ?>
			<div align="right">
				<button class="btn-uin btn btn-inverse btn btn-small" name="sv_organisasi">Simpan Data Organisasi</button>
			</div>
			<?php } ?>
			</form>
		</div>

		<div class="container">
			<h3><?php echo $label_kegiatan[$index]; $index++; ?></h3>
				<?php if(isset($pesan_sertifikasi)){ ?>
					<div class="container">
						<div class="alert alert-danger"><?php echo $pesan_sertifikasi; ?></div>
					</div>
					<?php
				} ?>
			<form action="<?php echo base_url(); ?>skpi/skpi_admin/verifikasi_data_prestasi" method="POST">
				<table class="table table-bordered">
					<tr>
						<th>No</th>
						<th>Nama Kegiatan</th>
						<th>Penyelenggara</th>
						<th>Keterangan</th>
						<th>Bukti</th>
						<th>Verifikasi</th>
					</tr>
					<?php if(count($dpm_sertifikasi)==0){ ?>
						<tr>
							<td colspan="6" align="center">Data tidak ditemukan !</td>
						</tr>
					<?php }else{ ?>
						<?php $i=1; ?>
						<?php foreach($dpm_sertifikasi as $key){ ?>
							<tr align="center">
								<td><?php echo $i; $i++; ?></td>
								<td><?php echo $key['NM_KEGIATAN']; ?></td>
								<td><?php echo $key['NM_PENY_KEGIATAN']; ?></td>
								<td><?php echo $key['KETERANGAN']; ?></td>
								<td><?php echo anchor('skpi/skpi_admin/sertifikat_kegiatan/'.$key['ID_RIWAYAT'].'/sertifikasi', 'cek', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
								<td align="center"><input type="checkbox" name="sertifikasi[]" value="<?php echo $key['ID_RIWAYAT']; ?>" <?php echo $sertifikasi_valid[$key['ID_RIWAYAT']]; ?> class="form-control"></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</table>

				<br>
				<h3><?php echo $label_kegiatan[$index-1].' ( ICT, IKLA dan TOEC )';?></h3>
				<table class="table table-bordered">
					<tr>
						<th>No</th>
						<th>Nama Kegiatan</th>
						<th>Penyelenggara</th>
						<th>Nilai</th>
						<th>Verifikasi</th>
					</tr>
					<?php if(count($uin_sertifikasi)==0){ ?>
						<tr>
							<td colspan="6" align="center">Data tidak ditemukan !</td>
						</tr>
					<?php }else{ ?>
						<?php $i=1; ?>
						<?php foreach($uin_sertifikasi as $key){ ?>
							<tr align="center">
								<td><?php echo $i; $i++; ?></td>
								<td><?php echo $key['NAMA_IDN']; ?></td>
								<td><?php echo $key['PENYELENGGARA']; ?></td>
								<td><?php echo $key['NILAI']; ?></td>
								<td align="center"><input type="checkbox" name="sertifikasi[]" value="<?php echo $key['ID_RIWAYAT']; ?>" <?php echo $sertifikasi_valid_uin[$key['ID_RIWAYAT']]; ?> class="form-control"></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</table>
				<?php if(count($dpm_sertifikasi)!=0 || count($uin_sertifikasi)!=0){ ?>
					<div align="right">
						<button class="btn-uin btn btn-inverse btn btn-small" name="sv_sertifikasi">Simpan Data Sertifikasi</button>
					</div>
				<?php } ?>
			</form>
		</div>

		<div class="container">
			<h3><?php echo $label_kegiatan[$index]; $index++; ?></h3>
				<?php if(isset($pesan_magang)){ ?>
					<div class="container">
						<div class="alert alert-danger"><?php echo $pesan_magang; ?></div>
					</div>
					<?php
				} ?>
			<form action="<?php echo base_url(); ?>skpi/skpi_admin/verifikasi_data_prestasi" method="POST">
				<table class="table table-bordered">
					<tr>
						<th>No</th>
						<th>Nama Kegiatan</th>
						<th>Penyelenggara</th>
						<th>Keterangan</th>
						<th>Bukti</th>
						<th>Verifikasi</th>
					</tr>
					<?php if(count($dpm_magang)==0){ ?>
						<tr>
							<td colspan="6" align="center">Data tidak ditemukan !</td>
						</tr>
					<?php }else{ ?>
						<?php $i=1; ?>
						<?php foreach($dpm_magang as $key){ ?>
							<tr align="center">
								<td><?php echo $i; $i++; ?></td>
								<td><?php echo $key['NM_KEGIATAN']; ?></td>
								<td><?php echo $key['NM_PENY_KEGIATAN']; ?></td>
								<td><?php echo $key['KETERANGAN']; ?></td>
								<td><?php echo anchor('skpi/skpi_admin/sertifikat_kegiatan/'.$key['ID_RIWAYAT'].'/magang', 'cek', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
								<td align="center"><input type="checkbox" name="magang[]" value="<?php echo $key['ID_RIWAYAT']; ?>" <?php echo $magang_valid[$key['ID_RIWAYAT']]; ?> class="form-control"></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</table>
				<?php if(count($dpm_magang)!=0){ ?>
					<div align="right">
						<button class="btn-uin btn btn-inverse btn btn-small" name="sv_magang">Simpan Data Magang</button>
					</div>
				<?php } ?>
			</form>
			
		</div>


		<div class="container">
			<h3><?php echo $label_kegiatan[$index]; $index++; ?></h3>
				<?php if(isset($pesan_kegiatan)){ ?>
					<div class="container">
						<div class="alert alert-danger"><?php echo $pesan_kegiatan; ?></div>
					</div>
					<?php
				} ?>
			<form action="<?php echo base_url(); ?>skpi/skpi_admin/verifikasi_data_prestasi" method="POST">
				<table class="table table-bordered">
					<tr>
						<th>No</th>
						<th>Nama Kegiatan</th>
						<th>Penyelenggara</th>
						<th>Keterangan</th>
						<th>Bukti</th>
						<th>Verifikasi</th>
					</tr>
					<?php if(count($dpm_karakter)==0){ ?>
						<tr>
							<td colspan="6" align="center">Data tidak ditemukan !</td>
						</tr>
					<?php }else{ ?>
						<?php $i=1; ?>
						<?php foreach($dpm_karakter as $key){ ?>
							<tr align="center">
								<td><?php echo $i; $i++; ?></td>
								<td><?php echo $key['NM_KEGIATAN']; ?></td>
								<td><?php echo $key['NM_PENY_KEGIATAN']; ?></td>
								<td><?php echo $key['KETERANGAN']; ?></td>
								<td><?php echo anchor('skpi/skpi_admin/sertifikat_kegiatan/'.$key['ID_RIWAYAT'].'/kegiatan', 'cek', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
								<td align="center"><input type="checkbox" name="karakter[]" value="<?php echo $key['ID_RIWAYAT']; ?>" <?php echo $karakter_valid[$key['ID_RIWAYAT']]; ?> class="form-control"></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</table>
				<?php if(count($dpm_karakter)!=0){ ?>
					<div align="right">
						<button class="btn-uin btn btn-inverse btn btn-small" name="sv_karakter">Simpan Data Pendidikan Karakter</button>
					</div>
				<?php } ?>
			</form>
			
		</div>
<?php } ?>

		<div>
			<table class="table">
				<tr>
					<td align="left"><?php echo anchor('skpi/skpi_admin/verifikasi_data_cp', 'Kembali', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
					<td align="right"><?php echo anchor('skpi/skpi_admin/verifikasi_penulisan/', 'Selanjutnya', array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
				</tr>
			</table>
		</div>
	</div>
</body>
