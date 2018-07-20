<?php foreach($dokumen as $p){} ?>
<?php 	 $error = $this->session->flashdata('error'); 	
	if(!empty($error)){?>
	<div class="alert alert-danger">
		<?php 	echo $error;?>
	</div><?php } ?>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_dokumen">Nama Dokumen</label>
		<div class="col-md-6">
			<input required type="text" class="form-control" name="nama_dokumen" id="nama_dokumen" value="<?php echo $p->nama_dokumen?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="bahasa">Bahasa</label>
		<?php $bhs=array('id'=>'Indonesia','en'=>'English','ar'=>'Arabic');?>
		<div class="col-md-3">			
			<select class="form-control mb-md" name="bahasa" id="bahasa">
				<?php foreach($bhs as $ib=>$bs){
					if ($ib == $p->kode_bahasa) {
					echo"<option value='".$ib."' selected>".$bs."</option>";
					}else{
						echo"<option value='".$ib."'>".$bs."</option>";
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="tahun">Tahun</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="tahun" id="tahun" value="<?php echo $p->tahun?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_file">Pilih File</label>
		<div class="col-md-6">
			<input name="nama_file" id="nama_file" type="file">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>
</form>