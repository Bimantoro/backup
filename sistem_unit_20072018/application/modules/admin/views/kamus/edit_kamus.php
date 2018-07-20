<?php foreach($kamus as $k){} ?>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group" hidden>
		<label class="col-md-3 control-label" for="kode_unit">kode</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="kode" id="kode" value="<?php echo $k->id_kamus ?>">
		</div>
	</div>
	<div class="form-group" hidden>
		<label class="col-md-3 control-label" for="kode_unit">old_kata</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="oldkata" id="oldkata" value="<?php echo $k->kata ?>">
		</div>
	</div>
	<div class="form-group" hidden>
		<label class="col-md-3 control-label" for="kode_unit">old_lang</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="oldopt" id="oldopt" value="<?php echo $k->kode_bahasa ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="kode_unit">Kata</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="kata" id="kata" required value="<?php echo $k->kata ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="bahasa">Bahasa</label>
		<?php $bhs=array('en'=>'English','ar'=>'Arabic');?>
		<div class="col-md-3">			
			<select class="form-control mb-md" name="opt" id="opt">
				<?php foreach($bhs as $ib=>$bs){
					if($ib == $k->kode_bahasa){
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
		<label class="col-md-3 control-label" for="kode_unit">Terjemahan</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="terjemahan" id="terjemahan" value="<?php echo $k->terjemahan ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>
</form>