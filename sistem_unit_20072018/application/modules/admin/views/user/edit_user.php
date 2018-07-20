<?php foreach($user as $usr){} ?>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label" for="username">Username</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="username" id="username" required readonly value="<?php echo $usr->username; ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_unit">Nama Unit</label>
		<div class="col-md-6">
			<!-- <input type="text" class="form-control" name="nama_unit" id="nama_unit" required> -->
			<select class="form-control" name="kode_unit" id="kode_unit" required>
				<?php if($units){
					foreach ($units as $u) {
						if($u->kode_unit == $usr->kode_unit){
							echo "<option value='".$u->kode_unit."' selected>".$u->nama_unit."</option>";
						}else{
							echo "<option value='".$u->kode_unit."'>".$u->nama_unit."</option>";
						}
						
					}
				} ?>
				
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="level">Level</label>
		<?php $adm=array('WPR002'=>'WPR002','WPR001'=>'WPR001');?>
		<div class="col-md-6">			
			<select class="form-control" name="level" id="level">
				<?php foreach($adm as $ib=>$bs){
					if($ib == $usr->level){
						echo"<option value='".$ib."' selected>".$bs."</option>";
					}else{
						echo"<option value='".$ib."'>".$bs."</option>";
					}
					
				}
				?>
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