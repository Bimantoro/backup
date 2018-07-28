<?php foreach($prodi as $p){} ?>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label" for="kode_unit">Kode Unit</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="kode_unit" id="kode_unit" value="<?php echo $p->kode_unit?>" required readonly>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_unit">Nama Unit</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="nama_unit" id="nama_unit" value="<?php echo $p->nama_unit?>" required>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="kode_prodi">Kode Prodi</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="kode_prodi" id="kode_prodi" value="<?php echo $p->kode_prodi?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="bahasa">Bahasa</label>
		<?php $bhs=array('id'=>'Indonesia','en'=>'English','ar'=>'Arabic');?>
		<div class="col-md-3">			
			<select class="form-control mb-md" name="bahasa" id="bahasa">
				<?php foreach($bhs as $ib=>$bs){
					if($ib == $p->kode_bahasa){
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
		<label class="col-md-3 control-label" for="subdomain">Subdomain</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="subdomain" id="subdomain" value="<?php echo $p->subdomain?>" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="alamat">Alamat</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="alamat" id="alamat" value="<?php echo $p->alamat?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="email">Email</label>
		<div class="col-md-6">
			<input type="email" class="form-control" name="email" id="email" value="<?php echo $p->email?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="telp">Telp</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="telp" id="telp" value="<?php echo $p->telp?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="sidebar">Nama Sidebar Unit</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="sidebar" id="sidebar" value="<?php echo $p->nama_sidebar_unit?>">
		</div>
	</div>

		<div class="form-group">
		<label class="col-md-3 control-label" for="slider">Status Slider</label>
		<div class="col-md-3">
		<?php $sld=array('1'=>'Dengan Slider','0'=>'Tanpa Slider');?>			
			<select class="form-control mb-md" name="slider" id="slider">
				<?php foreach($sld as $ib=>$bs){
					if($ib == $p->status_slider_bar){
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