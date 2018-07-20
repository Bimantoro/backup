<?php foreach($page as $p){} ?>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3" for="nama_halaman">Nama Halaman</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="title" id="title" value="<?php echo $p->title?>" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="bahasa">Bahasa</label>
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
		<label class="col-md-3" for="photo">Pilih Foto</label>
		<div class="col-md-6">
			<input name="photo" id="photo" type="file">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="title">Konten</label>
		<div class="col-md-12">
			<textarea name="content" id="isi1"><?php echo $p->content?></textarea>
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