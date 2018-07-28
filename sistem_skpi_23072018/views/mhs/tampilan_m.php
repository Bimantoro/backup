<?php
	$arr1 = array(	'app_text' 	=> 'Surat Keterangan Pendamping Ijazah', 
					'app_name' 	=> $string_skpi[0].' Mahasiswa', 
					'app_url'	=> 'skpi/skpi_mhs/');

	$this->s00_lib_output->output_info_mhs($arr1);
?> 

<body>
	<br>

<!-- 	<div>
		<?php if($status==1){ ?>
		<div class="bs-callout bs-callout-success">Surat Keterangan Pendamping Ijazah untuk NIM <?php echo $mhs['NIM']; ?> sudah diverifikasi, silahkan tekan tombol cetak untuk mencetak dokumen Surat Keterangan Pendamping Ijazah</b>
			<br>
			<br>
			<?php echo anchor('skpi/skpi_mhs/cetak', 'Cetak Surat Keterangan Pendamping Ijazah', array('class' => 'btn-uin btn btn-inverse btn btn-small', 'target' => '_blank')); ?>

		</div>
		<?php }else{ ?>
		<div class="bs-callout bs-callout-error">Surat Keterangan Pendamping Ijazah untuk NIM <?php echo $mhs['NIM']; ?> belum dilakukan diverifikasi, silahkan informasi lebih lanjut silahkan hubungi pihak program studi</b></div>
		<?php } ?>
	</div> -->
	<div>		
		<ul id="crumbs">
			<li><a href="<?php echo base_url(); ?>" title="Beranda">Beranda</a></li>
			<li>Daftar <?php echo $string_skpi[0]; ?></li></ul>
	</div>
	<!-- PERTAMA YANG HARUS DICEK ADALAH SYARAT PENDAFTARAN, JIKA TIDAK ADA MAKA TIDAK BISA DAFTAR | ADMIN AKADEMIK HARUS MENGISI SYARATNYA TERLEBIH DAHULU : -->
	<?php if($BATAL_DAFTAR == 0){ ?>
	<?php if(!empty($SYARAT_DAFTAR['SYARAT'])){ ?>
	<div>
		<h2>Alur Pendaftaran <?php echo $string_skpi[0]; ?></h2>
		<?php if($STS_SKPI == 'BELUM'){ ?>
		<ol class="progtrckr" data-progtrckr-steps="2">
			<li class="progtrckr-onprogress number1">Daftar Verifikasi <?php echo $string_skpi[0]; ?></li><!--
			--><li class="progtrckr-todo number2">Verifikasi <?php echo $string_skpi[0]; ?></li>
		</ol>
		<?php }else if($STS_SKPI==0){ ?>
		<br>
		<ol class="progtrckr" data-progtrckr-steps="2">
			<li class="progtrckr-done number1">Daftar Verifikasi <?php echo $string_skpi[0]; ?></li><!--
			--><li class="progtrckr-onprogress number2">Verifikasi <?php echo $string_skpi[0]; ?></li>
		</ol>
		<?php }else{ ?>
		<ol class="progtrckr" data-progtrckr-steps="2">
			<li class="progtrckr-done number1">Daftar Verifikasi <?php echo $string_skpi[0]; ?></li><!--
			--><li class="progtrckr-done number2">Verifikasi <?php echo $string_skpi[0]; ?></li>
		</ol>
		<?php } ?>

		<!-- MEMUNCULKAN NOTIFNYA -->

		<?php if(!empty($KEGIATAN[0])){ ?>

		<?php if($STS_SKPI == 'BELUM'){ ?>
		<?php if($SYARAT_DAFTAR['STATUS'] == 1){ ?>
				<div class="bs-callout bs-callout-on-progress">
					<p><b><?php echo $NAMA; ?></b>, silahkan melakukan pengecekan data aktivitas sebelum melakukan pendaftaran proses verifikasi <?php echo $string_skpi[0]; ?>. Jika terdapat perubahan pada data silahkan dilakukan update dari halaman <b>Data Pribadi Mahasiswa</b>.</p>

					<br>
					<p>Silahkan tekan tombol daftar untuk melakukan pendaftaran verifikasi <?php echo $string_skpi[0]; ?></p>
					<br>
					<p><?php echo anchor('skpi/skpi_mhs/verifikasi_pendaftaran', 'Daftar', array('class' => 'btn-uin btn btn-small btn btn-inverse')); ?></p>
				</div>
			<?php }else{ ?>
				<div class="bs-callout bs-callout-error">
					<p>	Mohon Maaf <b><?php echo $NAMA; ?></b>, Anda belum dapat melakukan Pendaftaran Verifikasi <?php echo $string_skpi[0]; ?>, karena ada syarat-syarat yang belum terpenuhi, sebagai berikut :</p>
				</div>
			<?php } ?>
		<?php }else if($STS_SKPI==0){ ?>


		<div class="bs-callout bs-callout-on-progress">
			<p>Verifikasi <?php echo $string_skpi[0]; ?> <b><?php echo $NAMA; ?></b> sedang dalam proses, untuk informasi lebih lanjut silahkan hubungi petugas Program Studi.</p>
		</div>

		<?php }else{ ?>

		<div class="bs-callout bs-callout-success">
			<p>Selamat <b><?php echo $NAMA; ?></b>, <?php echo $string_skpi[0]; ?> sudah berhasil di verifikasi.</p>
			<br>
			<p>
				<?php echo anchor(base_url('/skpi/skpi_mhs/cetak'), 'Cetak Draft '.$string_skpi[0], array('class' => 'btn-uin btn btn-small btn-inverse', 'target' => '_blank')); ?>
			</p>
		</div>

		<?php } ?>

		<?php }else{ ?>
			<div class="bs-callout bs-callout-error">
				<p>Label Surat Keterangan Pendamping Ijazah Tidak ditemukan !</p>
			</div>
		<?php } ?>

		<?php if($STS_SKPI == 'BELUM'){ ?>
			<?php if($SYARAT_DAFTAR['SYARAT']){ ?>
				<div>
					<h2>Syarat Pendaftaran Verifikasi</h2>
					<table class="table table-bordered">
						<tr>
							<td width="5px" style="text-align: center; vertical-align: middle;"><b>No.</b></td>
							<td width="300px" style="text-align: center; vertical-align: middle;"><b>Syarat</b></td>
							<td width="300px" style="text-align: center; vertical-align: middle;"><b>Isi</b></td>
							<td width="130px" style="text-align: center; vertical-align: middle;"><b>Hubungi</b></td>
							<td width="5px" style="text-align: center; vertical-align: middle;"><b>Status</b></td>
						</tr>
						<?php $nbr = 1; ?>
						<?php foreach ($SYARAT_DAFTAR['SYARAT'] as $s): ?>
							<tr>
								<td style="text-align: center; vertical-align: middle;"> <?php echo $nbr; $nbr++; ?>.</td>
								<td style="vertical-align: middle;"> <?php echo $s['TITLE'].' = '.$s['SYARAT']; ?></td>
								<td style="vertical-align: middle;"> <?php echo $s['NILAI']; ?></td>
								<td style="vertical-align: middle; text-align: center;"> <?php echo $s['KONTAK']; ?></td>
								<td style="vertical-align: middle; text-align: center;">
									<?php if($s['STATUS'] == 1){ ?>
										<span class="badge badge-success"> <i class="icon-white icon-ok"></i></span>
									<?php }else{ ?>
										<span class="badge badge-important"> <i class="icon-white icon-remove"></i></span>
									<?php } ?>
									
								</td>
							</tr>
						<?php endforeach ?>
					</table>
				</div>
			<?php } ?>
		<?php } ?>	


		<?php if(isset($KEGIATAN[0])){ ?>
		<div>
			<h2>Data <?php 	echo $KEGIATAN[0]['idn']; ?></h2>

			<table class="table table-bordered">
				<tr>
					<td rowspan="2" width="5px" style="text-align: center; vertical-align: middle;"><b>No.</b></td>
					<td rowspan="2" width="200px" style="text-align: center; vertical-align: middle;"><b>Kegiatan</b></td>
					<td colspan="2" style="text-align: center; vertical-align: middle;"><b>Isi</b></td>
					<td rowspan="2" width="5px" style="text-align: center; vertical-align: middle;"><b>Status</b></td>
				</tr>
				<tr>
					<td style="text-align: center; vertical-align: middle;"><b>Indonesia</b></td>
					<td style="text-align: center; vertical-align: middle;"><b>Inggris</b></td>
				</tr>
				<!-- satu label memungkinkan menggunakan 2 row -->
				<?php //$nomer_urut = 1; ?>
				<?php for ($i=0; $i < count($KEGIATAN[1]); $i++) { ?>
					<?php $jml_data = count($KEGIATAN[2][$i]); ?>
					<?php for($j=0; $j < $jml_data; $j++){ ?>
						<?php if($j==0){ ?>
							<tr>
								<td rowspan="<?php echo $jml_data; ?>" style="text-align: center;"><?php echo $i+1; ?>.</td>
								<td rowspan="<?php echo $jml_data; ?>"><?php echo $KEGIATAN[1][$i]['idn']; ?> <?php if($STS_SKPI == 'BELUM'){ ?> <hr> <a href="<?php echo $LINK_DPM[$i]; ?>" ><i style="color: #1a0dab;">Perbaiki Data</i></a> <?php } ?></td>
								<td><?php echo ($KEGIATAN[2][$i][$j]['IDN']=='')?'-':$KEGIATAN[2][$i][$j]['IDN']; ?></td>
								<td><i><?php echo ($KEGIATAN[2][$i][$j]['EN']=='')?'-':$KEGIATAN[2][$i][$j]['EN']; ?></i></td>
								<td rowspan="<?php echo $jml_data; ?>" style="text-align: center; vertical-align: middle;">
									<?php if($KEGIATAN[3][$i] == 1){ ?>
										<span class="badge badge-success"> <i class="icon-white icon-ok"></i></span>
									<?php }else{ ?>
										<span class="badge badge-important"> <i class="icon-white icon-remove"></i></span>
									<?php } ?>
								</td>
							</tr>
						<?php }else{ ?>
							<tr>
								<td><?php echo ($KEGIATAN[2][$i][$j]['IDN']=='')?'-':$KEGIATAN[2][$i][$j]['IDN']; ?></td>
								<td><i><?php echo ($KEGIATAN[2][$i][$j]['EN']=='')?'-':$KEGIATAN[2][$i][$j]['EN']; ?></i></td>
							</tr>
						<?php } ?>
					<?php } ?>
				<?php } ?>
				
			</table>
		</div>
		<?php } ?>
	</div>
	<div>
		<strong>Keterangan</strong>
		<table style="margin: 5px 0 30px 0;">
			<tbody>
				<tr style="margin: 10px;"><td colspan="2" style="height:7px;"></td></tr>
				<tr>
				<td style=""><span class="badge badge-success"> <i class="icon-white icon-ok"></i></span></td>
				<td style="">&nbsp; : Syarat sudah lengkap</td>
				</tr>

				<tr style="margin: 10px;"><td colspan="2" style="height:7px;"></td></tr>
				<tr>
				<td style=""><span class="badge badge-important"> <i class="icon-white icon-remove"></i></span></td>
				<td style="">&nbsp; : Syarat <b>BELUM</b> lengkap. Silahkan lengkapi penulisan <i>(multilingual)</i> data kegiatan atau hubungi petugas</td>
				</tr>
			</tbody>
		</table>
	</div>

	<?php }else{ ?>
		<div>
			<h2>Alur Pendaftaran <?php echo $string_skpi[0]; ?></h2>
			<ol class="progtrckr" data-progtrckr-steps="2">
				<li class="progtrckr-todo number1">Daftar Verifikasi <?php echo $string_skpi[0]; ?></li><!--
				--><li class="progtrckr-todo number2">Verifikasi <?php echo $string_skpi[0]; ?></li>
			</ol>

			<div class="bs-callout bs-callout-todo">
					<p>	Mohon Maaf <b><?php echo $NAMA; ?></b>, Anda belum dapat melakukan Pendaftaran Verifikasi <?php echo $string_skpi[0]; ?>, karena Syarat pendaftaran verifikasi Surat Ket. Pendamping Ijazah belum ada untuk Program Studi anda. Silahkan menghubungi petugas</p>
			</div>
		</div>
	<?php } ?>
	<?php }else{ ?>
		<div>
			<h2>Alur Pendaftaran <?php echo $string_skpi[0]; ?></h2>
			<ol class="progtrckr" data-progtrckr-steps="2">
				<li class="progtrckr-done number1">Daftar Verifikasi <?php echo $string_skpi[0]; ?></li><!--
				--><li class="progtrckr-onprogress number2">Verifikasi <?php echo $string_skpi[0]; ?></li>
			</ol>

			<div class="bs-callout bs-callout-on-progress">
					<p>	Mohon Maaf <b><?php echo $NAMA; ?></b>, pendaftaran verifikasi <?php echo $string_skpi[0]; ?> <b>DIBATALKAN</b> dengan keterangan sebagai berikut : </p>
					<br>
					<p>
						<div class="jumbotron" style="background-color: white; border-radius: 5px; padding: 10px;">
							<table class="table table-bordered" style="border: 0px solid black; margin: 0px;">
								<tr>
									<td style="border: 1px;"><i><?php echo ($BATAL_DAFTAR_PESAN=='')?'Tidak Ada Keterangan !':$BATAL_DAFTAR_PESAN; ?></i></td>
								</tr>
							</table>
						</div>
					</p>
					<br>
					<p>Silahkan tekan tombol berikut untuk melakukan daftar ulang verifikasi <?php echo $string_skpi[0]; ?></p>
					<br>
					<p><?php echo anchor('skpi/skpi_admin/proses_daftar_ulang', 'Daftar Ulang Verifikasi', array('class' => 'btn-uin btn btn-small btn btn-inverse')); ?></p>
			</div>
		</div>
	<?php } ?>	
</body>
