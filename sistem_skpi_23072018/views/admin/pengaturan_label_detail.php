<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		
	</style>
</head>
<body>
	<br>
	<form class="form-inline" action="<?php echo base_url(); ?>skpi/skpi_admin/pengaturan_label/<?php echo $master_label; ?>" method="POST">
		<table class="table-snippet">
			<tbody>
				<tr>
					<td style="padding: 10px;" class="reg-label" width="20%;">Pascasarjana/Fakultas</td>
					<td style="padding: 10px;" class="reg-input" width="10%;">
						<select name="kd_fak" class="form-control" onchange='this.form.submit();'>
						<?php if(!isset($kd_fak) || $kd_fak=='X0X'){ ?>
							<option value="X0X"> -- Pilih -- </option>
						<?php } ?>
				      	<?php 
				      		$i=0;
				      		for($i=0; $i<count($ls_kd_fak); $i++){
				      			if(isset($kd_fak)){
				      				if($ls_kd_fak[$i]==$kd_fak){
				      					echo "<option value=".$ls_kd_fak[$i]." selected >".$ls_nm_fak[$i]."</option>";
				      				}else{
				      					echo "<option value=".$ls_kd_fak[$i].">".$ls_nm_fak[$i]."</option>";
				      				}
				      			}else{

				      				echo "<option value=".$ls_kd_fak[$i].">".$ls_nm_fak[$i]."</option>";
				      			}
				      			
				      		}
				      	?>
				      </select>
					</td>
				</tr>
				<tr>
					<td style="padding: 10px;" class="reg-label" width="20%;">Prodi</td>
					<td style="padding: 10px;" class="reg-input">
						<select name="kd_prodi" class="form-control" onchange="this.form.submit();">
						<?php if(!isset($kd_prodi) || $kd_prodi=='X0X'){ ?>
							<option value="X0X"> -- Pilih -- </option>
						<?php } ?>
				      	<?php 
				      		$i=0;
				      		for($i=0; $i<count($ls_kd_prodi); $i++){
				      			if(isset($kd_prodi)){
				      				if($ls_kd_prodi[$i]==$kd_prodi){
				      					echo "<option value=".$ls_kd_prodi[$i]." selected >".$ls_nm_prodi[$i]."</option>";
				      				}else{
				      					echo "<option value=".$ls_kd_prodi[$i].">".$ls_nm_prodi[$i]."</option>";
				      				}
				      			}else{

				      				echo "<option value=".$ls_kd_prodi[$i].">".$ls_nm_prodi[$i]."</option>";
				      			}
				      			
				      		}
				      	?>
				      </select>
					</td>
					<td><button class="btn-uin btn btn-inverse btn btn-small" type="submit" name="cek" onclick="loading_on();">Cek Pengaturan</button></td>
				</tr>
			</tbody>
		</table>
	

	<?php if($show==true){ ?>
	<div id="konten">
		<h3>Data Penggunaan Label</h3>
		<?php if(isset($label_konten)){ ?>
		<table class="table table-bordered table table-hover">
			<tr>
				<th>No.</th>
				<th>Indonesia</th>
				<th>Inggris</th>
				<th>Status</th>
			</tr>
			<?php $i=1; ?>
			<?php $jml = count($label_konten); ?>
			<?php if($jml==0){ ?>
				<tr><td colspan="4" style="text-align: center;"> Tidak Ditemukan Data Label !</td></tr>
			<?php }else{ ?>
			<?php foreach ($label_konten as $key): ?>
				<tr>
					<td style="text-align: center; vertical-align: middle;"><?php echo $i; $i++; ?>.</td>
					<td style="text-align: center; vertical-align: middle; width: 45%;"><?php echo $key['nama_idn']; ?></td>
					<td style="text-align: center; vertical-align: middle; width: 45%;"><i><?php echo $key['nama_en']; ?></i></td>
					<td style="text-align: center; vertical-align: middle;"><input type="checkbox" name="status[]" value="<?php echo $key['id_ld']; ?>" <?php echo $key['check']; ?>></td>
				</tr>
			<?php endforeach ?>
			<?php } ?>
		</table>

		<?php if($jml!=0){ ?>
		<div align="right">
			<button class="btn-uin btn btn-small btn btn-inverse" type="submit" name="sv_label">Simpan</button>
		</div>
		<?php } ?>
		<?php }else{ ?>
			<div class="bs-callout bs-callout-error">Tidak ada data untuk ditampilkan !</div>
		<?php } ?>
	</div>
	</form>
	<?php } ?>
</body>
</html>