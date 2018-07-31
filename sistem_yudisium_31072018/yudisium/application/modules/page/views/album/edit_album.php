<?php foreach($album as $p){} ?>
<?php 	$this->session->flashdata('error'); ?>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label">Judul Album</label>
		<div class="col-md-6">
			<input required type="text" class="form-control" name="judul" id="judul" value="<?php echo $p->judul?>" maxlength="255">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Bahasa</label>
		<?php $bhs=array('id'=>'Indonesia','en'=>'English','ar'=>'Arabic');?>
		<div class="col-md-3">			
			<select class="form-control mb-md" name="kode_bahasa" id="kode_bahasa">
				<?php foreach($bhs as $ib=>$bs){
					if ($ib == $p->kode_bahasa) {
						echo"<option selected value='".$ib."'>".$bs."</option>";
					}
					else {
						echo"<option value='".$ib."'>".$bs."</option>";
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Ringkasan</label>
		<div class="col-md-9">
			<textarea class="form-control" name="ringkasan" id="ringkasan"><?php echo $p->ringkasan?></textarea>
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
		<label class="col-md-3 control-label"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>
</form>