<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">


<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label" for="kode_unit">Username</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="username" id="username" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_unit">Nama Unit</label>
		<div class="col-md-6">
			<!-- <input type="text" class="form-control" name="nama_unit" id="nama_unit" required> -->
			<select class="form-control" name="kode_unit" id="kode_unit" required>
				<?php if($units){
					foreach ($units as $u) {
						echo "<option value='".$u->kode_unit."'>".$u->nama_unit."</option>";
					}
					

				} ?>
				
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="level">Level</label>
		<?php $adm=array('WPR002'=>'ADMIN','WPR001'=>'SUPER ADMIN');?>
		<div class="col-md-6">			
			<select class="form-control" name="level"bahasa">
				<?php foreach($adm as $ib=>$bs){
					echo"<option value='".$ib."'>".$bs."</option>";
				}
				?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>

</form>

