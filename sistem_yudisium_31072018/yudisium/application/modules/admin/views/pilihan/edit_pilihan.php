<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-3.2.1.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/js2/jquery-ui.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/select2/select2.min.js') ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/js2/jquery-ui.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/select2/select2.min.css') ?>">

<form class="form-horizontal form-bordered" method="post" action="" enctype='multipart/form-data'>
	<div class="form-group">
		<label class="col-md-3 control-label" for="tahun">tahun</label>
		<div class="col-md-6">
			<select class="form-control" name="tahun" id="tahun" style="pointer-events: none;" readonly>
				<?php foreach ($tahun as $t => $v) {
					if($v == $pilihan['tahun']){
						echo "<option value='".$v."' selected> ".$v." </option>";
					}else{
						echo "<option value='".$v."'> ".$v." </option>";
					}
				} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="jalur">Jalur</label>
		<div class="col-md-6">
			<select class="form-control" name="jalur" id="jalur" style="pointer-events: none;" readonly>
				<?php foreach ($jalur as $d) {
					if($pilihan['kode_jalur'] == $d['kode_jalur']){
						echo "<option value='".$d['kode_jalur']."' selected> ".$d['nama_jalur']." </option>";
					}else{
						echo "<option value='".$d['kode_jalur']."'> ".$d['nama_jalur']." </option>";
					}
				} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="gel">Gelombang</label>
		<div class="col-md-6">
			<select class="form-control" name="gelombang" id="gelombang" style="pointer-events: none;" readonly>
				<?php foreach ($gelombang as $d) {
					if($pilihan['kode_gelombang'] == $d['kode_gelombang']){
						echo "<option value='".$d['kode_gelombang']."' selected> ".$d['nama_gelombang']." </option>";
					}else{
						echo "<option value='".$d['kode_gelombang']."'> ".$d['nama_gelombang']." </option>";
					}
				} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="kelas">Kelas</label>
		<div class="col-md-6">
			<select class="form-control" name="kelas" id="kelas">
				<?php foreach ($kelas as $d) {
					if($pilihan['kode_kelas'] == $d['kode_kelas']){
						echo "<option value='".$d['kode_kelas']."' selected> ( ".$d['kode_kelas']." ) ".$d['nama_kelas']." </option>";
					}else{
						echo "<option value='".$d['kode_kelas']."'> ( ".$d['kode_kelas']." ) ".$d['nama_kelas']." </option>";
					}
				} ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="pilihan">pilihan</label>
		<div class="col-md-6">
			<input type="number" min=1 max=2 class="form-control" name="pilihan" id="pilihan" required value="<?php echo $pilihan['pilihan']; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="mulai">Mulai</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="mulai" id="mulai" required value="<?php echo $pilihan['tgl_mulai']; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="selesai">Selesai</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="selesai" id="selesai" required value="<?php echo $pilihan['tgl_selesai']; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="noyud">No</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="noyud" id="noyud" required value="<?php echo $pilihan['no_yudisium']; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="ketua">Ketua</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="ketua" id="ketua" required value="<?php echo $pilihan['ketua_yudisium']; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="tempat">Tempat</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="tempat" id="tempat" required value="<?php echo $pilihan['tempat_yudisium']; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-3 control-label" for="tgl_yud">Tgl Yudisium</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="tgl_yud" id="tgl_yud" required value="<?php echo $pilihan['tgl_yudisium']; ?>">
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
	$('#mulai').datepicker({
		dateFormat : 'yy-mm-dd'
	});

	$('#selesai').datepicker({
		dateFormat : 'yy-mm-dd'
	});

	$('#tgl_yud').datepicker({
		dateFormat : 'yy-mm-dd'
	});
</script>