<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label" for="fah">Fakultas</label>
		<div class="col-md-6">
			<select class="form-control" name="fak" id="fak" readonly style="pointer-events: none;">
			<?php foreach($fakultas as $f){
				if($akun['kode_fakultas'] == $f['kode_fakultas']){
					echo "<option value='".$f['kode_fakultas']."' selected>".$f['nama_fakultas']."</option>";
				}else{
					echo "<option value='".$f['kode_fakultas']."' >".$f['nama_fakultas']."</option>";
				}
				
			} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="kode">ID User</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="id" id="id" required value="<?php echo $akun['id_user'] ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="nama">Level</label>
		<div class="col-md-6">
			<?php $level = array('Y001' => 'Dekan', 'Y000' => 'Super Admin'); ?>
			<select name="level" id="level" class="form-control">
				<?php foreach($level as $f => $y){
				if($akun['level'] == $f){
					echo "<option value='".$f."' selected>".$y."</option>";
				}else{
					echo "<option value='".$f."' >".$y."</option>";
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