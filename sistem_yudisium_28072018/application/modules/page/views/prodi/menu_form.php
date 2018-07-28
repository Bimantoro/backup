<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">

<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label" for="kode_unit">Kode Unit</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="kode_unit" id="kode_unit" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_unit">Nama Unit</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="nama_unit" id="nama_unit" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="kode_prodi">Kode Prodi</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="kode_prodi" id="kode_prodi">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="bahasa">Bahasa</label>
		<?php $bhs=array('id'=>'Indonesia','en'=>'English','ar'=>'Arabic');?>
		<div class="col-md-3">			
			<select class="form-control mb-md" name="bahasa" id="bahasa">
				<?php foreach($bhs as $ib=>$bs){
					echo"<option value='".$ib."'>".$bs."</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="subdomain">Subdomain</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="subdomain" id="subdomain" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="alamat">Alamat</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="alamat" id="alamat">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="email">Email</label>
		<div class="col-md-6">
			<input type="email" class="form-control" name="email" id="email">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="telp">Telp</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="telp" id="telp">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="sidebar">Nama Sidebar Unit</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="sidebar" id="sidebar">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="slider">Status Slider</label>
		<div class="col-md-3">
		<?php $bhs=array('1'=>'Dengan Slider','0'=>'Tanpa Slider');?>			
			<select class="form-control mb-md" name="slider" id="slider">
				<?php foreach($bhs as $ib=>$bs){
					echo"<option value='".$ib."'>".$bs."</option>";
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

