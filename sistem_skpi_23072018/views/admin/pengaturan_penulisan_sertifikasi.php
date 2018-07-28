<?php 
	$cek_status_kode = array('','');
	$cek_status_pen = array('','');

	$kode_a = null; $ket_a = null; $stat_a = null; $status_edit_a = false;
	if(isset($kode_pen)){
		$kode_a = $kode_pen['kode'];
		$ket_a  = $kode_pen['keterangan'];
		$stat_a = $kode_pen['status'];

		if($stat_a == 1){
			$cek_status_kode = array('','selected');
		}else{
			$cek_status_kode = array('selected','');
		}

		$status_edit_a = true;
 	}

 	$id_ps = null; $kode_b = null; $nama_id = null; $nama_en = null; $unit_id = null; $unit_en = null; $urutan = null; $stat_b = null; $status_edit_b = false;
 	if(isset($pengaturan_penulisan_id)){
 		$id_ps = $pengaturan_penulisan_id['id_ps'];
 		$kode_b = $pengaturan_penulisan_id['kode'];
 		$nama_id = $pengaturan_penulisan_id['nama_idn'];
 		$nama_en = $pengaturan_penulisan_id['nama_en'];
 		$unit_id = $pengaturan_penulisan_id['unit_idn'];
 		$unit_en = $pengaturan_penulisan_id['unit_en'];
 		$urutan = $pengaturan_penulisan_id['urutan'];
 		$stat_b = $pengaturan_penulisan_id['status'];

 		if($stat_b == 1){
			$cek_status_pen = array('','selected');
		}else{
			$cek_status_pen = array('selected','');
		}

		$status_edit_b = true;
 	}
 ?>

 <?php if($level == 'root'){ ?>
<br>
<h3>Data Kode Pengaturan Penulisan</h3>
<form class="form-inline" action="<?php echo base_url('skpi/skpi_admin/pengaturan_penulisan_sertifikasi') ?>" method="POST">
	<div hidden>
		<input type="text" name="old_kode" value="<?php echo $kode_a; ?>">
	</div>
	<table class="table-snippet">
		<tbody>
			<tr>
				<td style="padding: 10px;" class="reg-label" width="10%;">KODE</td>
				<td style="padding: 10px;" class="reg-input" width="20%;"><input type="text" name="kode" class="form-control" placeholder="Kode Identifikasi Sertifikasi"
				 value="<?php echo $kode_a; ?>" required></td>
			</tr>
			<tr>
				<td style="padding: 10px;" class="reg-label" width="10%;">Keterangan</td>
				<!-- <td style="padding: 10px;" class="reg-input"><input type="text" name="kode" class="form-control" placeholder="Ketarangan"
				value="<?php echo $ket_a; ?>" required></td> -->
				<td style="padding: 10px;"><textarea class="form-control" rows="2" required name="keterangan"><?php echo $ket_a; ?></textarea></td>
			</tr>
			<tr>
				<td style="padding: 10px;" class="reg-label" width="10%;">Status</td>
				<td style="padding: 10px;" class="reg-input">
					<select class="form-control" name="status">
						<option value="0" <?php echo $cek_status_kode[0]; ?> >TIDAK AKTIF</option>
						<option value="1" <?php echo $cek_status_kode[1]; ?> >AKTIF</option>
					</select>
				</td>
				<?php if($status_edit_a){ ?>
				<td style="padding: 10px;" width="20%;"><button class="btn-uin btn btn-inverse btn btn-small" type="submit" name="up_kode">Perbaharui Kode</button></td>
				<td><button class="btn-uin btn btn-inverse btn btn-small" type="submit" name="dt_kode">Hapus Kode</button></td>
				<?php }else{ ?>
				<td><button class="btn-uin btn btn-inverse btn btn-small" type="submit" name="sv_kode">Simpan Kode</button></td>
				<?php } ?>
			</tr>		
		</tbody>
	</table>
</form>
<table class="table table-bordered table table-hover">
	<thead>
		<th align="center" >No.</th>
		<th align="center" >Kode</th>
		<th align="center" >Keterangan</th>
		<th align="center" >Status</th>
		<th align="center" >Proses</th>
	</thead>
	<tbody>
		<?php if(!$kode_penulisan){ ?>
			<tr><td colspan="5" align="center">Tidak Ada Data !</td></tr>
		<?php }else{ ?>
				<?php $i = 1; ?>
				<?php foreach ($kode_penulisan as $key): ?>
					<tr>
						<td style="text-align: center;"><?php echo $i; $i++; ?>.</td>
						<td style="text-align: center;"><?php echo $key['kode'];?></td>
						<td style="text-align: center;"><?php echo $key['keterangan'];?></td>
						<td style="text-align: center;">
							<?php if($key['status'] == 1){ ?>
								<span class="badge badge-success"><i class="icon-white icon-ok"></i></span>
							<?php }else{ ?>
								<span class="badge badge-important"><i class="icon-white icon-remove"></i></span>
							<?php } ?>
						</td>
						<td style="text-align: center;">
							<?php echo anchor(base_url('/skpi/skpi_admin/pengaturan_penulisan_sertifikasi/edit/kode/'.$key['kode']), 'edit', array('class' => 'btn-uin btn btn-small btn-inverse')); ?>
						</td>
					</tr>
				<?php endforeach ?>
		<?php } ?>
	</tbody>
</table>
<?php } ?>
<br>
<h3>Data Aturan Penulisan Sertifikasi</h3>
<form class="form-inline" action="<?php echo base_url('skpi/skpi_admin/pengaturan_penulisan_sertifikasi') ?>" method="POST">
	<div hidden>
		<input type="number" name="id_ps" value="<?php echo $id_ps; ?>">
	</div>
	<table class="table-snippet">
		<tbody>
			<tr>
				<td style="padding: 10px; vertical-align: middle;" class="reg-label" width="10%;">KODE</td>
				<td style="padding: 10px;" class="reg-input" width="20%;">
					<select class="form-control" name="kode_penulisan" required>
						<?php foreach ($kode_aktif as $key): ?>
							<?php if($key['kode'] == $kode_b){ ?>
								<option value="<?php echo $key['kode']; ?>" selected><?php echo $key['kode']; ?></option>
							<?php }else{ ?>
								<option value="<?php echo $key['kode']; ?>"><?php echo $key['kode']; ?></option>
							<?php } ?>
						<?php endforeach ?>
					</select>
				</td>
				<td width="30px"></td>
				<td style="padding: 10px; vertical-align: middle;" class="reg-label" width="15%;">Unit (ID) </td>
				<td style="padding: 10px;" class="reg-input"><input type="text" name="unit_id" class="form-control" placeholder="Unit Penyelenggara (Indonesia)" 
					value="<?php echo $unit_id; ?>" required></td>
			</tr>
			<tr>
				<td style="padding: 10px; vertical-align: middle;" class="reg-label" width="15%;">Nama (ID)</td>
				<td style="padding: 10px;" class="reg-input"><input type="text" name="nama_id" class="form-control" placeholder="Nama Sertifikasi (Indonesia)"
					value="<?php echo $nama_id; ?>" required></td>
				<td width="30px"></td>
				<td style="padding: 10px; vertical-align: middle;" class="reg-label" width="10%;">Unit (EN) </td>
				<td style="padding: 10px;" class="reg-input"><input type="text" name="unit_en" class="form-control" placeholder="Unit Penyelenggara (Inggris)"
					value="<?php echo $unit_en; ?>" required></td>
			</tr>
			<tr>
				<td style="padding: 10px; vertical-align: middle;" class="reg-label" width="15%;">Nama (EN)</td>
				<td style="padding: 10px;" class="reg-input"><input type="text" name="nama_en" class="form-control" placeholder="Nama Sertifikasi (Indonesia)"
					value="<?php echo $nama_en; ?>" required></td>
				<td width="30px"></td>
				<td style="padding: 10px; vertical-align: middle;" class="reg-label" width="10%;">Urutan </td>
				<td style="padding: 10px;" class="reg-input"><input type="number" name="urutan" class="form-control" min="0"
					value="<?php echo $urutan; ?>" required></td>
			</tr>
			<tr>
				<td style="padding: 10px; vertical-align: middle;" class="reg-label" width="10%;">Status</td>
				<td style="padding: 10px;" class="reg-input" width="20%;">
					<select class="form-control" name="status_pengaturan">
						<option value="0" <?php echo $cek_status_pen[0]; ?>>TIDAK AKTIF</option>
						<option value="1" <?php echo $cek_status_pen[1]; ?>>AKTIF</option>
					</select>
				</td>
				<td width="30px"></td>
				<td style="padding: 10px; vertical-align: middle;" colspan="2" class="reg-label" width="15%;">
					<?php if($status_edit_b){ ?>
						<button class="btn-uin btn btn-small btn-inverse" name="up_pengaturan">Perbaharui</button>
					<?php }else{ ?>
						<button class="btn-uin btn btn-small btn-inverse" name="sv_pengaturan">Simpan</button>
					<?php } ?>
				</td>
			</tr>
		</tbody>
	</table>
