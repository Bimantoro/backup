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
				<?php //echo $tambah; ?>
				<?php 	}else{ ?>
				<h3>Daftar Master Tabel SKPI</h3>
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
							<td><?php echo ($key['status']=='0')?'<span class="badge badge-important"><i class="icon-white icon-remove"></i></span>':'<span class="badge badge-success"><i class="icon-white icon-ok"></i></span>'; ?></td>
							<td><?php echo $key['keterangan']; ?></td>
							<td><?php echo anchor('skpi/skpi_admin/pengaturan_label/'.$key['id_l'] , ($level=='laporan')?'Lihat':'Edit' , array('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
						</tr>
					<?php endforeach ?>
				</table>

				

				<?php 	} ?>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</div>
</body>