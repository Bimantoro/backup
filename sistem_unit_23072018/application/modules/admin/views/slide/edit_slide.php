<?php 
	$a=$this->session->flashdata('msg');
	if($a!=null):?>
		<div class="alert alert-<?php echo $a[0]?> alert-msg">
			<?php echo $a[1] ?>
		</div>
		
	<?php  endif;?>
<?php foreach($slide as $p){} ?>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3" for="nama_menu">Tambahkan Slide</label>
		<div class="col-md-6">
			<input type="file" name="picture" id="picture" value="<?php echo $p->picture?>" >
			<label style="color:red;" class="ml-xl">File gambar yang disarankan berekstensi .jpg/.jpeg dengan ukuran 1170 x 487 pixel</label>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="deskripsi_foto">Background Slide</label>
		<div class="col-md-6">
			<div id="cp2" class="input-group colorpicker-component">
          <input type="text" value="<?php echo $p->background?>" class="form-control" name="background"/>
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
		<label class="col-md-3" for="photo">Tanggal Mulai</label>
		<div class="col-md-6">
			<input name="tgl_mulai" id="tgl_mulai" type="date" value="<?php echo $p->tgl_mulai?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="photo">Tanggal Selesai</label>
		<div class="col-md-6">
			<input name="tgl_selesai" id="tgl_selesai" type="date" value="<?php echo $p->tgl_selesai?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3" for="isi">Url</label>
		<div class="col-md-6">
			<input type="text" name="url" name="url" value="<?php echo $p->url?>" class="form-control"/>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12">			
			<button type="submit" class="btn btn-primary pull-right">Simpan</button>
		</div>
	</div>

</form>