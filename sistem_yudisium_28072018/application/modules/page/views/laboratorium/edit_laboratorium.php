<?php foreach($laboratorium as $p){} ?>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3" for="nama_halaman">Nama Laboratorium</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="nama_lab" id="nama_lab" value="<?php echo $p->nama_lab?>">
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
		<label class="col-md-3" for="nama_halaman">Foto Laboratorium</label>
		<div class="col-md-6">
			<input name="photo" id="photo" type="file">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="title">Deskripsi</label>
		<div class="col-md-12">
			<textarea name="deskripsi" id="isi1"><?php echo $p->deskripsi?></textarea>
			<?php echo display_ckeditor($ckeditor);  ?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-12">			
			<button type="submit" class="btn btn-primary pull-right">Simpan</button>
		</div>
	</div>

</form>