<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/select2/select2.min.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/select2/select2.min.css') ?>">

<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label" for="tahun">tahun</label>
		<div class="col-md-6">
			<select class="form-control" name="tahun" id="tahun">
				<option value="X0X"> -- Pilih --</option>
				<?php foreach ($tahun as $t => $v) {
					echo "<option value='".$v."'> ".$v." </option>";
				} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="jalur">Jalur</label>
		<div class="col-md-6">
			<select class="form-control" name="jalur" id="jalur">
				<option value="X0X"> -- Pilih --</option>
				<?php foreach ($jalur as $d) {
					echo "<option value='".$d['kode_jalur']."'> ".$d['nama_jalur']." </option>";
				} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="gel">Gelombang</label>
		<div class="col-md-6">
			<select class="form-control" name="gelombang" id="gelombang">
				<option value="X0X"> -- Pilih --</option>
				<?php foreach ($gelombang as $d) {
					echo "<option value='".$d['kode_gelombang']."'> ".$d['nama_gelombang']." </option>";
				} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="ujian">Ujian</label>
		<div class="col-md-6">
			<select class="form-control" name="ujian" id="ujian">
				<option value="X0X"> -- Pilih --</option>
				<?php foreach ($ujian as $d) {
					echo "<option value='".$d['kode_ujian']."'> ".$d['nama_ujian']." </option>";
				} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="bobot">Bobot</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="bobot" id="bobot" required>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-3 control-label" for="jenis_url"></label>
		<div class="col-md-3">			
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>

</form>


<script type="text/javascript">
	
	// function get_available_jalur(){
	// 	var tahun = $('#tahun').val();
	// 	$.ajax({
	// 		url  : 'get_ajax_jalur_tersedia',
	// 		type : 'POST',
	// 		data : 'tahun='+tahun,

	// 		success : function(result){
	// 			$('#jalur').empty();
	// 			if(result == '0'){
	// 				$('#jalur').append("<option value='X0X'> -- Pilih -- </option>");
	// 			}else{
	// 				var r = JSON.parse(result);
	// 				$('#jalur').append("<option value='X0X'> -- Pilih -- </option>");
	// 				$.each(r, function(index, value){
	// 					$('#jalur').append("<option value='"+value.kode_jalur+"'> "+value.nama_jalur+" </option>");
	// 				});
	// 			}
	// 		}

	// 	});
	// }

	// function get_available_gelombang(){
	// 	var tahun = $('#tahun').val();
	// 	var jalur = $('#jalur').val();
	// 	$.ajax({
	// 		url  : 'get_ajax_gelombang_tersedia',
	// 		type : 'POST',
	// 		data : 'tahun='+tahun+'&jalur='+jalur,

	// 		success : function(result){
	// 			$('#gelombang').empty();
	// 			if(result == '0'){
	// 				$('#gelombang').append("<option value='X0X'></option>");
	// 			}else{
	// 				var r = JSON.parse(result);
	// 				$('#gelombang').append("<option value='X0X'> -- Pilih -- </option>");
	// 				$.each(r, function(index, value){
	// 					$('#gelombang').append("<option value='"+value.kode_gelombang+"'> "+value.nama_gelombang+" </option>");
	// 				});
	// 			}
	// 		}

	// 	});
	// }

	// function get_available_ujian(){
	// 	var tahun = $('#tahun').val();
	// 	var jalur = $('#jalur').val();
	// 	var gel   = $('#gelombang').val();
	// 	$.ajax({
	// 		url  : 'get_ajax_ujian_tersedia',
	// 		type : 'POST',
	// 		data : 'tahun='+tahun+'&jalur='+jalur+'&gelombang='+gel,

	// 		success : function(result){
	// 			$('#ujian').empty();
	// 			if(result == '0'){
	// 				$('#ujian').append("<option value='X0X'></option>");
	// 			}else{
	// 				var r = JSON.parse(result);
	// 				$('#ujian').append("<option value='X0X'> -- Pilih -- </option>");
	// 				$.each(r, function(index, value){
	// 					$('#ujian').append("<option value='"+value.kode_ujian+"'> "+value.nama_ujian+" </option>");
	// 				});
	// 			}
	// 		}

	// 	});
	// }

	// function get_config_bobot(){

	// }


	$(document).ready(function(){

		// $("#tahun").on('change', function(){
		// 	get_available_jalur();
		// });

		// $("#jalur").on('change', function(){
		// 	get_available_gelombang();
		// });
	});

</script>

