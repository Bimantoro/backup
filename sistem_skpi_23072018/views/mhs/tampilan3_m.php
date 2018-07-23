<?php
	$arr1 = array(	'app_text' 	=> 'Surat Keterangan Pendamping Ijazah', 
					'app_name' 	=> 'SKPI Mahasiswa', 
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
			<li>Daftar SKPI</li></ul>
	</div>
	<div>
		<h2>Alur Pendaftaran Verifikasi Surat Ket. Pendamping Ijazah</h2>
		<?php if($STS_SKPI == 'BELUM'){ ?>
		<ol class="progtrckr" data-progtrckr-steps="2">
			<li class="progtrckr-onprogress number1">Daftar Verifikasi SKPI</li><!--
			--><li class="progtrckr-todo number2">Verifikasi SKPI</li>
		</ol>
		<?php } else { redirect(base_url('/skpi/skpi_mhs/daftar_skpi'));} ?>

		<!-- MEMUNCULKAN NOTIFNYA -->
		<?php if($STS_SKPI == 'BELUM'){ ?>
		<form action="<?php echo base_url(); ?>/skpi/skpi_mhs/daftar_skpi" method="POST" id='formulir_ver'>
		<div class="bs-callout bs-callout-on-progress">
			<div>
				<h2>Data <?php 	echo $KEGIATAN[0]['idn']; ?></h2>

				<table class="table" style="border:1px solid black;">
					<tr>
						<td rowspan="2" width="5px" style="text-align: center; vertical-align: middle; border:1px solid black;"><b>No.</b></td>
						<td rowspan="2" width="200px" style="text-align: center; vertical-align: middle; border:1px solid black;"><b>Kegiatan</b></td>
						<td colspan="2" style="text-align: center; vertical-align: middle; border:1px solid black;"><b>Isi</b></td>
						<td rowspan="2" width="5px" style="text-align: center; vertical-align: middle; border:1px solid black;"><b>Status</b></td>
					</tr>
					<tr>
						<td style="text-align: center; vertical-align: middle; border:1px solid black;"><b>Indonesia</b></td>
						<td style="text-align: center; vertical-align: middle; border:1px solid black;"><b>Inggris</b></td>
					</tr>
					<!-- satu label memungkinkan menggunakan 2 row -->
					<?php //$nomer_urut = 1; ?>
					<?php for ($i=0; $i < count($KEGIATAN[1]); $i++) { ?>
						<?php $jml_data = count($KEGIATAN[2][$i]); ?>
						<?php for($j=0; $j < $jml_data; $j++){ ?>
							<?php if($j==0){ ?>
								<tr>
									<td rowspan="<?php echo $jml_data; ?>" style="border:1px solid black;"><?php echo $i+1; ?>.</td>
									<td rowspan="<?php echo $jml_data; ?>" style="border:1px solid black;"><?php echo $KEGIATAN[1][$i]['idn']; ?></td>
									<td style="border:1px solid black;"><?php echo ($KEGIATAN[2][$i][$j]['IDN']=='')?'-':$KEGIATAN[2][$i][$j]['IDN']; ?></td>
									<td style="border:1px solid black;"><i><?php echo ($KEGIATAN[2][$i][$j]['EN']=='')?'-':$KEGIATAN[2][$i][$j]['EN']; ?></i></td>
									<td rowspan="<?php echo $jml_data; ?>" style="text-align: center; vertical-align: middle; border:1px solid black;"><span class="badge badge-info"><i class="icon-white icon-info"></i></span></td>
								</tr>
							<?php }else{ ?>
								<tr>
									<td style="border:1px solid black;"><?php echo ($KEGIATAN[2][$i][$j]['IDN']=='')?'-':$KEGIATAN[2][$i][$j]['IDN']; ?></td>
									<td style="border:1px solid black;"><i><?php echo ($KEGIATAN[2][$i][$j]['EN']=='')?'-':$KEGIATAN[2][$i][$j]['EN']; ?></i></td>
								</tr>
							<?php } ?>
						<?php } ?>
					<?php } ?>
					
				</table>
			</div>
			<p><b><?php echo $NAMA; ?></b> Silahkan tinjau kembali data diatas, jika masih terdapat kekurangan atau kesalahan dalam penulisan silahkan lakukan perbaikan melakui laman <b>Data Pribadi Mahasiswa</b>.</p>
			<br>
			<p>Jika dirasa data diatas sudah benar, maka silahkan lanjutkan ke proses pendaftaran verifikasi Surat Ket. Pendamping Ijazah dan dengan dilakukannya pendaftaran verifikasi Surat Ket. Pendamping Ijazah data tersebut diatas sudah tidak dapat diperbaharui.</p>
			<br>
			<p>
				<div class="jumbotron" style="background-color: white; border-radius: 5px; padding: 10px;">
					<table class="table table-bordered" style="border: 1px solid white; margin: 0px;">
						<tr>
							<td style="border: 1px; vertical-align: middle; text-align: center; width: 30px;">
								<input type="checkbox" name="cekbox" required onchange="enable_button();">
							</td>
							<td style="border: 1px;"> <b>Ya saya setuju</b> melanjutkan proses pendaftaran verifikasi Surat Ket. Pendamping Ijazah dan tidak akan melakukan perubahan data tersebut diatas. </td>
						</tr>
					</table>
				</div>
			</p>
			<br>
			<table class="table">
				<tr>
					<td style="border: 0px;"> <?php echo anchor(base_url('skpi/skpi_mhs/daftar_skpi'), 'Batalkan', array('class' => 'btn-uin btn btn-small btn-inverse')); ?> </td>
					<td style="border: 0px;" align="right"><button disabled type="submit" id="btn_verifikasi" name="sv_daftar" class="btn-uin btn btn-small btn btn-inverse">Daftar Verifikasi</button> </td>
				</tr>
			</table>
		</div>
		</form>
		<?php } ?> 
	</div>
	<div>
		<strong>Keterangan</strong>
		<table style="margin: 5px 0 30px 0;">
			<tbody>
				<tr><td colspan="2" style="height:10px;"></td></tr>
				<tr>
				<td style=""><span class="badge badge-info"><i class="icon-white icon-info"></i></span></td>
				<td style="">&nbsp; : Informasi Data SKPI.</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>


<script type="text/javascript">
	function enable_button(){
		if(formulir_ver.btn_verifikasi.disabled==true){
			formulir_ver.btn_verifikasi.disabled=false;
			return confirm('Setelah dilakukan pendaftaran verifikasi SKPI, Data Surat Keterangan Pendamping Ijazah untuk <?php echo $NAMA; ?> tidak dapat di ubah !');
		}else{
			formulir_ver.btn_verifikasi.disabled=true;
		}
	}
</script>
