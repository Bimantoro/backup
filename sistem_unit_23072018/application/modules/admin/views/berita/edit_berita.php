<?php 
	$a=$this->session->flashdata('msg');
	if($a!=null):?>
		<div class="alert alert-<?php echo $a[0]?> alert-msg">
			<?php echo $a[1] ?>
		</div>
		
	<?php  endif;?>
<?php foreach($berita as $p){} ?>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3" for="nama_menu">Judul Berita</label>
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
		<label class="col-md-3" for="ringkasan">Ringkasan</label>
		<div class="col-md-6">
			<textarea class="form-control" name="ringkasan" id="ringkasan" type="text"><?php echo $p->ringkasan?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="photo">Pilih Foto</label>
		<div class="col-md-6">
			<input name="photo" id="photo" type="file">
		</div>
		<label style="color:red;" class="ml-xl">File gambar yang disarankan berekstensi .jpg/.jpeg</label>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="deskripsi_foto">Deskripsi Foto</label>
		<div class="col-md-6">
			<textarea class="form-control" name="deskripsi_foto" id="deskripsi_foto" type="text"><?php echo $p->deskripsi_foto?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="isi">Isi</label>
		<div class="col-md-12">
			<textarea name="isi" id="isi1"><?php echo $p->isi?></textarea>
			<?php echo display_ckeditor($ckeditor); ?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="jenis_url"></label>
		<div class="col-md-12">			
			<button type="submit" class="btn btn-primary pull-right">Simpan</button>
		</div>
	</div>

</form>