<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/select2/select2.min.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/select2/select2.min.css') ?>">

<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label" for="fah">Fakultas</label>
		<div class="col-md-6">
			<select class="form-control" name="fak" id="fak">
			<?php foreach($fakultas as $f){
				echo "<option value='".$f['kode_fakultas']."' >".$f['nama_fakultas']."</option>";
			} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="kode">Kode Prodi</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="kode" id="kode" required>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="nama">Nama Prodi</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="nama" id="nama" required>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="jenjang">Jenjang</label>
		<div class="col-md-6">
			<select class="form-control" name="jenjang" id="jenjang">
			<?php foreach($jenjang as $f){
				echo "<option value='".$f['kode_jenjang']."' >".$f['nama_jenjang']."</option>";
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

