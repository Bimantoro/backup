<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">

<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data' >
	<?php if(!empty($this->session->flashdata('error'))){ ?>
		<div class="alert alert-danger">
			<?php echo $this->session->flashdata('error'); ?>
		</div>
	<?php } ?>
	<div class="form-group">
		<label  class="col-md-3 control-label">Judul Album</label>
		<div class="col-md-6">
			<input required type="text" class="form-control" name="judul_album" id="judul_album" maxlength="255">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Bahasa</label>
		<?php $bhs=array('id'=>'Indonesia','en'=>'English','ar'=>'Arabic');?>
		<div class="col-md-3">			
			<select class="form-control mb-md" name="kode_bahasa" id="kode_bahasa">
				<?php foreach($bhs as $ib=>$bs){
					echo"<option value='".$ib."'>".$bs."</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Ringkasan</label>
		<div class="col-md-9">
			<textarea class="form-control" name="ringkasan" id="ringkasan"></textarea>
			<?php echo display_ckeditor(
				array(
					'id' 	=> 	'ringkasan',
					'path'	=>	'asset/ckeditor',
					'config' => array(
						'toolbar' 	=> 	"Full", 	//Using the Full toolbar
						'width' 	=> 	"100%",	//Setting a custom width
						'height' 	=> 	'300px',	//Setting a custom height
					),	
				)
			); ?>
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