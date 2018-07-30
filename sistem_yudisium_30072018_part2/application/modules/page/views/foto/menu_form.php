<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">
<script type="text/javascript">
	$(document).ready(function(){
		$("#div_ringkasan").hide();
	});
</script>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3" for="nama_menu">Pilih File</label>
		<div class="col-md-6">
			<input type="file" class="form-control" name="upload[]" multiple="multiple">
			<label style="color: red;">Anda bisa mengupload beberapa file foto sekaligus, dengan masing-masing foto berukuran maksimal 2 MB.</label>
		</div>

	</div>
	<div class="form-group" id="div_ringkasan">
		<label class="col-md-3" for="ringkasan">Ringkasan</label>
		<div class="col-md-6">
			<textarea class="form-control" name="ringkasan" id="ringkasan" type="text"></textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3" for="jenis_url"></label>
		<div class="col-md-12">			
			<button type="submit" class="btn btn-primary pull-right">Simpan</button>
		</div>
	</div>

</form>

<script type="text/javascript">
	$('#tanggal_post').datepicker({
		dateFormat : 'dd/mm/yy'
	});
</script>