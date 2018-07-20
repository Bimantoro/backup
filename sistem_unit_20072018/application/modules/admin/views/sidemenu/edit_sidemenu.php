<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group" hidden>
		<label class="col-md-3 control-label" for="idmenu">id menu</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="idmenu" id="idmenu" readonly required value="<?php echo $sidemenu['id_menu']; ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="namamenu">Nama Menu</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="menu" id="menu" required value="<?php echo $sidemenu['nama_menu']; ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="url">Url</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="url" id="url" required value="<?php echo $sidemenu['url']; ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="bahasa">Bahasa</label>
		<?php $bhs=array('id'=>'Indonesia','en'=>'English','ar'=>'Arabic');?>
		<div class="col-md-3">			
			<select class="form-control mb-md" name="bahasa" id="bahasa">
				<?php foreach($bhs as $ib=>$bs){
					if($sidemenu['kode_bahasa'] == $ib){
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
		<label class="col-md-3 control-label" for="order">Menu Order</label>
		<div class="col-md-6">
			<input type="number" class="form-control" name="order" id="order" required min="1" value="<?php echo $sidemenu['menu_order']; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>
</form>