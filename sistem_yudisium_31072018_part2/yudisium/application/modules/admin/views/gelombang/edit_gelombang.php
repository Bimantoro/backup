<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
		<div class="form-group">
		<label class="col-md-3 control-label" for="kode">Kode Gelombang</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="kode" id="kode" required readonly value="<?php echo $gelombang['kode_gelombang'] ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="nama">Nama Gelombang</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="nama" id="nama" required value="<?php echo $gelombang['nama_gelombang'] ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>
</form>