<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label" for="fah">Fakultas</label>
		<div class="col-md-6">
			<select class="form-control" name="fak" id="fak" readonly style="pointer-events: none;">
			<?php foreach($fakultas as $f){
				if($prodi['kode_fakultas'] == $f['kode_fakultas']){
					echo "<option value='".$f['kode_fakultas']."' selected>".$f['nama_fakultas']."</option>";
				}else{
					echo "<option value='".$f['kode_fakultas']."' >".$f['nama_fakultas']."</option>";
				}
				
			} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="kode">Kode Prodi</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="kode" id="kode" required value="<?php echo $prodi['kode_prodi'] ?>" readonly>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="nama">Nama Prodi</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="nama" id="nama" required value="<?php echo $prodi['nama_prodi'] ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="jenjang">Jenjang</label>
		<div class="col-md-6">
			<select class="form-control" name="jenjang" id="jenjang">
			<?php foreach($jenjang as $f){
				if($prodi['kode_jenjang'] == $f['kode_jenjang']){
					echo "<option value='".$f['kode_jenjang']."' selected>".$f['nama_jenjang']."</option>";
				}else{
					echo "<option value='".$f['kode_jenjang']."' >".$f['nama_jenjang']."</option>";
				}
				
			} ?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>
</form>