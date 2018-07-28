<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">

<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_pengumuman">Nama Pengumuman</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="nama_pengumuman" id="nama_pengumuman" required>
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
		<label class="col-md-3 control-label" for="nama_file">Pilih File</label>
		<div class="col-md-6">
			<input name="nama_file" id="nama_file" type="file">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="url">Url</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="url" id="url">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="tanggal_post">Tanggal</label>
		<div class="col-md-6">
			<input class="form-control" name="tanggal_post" id="tanggal_post" type="text">
			<label style="color:red;" class="ml-xl">Jika kosong akan terisi tanggal saat ini.</label>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>

</form>

<script type="text/javascript">
	$('#tanggal_post').datepicker({
		dateFormat : 'dd/mm/yy'
	});
</script>