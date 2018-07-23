<br>
<body>
	<div>
		<form class="form-inline" action="<?php echo base_url(); ?>/skpi/skpi_admin/simpan_label" method="POST">
			<h3>Label Title :</h3>
			<?php if($level!='laporan'){ ?>
			<table class="table-snippet">
				<tbody>
					<tr hidden>
						<td class="reg-label" width="20%;" style="padding: 10px;">ID_L</td>
						<td class="reg-input">
							<input type="text" name="id_l" style="width: 520px;" class="inputx"
							value="<?php echo $id_l; ?>">
						</td>
					</tr>

					<tr hidden>
						<td class="reg-label" width="20%;" style="padding: 10px;">posisi</td>
						<td class="reg-input">
							<input type="text" name="title_posisi" style="width: 520px;" class="form-control"
							value="0">
						</td>
					</tr>

					<tr>
						<td class="reg-label" width="20%;" style="padding: 10px;">Bahasa Indonesia</td>
						<td class="reg-input">
							<input type="text" name="title_nama_idn" style="width: 520px;" class="form-control"
							placeholder="Title dalam Bahasa Indonesia" required>
						</td>
					</tr>

					<tr>
						<td class="reg-label" width="20%;" style="padding: 10px;">Bahasa Inggris</td>
						<td class="reg-input">
							<input type="text" name="title_nama_en" style="width: 520px;" class="inputx"
							placeholder="Title dalam Bahasa Inggris" required>
						</td>
					</tr>
					<br>

					<tr>
						<td class="reg-label" width="20%;" style="padding: 10px;">Bahasa Arab</td>
						<td class="reg-input">
							<input type="text" name="title_nama_arb" style="width: 520px;" class="inputx"
							placeholder="Title dalam Bahasa Arab">
						</td>
					</tr>

					<tr>
						<td class="reg-label" width="20%;" style="padding: 10px;">Urutan</td>
						<td class="reg-input">
							<input type="number" name="title_urutan" style="width: 50px;" class="inputx"
							required>
						</td>
					</tr>

					<tr>
						<td colspan="2" align="right"><button type="submit" name="sv_title" class="btn-uin btn-inverse btn-small" alig>Tambah Label Title</button></td>
					</tr>
				</tbody>
			</table>
			<?php } ?>
			</form>

			<br class="ganjel">
			<table class="table table-bordered">
				<tr>
					<th>No</th>
					<th>Indonesia</th>
					<th>Inggris</th>
					<th>Arab</th>
					<th>Urutan</th>
					<?php if($level!='laporan'){ ?>
					<th colspan="2" width="15%;">Aksi</th>
					<?php } ?>
				</tr>
				<?php if($jml_label_title==0){ ?>
					<tr align="center">
						<td colspan="5">Tidak Ada Data untuk Ditampilkan !</td>
					</tr>
				<?php }else{ ?>
					<?php $i=1; ?>
					<?php foreach ($label_title as $key): ?>
						<tr align="center">
							<td><?php echo $i.'.'; $i++; ?></td>
							<td><?php echo anchor('skpi/skpi_admin/tambah_label_detail/'.$key['id_ld'].'/'.$id_l, $key['nama_idn'], array ('class' => 'detail')); ?></td>
							<td><i><?php echo anchor('skpi/skpi_admin/tambah_label_detail/'.$key['id_ld'].'/'.$id_l, $key['nama_en'], array ('class' => 'detail')); ?></i></td>
							<td><?php echo anchor('skpi/skpi_admin/tambah_label_detail/'.$key['id_ld'].'/'.$id_l, ($key['nama_arb']=='')?'-':$key['nama_arb'], array ('class' => 'detail')); ?></td>
							<td><?php echo $key['urut']; ?></td>
							<?php if($level!='laporan'){ ?>
							<td><?php echo anchor('skpi/skpi_admin/edit_label/'.$key['id_ld'].'/'.$id_l, 'Edit', array ('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
							<td><?php echo anchor('skpi/skpi_admin/hapus_label/'.$key['id_ld'].'/'.$id_l, 'Hapus', array ('class' => 'btn-uin btn btn-inverse btn btn-small', 'onclick'=>"return confirm('apakah anda yakin ingin menghapus data label ?')")); ?></td>
							<?php } ?>
						</tr>
					<?php endforeach ?>

				<?php } ?>
			</table>

			<br class="ganjel">
			<h3>Label Konten SKPI</h3>
			<form  class="form-inline" action="<?php echo base_url(); ?>/skpi/skpi_admin/simpan_label" method="POST">
			<?php if($level!='laporan'){ ?>
			<table class="table-snippet">
				<tbody>

					<tr hidden>
						<td class="reg-label" width="20%;" style="padding: 10px;">ID_L</td>
						<td class="reg-input">
							<input type="text" name="id_l" style="width: 520px;" class="inputx"
							value="<?php echo $id_l; ?>">
						</td>
					</tr>

					<tr hidden>
						<td class="reg-label" width="20%;" style="padding: 10px;">Konten posisi</td>
						<td class="reg-input">
							<input type="text" name="konten_posisi" style="width: 520px;" class="inputx"
							value="1">
						</td>
					</tr>

					<tr>
						<td class="reg-label" width="20%;" style="padding: 10px;">Bahasa Indonesia</td>
						<td class="reg-input">
							<input type="text" name="konten_nama_idn" style="width: 520px;" class="inputx"
							placeholder="Konten SKPI dalam Bahasa Indonesia" required>
						</td>
					</tr>

					<tr>
						<td class="reg-label" width="20%;" style="padding: 10px;">Bahasa Inggris</td>
						<td class="reg-input">
							<input type="text" name="konten_nama_en" style="width: 520px;" class="inputx"
							placeholder="Konten SKPI dalam Bahasa Inggris" required>
						</td>
					</tr>
					<br>

					<tr>
						<td class="reg-label" width="20%;" style="padding: 10px;">Bahasa Arab</td>
						<td class="reg-input">
							<input type="text" name="konten_nama_arb" style="width: 520px;" class="inputx"
							placeholder="Konten SKPI dalam Bahasa Arab">
						</td>
					</tr>

					<tr>
						<td class="reg-label" width="20%;" style="padding: 10px;">Urutan</td>
						<td class="reg-input">
							<input type="number" name="konten_urutan" style="width: 50px;" class="inputx"
							 required>
						</td>
					</tr>

					<tr>
						<td colspan="2" align="right"><button type="submit" name="sv_konten" class="btn-uin btn-inverse btn-small" alig>Tambah Label Konten</button></td>
					</tr>
				</tbody>
			</table>
			<?php } ?>
			<br class="ganjel">
						<table class="table table-bordered">
				<tr>
					<th>No</th>
					<th>Indonesia</th>
					<th>Inggris</th>
					<th>Arab</th>
					<th>Urutan</th>
					<?php if($level!='laporan'){ ?>
					<th colspan="3" width="25%;">Aksi</th>
					<?php } ?>
				</tr>
				<?php if($jml_label_konten==0){ ?>
					<tr align="center">
						<td colspan="6">Tidak Ada Data untuk Ditampilkan !</td>
					</tr>
				<?php }else{ ?>
					<?php $i=1; ?>
					<?php foreach ($label_konten as $key): ?>
						<tr align="center">
							<td><?php echo $i.'.'; $i++; ?></td>
							<td><?php echo anchor('skpi/skpi_admin/tambah_label_detail/'.$key['id_ld'].'/'.$id_l, $key['nama_idn'], array ('class' => 'detail')); ?></td>
							<td><i><?php echo anchor('skpi/skpi_admin/tambah_label_detail/'.$key['id_ld'].'/'.$id_l, $key['nama_en'], array ('class' => 'detail')); ?></i></td>
							<td><?php echo anchor('skpi/skpi_admin/tambah_label_detail/'.$key['id_ld'].'/'.$id_l, ($key['nama_arb']=='')?'-':$key['nama_arb'], array ('class' => 'detail')); ?></td>
							<td><?php echo $key['urut']; ?></td>
							<?php if($level!='laporan'){ ?>
							<td><?php echo anchor('skpi/skpi_admin/edit_label/'.$key['id_ld'].'/'.$id_l, 'Edit', array ('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
							<td><?php echo anchor('skpi/skpi_admin/hapus_label/'.$key['id_ld'].'/'.$id_l, 'Hapus', array ('class' => 'btn-uin btn btn-inverse btn btn-small', 'onclick'=>"return confirm('apakah anda yakin ingin menghapus data label ?')")); ?></td>
							<?php } ?>

						</tr>
					<?php endforeach ?>

				<?php } ?>
			</table>
		</form>
		<br class="ganjel">
		<?php if($id_l!=''){ ?>
		<form class="form-inline" action="<?php base_url(); ?>/skpi/skpi_admin/simpan_label" method="POST">
			<table class="table-snippet">
				<tbody>

					<tr hidden>
						<td class="reg-label" width="20%;" style="padding: 10px;">Id_label_master</td>
						<td class="reg-input">
							<input type="text" name="id_label" style="width: 520px;" class="inputx"
							value="<?php echo $id_l; ?>">
						</td>
					</tr>

					<tr hidden>
						<td class="reg-label" width="20%;" style="padding: 10px;">status_awal</td>
						<td class="reg-input">
							<input type="text" name="status_awal" style="width: 520px;" class="inputx"
							value="<?php echo $label['status']; ?>">
						</td>
					</tr>

					<tr>
						<td style="padding: 10px;" class="reg-label" width="20%;">Tanggal Mulai</td>
						<td>
							<div class="input-append">
								<input type="text" name="tgl_mulai" class="form-control datepicker" required value="<?php echo $label['tgl_mulai']; ?>" readonly>
								<span class="add-on">
								  <i data-time-icon="icon-time" data-date-icon="icon-calendar" class="icon-calendar">
								  </i>
								</span>
							</div>
						</td>
					</tr>

					<tr>
						<td style="padding: 10px;" class="reg-label" width="20%;">Tanggal Selesai</td>
						<td>
							<div class="input-append">
								<input type="text" name="tgl_selesai" class="form-control datepicker" required value="<?php echo $label['tgl_selesai']; ?>" readonly>
								<span class="add-on">
								  <i data-time-icon="icon-time" data-date-icon="icon-calendar" class="icon-calendar">
								  </i>
								</span>
							</div>
						</td>
					</tr>
					

					<tr>
						<td class="reg-label" width="20%;" style="padding: 10px;">Status</td>
						<td class="reg-input">
							<select name="status_label" class="inputx">
								<option value="<?php echo $label['status']; ?>"><?php echo ($label['status']=='0')?'Tidak Aktif':'Aktif'; ?></option>
								<option value="<?php echo ($label['status']=='0')?'1':'0' ?>"><?php echo ($label['status']=='0')?'Aktif':'Tidak Aktif'; ?></option>
							</select>
						</td>
					</tr>

					<tr>
						<td class="reg-label" width="20%;" style="padding: 10px;">Keterangan</td>
						<td class="reg-input">
							<input type="text" name="keterangan_label" style="width: 520px;" class="inputx"
							value="<?php echo $label['keterangan']; ?>">
						</td>
					</tr>

					<?php if($level!='laporan'){ ?>
					<tr>
						<td colspan="2" align="right"><button type="submit" name="sv_master_label" class="btn-uin btn-inverse btn-small" alig>Simpan Perubahan Master Label</button></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
		<?php } ?>

		<div class="reg-kolom-kiri"><?php echo $back; ?></div>
		<div class="reg-kolom-kanan"></div>
	</div>
</body>

<script type="text/javascript">
	 $(function(){
	  $(".datepicker").datepicker({
	      format: 'dd/mm/yyyy',
	      autoclose: true,
	      todayHighlight: true,
	  });
	 });
</script>