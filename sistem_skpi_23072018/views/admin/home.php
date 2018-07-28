<?php
	$arr1 = array(	'app_text' 	=> $judul, 
					'app_name' 	=> 'Admin '.$string_judul[0], 
					'app_url'	=> 'skpi/skpi_admin/');

	$this->s00_lib_output->output_frontpage_mhs($arr1);
?>
<!-- <body>
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
				<h3 align="center">DAFTAR MASTER LABEL SKPI</h3>
				<table class="table table-bordered">
					<tr align="center">
						<th>No</th>
						<th>Tanggal Mulai</th>
						<th>Tanggal Selesai</th>
						<th>Status</th>
						<th>Keterangan</th>
						<th>Aksi</th>
					</tr>
					<?php 	$i=1; ?>
					<?php foreach ($label as $key): ?>
						<tr align="center">
							<td><?php echo $i; $i++; ?></td>
							<td><?php echo ($key['tgl_mulai']=='')?'':date('d/m/Y', strtotime($key['tgl_mulai'])) ?></td>
							<td><?php echo ($key['tgl_selesai']=='')?'':date('d/m/Y', strtotime($key['tgl_selesai'])) ?></td>
							<td><?php echo ($key['status']=='0')?'Tidak Aktif':'Aktif'; ?></td>
							<td><?php echo $key['keterangan']; ?></td>
							<td><?php echo anchor('skpi/skpi_admin/tambah_label/'.$key['id_l'] , ($level=='laporan')?'Lihat':'Edit' , array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
						</tr>
					<?php endforeach ?>
				</table>
				
				<br>
				<?php echo $tambah; ?>

				<?php 	} ?>
			</div>
			<div class="col-md-2"></div>
		</div>
		<div>
			<br>
			<?php echo anchor('skpi/skpi_admin/verifikasi_data_mhs', 'Verifikasi Data Mahasiswa', array('class' => 'ver')); ?>

			<br>
			<?php echo anchor('skpi/skpi_admin/skpi_mhs', 'List data mhs', array('class' => 'ver')); ?>

			<br>
			<?php echo anchor('skpi/skpi_admin/status_skpi_mhs', 'Ubah status skpi', array('class' => 'ver')); ?>
		</div>
	</div>
</div>
</body> -->