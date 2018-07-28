<?php
	$arr1 = array(	'app_text' 	=> $judul, 
					'app_name' 	=> 'Admin SKPI', 
					'app_url'	=> 'skpi/skpi_admin/editlabel/');

	$this->s00_lib_output->output_frontpage_mhs($arr1);
?>
<body>
	<div>
			<h3>Label :</h3>
			<table class="table-snippet">
				<form action="<?php echo base_url(); ?>/skpi/skpi_admin/simpan_label" method="POST">
				<tbody>
					<tr hidden>
						<td class="reg-label" width="20%;">ID</td>
						<td class="reg-input">
							<input type="text" name="id" style="width: 520px;" class="inputx"
							value="<?php echo $label['id_ld']; ?>">
						</td>
					</tr>

					<tr hidden>
						<td class="reg-label" width="20%;">ID_L</td>
						<td class="reg-input">
							<input type="text" name="id_l" style="width: 520px;" class="inputx"
							value="<?php echo $id_l; ?>">
						</td>
					</tr>

					<tr hidden>
						<td class="reg-label" width="20%;">ID_MD</td>
						<td class="reg-input">
							<input type="text" name="id_md" style="width: 520px;" class="inputx"
							value="<?php echo $id_md; ?>">
						</td>
					</tr>

					<tr hidden>
						<td class="reg-label" width="20%;">Posisi</td>
						<td class="reg-input">
							<input type="text" name="title_posisi" style="width: 520px;" class="inputx"
							value="<?php echo $label['posisi']; ?>">
						</td>
					</tr>

					<tr>
						<td class="reg-label" width="20%;">Bahasa Indonesia</td>
						<td class="reg-input">
							<input type="text" name="title_nama_idn" style="width: 520px;" class="inputx"
							value="<?php echo $label['nama_idn']; ?>">
						</td>
					</tr>

					<tr>
						<td class="reg-label" width="20%;">Bahasa Inggris</td>
						<td class="reg-input">
							<input type="text" name="title_nama_en" style="width: 520px;" class="inputx"
							value="<?php echo $label['nama_en']; ?>">
						</td>
					</tr>
					<br>

					<tr>
						<td class="reg-label" width="20%;">Bahasa Arab</td>
						<td class="reg-input">
							<input type="text" name="title_nama_arb" style="width: 520px;" class="inputx"
							value="<?php echo $label['nama_arb']; ?>">
						</td>
					</tr>

					<tr>
						<td class="reg-label" width="20%;">Urutan</td>
						<td class="reg-input">
							<input type="number" name="title_urutan" style="width: 50px;" class="inputx"
							value="<?php echo $label['urut']; ?>">
						</td>
					</tr>

					<tr>
						<td colspan="2" align="right"><button type="submit" name="sv_editlabel" class="btn-uin btn-inverse btn-small" alig>Simpan Perubahan</button></td>
					</tr>
				</tbody>
				</form>
			</table>
			<br class="ganjel">
			<div class="reg-kolom-kiri"><?php echo $back; ?></div>
			<div class="reg-kolom-kanan"></div>
	</div>
</body>