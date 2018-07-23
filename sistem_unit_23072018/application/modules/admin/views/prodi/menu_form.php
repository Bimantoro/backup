<?php 
	$prd = array();
	if(isset($prodi)){
		$prd = $prodi;
	}

	$fk = array();
	if(isset($fakultas)){
		$fk = $fakultas;
	}

	$prodi_json = json_encode($prd);
	$prodi_json = str_replace("'", "", $prodi_json);

	$fak_json = json_encode($fk);
	$fak_json = str_replace("'", "", $fak_json);
 ?>

<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">

<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>

	<?php if(isset($add_data)){ ?>
	<div class="form-group">
		<label class="col-md-3 control-label" for="daftar_prodi">Daftar Fakultas</label>
		<div class="col-md-6">
			<select class="form-control" id="daftar_fakultas" name="daftar_fakultas">
				<option value="X0X"> -- Pilih --</option>
				<?php if($fk){ ?>
					<?php foreach ($fk as $p) { ?>
						<option value="<?php echo $p['KD_FAK']; ?>"> <?php echo $p['NM_FAK']; ?> </option>
					<?php } ?>
				<?php } ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="daftar_prodi">Daftar Prodi</label>
		<div class="col-md-6">
			<select class="form-control" id="daftar_prodi" name="daftar_prodi">
				<option value="X0X"> -- Pilih --</option>
			</select>
		</div>
	</div>
	<?php } ?>

	<div class="form-group">
		<label class="col-md-3 control-label" for="kode_unit">Kode Unit</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="kode_unit" id="kode_unit" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="nama_unit">Nama Unit</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="nama_unit" id="nama_unit" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="kode_prodi">Kode Prodi</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="kode_prodi" id="kode_prodi">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="bahasa">Bahasa</label>
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
		<label class="col-md-3 control-label" for="subdomain">Subdomain</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="subdomain" id="subdomain" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="alamat">Alamat</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="alamat" id="alamat">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="email">Email</label>
		<div class="col-md-6">
			<input type="email" class="form-control" name="email" id="email">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="telp">Telp</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="telp" id="telp">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="fb">Facebook</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="facebook" id="facebook" placeholder="http://www.facebook.com/uinsk">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="fb">Twitter</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="twitter" id="twitter" placeholder="http://www.twitter.com/uinsk">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="fb">Instagram</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="instagram" id="instagram" placeholder="http://www.instagram.com/uinsk">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="fb">Youtube</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="youtube" id="youtube" placeholder="http://www.youtube.com/uinsk">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="sidebar">Nama Sidebar Unit</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="sidebar" id="sidebar">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="slider">Status Slider</label>
		<div class="col-md-3">
		<?php $bhs=array('1'=>'Dengan Slider','0'=>'Tanpa Slider');?>			
			<select class="form-control mb-md" name="slider" id="slider">
				<?php foreach($bhs as $ib=>$bs){
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

<script>

	//set global variable untuk daftar prodi :
	var prodi = '<?php 	echo $prodi_json; ?>';
	var fak = '<?php echo $fak_json; ?>';
	var prodi_s = '';

	function auto_fill_form(){
		var kd_prodi = $('#daftar_prodi').val();
		if(kd_prodi == 'X0X'){
			//console.log('clear form atau do nothing ?');
			auto_fill_form_fakultas();
		}else{
			var p = JSON.parse(prodi_s);
			$.each(p, function(index, value){
				if(value.KD_PRODI == kd_prodi){
					$('#kode_unit').val(value.KD_JURUSAN);
					$('#nama_unit').val(value.NM_PRODI);
					$('#kode_prodi').val(value.KD_PRODI);
					$('#alamat').val(value.ALAMAT);
					$('#email').val(value.EMAIL);
					$('#telp').val(value.TELP);
				}
			});
		}
	}

	function auto_fill_form_fakultas(){
		var kd_fak = $('#daftar_fakultas').val();
		if(kd_fak == 'X0X'){
			$('#kode_unit').val('');
			$('#nama_unit').val('');
			$('#kode_prodi').val('');
			$('#alamat').val('');
			$('#email').val('');
			$('#telp').val('');
		}else{
			var f = JSON.parse(fak);
			$.each(f, function(index, value){
				if(value.KD_FAK == kd_fak){
					$('#kode_unit').val(value.KD_FAK);
					$('#nama_unit').val(value.NM_FAK);
					$('#kode_prodi').val(value.KD_PRODI);
					$('#alamat').val(value.ALAMAT);
					$('#email').val(value.EMAIL);
					$('#telp').val(value.TELP);
				}
			});
		}
	}

	function fill_daftar_prodi(){
		var kd_fak = $('#daftar_fakultas').val();
		auto_fill_form_fakultas();

		if(kd_fak == 'X0X'){
			$('#daftar_prodi').empty();
			$('#daftar_prodi').append("<option value='X0X'> -- Pilih -- </option>")

			prodi_s = '';
		}else{
			$('#daftar_prodi').empty();
			$('#daftar_prodi').append("<option value='X0X'> -- Pilih -- </option>")

			//auto_fill_form_fakultas();

			var p = JSON.parse(prodi);
			console.log(p);
			$.each(p, function(index, value){
				if(index == kd_fak){
					prodi_s = JSON.stringify(value);
					$.each(value, function(idx, val){
						$('#daftar_prodi').append("<option value='"+val.KD_PRODI+"'>"+val.NM_PRODI+"</option>")
					});
				}
			});

		}

	}

	$(document).ready(function(){
		$('#daftar_prodi').on('change', function(){
    		auto_fill_form();
    	});

    	$('#daftar_fakultas').on('change', function(){
    		fill_daftar_prodi();
    	});
	});

</script>

