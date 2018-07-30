<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">

<?php $a=$this->session->flashdata('msg');
	if($a!=null):?>
		<div class="alert alert-<?php echo $a[0]?> alert-msg">
			<?php echo $a[1] ?>
		</div>
		
	<?php  endif;?>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	
	<div class="form-group">
		<label class="col-md-3" for="photo">Tambahkan Slide</label>
		<div class="col-md-6">
			<input name="picture" id="picture" type="file" required>
		</div>
		<label style="color:red;" class="ml-xl">File gambar yang disarankan berekstensi .jpg/.jpeg dengan ukuran 1170 x 487 pixel</label>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="deskripsi_foto">Background Slide</label>
		<div class="col-md-6">
			<div id="cp2" class="input-group colorpicker-component">
          <input type="text" value="#00AABB" class="form-control" name="background"/>
          <span class="input-group-addon"><i></i></span>
		</div>
		</div>
	</div>
       
		
	<div class="form-group">
		<label class="col-md-3" for="bahasa">Bahasa</label>
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
		<label class="col-md-3" for="deskripsi_foto">Tanggal Mulai</label>
		<div class="col-md-6">
			<input type="text" required autocomplete="off" class="form-control" name="tgl_mulai" id="tgl_mulai"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="deskripsi_foto">Tanggal Selesai</label>
		<div class="col-md-6">
			<input type="text" required autocomplete="off" class="form-control" name="tgl_selesai" id="tgl_selesai"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="deskripsi_foto">Url</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="url" id="url"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="jenis_url"></label>
		<div class="col-md-12">			
			<button type="submit" class="btn btn-primary pull-right">Simpan</button>
		</div>
	</div>
	
</form>

<script>
	$('#tgl_mulai').datepicker({
		dateFormat : 'dd/mm/yy'
	});

	$('#tgl_selesai').datepicker({
		dateFormat : 'dd/mm/yy'
	});
</script>