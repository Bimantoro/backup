<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		.loader3:before,
		.loader3:after,
		.loader3 {
		  border-radius: 50%;
		  width: 2.5em;
		  height: 2.5em;
		  -webkit-animation-fill-mode: both;
		  animation-fill-mode: both;
		  -webkit-animation: load7 1.8s infinite ease-in-out;
		  animation: load7 1.8s infinite ease-in-out;
		}
		.loader3 {
		  font-size: 5px;
		  margin: 30px auto;
		  position: relative;
		  text-indent: -9999em;
		  -webkit-transform: translateZ(0);
		  -ms-transform: translateZ(0);
		  transform: translateZ(0);
		  -webkit-animation-delay: -0.16s;
		  animation-delay: -0.16s;
		}
		.loader3:before {
		  left: -3.5em;
		  -webkit-animation-delay: -0.32s;
		  animation-delay: -0.32s;
		}
		.loader3:after {
		  left: 3.5em;
		}
		.loader3:before,
		.loader3:after {
		  content: '';
		  position: absolute;
		  top: 0;
		}
		@-webkit-keyframes load7 {
		  0%,
		  80%,
		  100% {
			box-shadow: 0 2.5em 0 -1.3em #000000;
		  }
		  40% {
			box-shadow: 0 2.5em 0 0 #000000;
		  }
		}
		@keyframes load7 {
		  0%,
		  80%,
		  100% {
			box-shadow: 0 2.5em 0 -1.3em #000000;
		  }
		  40% {
			box-shadow: 0 2.5em 0 0 #000000;
		  }
		}
	</style>
</head>
<body>


<br>
<form class="form-inline" action="<?php echo base_url(); ?>skpi/skpi_admin/list_pendaftar_verifikasi" method="POST">
	<table class="table-snippet">
		<tbody>
			<tr>
				<td style="padding: 10px;" class="reg-label" width="20%;">Pascasarjana/Fakultas</td>
				<td style="padding: 10px;" class="reg-input" width="10%;">
					<select name="kd_fak" class="form-control" onchange='loading_on(); this.form.submit();'>
					<?php if(!isset($kd_fak)){ ?>
						<option value=""> -- Pilih -- </option>
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
					<select name="kd_prodi" class="form-control" onchange="loading_on(); this.form.submit();">
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
			</tr>
			<tr>
				<td style="padding: 10px;" class="reg-label" width="20%;">Angkatan</td>
				<td style="padding: 10px;" class="reg-input">
					<!-- <input type="text" name="angkatan" value="<?php echo (isset($angkatan))?$angkatan:''; ?>"> -->
					 <select name="angkatan" class="form-control" onchange="loading_on(); this.form.submit();">
					 	<?php if(!isset($angkatan) || $angkatan=='X0X'){ ?>
							<option value="X0X"> -- Pilih -- </option>
						<?php } ?>
				      	<?php 
				      		$i=0;
				      		for($i=0; $i<count($ls_angkatan); $i++){
				      			if(isset($angkatan)){
				      				if($ls_angkatan[$i]==$angkatan){
				      					echo "<option value=".$ls_angkatan[$i]." selected >".$ls_angkatan[$i]."</option>";
				      				}else{
				      					echo "<option value=".$ls_angkatan[$i]." >".$ls_angkatan[$i]."</option>";
				      				}
				      			
				      			}else{
				      				echo "<option value=".$ls_angkatan[$i]." >".$ls_angkatan[$i]."</option>";
				      			}
				      		}
				      	?>
				      </select>
				</td>
				<!-- <td><button class="btn-uin btn btn-inverse btn btn-small" type="submit" name="cek">Lihat Data</button></td> -->
			</tr>
</form>
<form class="form-inline" action="<?php echo base_url(); ?>skpi/skpi_admin/list_pendaftar_verifikasi" method="POST">
			<tr>
				<td style="padding: 10px;" class="reg-label">NIM</td>
				<td style="padding: 10px;" class="reg-label">
					<input type="text" name="nim" value="<?php echo (isset($nim))?$nim:''; ?>" required>
				</td>
				<td><button class="btn-uin btn btn-inverse btn btn-small" type="submit" name="cek_nim" onclick="loading_on();">Cek NIM</button></td>
			</tr>
		</tbody>
	</table>
</form>

<div id="loading" hidden>
		<div class="loader3">Loading...</div>
</div>

<div id="konten">
	<?php if(isset($mhs)){ ?>
	<h3>Data Mahasiswa Pendaftar Verifikasi SKPI</h3>
	<?php if(count($mhs)<=0){ ?>
		<div>
			<div class="bs-callout bs-callout-error">Tidak ada data untuk ditampilkan !</div>
		</div>
	<?php }else{ ?>
	<form action="<?php echo base_url(); ?>skpi/skpi_admin/list_pendaftar_verifikasi" method="POST">
	<table class="table table-bordered">
		<tr>
			<th>No.</th>
			<th>NIM</th>
			<th>Nama</th>
			<th>Status</th>
			<th width="5%;">Proses</th>
		</tr>
		<?php
		$i=1;

		foreach ($mhs as $key) { ?>
			<tr>
				<td style="vertical-align: middle; text-align: center;"><?php echo $i; $i++; ?>.</td>
				<td style="vertical-align: middle;"><?php echo $key['NIM']; ?></td>
				<td style="vertical-align: middle;"><?php echo $key['NAMA']; ?></td>
				<?php if($key['STATUS']){ ?>
					<td class="tac" align="center" style="vertical-align: middle;">
						<span class="badge badge-success">
							<i class="icon-white icon-ok"></i>
						</span>
					</td>
					<td align="center" style="vertical-align: middle;">
						-
					</td>
				<?php }else{ ?>
					<td class="tac" align="center" style="vertical-align: middle;">
						<span class="badge badge-important">
							<i class="icon-white icon-remove"></i>
						</span>
					</td>
					<td align="center" style="vertical-align: middle;">
						<?php if($this->session->userdata('skpi_lvl')!='laporan' && $this->session->userdata('skpi_lvl')!='admin'){ ?>
							<button class="btn-uin btn-inverse btn-small" type="submit" name="btn_batal" value="<?php echo $key['NIM']; ?>">Batalkan</button>
						<?php }else{ ?>
							-
						<?php } ?>
					</td>
				<?php } ?>
			</tr>
		<?php
			
		 } ?>
	</table>
	</form>
	<div>
		<strong>Keterangan</strong> :
		<tr>
			<td>
				<span class="badge badge-success">
							<i class="icon-white icon-ok"></i> AKTIF
				</span>
			</td>
		</tr>
		<tr>
			<td>
				<span class="badge badge-important">
							<i class="icon-white icon-remove"></i> TIDAK AKTIF
				</span>
			</td>
		</tr><br><br>
	</div>
	<?php }} ?>
</div>

</body>
</html>


<script>
	var condition = false;

	function loading_on(){
		if(condition==false){
			this.loading.hidden=false;
			this.konten.hidden=true;
			condition = true;
		}
		
	}
</script>