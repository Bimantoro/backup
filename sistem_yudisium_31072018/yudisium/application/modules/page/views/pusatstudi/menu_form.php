<form class="form-horizontal form-bordered" method="post" action="">
	<div class="form-group">
		<label class="col-md-3" for="title">Nama Pusat Studi</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="nama_pusat_studi" id="nama_pusat_studi">
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
		<label class="col-md-3" for="title">Deskripsi</label>
		<div class="col-md-12">
			<textarea name="deskripsi" id="isi1"></textarea>
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