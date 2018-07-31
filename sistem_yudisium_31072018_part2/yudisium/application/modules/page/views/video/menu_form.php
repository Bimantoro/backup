<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">

<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data' >
	<?php 	 $error = $this->session->flashdata('error'); 
	if(isset($error)){?>
	<div class="alert alert-danger">
		<?php 	echo $error;?>
	</div><?php } ?>
	<div class="form-group">
		<label  class="col-md-3 " for="judul">Judul</label>
		<div class="col-md-6">
			<input required type="text" class="form-control" name="judul" id="judul">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 " for="bahasa">Bahasa</label>
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
		<label class="col-md-3" required for="url">Youtube URL</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="url" id="url">
			<label style="color:grey;" class="ml-xl">Contoh : https://www.youtube.com/watch?v=BKzD3yCVk78</label>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 " for="ringkasan">Ringkasan</label>
		<div class="col-md-6">
			<textarea class="form-control" name="ringkasan" id="ringkasan" type="text"></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 " for="isi">Isi :</label>
		<div class="col-md-12">
			<textarea name="isi" id="isi1"></textarea>
			<?php echo display_ckeditor($ckeditor);  ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-3 " for="tanggal_post">Tanggal</label>
		<div class="col-md-6">
			<input class="form-control" name="tanggal_post" id="tanggal_post" type="text" autocomplete="off">
			<label style="color:red;" class="ml-xl">Jika kosong akan terisi tanggal saat ini.</label>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 " for="jenis_url"></label>
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