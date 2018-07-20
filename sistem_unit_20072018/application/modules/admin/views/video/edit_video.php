<?php foreach($video as $p){} ?>
	<?php if(!empty($this->session->flashdata('error'))) { ?>
		<div class="alert alert-danger">
			<?php echo $this->session->flashdata('error'); ?>
		</div>
	<?php } ?>
<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 " for="judul">Judul</label>
		<div class="col-md-6">
			<input required type="text" class="form-control" name="judul" id="judul" value="<?php echo $p->judul?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 " for="bahasa">Bahasa</label>
		<?php $bhs=array('id'=>'Indonesia','en'=>'English','ar'=>'Arabic');?>
		<div class="col-md-3">			
			<select class="form-control mb-md" name="bahasa" id="bahasa">
				<?php foreach($bhs as $ib=>$bs){
					if($ib==$p->kode_bahasa){
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
		<label class="col-md-3" required for="url">Url Youtube</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="url" id="url" value="<?php echo $p->url?>">
			<label style="color:grey;font-size: 12px"  class="ml-xl">Contoh : https://www.youtube.com/watch?v=BKzD3yCVk78</label>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 " for="ringkasan">Ringkasan</label>
		<div class="col-md-6">
			<textarea class="form-control" name="ringkasan" id="ringkasan" type="text"><?php echo $p->ringkasan?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 " for="isi">Isi</label>
		<div class="col-md-12">
			<textarea name="isi" id="isi1"><?php echo $p->isi?></textarea>
			<?php echo display_ckeditor($ckeditor); ?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 " for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>
</form>