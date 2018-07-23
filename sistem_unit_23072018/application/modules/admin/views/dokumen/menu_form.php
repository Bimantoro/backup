<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">

<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data' >
	<?php 	 $error = $this->session->flashdata('error'); 	
	if(!empty($error)){?>
	<div class="alert alert-danger">
		<?php 	echo $error;?>
	</div><?php } ?>
	<div class="form-group">
		<label  class="col-md-3 control-label" for="nama_dokumen">Nama Dokumen</label>
		<div class="col-md-6">
			<input required type="text" class="form-control" name="nama_dokumen" id="nama_dokumen">
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
		<label class="col-md-3 control-label" for="tahun">Tahun</label>
		<div class="col-md-6">
			<input class="form-control" name="tahun" id="tahun" type="text">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="tanggal_post">Tanggal</label>
		<div class="col-md-6">
			<input class="form-control" name="tanggal_post" id="tanggal_post" type="text" autocomplete="off">
			<label style="color:red;" class="ml-xl">Jika kosong akan terisi tanggal saat ini.</label>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_file">Pilih File</label>
		<div class="col-md-6">
			<input class="" name="nama_file" id="nama_file" type="file">
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