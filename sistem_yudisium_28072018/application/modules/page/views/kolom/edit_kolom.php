<?php foreach($kolom as $p){} ?>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3" for="nama_menu">Judul Kolom</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="judul" id="judul" value="<?php echo $p->judul?>" required>
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
		<label class="col-md-3" for="ringkasan">Ringkasan</label>
		<div class="col-md-6">
			<textarea class="form-control" name="ringkasan" id="ringkasan" type="text"><?php echo $p->ringkasan?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="isi">Isi</label>
		<div class="col-md-12">
			<textarea name="isi" id="isi1"><?php echo $p->isi?></textarea>
			<?php echo display_ckeditor($ckeditor);  ?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="jenis_url"></label>
		<div class="col-md-12">			
			<button type="submit" class="btn btn-primary pull-right">Simpan</button>
		</div>
	</div>

</form>