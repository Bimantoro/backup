<br>
<body>
	<div>
		<h3>Label Konten</h3>
			<table class="table table-user">
				<tr>
					<td width="20%;"><b>Bahasa Indonesia</b></td>
					<td>: <?php echo $label_konten['nama_idn']; ?></td>
				</tr>
				<tr>
					<td><b>Bahasa Inggris</b></td>
					<td>: <i><?php echo $label_konten['nama_en']; ?></i></td>
				</tr>
				<tr>
					<td><b>Bahasa Arab</b></td>
					<td>: <?php echo $label_konten['nama_arb']; ?></td>
				</tr>
				<tr>
					<td><b>Urutan</b></td>
					<td>: <?php echo $label_konten['urut']; ?></td>
				</tr>
			</table>

			<h3>Label Detail Konten</h3>
			<table class="table-snippet">
			<form action="<?php echo base_url(); ?>/skpi/skpi_admin/simpan_label" method="POST">
				<?php if($level!='laporan'){ ?>
				<tbody>
					<tr hidden>
						<td class="reg-label" width="20%;">id_md</td>
						<td class="reg-input">
							<input type="text" name="id_md" style="width: 520px;" class="inputx"
							value="<?php echo $id_md; ?>">
						</td>
					</tr>

					<tr hidden>
						<td class="reg-label" width="20%;">id_l</td>
						<td class="reg-input">
							<input type="text" name="id_l" style="width: 520px;" class="inputx"
							value="<?php echo $id_l; ?>">
						</td>
					</tr>

					<tr hidden>
						<td class="reg-label" width="20%;">posisi</td>
						<td class="reg-input">
							<input type="text" name="detail_posisi" style="width: 520px;" class="inputx"
							value="2">
						</td>
					</tr>

					<tr>
						<td class="reg-label" width="20%;">Bahasa Indonesia</td>
						<td class="reg-input">
							<input type="text" name="detail_nama_idn" style="width: 520px;" class="inputx"
							placeholder="Label dalam Bahasa Indonesia" required>
						</td>
					</tr>

					<tr>
						<td class="reg-label" width="20%;">Bahasa Inggris</td>
						<td class="reg-input">
							<input type="text" name="detail_nama_en" style="width: 520px;" class="inputx"
							placeholder="Label dalam Bahasa Inggris" required>
						</td>
					</tr>
					<br>

					<tr>
						<td class="reg-label" width="20%;">Bahasa Arab</td>
						<td class="reg-input">
							<input type="text" name="detail_nama_arb" style="width: 520px;" class="inputx"
							placeholder="Label dalam Bahasa Arab">
						</td>
					</tr>

					<tr>
						<td class="reg-label" width="20%;">Urutan</td>
						<td class="reg-input">
							<input type="number" name="detail_urutan" style="width: 50px;" class="inputx" required>
						</td>
					</tr>

					<tr>
						<td colspan="2" align="right"><button type="submit" name="sv_detail_konten" class="btn-uin btn-inverse btn-small" alig>Tambah Label Detail Konten</button></td>
					</tr>
				</tbody>
				<?php } ?>
			</form>
			</table>

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
				<?php if($jml_label_detail==0){ ?>
					<tr align="center">
						<td colspan="5">Tidak Ada Data untuk Ditampilkan !</td>
					</tr>
				<?php }else{ ?>
					<?php $i=1; ?>
					<?php foreach ($label_title_detail as $key): ?>
						<tr align="center">
							<td><?php echo $i.'.'; $i++; ?></td>
							<td><?php echo $key['nama_idn']; ?></td>
							<td><i><?php echo $key['nama_en']; ?></i></td>
							<td><?php echo $key['nama_arb']; ?></td>
							<td><?php echo $key['urut']; ?></td>
							<?php if($level!='laporan'){ ?>
							<td><?php echo anchor('skpi/skpi_admin/edit_label/'.$key['id_ld'].'/'.$id_l.'/'.$id_md, 'Edit', array ('class' => 'btn-uin btn btn-inverse btn btn-small')); ?></td>
							<td><?php echo anchor('skpi/skpi_admin/hapus_label/'.$key['id_ld'].'/'.$id_l.'/'.$id_md, 'hapus', array('class'=> 'btn-uin btn btn-inverse btn btn-small', 'onclick'=>"return confirm('apakah anda yakin ingin menghapus data label ?')"));; ?></td>
							<?php } ?>
						</tr>
					<?php endforeach ?>

				<?php } ?>
			</table>
			<br class="ganjel">
			<div class="reg-kolom-kiri"><?php echo $back; ?></div>
			<div class="reg-kolom-kanan"></div>
	</div>
</body>