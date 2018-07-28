<?php
	// $arr1 = array(	'app_text' 	=> $judul, 
	// 				'app_name' 	=> 'Admin SKPI', 
	// 				'app_url'	=> 'skpi/skpi_admin/');

	// $this->s00_lib_output->output_frontpage_mhs($arr1);
?>
<br>
<body>
<div class="container">
	<div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<?php if($jml_label==0){ ?>
				<h1>Tidak Ada Data untuk Ditampilkan !</h1>
				<br>
				<?php echo $tambah; ?>
				<?php 	}else{ ?>
				<h3>Daftar Master Label SKPI</h3>
				<?php if(isset($pesan)){ ?>
					<div class="container">
						<div class="alert alert-danger"><?php echo $pesan; ?></div>
					</div>
				<?php } ?>
				<table class="table table-bordered">
					<tr align="center">
						<th>No</th>
						<th>Tanggal Mulai</th>
						<th>Tanggal Selesai</th>
						<th>Status</th>
						<th>Keterangan</th>
						<th>Proses</th>
					</tr>
					<?php 	$i=1; ?>
					<?php foreach ($label as $key): ?>
						<tr align="center">
							<td><?php echo $i; $i++; ?></td>
							<td><?php echo ($key['tgl_mulai']=='')?'-':$key['tgl_mulai']; ?></td>
							<td><?php echo ($key['tgl_selesai']=='')?'-':$key['tgl_selesai']; ?></td>
							<?php if($key['status']=='0'){ ?>
								<td class="tac" align="center" style="vertical-align: middle;">
									<span class="badge badge-important">
										<i class="icon-white icon-remove"></i>
									</span>
								</td>
							<?php }else{ ?>
								<td class="tac" align="center" style="vertical-align: middle;">
									<span class="badge badge-success">
										<i class="icon-white icon-ok"></i>
									</span>
								</td>
							<?php } ?>
							<td><?php echo $key['keterangan']; ?></td>
							<td><?php echo anchor('skpi/skpi_admin/tambah_label/'.$key['id_l'] , ($level=='laporan')?'Lihat':'Edit' , array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
						</tr>
					<?php endforeach ?>
				</table>

				<?php echo $tambah; ?>

				<?php 	} ?>
			</div>
			<div class="col-md-2"></div>
		</div>
<!-- 		<div>
			<br>
			<?php echo anchor('skpi/skpi_admin/verifikasi_data_mhs', 'Verifikasi Data Mahasiswa', array('class' => 'ver')); ?>

			<br>
			<?php echo anchor('skpi/skpi_admin/skpi_mhs', 'List data mhs', array('class' => 'ver')); ?>

			<br>
			<?php echo anchor('skpi/skpi_admin/status_skpi_mhs', 'Ubah status skpi', array('class' => 'ver')); ?>
		</div> -->
	</div>
</div>
</body>