</form>

<table class="table table-bordered table table-hover">
	<thead>
		<tr>
			<th align="center" rowspan="2" style="vertical-align: middle;">No.</th>
			<th align="center" rowspan="2" style="vertical-align: middle;">Kode</th>
			<th align="center" colspan="2" >Nama</th>
			<th align="center" colspan="2" >Unit</th>
			<th align="center" rowspan="2" style="vertical-align: middle;">Status</th>
			<th align="center" rowspan="2" style="vertical-align: middle;">Urutan</th>
			<th align="center" rowspan="2" style="vertical-align: middle;">Proses</th>	
		</tr>
		<tr>
			<th>Indonesia</th>
			<th>Inggris</th>
			<th>Indonesia</th>
			<th>Inggris</th>
		</tr>
	</thead>
	<tbody>
		<?php if(!$pengaturan_penulisan){ ?>
		<tr><td colspan="9" align="center">Tidak Ada Data !</td></tr>
		<?php }else{ ?>
		<?php $i = 1; ?>
		<?php foreach ($pengaturan_penulisan as $key): ?>
			<tr>
				<td align="center"><?php echo $i; $i++; ?>.</td>
				<td align="center"><?php echo $key['kode']; ?></td>
				<td align="center"><?php echo $key['nama_idn']; ?></td>
				<td align="center"><i><?php echo $key['nama_en']; ?></i></td>
				<td align="center"><?php echo $key['unit_idn']; ?></td>
				<td align="center"><i><?php echo $key['unit_en']; ?></i></td>
				<td align="center">
					<?php if($key['status'] == 1){ ?>
						<span class="badge badge-success"><i class="icon-white icon-ok"></i></span>
					<?php }else{ ?>
						<span class="badge badge-important"><i class="icon-white icon-remove"></i></span>
					<?php } ?>
				</td>
				<td align="center"><?php echo $key['urutan']; ?></td>
				<td align="center">
					<?php echo anchor(base_url('/skpi/skpi_admin/pengaturan_penulisan_sertifikasi/edit/pengaturan/'.$key['id_ps']), 'edit', array('class' => 'btn-uin btn btn-small btn-inverse')); ?>
				</td>
			</tr>
		<?php endforeach ?>
		
		<?php } ?>
	</tbody>
</table>